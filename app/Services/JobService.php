<?php

namespace App\Services;

use App\Models\Job;
use App\Models\RelianceJob;
use Illuminate\Support\Facades\DB;

class  JobService
{
    public function storeJob($data)
    {
        return DB::transaction(function () use ($data) {
            $job = RelianceJob::create([
                'buyer_name' => $data['buyer_name'],
                'invoice_no' => $data['invoice_no'],
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
                'job_no' => $data['job_no'],
            ]);

            // Perform additional operations if needed
            // Example: Log the job creation, send notifications, etc.

            return $job;

            return $job;
        });
    }
}
