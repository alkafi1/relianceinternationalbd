<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait BaseEnum
{
    /**
     * Get all cases as a collection with details.
     */
    public static function all(): Collection
    {
        return collect(static::values())->map(
            fn (string $value, string $key) => [
                'key' => $key,
                'value' => $value,
                'label' => $value,
            ]
        );
    }

    /**
     * Get all values as an array.
     */
    public static function getValues(): array
    {
        return array_values(static::values());
    }

    /**
     * Get a case by its key.
     */
    public static function fromKey(string $key): ?self
    {
        $values = static::values();

        if (array_key_exists($key, $values)) {
            return new static($values[$key]);
        }

        return null;
    }
}
