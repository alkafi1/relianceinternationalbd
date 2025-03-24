<?php

namespace App\Http\Requests\Terminal;

use Illuminate\Foundation\Http\FormRequest;

class TerminalExpenseUpdateRequest extends FormRequest
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
    {dd($this->request->all());
        return [
            'title' => 'required|string|max:256',
            'terminal_id' => 'required|exists:terminals,uid',
            'job_type' => 'required|in:import,export,both',
            'comission_rate' => 'required',
            'minimum_comission' => 'required',
            'status' => 'required|in:active,deactive',
            'job_expend_field' => 'required|array', // Validate job_expend_field array
            'job_expend_field.*' => 'required|string|max:255', // Validate each job_expend_field
            'amount' => 'required|array', // Validate amount array
            'amount.*' => 'required|numeric', // Validate each amount
        ];
    }
}
