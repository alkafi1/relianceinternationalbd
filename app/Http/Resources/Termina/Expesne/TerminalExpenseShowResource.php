<?php

namespace App\Http\Resources\Termina\Expesne;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TerminalExpenseShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'terminal_name' => $this->terminal->terminal_name,
            'title' => $this->title,
            'job_type' => $this->job_type,
            'comission_rate' => $this->comission_rate,
            'minimum_comission' => $this->minimum_comission,
            'terminal_id' => $this->terminal_id,
            'job_expense' => collect($this->jobExpense)->map(function ($expense) {
                return [
                    'uid' => $expense['uid'],
                    'job_expend_field' => $expense['job_expend_field'],
                    'amount' => $expense['amount'],
                ];
            })->toArray(),
        ];
    }
}
