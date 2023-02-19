<?php

namespace Exa\DTOs;

use Carbon\CarbonImmutable;
use Exa\Support\Formatter;
use WendellAdriel\ValidatedDTO\Casting\CarbonImmutableCast;

class DateRangeDTO extends DatatableDTO
{
    public ?CarbonImmutable $start_date;

    public CarbonImmutable $end_date;

    public function defineTimeframe(string $timeframe): self
    {
        if (! is_null($this->start_date)) {
            return $this;
        }

        $this->start_date = CarbonImmutable::now()->sub($timeframe)->startOfDay();
        $this->end_date = CarbonImmutable::now();

        return $this;
    }

    protected function rules(): array
    {
        return array_merge(parent::rules(), [
            'start_date' => ['sometimes', 'string', 'date_format:'.Formatter::API_DATE_FORMAT],
            'end_date' => ['sometimes', 'string', 'date_format:'.Formatter::API_DATE_FORMAT],
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
