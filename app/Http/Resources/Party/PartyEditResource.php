<?php

namespace App\Http\Resources\Party;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartyEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uid' => $this->uid,
            'party_name' => $this->party_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status,
            'updated_at' => $this->updated_at->toDateString(),
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
