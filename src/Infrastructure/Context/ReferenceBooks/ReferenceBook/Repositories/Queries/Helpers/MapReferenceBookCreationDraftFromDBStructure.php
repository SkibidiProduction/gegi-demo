<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Helpers;

use Application\Context\ReferenceBooks\ReferenceBook\Factories\ReferenceBookCreationDraftFactory;
use Carbon\Carbon;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\StatusEnum;
use Domain\Context\ReferenceBooks\ReferenceBook\Enums\TypeEnum;
use Domain\Context\ReferenceBooks\ReferenceBook\ReferenceBookCreationDraft;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Code\Code;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Description\Description;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Name\Name;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\ReferenceBookType\Type;
use Domain\Context\ReferenceBooks\ReferenceBook\ValueObjects\Status\Status;
use Domain\Shared\ValueObjects\Id\Id;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\Queries\Sql\GetLockByReferenceBookCreationDraftId;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Repositories\ReferenceBookCreationDraftSqlRepository;
use JsonException;
use ReflectionException;
use Throwable;

class MapReferenceBookCreationDraftFromDBStructure
{
    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public static function run(
        object $rawReferenceBookCreationDraft,
        ReferenceBookCreationDraftSqlRepository $repository
    ): ReferenceBookCreationDraft {
        $body = self::getEncodedBodyObject($rawReferenceBookCreationDraft->body);

        $lock = GetLockByReferenceBookCreationDraftId::run(new Id($rawReferenceBookCreationDraft->id));

        return ReferenceBookCreationDraftFactory::object()
            ->withId(new Id($rawReferenceBookCreationDraft->id))
            ->withStatus(new Status(StatusEnum::from($body->status)))
            ->withCode(new Code($body->code))
            ->withName(new Name($rawReferenceBookCreationDraft->name))
            ->withType(new Type(TypeEnum::from($body->type)))
            ->withDescription(self::getDescription($body->description))
            ->withCreatedAt(Carbon::parse($rawReferenceBookCreationDraft->created_at))
            ->withUpdatedAt(
                $rawReferenceBookCreationDraft->updated_at
                    ? Carbon::parse($rawReferenceBookCreationDraft->updated_at)
                    : null
            )
            ->withCreatedBy(new Id($rawReferenceBookCreationDraft->created_by))
            ->withUpdatedBy(
                $rawReferenceBookCreationDraft->updated_by
                    ? new Id($rawReferenceBookCreationDraft->updated_by)
                    : null
            )
            ->withEditor($lock ? new Id($lock->user_id) : null)
            ->restore($repository);
    }

    private static function getDescription(?string $description): ?Description
    {
        return empty($description) ? null : new Description($description);
    }

    /**
     * @throws JsonException
     */
    private static function getEncodedBodyObject(string $jsonBody): object
    {
        return json_decode(
            $jsonBody,
            false,
            JSON_UNESCAPED_UNICODE,
            JSON_THROW_ON_ERROR
        );
    }
}
