<?php

namespace App\Traits;

trait HasEnumHelpers
{
    public static function values(): array
    {
        $cases = static::cases();

        return array_column($cases, 'value');
    }

    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    public static function options(): array
    {
        $cases = static::cases();

        return array_column($cases, 'value', 'name');
    }

    public static function lowercaseOptions(): array
    {
        $cases = static::cases();

        $options = array_column($cases, 'value', 'name');

        return array_change_key_case($options, CASE_LOWER);
    }
}
