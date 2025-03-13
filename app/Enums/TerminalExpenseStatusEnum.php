<?php

namespace App\Enums;


use App\Traits\BaseEnum;
use Spatie\Enum\Enum;       

/**
 * @method static self ACTIVE()
 * @method static self DEACTIVE()
 */

class TerminalExpenseStatusEnum extends Enum
{
    use BaseEnum;

    protected static function values(): array
    {
        // Define account category
        return [
            'ACTIVE' => 'active',
            'DEACTIVE' => 'deactive',
        ];
    }
}
