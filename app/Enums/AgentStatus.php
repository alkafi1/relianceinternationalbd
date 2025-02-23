<?php

namespace App\Enums;


use App\Traits\BaseEnum;
use Spatie\Enum\Enum;       

/**
 * @method static self APPROVED()
 * @method static self UNAPPROVED()
 * @method static self DELETED()
 * @method static self LOCK()
 * @method static self SUSPENDED()
 */

class AgentStatus extends Enum
{
    use BaseEnum;

    protected static function values(): array
    {
        // Define account category
        return [
            'APPROVED' => 'approved',
            'UNAPPROVED' => 'unapproved',
            'DELETED' => 'deleted',
            'LOCK' => 'lock',
            'SUSPENDED' => 'suspended',
        ];
    }
}
