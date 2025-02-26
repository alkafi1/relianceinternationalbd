<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Terminal extends BaseModel
{
    use HasFactory;

    protected $table = 'terminals';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',              // UUID as the unique identifier
        'terminal_id',      // Terminal ID (string identifier)
        'terminal_name',    // Name of the terminal
        'terminal_short_form', // Short form (optional)
        'description',      // Description of the terminal
        'terminal_type',    // Type of terminal (1 = Both, 2 = Import, 3 = Export)
        'address',          // Address of the terminal
        'status',           // Status of the terminal (0 = Delete, 1 = Active, 2 = Deactive)
        'create_date',      // Date and time when the terminal was created
        'update_date',      // Date and time when the terminal was last updated
        'image',            // Image associated with the terminal (optional)
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
