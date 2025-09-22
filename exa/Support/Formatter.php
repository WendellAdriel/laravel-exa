<?php

declare(strict_types=1);

namespace Exa\Support;

final readonly class Formatter
{
    public const string ON_LABEL = 'ON';

    public const string OFF_LABEL = 'OFF';

    public const string YES_LABEL = 'YES';

    public const string NO_LABEL = 'NO';

    public const string NA_LABEL = 'N/A';

    public const string API_DATE_FORMAT = 'Y-m-d';

    public const string API_DATETIME_FORMAT = 'Y-m-d H:i:s';

    public const string AMERICAN_DATE_FORMAT = 'm/d/Y';

    public const string AMERICAN_DATETIME_FORMAT = 'm/d/Y H:i:s';

    public const string DEFAULT_CURRENCY = '$';

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
        return $currency . self::formatFloat($value);
    }

    public static function formatBoolean(bool $value, string $trueValue = self::YES_LABEL, string $falseValue = self::NO_LABEL): string
    {
        return $value ? $trueValue : $falseValue;
    }
}
