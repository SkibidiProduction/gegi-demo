<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\FormFields;

enum ItemType: string
{
    case Input = 'input';

    case InputGroup = 'input-group';

    case Checkbox = 'checkbox';

    case CheckboxGroup = 'checkbox-group';

    case Dropdown = 'dropdown';

    case Radio = 'radio';

    case RadioGroup = 'radio-group';

    case Select = 'select';

    case PriceRange = 'price-range';

    case DatePicker = 'date-picker';

    case Autocomplete = 'autocomplete';

    case Textarea = 'textarea';
}
