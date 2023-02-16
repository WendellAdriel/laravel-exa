<?php

namespace Exa\DTOs;

use Exa\Support\Formatter;
use WendellAdriel\ValidatedDTO\Casting\CarbonImmutableCast;

class DateRangeDTO extends DatatableDTO
{
    protected function rules(): array
    {
        return array_merge(parent::rules(), [
            'start_date' => ['sometimes', 'string', 'date_format:' . Formatter::API_DATE_FORMAT],
            'end_date' => ['sometimes', 'string', 'date_format:' . Formatter::API_DATE_FORMAT],
        ]);
    }

    protected function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'end_date' => date(Formatter::API_DATE_FORMAT),
        ]);
    }

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'start_date' => new CarbonImmutableCast(null, Formatter::API_DATE_FORMAT),
            'end_date' => new CarbonImmutableCast(null, Formatter::API_DATE_FORMAT),
        ]);
    }
}
