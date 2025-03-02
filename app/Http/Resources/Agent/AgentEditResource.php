<?php

namespace App\Http\Resources\Agent;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentEditResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'age' => $this->age,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status,
            'division' => $this->division,
            'district' => $this->district,
            'thana_id' => $this->thana_id,
            'display_name' => $this->display_name,
            'image' => $this->image ? url('storage/' . $this->image) : null, // Assuming you're storing images in public/storage
            'updated_at' => $this->updated_at->toDateString(),
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
