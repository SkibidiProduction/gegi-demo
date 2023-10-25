<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories;

use Application\Context\ReferenceBooks\ReferenceBook\Proxy\SqlValueProxy;
use Domain\Context\ReferenceBooks\Column\Column;
use Domain\Context\ReferenceBooks\Column\Enums\DataTypeEnum;
use Domain\Context\ReferenceBooks\Column\ValueObjects\Settings\EnumSettings;
use Domain\Shared\ValueObjects\Id\Id;
use Exception;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\ColumnSettings\ColumnSettingsActionBuilder;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\ColumnSettings\ColumnSettingsBuilder;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields\FormFieldDatePickerBuilder;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields\FormFieldInputBuilder;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields\FormFieldSelectBuilder;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields\Options\DatePickerOptionsBuilder;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields\Options\InputOptionsBuilder;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\Factories\FormFields\Options\SelectOptionsBuilder;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\ColumnSettings\ColumnSettingsActionType;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFieldGroup;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\FormField;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields\ItemType;
use Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\TableSchema;
use Infrastructure\Context\ReferenceBooks\Row\Repositories\RowSqlRepository;
use Throwable;

final class TableSchemaBuilder
{
    private TableSchema $tableSchema;

    public function __construct(
        private readonly TableColumnBuilder $tableColumnBuilder,
        private readonly ColumnSettingsBuilder $columnSettingsBuilder,
        private readonly FormSchemaBuilder $formSchemaBuilder,
        private readonly FormFieldInputBuilder $formFieldInputBuilder,
        private readonly FormFieldSelectBuilder $formFieldSelectBuilder,
        private readonly FormFieldDatePickerBuilder $formFieldDatePickerBuilder,
        private readonly InputOptionsBuilder $inputOptionsBuilder,
        private readonly SelectOptionsBuilder $selectOptionsBuilder,
        private readonly DatePickerOptionsBuilder $datePickerOptionsBuilder,
        private readonly ColumnSettingsActionBuilder $columnSettingsActionBuilder,
    ) {
        $this->reset();
    }

    public function reset(): self
    {
        $this->tableSchema = new TableSchema();

        return $this;
    }

    public function withTitle(?string $title): self
    {
        $this->tableSchema->setTitle($title);

        return $this;
    }

    /**
     * @throws Throwable
     * @param array<Column> $columns
     */
    public function withColumns(array $columns): self
    {
        foreach ($columns as $column) {
            $formatType = $column->dataType()->asEnum() === DataTypeEnum::Date
                ? 'dd.MM.yyyy'
                : null
            ;

            $formFieldItemType = match ($column->dataType()->asEnum()) {
                DataTypeEnum::String, DataTypeEnum::Numeric => ItemType::Input,
                DataTypeEnum::Enum => ItemType::Select,
                DataTypeEnum::Date => ItemType::DatePicker,
            };

            $columnFormSchema = null;

            if (!in_array($column->name()->value(), FormFieldGroup::EXCLUDED_FIELDS)) {
                $columnFormSchemaField = match ($formFieldItemType) {
                    ItemType::Input => $this->buildInputFormField($column, $formFieldItemType),
                    ItemType::Select => $this->buildSelectFormField($column, $formFieldItemType),
                    ItemType::DatePicker => $this->buildDatePickerFormField($column, $formFieldItemType),
                    default => throw new Exception('To be implemented')
                };

                $columnFormSchema = $this->formSchemaBuilder
                    ->reset()
                    ->withFields([$columnFormSchemaField])
                    ->build()
                ;
            }

            $columnSettings = $column->settings();

            $action = match (get_class($columnSettings)) {
                EnumSettings::class => $this->columnSettingsActionBuilder
                    ->reset()
                    ->withType(ColumnSettingsActionType::Select)
                    /** @phpstan-ignore-next-line */
                    ->withItems(new SqlValueProxy(new Id($columnSettings->columnId()), new RowSqlRepository()))
                    ->build()
                ,
                default => null,
            };

            $tableColumnSettings = $this->columnSettingsBuilder
                ->reset()
                ->withAction($action)
                ->withFormSchema($columnFormSchema)
                ->build()
            ;

            $this->tableSchema->addColumn(
                $this->tableColumnBuilder
                ->reset()
                ->withKey($column->id())
                ->withLabel($column->name())
                ->withWidth($column->width())
                ->withColumnSettings($tableColumnSettings)
                ->withType($column->dataType())
                ->withFormatType($formatType)
                ->withRange(false)
                ->withLinkType(null)
                //TODO: Пока что false, потом будет true
                ->withSort(false)
                //TODO: Реализовать при добавлении фильтров
                ->withColumnFilter(null)
                ->withIsRequired($column->isRequired())
                ->build()
            );
        }

        return $this;
    }

