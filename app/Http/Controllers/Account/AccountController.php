<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.index');
    }

    public function datatable(Request $request)
    {
        // Check if the request is an AJAX request
        if ($request->ajax()) {
            $query = Account::query();

            // Apply custom sorting and filtering to the query
            return DataTables::of($query)
                ->addColumn('account_name', fn($data) => $data->account_name ?? '')
                ->filterColumn('account_name', fn($query, $keyword) => $query->where('account_name', 'LIKE', "%{$keyword}%"))
                ->orderColumn('account_name', fn($query, $order) => $query->orderBy('account_name', $order))

                ->addColumn('current_balance', fn($data) => $data->current_balance ?? '')
                ->filterColumn('current_balance', fn($query, $keyword) => $query->where('current_balance', 'LIKE', "%{$keyword}%"))
                ->orderColumn('current_balance', fn($query, $order) => $query->orderBy('current_balance', $order))

                ->addColumn('account_type', fn($data) => $data->account_type ?? '')
                ->filterColumn('account_type', fn($query, $keyword) => $query->where('account_type', 'LIKE', "%{$keyword}%"))
                ->orderColumn('account_type', fn($query, $order) => $query->orderBy('account_type', $order))
                
                // Action Buttons (Not Sortable or Searchable)
                ->addColumn('action', function ($data) {
                    $editUrl = route('party.edit', $data->uid);
                    return '
                        <a href="javascript:void(0)" class="view text-info me-2" data-id="' . $data->uid . '">
                            <i class="fas fa-eye text-info" style="font-size: 16px;"></i>
                        </a>
                        <a href="' . $editUrl . '" class="text-primary me-2" data-id="' . $data->uid . '">
                            <i class="fas fa-edit text-primary" style="font-size: 16px;"></i>
                        </a>
                        <a href="javascript:void(0)" class="delete text-danger" data-id="' . $data->uid . '">
                            <i class="fas fa-trash text-danger" style="font-size: 16px;"></i>
                        </a>';
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? $data->created_at->format('Y-m-d H:i:s') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') LIKE ?", ["%{$keyword}%"]);
                })
                ->orderColumn('created_at', function ($query, $order) {
                    $query->orderBy('created_at', $order);
                })
                // Allow raw HTML in action and status columns
                ->rawColumns(['action',])
                ->toJson();
        }
    }
}
