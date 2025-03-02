<?php

namespace App\Http\Requests\Agent;

use App\Enums\AgentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:1', 'max:120'],
            // 'email' => ['required', 'email', Rule::unique('agents', 'email')->ignore($this->agent->uid)],
            'phone' => ['required', 'string', 'max:20'],
            // 'password' => ['nullable', 'string', 'min:8'],
            'address' => ['nullable', 'string', 'max:500'],
            'division_id' => ['nullable', 'integer', 'exists:divisions,id'],
            'district_id' => ['nullable', 'integer', 'exists:districts,id'],
            'thana_id' => ['nullable', 'integer', 'exists:thanas,id'],
            'status' => ['required', 'string', 'max:255', Rule::in(AgentStatus::getValues())],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif', 'max:2048'],
        ];
    }
}
