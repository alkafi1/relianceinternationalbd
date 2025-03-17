<?php

namespace App\Services;

use App\Enums\JobStatusEnum;
use App\Models\BillRegister;
use App\Models\Job;
use App\Models\RelianceJob;
use App\Models\RelianceJobExpense;
use App\Models\RelianceJobExpenseSummury;
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
                'job_no' => $data['job_no'],
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

    public function updateJob($uid, $data)
    {
        $job =  RelianceJob::where('uid', $uid)->first();

        return DB::transaction(function () use ($job, $data) {
            $job->update([
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
                // 'agent_id' => $data['agent_id'],       // Ensure this is a valid UUID
                'status' => $data['status'],
                'voucher_amount' => $data['voucher_amount'],
                'job_no' => $data['status'] == JobStatusEnum::COMPLETED()->value ? $this->generateJobNo($data) : $data['job_no'],
                'updated_by_type' => auth()->guard('web')->check() ? 'App\Models\User' : 'App\Models\Agent',
                'updated_by_uid' => auth()->user()->uid ?? auth()->guard('agent')->user()->uid,
                'comment' => $data['comment'],
                'job_complete_date' => $data['job_date'],
            ]);

            foreach ($data['job_expend_field'] as $index => $field) {
                // Check if a job expense record already exists, if not, create it
                RelianceJobExpense::create(
                    [
                        'job_id' => $job->uid,
                        'job_expend_field' => $data['job_expend_field'][$index],
                        'amount' => $data['amount'][$index],
                    ]
                );
            }

            RelianceJobExpenseSummury::create(
                [
                    'job_id' => $job->uid,
                    'agency_commission' => $data['agency_commission'] ?? 0.00,
                    'total_expenses' => $data['total_expenses'] ?? 0.00,
                    'advanced_received' => $data['advanced_received'] ?? 0.00,
                    'due' => $data['due'] ?? 0.00,
                    'grand_total' => $data['grand_total'] ?? 0.00,
                ]
            );
            if ($data['status'] == JobStatusEnum::COMPLETED()->value) {
                $billRegister = BillRegister::create([
                    'job_id' => $job->uid,
                    'job_no' => $data['job_no'],
                    'party_id' => $data['party_id'],
                    'bill_no' => $this->generateBillNo($data),
                    'bill_amount' => $data['grand_total'],
                    'bill_date' => $data['bill_date']?? '',
                    'received_amount' => $data['received_amount'] ?? 0.00,
                    'received_date' => $data['received_date'] ?? '',
                    'due_amount' => $data['due_amount'] ?? 0.00,
                    'remarks' => $data['comment'],
                ]);
            }


            // Perform additional operations if needed
            // Example: Log the job update, send notifications, etc.

            return $job;
        });
    }

    /**
     * Generates a unique bill number based on the party ID and job type.
     *
     * The bill number is in the format RI-[E|I]-[4 digit sequence number]-[2 digit year].
     * The sequence number is obtained from the last bill number for the party ID.
     *
     * @param array $data The job data array.
     * @return string The generated bill number.
     */
    public function generateBillNo(array $data): string
    {
        // Get the job type (E or I) from the provided data
        $job_type = strtoupper($data['job_type']) == 'EXPORT' ? 'E' : 'I';

        // Get the party ID from the provided data
        $party_id = $data['party_id'];

        // Get the last bill number for the party ID from the database
        $lastBillNo = BillRegister::where('party_id', $party_id)->max('bill_no');

        // If there are no previous bill numbers, set the sequence number to 1
        if (empty($lastBillNo)) {
            $sequenceNumber = 1;
        } else {
            // Otherwise, extract the sequence number from the last bill number
            // and increment it by 1
            $sequenceNumber = (int)substr($lastBillNo, 5) + 1;
        }

        // Format the sequence number to have 4 digits, padded with zeros
        $formattedSequenceNumber = str_pad($sequenceNumber, 4, '0', STR_PAD_LEFT);

        // Build the bill number in the format RI-[E|I]-[4 digit sequence number]-[2 digit year]
        $billNo = 'RI-' . $job_type . '-' . $formattedSequenceNumber . '-' . date('y');

        // Return the generated bill number
        return $billNo;
    }
}
