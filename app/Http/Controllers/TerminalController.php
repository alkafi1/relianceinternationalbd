<?php

namespace App\Http\Controllers;

use App\Enums\TerminalStatusEnum;
use App\Enums\TerminalTypeEnum;
use App\Http\Requests\Terminal\TerminalExpenseStoreRequest;
use App\Http\Requests\Terminal\TerminalStoreRequest;
use App\Http\Resources\Termina\Expesne\TerminalExpenseShowResource;
use App\Models\Jobexpense;
use App\Models\Terminal;
use App\Models\TerminalExpense;
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
                        <a href="javascript:void(0)" class="show text-info me-2" data-id="' . $data->uid . '">
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

    // expense

    /**
     * Renders the terminal expense list view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function expenseList()
    {
        return view('terminal.expense.index');
    }

    public function datatableTerminalExpense(Request $request)
    {
        if ($request->ajax()) {
            $query = TerminalExpense::with('terminal');

            return DataTables::of($query)
                // Terminal Name (Sortable & Searchable)
                ->addColumn('terminal_name', function ($data) {
                    return $data->terminal->terminal_name ?? ''; // Assuming a relationship with the Terminal model
                })

                // Title (Sortable & Searchable)
                ->addColumn('title', function ($data) {
                    return $data->title ?? '';
                })

                // Job Type (Sortable & Searchable)
                ->addColumn('job_type', function ($data) {
                    $jobTypeBadge = '<span class="job_type badge badge-light-' .
                        ($data->job_type == 'both' ? 'success' : ($data->job_type == 'import' ? 'info' : 'warning')) . '"
                    title="Job Type: ' .
                        ($data->job_type == 'both' ? 'Both' : ($data->job_type == 'import' ? 'Import' : 'Export')) . '">' .
                        ($data->job_type == 'both' ? 'Both' : ($data->job_type == 'import' ? 'Import' : 'Export')) .
                        '</span>';

                    return $jobTypeBadge;
                })
                ->filterColumn('job_type', function ($query, $keyword) {
                    if (stripos('Both', $keyword) !== false) {
                        $query->where('job_type', 'both');
                    } elseif (stripos('Import', $keyword) !== false) {
                        $query->where('job_type', 'import');
                    } elseif (stripos('Export', $keyword) !== false) {
                        $query->where('job_type', 'export');
                    }
                })
                ->orderColumn('job_type', function ($query, $order) {
                    $query->orderBy('job_type', $order);
                })

                // Commission Rate (Sortable & Searchable)
                ->addColumn('comission_rate', function ($data) {
                    return $data->comission_rate ?? '';
                })

                // Minimum Commission (Sortable & Searchable)
                ->addColumn('minimum_comission', function ($data) {
                    return $data->minimum_comission ?? '';
                })

                // Status (Sortable & Searchable)
                ->addColumn('status', function ($data) {
                    $statusUrl = route('terminal.expense.status', $data->uid);

                    return '<span class="status badge badge-light-' .
                        ($data->status == 'active' ? 'success' : 'danger') . '"
                    title="Status: ' .
                        ($data->status == 'active' ? 'Active' : 'Inactive') . '"
                    data-url="' . ($statusUrl ?? '#') . '">' .
                        ($data->status == 'active' ? 'Active' : 'Inactive') .
                        '</span>';
                })
                ->filterColumn('status', function ($query, $keyword) {
                    if (stripos('Active', $keyword) !== false) {
                        $query->where('status', 'active');
                    } elseif (stripos('Inactive', $keyword) !== false) {
                        $query->where('status', 'inactive');
                    }
                })
                ->orderColumn('status', function ($query, $order) {
                    $query->orderBy('status', $order);
                })

                // Action Buttons (Not Sortable or Searchable)
                ->addColumn('action', function ($data) {
                    $deleteUrl = route('terminal.expense.destroy', $data->uid);

                    $showUrl = route('terminal.expense.show', $data->uid);
                    return '
                    <a href="javascript:void(0)" class="details text-info me-2" data-id="' . $data->uid . '" data-url="' . $showUrl . '">
                        <i class="fas fa-eye text-info" style="font-size: 16px;"></i>
                    </a>
                    <a href="javascript:void(0)" class="delete text-danger" data-id="' . $data->uid . '" data-url="' . $deleteUrl . '">
                        <i class="fas fa-trash text-danger" style="font-size: 16px;"></i>
                    </a>';
                })

                // Allow raw HTML in action, status, and job_type columns
                ->rawColumns(['action', 'status', 'job_type'])
                ->toJson();
        }
    }

    /**
     * Display the terminal expense creation form.
     *
     * This method retrieves all active terminals and passes them
     * to the terminal expense creation view.
     *
     * @return \Illuminate\View\View The view for creating a terminal expense.
     */

    public function expenseCreate()
    {
        $terminals = Terminal::where('status', TerminalStatusEnum::ACTIVE()->value)->get();
        return view('terminal.expense.create', compact('terminals'));
    }

    /**
     * Store a newly created terminal expense in storage.
     *
     * This method validates the incoming request, stores the terminal expense
     * using the TerminalService, and returns a JSON response indicating
     * success or failure.
     *
     * @param TerminalExpenseStoreRequest $request The incoming request containing
     * validated terminal expense data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing success status,
     * message, and the stored terminal expense data.
     */

    public function expenseStore(TerminalExpenseStoreRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();
        // Store the terminal
        $termianl = $this->terminalService->expenseStore($validatedData);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Terminal expense created successfully.',
            'data' => $termianl,
        ], 201);
    }

    public function destroyExpense(TerminalExpense $terminalExpense)
    {
        return TerminalExpense::destroyModel($terminalExpense);
    }
    /**
     * Toggle the status of a terminal expense.
     *
     * This method switches the terminal expense status between 'active' and 'deactive',
     * saves the updated status, and returns a JSON response indicating success.
     *
     * @param \App\Models\TerminalExpense $terminalExpense The terminal expense instance to update.
     * @return \Illuminate\Http\JsonResponse A JSON response containing success status and a message.
     */
    public function updateStatusExpense(TerminalExpense $terminalExpense)
    {
        // Toggle the status (1 to 0 or 0 to 1)
        $terminalExpense->status = $terminalExpense->status == 'active' ? 'deactive' : 'active';
        $terminalExpense->save();

        // Return the new status in the response
        return response()->json([
            'success' => true,
            'message' => 'Terminal Expense Status change successfully.',
        ], 201);
    }

    public function show(TerminalExpense $terminalExpense)
    {
        // $terminalExpense = new TerminalExpenseShowResource($terminalExpense->load('jobExpense', 'terminal'));
        $terminalExpense->load('jobExpense', 'terminal');
        // Generate HTML using a Blade view
        $html = view('terminal.expense.partials.terminal_expense_details', [
            'terminalExpense' => $terminalExpense,
        ])->render();

        // dd($html);
        // $terminalExpense->load('jobExpense');
        return response()->json([
            'success' => true,
            'data' => $terminalExpense,
            'html' => $html
        ], 200);
    }

    // public function datatableTerminalExpenseJObField(Request $request, $terminalExpense)
    // {
    //     dd($terminalExpense);
    //     if ($request->ajax()) {
    //         $query = Jobexpense::with('terminal')->where('terminal_expense_id', $terminalExpense->uid);

    //         return DataTables::of($query)
    //             // Terminal Name (Sortable & Searchable)
    //             ->addColumn('terminal_name', function ($data) {
    //                 return $data->terminal->terminal_name ?? ''; // Assuming a relationship with the Terminal model
    //             })

    //             // Title (Sortable & Searchable)
    //             ->addColumn('title', function ($data) {
    //                 return $data->title ?? '';
    //             })

    //             // Amount (Sortable & Searchable)

    //             // Action Buttons (Not Sortable or Searchable)
    //             ->addColumn('action', function ($data) {
    //                 $deleteUrl = route('terminal.expense.destroy', $data->uid);

    //                 return '
    //                 <a href="javascript:void(0)" class="delete text-danger" data-id="' . $data->uid . '" data-url="' . $deleteUrl . '">
    //                     <i class="fas fa-trash text-danger" style="font-size: 16px;"></i>
    //                 </a>';
    //             })
    //             // Allow raw HTML in action, status, and job_type columns
    //             ->rawColumns(['action', 'status'])
    //             ->toJson();
    //     }
    // }
}
