<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Party extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uid',
        'party_id',
        'party_name',
        'email',
        'phone',
        'address',
        'status',
    ];


    /**
     * The "booting" method of the model.
     *
     * Automatically generates the party_id on creation.
     *
     * @return void
     */ /**
     * The "booting" method of the model.
     *
     * Automatically generates the party_id on creation.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($party) {
            // Check if party_id is not already set (to prevent overriding)
            if (!$party->party_id) {
                // Get the latest party with the prefix 'party-'
                $latestparty = self::where('party_id', 'like', 'party-%')
                    ->orderByDesc('party_id') // Order by the latest party based on id
                    ->first();

                // Extract the numeric part of the last party_id or set it to 0 if no partys exist
                $latestpartyIdNumber = $latestparty ? (int) substr($latestparty->party_id, 6) : 0;

                // Increment the party_id number
                $newpartyIdNumber = str_pad($latestpartyIdNumber + 1, 2, '0', STR_PAD_LEFT);

                // Generate the new party_id
                $newpartyId = 'Party-' . $newpartyIdNumber;

                // Ensure the new party_id is unique
                while (self::where('party_id', $newpartyId)->exists()) {
                    // If the generated party_id already exists, increment the number again
                    $newpartyIdNumber++;
                    $newpartyId = 'Party-' . str_pad($newpartyIdNumber, 2, '0', STR_PAD_LEFT);
                }

                // Set the new party_id
                $party->party_id = $newpartyId;
            }
        });
    }
}
