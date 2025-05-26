<?php

namespace App\Enums;


use App\Traits\BaseEnum;
use Spatie\Enum\Enum;       

/**
 * @method static self EXPORT()
 * @method static self IMPORT()
 * @method static self BOTH()
 */

class JobTypeEnum extends Enum
{
    use BaseEnum;

    protected static function values(): array
    {
        return [
            'EXPORT' => 'export',
            'IMPORT' => 'import',
            'BOTH' => 'both',
        ];
    }
}
