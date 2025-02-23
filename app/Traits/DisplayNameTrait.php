<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait DisplayNameTrait
{
    protected function displayName(string $attribute = "name"): Attribute
    {
        return new Attribute(function () use ($attribute) {
            return $this->{$attribute};
        });
    }
}
