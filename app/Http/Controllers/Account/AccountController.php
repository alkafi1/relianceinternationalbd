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
            // ✅ Apply status filter if provided
            if (!empty($request->status)) {
                $query->where('type', 'party');
            }
            // Apply custom sorting and filtering to the query
            return DataTables::of($query)
                ->addColumn('account_name', function ($data) {
                    return $data->account_name ?? '';
                })
                ->filterColumn('account_name', function ($query, $keyword) {
                    return $query->where('account_name', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('account_name', function ($query, $order) {
                    return $query->orderBy('account_name', $order);
                })

                ->addColumn('current_balance', function ($data) {
                    return $data->current_balance ?? '';
                })
                ->filterColumn('current_balance', function ($query, $keyword) {
                    return $query->where('current_balance', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('current_balance', function ($query, $order) {
                    return $query->orderBy('current_balance', $order);
                })

                ->addColumn('account_type', function ($data) {
                    return $data->account_type ?? '';
                })
                ->filterColumn('account_type', function ($query, $keyword) {
                    return $query->where('account_type', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('account_type', function ($query, $order) {
                    return $query->orderBy('account_type', $order);
                })
                ->addColumn('created_at', function ($data) {
                    return $data->created_at;
                })

                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') LIKE ?", ["%{$keyword}%"]);
                })
                ->orderColumn('created_at', function ($query, $order) {
                    $query->orderBy('created_at', $order);
                })
                // Action Buttons (Not Sortable or Searchable)
                ->addColumn('action', function ($data) {
                    $editUrl = route('party.edit', $data->uid);
                    return '
                        <a href="javascript:void(0)" class="view text-info me-2" data-id="' . $data->uid . '">
                            <i class="fas fa-eye text-info" style="font-size: 16px;"></i>
                        </a>
                        
                        <a href="javascript:void(0)" class="delete text-danger" data-id="' . $data->uid . '">
                            <i class="fas fa-trash text-danger" style="font-size: 16px;"></i>
                        </a>';
                })

                // Allow raw HTML in action and status columns
                ->rawColumns(['action', 'account_name', 'current_balance', 'account_type', 'created_at'])
                ->toJson();
        }
    }
}
