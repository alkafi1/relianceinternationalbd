<?php

namespace App\Http\Requests\Agent;

use App\Enums\AgentStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AgentStoreRequest extends FormRequest
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
            'email' => ['required', 'email', Rule::unique('agents')->whereNull('deleted_at'),],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8'],
            'address' => ['nullable', 'string', 'max:500'],
            'division_id' => ['nullable', 'integer', 'exists:divisions,id'],
            'district_id' => ['nullable', 'integer', 'exists:districts,id'],
            'thana_id' => ['nullable', 'integer', 'exists:thanas,id'],
            'status' => ['required', 'string', 'max:255', Rule::in(AgentStatus::getValues())],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'first_name.string' => 'The first name must be a string.',
            'first_name.max' => 'The first name must not exceed 255 characters.',

            'last_name.required' => 'The last name field is required.',
            'last_name.string' => 'The last name must be a string.',
            'last_name.max' => 'The last name must not exceed 255 characters.',

            'age.integer' => 'The age must be an integer.',
            'age.min' => 'The age must be at least 1.',
            'age.max' => 'The age must not exceed 120.',

            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',

            'phone.string' => 'The phone number must be a string.',
            'phone.max' => 'The phone number must not exceed 20 characters.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',

            'address.string' => 'The address must be a string.',
            'address.max' => 'The address must not exceed 500 characters.',

            'division_id.integer' => 'The division ID must be an integer.',
            'division_id.exists' => 'The selected division is invalid.',

            'district_id.integer' => 'The district ID must be an integer.',
            'district_id.exists' => 'The selected district is invalid.',

            'thana_id.integer' => 'The thana ID must be an integer.',
            'thana_id.exists' => 'The selected thana is invalid.',

            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be one of: ' . implode(', ', AgentStatus::getValues()) . '.',

            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, gif.',
            'image.max' => 'The image must not exceed 2MB in size.',
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
