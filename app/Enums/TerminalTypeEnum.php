<?php

namespace App\Enums;


use App\Traits\BaseEnum;
use Spatie\Enum\Enum;       

/**
 * @method static self BOTH()
 * @method static self IMPORT()
 * @method static self EXPORT()
 */

class TerminalTypeEnum extends Enum
{
    use BaseEnum;

    protected static function values(): array
    {
        // Define account category
        return [
            'BOTH' => 'both',
            'IMPORT' => 'import',
            'EXPORT' => 'export',
        ];
    }
}

