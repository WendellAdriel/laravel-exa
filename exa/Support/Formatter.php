<?php

namespace Exa\Support;

readonly class Formatter
{
    public const ON_LABEL = 'ON';

    public const OFF_LABEL = 'OFF';

    public const YES_LABEL = 'YES';

    public const NO_LABEL = 'NO';

    public const NA_LABEL = 'N/A';

    public const API_DATE_FORMAT = 'Y-m-d';

    public const API_DATETIME_FORMAT = 'Y-m-d H:i:s';

    public const AMERICAN_DATE_FORMAT = 'm/d/Y';

    public const AMERICAN_DATETIME_FORMAT = 'm/d/Y H:i:s';

    public const DEFAULT_CURRENCY = '$';

    public static function formatInt(mixed $value): string
    {
        return number_format($value);
    }

    public static function formatFloat(mixed $value): string
    {
        return number_format($value, 2);
    }

    public static function formatMoney(mixed $value, string $currency = self::DEFAULT_CURRENCY): string
    {
        return $currency.self::formatFloat($value);
    }

    public static function formatBoolean(bool $value, string $trueValue = self::YES_LABEL, string $falseValue = self::NO_LABEL): string
    {
        return $value ? $trueValue : $falseValue;
    }
}
