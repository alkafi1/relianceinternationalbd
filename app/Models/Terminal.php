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
        'update_date',           // Image associated with the terminal (optional)
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The "booting" method of the model.
     *
     * Automatically generates the terminal_id on creation.
     *
     * @return void
     */ /**
     * The "booting" method of the model.
     *
     * Automatically generates the terminal_id on creation.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($terminal) {
            // Check if terminal_id is not already set (to prevent overriding)
            if (!$terminal->terminal_id) {
                // Get the latest terminal with the prefix 'terminal-'
                $latestterminal = self::where('terminal_id', 'like', 'terminal-%')
                    ->orderByDesc('terminal_id') // Order by the latest terminal based on id
                    ->first();

                // Extract the numeric part of the last terminal_id or set it to 0 if no terminals exist
                $latestterminalIdNumber = $latestterminal ? (int) substr($latestterminal->terminal_id, 6) : 0;

                // Increment the terminal_id number
                $newterminalIdNumber = str_pad($latestterminalIdNumber + 1, 2, '0', STR_PAD_LEFT);

                // Generate the new terminal_id
                $newterminalId = 'terminal-' . $newterminalIdNumber;

                // Ensure the new terminal_id is unique
                while (self::where('terminal_id', $newterminalId)->exists()) {
                    // If the generated terminal_id already exists, increment the number again
                    $newterminalIdNumber++;
                    $newterminalId = 'terminal-' . str_pad($newterminalIdNumber, 2, '0', STR_PAD_LEFT);
                }

                // Set the new terminal_id
                $terminal->terminal_id = $newterminalId;
            }
        });
    }
}
