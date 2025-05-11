<?php

namespace App\Http\Requests\Job;

use App\Enums\AgentStatus;
use App\Enums\JobStatusEnum;
use App\Enums\JobTypeEnum;
use App\Enums\PartyStatusEnum;
use App\Enums\TerminalStatusEnum;
use App\Models\Agent;
use App\Models\Party;
use App\Models\Terminal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJobRequest extends FormRequest
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
        // dd($this->all());  
        return [
            'buyer_name' => 'required|string|max:255',
            'invoice_no' => 'required|string|max:255',
            'value_usd' => 'required|numeric',
            'usd_rate' => 'required|numeric',
            'item' => 'required|string|max:255',
            'terminal_id' => [
                'required',
                'string',
                'max:255',
                'exists:terminals,uid',
                Rule::exists(Terminal::class, 'uid')->where(function ($query) {
                    $query->where('status', TerminalStatusEnum::ACTIVE()->value);
                })
            ],
            'party_id' => [
                'required',
                'string',
                'max:255',
                'exists:parties,uid',
                Rule::exists(Party::class, 'uid')->where(function ($query) {
                    $query->where('status', PartyStatusEnum::APPROVED()->value);
                })
            ],
            'lc_no' => 'nullable|string|max:255',
            'be_no' => 'required|string|max:255',
            'sales_contact' => 'nullable|string|max:255',
            'ud_no' => 'nullable|string|max:255',
            'ud_amendment_no' => 'nullable|string|max:255',
            'job_type' => [
                'required',
                'string',
                'max:255',
                Rule::in(JobTypeEnum::getValues()),
            ],
            'master_bl_number' => 'nullable|string|max:255',
            'house_bl_number' => 'nullable|string|max:255',
            'quantity' => 'required|numeric',
            'ctns_pieces' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'agent_id' => [
                'nullable',
                'string',
                'max:255',
                'exists:agents,uid', // 'exists:table,column'
                Rule::exists(Agent::class, 'uid')->where(function ($query) {
                    $query->where('status', AgentStatus::APPROVED()->value);
                }),
            ],
            'status' => ['required', 'string', 'max:255', Rule::in(JobStatusEnum::getValues())],
            'voucher_amount' => 'required|numeric',
            'job_no' => 'required',
            'job_expend_field' => 'required|array', // Validate job_expend_field array
            'job_expend_field.*' => 'required|string|max:255', // Validate each job_expend_field
            'amount' => 'required|array', // Validate amount array
            'amount.*' => 'required|numeric', // Validate each amount
            'comment' => 'nullable|string',
            'job_date' => ['nullable', 'date', Rule::requiredIf(function () {
                return $this->input('status') === JobStatusEnum::COMPLETED()->value;
            })],
            'agency_commission' => 'required|numeric',
            'total_expenses' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'due' => 'required|numeric',
            'advanced_received' => 'required|numeric',
        ];
    }
}
