<?php

namespace App\Services;

use App\Models\Job;
use App\Models\RelianceJob;
use App\Models\Terminal;
use Illuminate\Support\Facades\DB;

class  JobService
{
    public function storeJob($data)
    {
        return DB::transaction(function () use ($data) {
            $job = RelianceJob::create([
                'buyer_name' => $data['buyer_name'],
                'invoice_no' => $this->generateInvoiceNo(),
                'value_usd' => $data['value_usd'],
                'usd_rate' => $data['usd_rate'],
                'item' => $data['item'],
                'terminal_id' => $data['terminal_id'], // Ensure this is a valid UUID
                'party_id' => $data['party_id'],       // Ensure this is a valid UUID
                'lc_no' => $data['lc_no'],
                'be_no' => $data['be_no'],
                'sales_contact' => $data['sales_contact'],
                'ud_no' => $data['ud_no'],
                'ud_amendment_no' => $data['ud_amendment_no'],
                'job_type' => $data['job_type'],
                'master_bl_number' => $data['master_bl_number'],
                'house_bl_number' => $data['house_bl_number'],
                'quantity' => $data['quantity'],
                'ctns_pieces' => $data['ctns_pieces'],
                'weight' => $data['weight'],
                'agent_id' => $data['agent_id'],       // Ensure this is a valid UUID
                'status' => $data['status'],
                'voucher_amount' => $data['voucher_amount'],
                'job_no' => $this->generateJobNo($data),
                'created_by_type' => auth()->guard('web')->check() ? 'App\Models\User' : 'App\Models\Agent',
                'created_by_uid' => auth()->user()->uid ?? auth()->guard('agent')->user()->uid,
            ]);

            // Perform additional operations if needed
            // Example: Log the job creation, send notifications, etc.

            return $job;
        });
    }

    public function generateJobNo($data)
    {
        $agent_job_no = $data['job_no'];
        $termina_short_form = Terminal::where('uid', $data['terminal_id'])->first()->terminal_short_form;
        if ($agent_job_no) {
            $job_type = strtoupper($data['job_type']);
            if ($job_type == 'IMPORT') {
                $job_no = 'RI-(' . $termina_short_form . ')-I-' . $agent_job_no;
            } else {
                $job_no = 'RI-(' . $termina_short_form . ')-E-' . $agent_job_no;
            }

            return $job_no;
        }
        return 'JOB-' . time();
    }

    public function generateInvoiceNo()
    {
        $maxInvoiceNo = RelianceJob::max('invoice_no');
        return $maxInvoiceNo + 1;
    }
}
