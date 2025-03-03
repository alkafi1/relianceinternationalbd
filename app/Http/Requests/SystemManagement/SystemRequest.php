<?php

namespace App\Http\Requests\SystemManagement;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SystemRequest extends FormRequest
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
            'name' => 'required|string',
            'short_content' => 'required|string',
            'address_embaded' => 'nullable|string',
            'email' => 'nullable|string|email', // Added email validation
            'phone' => 'nullable|string', // Added phone validation (adjust as per your validation rules)
            'address' => 'nullable|string', // Added phone validation (adjust as per your validation rules)
            'facebook' => ['nullable', 'string', 'url'],
            'linkedin' => ['nullable', 'string', 'url'],
            'youtube' => ['nullable', 'string', 'url'],
            'twitter' => ['nullable', 'string', 'url'],
            'logo' => ['nullable', 'file', 'mimes:png,jpeg,gif', 'max:1024'], // max:1024 specifies 1MB limit
            'favicon' => ['nullable', 'file', 'mimes:png,jpeg,gif', 'max:1024'], // max:1024 specifies 1MB limit
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first(), // Get first error message
            'errors' => $validator->errors(), // Full validation errors
        ], 422));
    }
}
