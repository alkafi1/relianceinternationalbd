<?php

namespace App\Http\Requests\Terminal;

use App\Enums\TerminalStatusEnum;
use App\Enums\TerminalTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TerminalStoreRequest extends FormRequest
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
            'terminal_name' => 'required|string|max:255|unique:terminals,terminal_name,except,uid',
            'terminal_short_form' => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
            'terminal_type' => [
                'required',
                Rule::in(TerminalTypeEnum::getValues()), // Validate against enum values
            ],
            'address' => 'required|string|max:255',
            'status' => [
                'required',
                Rule::in(TerminalStatusEnum::getValues()), // Validate against enum values
            ],
        ];
    }
}
