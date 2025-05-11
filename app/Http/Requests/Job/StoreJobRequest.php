<?php

namespace App\Http\Requests\Job;

use App\Enums\AgentStatus;
use App\Enums\JobStatusEnum;
use App\Enums\JobTypeEnum;
use App\Enums\PartyStatusEnum;
use App\Enums\TerminalStatusEnum;
use App\Models\Agent;
use App\Models\Job;
use App\Models\Party;
use App\Models\Terminal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreJobRequest extends FormRequest
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
                Auth::guard('agent')->check() ? 'nullable' : 'required',
                'string',
                'max:255',
                'exists:agents,uid', // 'exists:table,column'
                Rule::exists(Agent::class, 'uid')->where(function ($query) {
                    $query->where('status', AgentStatus::APPROVED()->value);
                }),
            ],
            
            'status' => [Auth::guard('agent')->check() ? 'nullable' : 'required', 'string', 'max:255', Rule::in(JobStatusEnum::getValues())],
            'voucher_amount' => 'required|numeric',
            'job_no' => 'required|numeric',
        ];
    }
}
