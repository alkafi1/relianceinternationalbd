<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class AuditedAmountRequest extends FormRequest
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
            'audited_amount' => ['required', 'numeric'],
            'uid' => ['required', 'string', 'exists:reliance_jobs,uid'],
        ];
    }
}
