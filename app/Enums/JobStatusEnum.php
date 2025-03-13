<?php

namespace App\Enums;


use App\Traits\BaseEnum;
use Spatie\Enum\Enum;       

/**
 * @method static self INITIALIZED_BY_AGENT()
 * @method static self PROCESSING()
 * @method static self COMPLETED()
 */

class JobStatusEnum extends Enum
{
    use BaseEnum;

    protected static function values(): array
    {
        // Define account category
        return [
            'INITIALIZED_BY_AGENT' => 'initialized_by_agent',
            'PROCESSING' => 'processing',
            'COMPLETED' => 'completed',
        ];
    }
}