    /**
     * @throws Throwable
     * @param array<Column> $columns
     */
    public function withFormSchema(array $columns): self
    {
        $fields = [];

        foreach ($columns as $column) {
            if (in_array($column->name()->value(), FormFieldGroup::EXCLUDED_FIELDS)) {
                continue;
            }

            $formFieldItemType = match ($column->dataType()->asEnum()) {
                DataTypeEnum::String, DataTypeEnum::Numeric => ItemType::Input,
                DataTypeEnum::Enum => ItemType::Select,
                DataTypeEnum::Date => ItemType::DatePicker,
            };

            $fields[] = match ($formFieldItemType) {
                ItemType::Input => $this->buildInputFormField($column, $formFieldItemType),
                ItemType::Select => $this->buildSelectFormField($column, $formFieldItemType),
                ItemType::DatePicker => $this->buildDatePickerFormField($column, $formFieldItemType),
                default => throw new Exception('To be implemented')
            };
        }

        $formSchema = $this->formSchemaBuilder
            ->reset()
            ->withTitle(__('reference_book.table_schema.form_schema_title'))
            ->withFields($fields)
            ->build()
        ;

        $this->tableSchema->setFormSchema($formSchema);

        return $this;
    }

    public function build(): TableSchema
    {
        return $this->tableSchema;
    }

    private function buildInputFormField(Column $column, ItemType $formFieldItemType): FormField
    {
        $options = $this->inputOptionsBuilder
            ->reset()
            ->withType($column->dataType())
            ->withPlaceholder($column->name()->value())
            ->withClearable(false)
            ->withSize(null)
            ->withRounded(null)
            ->withBgColor(null)
            ->build()
        ;

        /** @phpstan-ignore-next-line  */
        return $this->formFieldInputBuilder
            ->reset()
            ->withImmediate(null)
            ->withName($column->id())
            ->withCaption($column->name()->value())
            ->withValueName($column->id())
            ->withItemType($formFieldItemType)
            ->withClasses(null)
            ->withRules($column->isRequired(), $column->settings())
            ->withStyle(null)
            ->withOptions($options)
            ->build()
        ;
    }

    /**
     * @throws Throwable
     */
    private function buildSelectFormField(Column $column, ItemType $formFieldItemType): FormField
    {
        /** @var EnumSettings $columnSettings */
        $columnSettings = $column->settings();

        $options = $this->selectOptionsBuilder
            ->reset()
            ->withPlaceholder($column->name())
            ->withItems(new SqlValueProxy(new Id($columnSettings->columnId()), new RowSqlRepository()))
            ->withItemText(null)
            ->withItemValue(null)
            ->withMultiple(false)
            ->withRounded(null)
            ->withSearchable(true)
            ->withAppendToBody(null)
            ->withInputBgColor(null)
            ->withClearable(null)
            ->build()
        ;

        /** @phpstan-ignore-next-line  */
        return $this->formFieldSelectBuilder
            ->reset()
            ->withImmediate(null)
            ->withName($column->id())
            ->withCaption($column->name()->value())
            ->withValueName($column->id())
            ->withItemType($formFieldItemType)
            ->withClasses(null)
            ->withRules($column->isRequired(), $column->settings())
            ->withStyle(null)
            ->withOptions($options)
            ->build()
        ;
    }

    private function buildDatePickerFormField(Column $column, ItemType $formFieldItemType): FormField
    {
        $options = $this->datePickerOptionsBuilder
            ->reset()
            ->withPlaceholder($column->name())
            ->withFormat(null)
            ->build()
        ;

        /** @phpstan-ignore-next-line  */
        return $this->formFieldDatePickerBuilder
            ->reset()
            ->withImmediate(null)
            ->withName($column->id())
            ->withCaption($column->name()->value())
            ->withValueName($column->id())
            ->withItemType($formFieldItemType)
            ->withClasses(null)
            ->withRules($column->isRequired(), $column->settings())
            ->withStyle(null)
            ->withOptions($options)
            ->build()
        ;
    }
}
