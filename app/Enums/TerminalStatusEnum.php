<?php

namespace App\Enums;


use App\Traits\BaseEnum;
use Spatie\Enum\Enum;       

/**
 * @method static self DELETE()
 * @method static self ACTIVE()
 * @method static self DEACTIVE()
 */

class TerminalStatusEnum extends Enum
{
    use BaseEnum;

    protected static function values(): array
    {
        // Define account category
        return [
            'DELETE' => 'delete',
            'ACTIVE' => 'active',
            'DEACTIVE' => 'deactive',
        ];
    }
}
