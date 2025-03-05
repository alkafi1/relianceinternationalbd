<?php

namespace App\Http\Controllers;

use App\Enums\TerminalStatusEnum;
use App\Enums\TerminalTypeEnum;
use App\Http\Requests\Terminal\TerminalStoreRequest;
use App\Models\Terminal;
use App\Services\TerminalService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TerminalController extends Controller
{

    protected $terminalService;

    public function __construct(TerminalService $terminalService)
    {
        $this->terminalService = $terminalService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        return view('terminal.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    function create()
    {
        return view('terminal.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Terminal\TerminalStoreRequest  $request
     * @return \Illuminate\Http\Response
     */

    function store(TerminalStoreRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();

        // Store the terminal
        $termianl = $this->terminalService->store($validatedData);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Terminal created successfully.',
            'data' => $termianl,
        ], 201);
    }

    /**
     * Toggle the status of a terminal.
     *
     * @param \App\Models\Terminal $terminal
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Terminal $terminal)
    {
        // Toggle the status (1 to 0 or 0 to 1)
        $terminal->status = $terminal->status == 'active' ? 'deactive' : 'active';
        $terminal->save();

        // Return the new status in the response
        return response()->json([
            'success' => true,
            'message' => 'Terminal Status change successfully.',
        ], 201);
    }

    /**
     * Remove the specified terminal from storage.
     *
     * @param \App\Models\terminal $terminal The terminal instance to be destroyed
     * @return bool|null True if the terminal was successfully deleted, false if the deletion failed, or null if the terminal doesn't exist
     */
    public function destroy(Terminal $terminal)
    {
        return Terminal::destroyModel($terminal);
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $query = Terminal::query();

            return DataTables::of($query)
                // terminal ID (Sortable & Searchable)
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
                    return \Illuminate\Support\Str::limit($data->description ?? '', 20, '...');
                })
                ->addColumn('terminal_type', function ($data) {
                    $terminalTypeBadge = '<span class="terminal_type badge badge-light-' .
                        ($data->terminal_type == TerminalTypeEnum::BOTH()->value ? 'success' : ($data->terminal_type == TerminalTypeEnum::IMPORT()->value ? 'info' : 'warning')) . '"
                    title="Terminal Type: ' .
                        ($data->terminal_type == TerminalTypeEnum::BOTH()->value ? 'Both' : ($data->terminal_type == TerminalTypeEnum::IMPORT()->value ? 'Import' : 'Export')) . '">' .
                        ($data->terminal_type == TerminalTypeEnum::BOTH()->value ? 'Both' : ($data->terminal_type == TerminalTypeEnum::IMPORT()->value ? 'Import' : 'Export')) .
                        '</span>';

                    return $terminalTypeBadge;
                })
                ->addColumn('address', function ($data) {
                    return $data->address ?? '';
                })

                // Status Badge (Sortable & Searchable)
                ->addColumn('status', function ($data) {
                    $statusUrl = route('terminal.status', $data->uid);

                    return '<span class="status badge badge-light-' .
                        ($data->status == TerminalStatusEnum::ACTIVE()->value ? 'success' : 'danger') . '"
    title="Status: ' .
                        ($data->status == TerminalStatusEnum::ACTIVE()->value ? 'Active' : 'Deactive') . '"
    data-url="' . ($statusUrl ?? '#') . '">' .
                        ($data->status == TerminalStatusEnum::ACTIVE()->value ? 'Active' : 'Deactive') .
                        '</span>';
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

                    $deleteUrl = route('terminal.destroy', $data->uid);
                    return '
                        <a href="javascript:void(0)" class="view text-info me-2" data-id="' . $data->uid . '">
                            <i class="fas fa-eye text-info" style="font-size: 16px;"></i>
                        </a>
                        <a href="javascript:void(0)" class="edit text-primary me-2" data-id="' . $data->uid . '">
                            <i class="fas fa-edit text-primary" style="font-size: 16px;"></i>
                        </a>
                        <a href="javascript:void(0)" class="delete text-danger" data-id="' . $data->uid . '" data-url="' . $deleteUrl . '">
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
                ->rawColumns(['action', 'status', 'terminal_type'])
                ->toJson();
        }
    }
}
