<?php

namespace App\Http\Controllers\Bill;

use App\Http\Controllers\Controller;
use App\Models\BillRegister;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BillController extends Controller
{
    public function index()
    {
        return view('bill.register-index');
    }

    public function datatable(Request $request)
    {
        $query = BillRegister::with(['party', 'job']); // Eager loading to prevent N+1 query

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addColumn('job_no', function ($data) {
                    return $data->job?->job_no ?? '-';
                })
                ->addColumn('party_name', function ($data) {
                    return $data->party?->party_name ?? '-';
                })
                ->addColumn('bill_no', function ($data) {
                    return $data->bill_no ?? '-';
                })
                ->addColumn('bill_amount', function ($data) {
                    return number_format($data->bill_amount, 2);
                })
                ->addColumn('bill_date', function ($data) {
                    return $data->bill_date ? $data->bill_date->format('Y-m-d') : '-';
                })
                ->addColumn('received_amount', function ($data) {
                    return number_format($data->received_amount, 2);
                })
                ->addColumn('received_date', function ($data) {
                    return $data->received_date ? $data->received_date->format('Y-m-d') : '-';
                })
                ->addColumn('due_amount', function ($data) {
                    return number_format($data->due_amount, 2);
                })
                ->addColumn('remarks', function ($data) {
                    return $data->remarks ?? '-';
                })
                ->addColumn('action', function ($data) {
                    $editUrl = route('job.edit', ['job' => $data->uid]);
                    return '
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton' . $data->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $data->id . '">
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-item view" data-id="' . $data->id . '">
                                        <i class="fas fa-eye text-info"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a href="' . $editUrl . '" class="dropdown-item">
                                        <i class="fas fa-edit text-primary"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-item delete text-danger" data-id="' . $data->id . '">
                                        <i class="fas fa-trash text-danger"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>';
                })
                ->filterColumn('job_no', function ($query, $keyword) {
                    $query->whereHas('job', function ($q) use ($keyword) {
                        $q->where('job_no', 'LIKE', "%{$keyword}%");
                    });
                })
                ->filterColumn('party_name', function ($query, $keyword) {
                    $query->whereHas('party', function ($q) use ($keyword) {
                        $q->where('party_name', 'LIKE', "%{$keyword}%");
                    });
                })
                ->filterColumn('bill_no', function ($query, $keyword) {
                    $query->where('bill_no', 'LIKE', "%{$keyword}%");
                })
                ->filterColumn('bill_date', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(bill_date, '%Y-%m-%d') LIKE ?", ["%{$keyword}%"]);
                })
                ->filterColumn('received_date', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(received_date, '%Y-%m-%d') LIKE ?", ["%{$keyword}%"]);
                })
                ->orderColumn('bill_no', function ($query, $order) {
                    $query->orderBy('bill_no', $order);
                })
                ->orderColumn('bill_date', function ($query, $order) {
                    $query->orderBy('bill_date', $order);
                })
                ->orderColumn('due_amount', function ($query, $order) {
                    $query->orderBy('due_amount', $order);
                })
                ->editColumn('created_at', fn ($data) => $data->created_at ? $data->created_at->format('Y-m-d H:i:s') : '')
                ->filterColumn('created_at', fn ($query, $keyword) => 
                    $query->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') LIKE ?", ["%{$keyword}%"])
                )
                ->orderColumn('created_at', fn ($query, $order) => $query->orderBy('created_at', $order))
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
