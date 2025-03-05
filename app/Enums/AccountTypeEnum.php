<?php

namespace App\Enums;


use App\Traits\BaseEnum;
use Spatie\Enum\Enum;       

/**
 * @method static self MASTER()
 * @method static self EMOPLOYEE()
 * @method static self PARTY()
 */

class AccountTypeEnum extends Enum
{
    use BaseEnum;

    protected static function values(): array
    {
        // Define account category
        return [
            'MASTER' => 'master',
            'EMOPLOYEE' => 'employee',
            'PARTY' => 'party',
        ];
    }
}
