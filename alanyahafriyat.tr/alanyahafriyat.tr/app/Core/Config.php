<?php

declare(strict_types=1);

namespace App\Core;

class Config
{
    protected static array $items = [];

    public static function set(array $items): void
    {
        static::$items = array_merge(static::$items, $items);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $value = static::$items;
        foreach ($segments as $segment) {
            if (is_array($value) && array_key_exists($segment, $value)) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }
        return $value;
    }
}
