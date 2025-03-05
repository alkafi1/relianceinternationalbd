<?php

namespace App\Http\Requests\Terminal;

use Illuminate\Foundation\Http\FormRequest;

class TerminalExpenseStoreRequest extends FormRequest
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
            'title' => 'required|string|max:256',
            'terminal_id' => 'required|exists:terminals,uid',
            'job_type' => 'required|in:import,export,both',
            'comission_rate' => 'required|integer',
            'minimum_comission' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
            'job_expend_field' => 'required|array', // Validate job_expend_field array
            'job_expend_field.*' => 'required|string|max:255', // Validate each job_expend_field
            'amount' => 'required|array', // Validate amount array
            'amount.*' => 'required|numeric', // Validate each amount
        ];
    }


    /**
     * Get custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'terminal_id.required' => 'The terminal field is required.',
            'terminal_id.exists' => 'The selected terminal is invalid.',
            'job_type.required' => 'The job type field is required.',
            'job_type.in' => 'The job type must be one of: import, export, both.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be one of: active, inactive.',
            'job_expend_field.required' => 'At least one job expenditure field is required.',
            'job_expend_field.*.required' => 'Each job expenditure field is required.',
            'amount.required' => 'At least one amount field is required.',
            'amount.*.required' => 'Each amount field is required.',
            'amount.*.numeric' => 'Each amount must be a number.',
        ];
    }
}
