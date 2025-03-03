<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConten extends BaseModel
{

    protected $fillable = [
        'name',
        'content',
        'media',
        'url'
    ];
}
