<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields;

use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\NumericSettings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\Settings;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\StringSettings;
use Domain\Shared\ValueObjects\Id\Id;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\FormFieldBase;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\ItemType;

abstract class FormFieldBuilder
{
    private mixed $formField = null;

    protected function formField(): mixed
    {
        return $this->formField;
    }

    public function withImmediate(?bool $immediate): self
    {
        $this->formField()->setImmediate($immediate);

        return $this;
    }

    public function withName(Id $name): self
    {
        $this->formField()->setName($name);

        return $this;
    }

    public function withCaption(?string $caption): self
    {
        $this->formField()->setCaption($caption);

        return $this;
    }

    public function withValueName(Id $valueName): self
    {
        $this->formField()->setValueName($valueName);

        return $this;
    }

    public function withItemType(ItemType $itemType): self
    {
        $this->formField()->setItemType($itemType);

        return $this;
    }

    public function withClasses(?array $classes): self
    {
        $this->formField()->setClasses($classes);

        return $this;
    }

    public function withRules(bool $columnIsRequired, Settings $columnSettings): self
    {
        $rules = [];

        if ($columnIsRequired) {
            $rules[] = 'required';
        }

        $rules = match (get_class($columnSettings)) {
            StringSettings::class => array_merge($rules, [
                /** @phpstan-ignore-next-line */
                'max:' . $columnSettings->maxCharactersNumber(),
            ]),
            NumericSettings::class => array_merge($rules, [
                'decimal',
                /** @phpstan-ignore-next-line */
                'min_value:' . $columnSettings->min(),
                /** @phpstan-ignore-next-line */
                'max_value:' . $columnSettings->max(),
            ]),
            default => $rules,
        };

        $rules = !empty($rules)
            ? implode('|', $rules)
            : null
        ;

        $this->formField()->setRules($rules);

        return $this;
    }

    public function withStyle(?string $style): self
    {
        $this->formField()->setStyle($style);

        return $this;
    }

    public function build(): FormFieldBase
    {
        return $this->formField();
    }
}
