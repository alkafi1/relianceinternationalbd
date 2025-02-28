<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TerminalController extends Controller
{
    function index()
    {
        $terminal_infos = Terminal::all();
        return view('terminal.index', [
            'terminal_infos' => $terminal_infos,
        ]);
    }

    public function datatable(Request $request)
    {
        $query = Terminal::latest();

        if ($request->ajax()) {
            $query = Terminal::query();

            return DataTables::of($query)
                // Agent ID (Sortable & Searchable)
                ->addColumn('terminal_id', function ($data) {
                    return $data->terminal_id ?? '';
                })

                // Full Name (Concatenated, needs custom sorting & filtering)
                ->addColumn('terminal_name', function ($data) {
                    return $data->terminal_name ?? '';
                })

                // Static Column (Not Sortable)
                ->addColumn('terminal_short_form', function ($data) {
                    return $data->terminal_short_form ?? '';
                })

                // Phone, Email, Age, Address (Sortable & Searchable)
                ->addColumn('description', function ($data) {
                    return $data->description ?? '';
                })
                ->addColumn('terminal_type', function ($data) {
                    return $data->terminal_type ?? '';
                })
                ->addColumn('address', function ($data) {
                    return $data->address ?? '';
                })

                // Status Badge (Sortable & Searchable)
                ->addColumn('status', function ($data) {
                    return '<span class="status badge badge-light-' . ($data->status == 1 ? 'success' : 'danger') . '"
                            title="Status: ' . ($data->status == 1 ? 'Active' : 'Inactive') . '">' .
                        ($data->status == 1 ? 'Active' : 'Inactive') . '</span>';
                })
                ->filterColumn('status', function ($query, $keyword) {
                    if (stripos('Active', $keyword) !== false) {
                        $query->where('status', 1);
                    } elseif (stripos('Inactive', $keyword) !== false) {
                        $query->where('status', 0);
                    }
                })
                ->orderColumn('status', function ($query, $order) {
                    $query->orderBy('status', $order);
                })

                // Action Buttons (Not Sortable or Searchable)
                ->addColumn('action', function ($data) {
                    return '
                        <a href="javascript:void(0)" class="view text-info me-2" data-id="' . $data->uid . '">
                            <i class="fas fa-eye text-info" style="font-size: 16px;"></i>
                        </a>
                        <a href="javascript:void(0)" class="edit text-primary me-2" data-id="' . $data->uid . '">
                            <i class="fas fa-edit text-primary" style="font-size: 16px;"></i>
                        </a>
                        <a href="javascript:void(0)" class="delete text-danger" data-id="' . $data->uid . '">
                            <i class="fas fa-trash text-danger" style="font-size: 16px;"></i>
                        </a>';
                })

                // Last Updated & Created At (Formatted, Sortable & Searchable)
                ->editColumn('last_updated', function ($data) {
                    return $data->updated_at ? $data->updated_at->format('Y-m-d H:i:s') : '';
                })
                ->filterColumn('last_updated', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i:%s') LIKE ?", ["%{$keyword}%"]);
                })
                ->orderColumn('last_updated', function ($query, $order) {
                    $query->orderBy('updated_at', $order);
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
                ->rawColumns(['action', 'status'])
                ->toJson();
        }
    }
}