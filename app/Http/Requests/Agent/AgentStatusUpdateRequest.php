<?php

namespace App\Http\Requests\Agent;

use App\Enums\AgentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgentStatusUpdateRequest extends FormRequest
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
            'uid' => ['required', 'string', 'exists:agents,uid'],
            'status' => ['required', 'string', 'max:255', Rule::in(AgentStatus::getValues())],
        ];
    }
}
