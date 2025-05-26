<?php

namespace App\Http\Controllers\Job;

use App\Enums\AgentStatus;
use App\Enums\JobStatusEnum;
use App\Enums\PartyStatusEnum;
use App\Enums\TerminalStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Models\Agent;
use App\Models\Party;
use App\Models\RelianceJob;
use App\Models\Terminal;
use App\Models\TerminalExpense;
use App\Services\JobService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JobController extends Controller
{
    /**
     * The job service instance.
     *
     * @var JobService
     */
    protected $jobService;

    /**
     * Create a new controller instance.
     *
     * @param  JobService  $jobService
     * @return void
     */
    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index()
    {
        // Fetch approved agents
        $agents = Agent::fetchByStatus('status', AgentStatus::APPROVED()->value);

        // Fetch active terminals
        $terminals = Terminal::fetchByStatus('status', TerminalStatusEnum::ACTIVE()->value);

        // Fetch approved parties
        $parties = Party::fetchByStatus('status', PartyStatusEnum::APPROVED()->value);
        return view('job.index', [
            'agents' => $agents,
            'terminals' => $terminals,
            'parties' => $parties
        ]);
    }

    public function datatable(Request $request)
    {
        if (auth('agent')->check()) {
            $query = RelianceJob::with([
                'billRegister',
                'terminal',
                'party',
                'agent',
                'relianceJobExpenseSummury'
            ])->where('agent_id', auth('agent')->user()->uid);
        } else {
            $query = RelianceJob::with([
                'billRegister',
                'terminal',
                'party',
                'agent',
                'relianceJobExpenseSummury'
            ]);
        }
        $query->latest();

        if ($request->ajax()) {

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }
            if ($request->has('terminal') && !empty($request->terminal)) {
                $query->where('terminal_id', $request->terminal);
            }
            if ($request->has('agent') && !empty($request->agent)) {
                $query->where('agent_id', $request->agent);
            }
            if ($request->has('party') && !empty($request->party)) {
                $query->where('party_id', $request->party);
            }
            if ($request->has('start_date') && !empty($request->start_date)) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }
            if ($request->has('end_date') && !empty($request->end_date)) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }

            return DataTables::of($query)
                // Serial Number Column
                ->addColumn('serial', function ($data) {
                    static $index = 0;
                    return ++$index;
                })
                ->orderColumn('serial', function ($query, $order) {
                    $query->orderBy('uid', $order);
                })
                ->addColumn('job_no', function ($data) {
                    return $data->job_no ?? '';
                })
                ->orderColumn('job_no', function ($query, $order) {
                    return $query->orderBy('job_no', $order);
                })

                ->addColumn('bill_no', function ($data) {
                    return $data->billRegister->bill_no ?? '';
                })
                ->orderColumn('bill_no', function ($query, $order) {
                    return $query->orderBy('billRegister.bill_no', $order);
                })

                ->addColumn('total_job_expense', function ($data) {
                    return $data->relianceJobExpenseSummury->total_expenses ?? '0.00';
                })
                ->orderColumn('total_job_expense', function ($query, $order) {
                    return $query->orderBy('relianceJobExpenseSummury.total_expenses', $order);
                })
                ->addColumn('commissoin', function ($data) {
                    return $data->relianceJobExpenseSummury->agency_commission ?? '0.00';
                })
                ->orderColumn('commissoin', function ($query, $order) {
                    return $query->orderBy('relianceJobExpenseSummury.commissoin', $order);
                })
                ->addColumn('advanced_received', function ($data) {
                    return $data->relianceJobExpenseSummury->advanced_received ?? '0.00';
                })
                ->orderColumn('advanced_received', function ($query, $order) {
                    return $query->orderBy('relianceJobExpenseSummury.advanced_received', $order);
                })
                ->addColumn('total_bill_amount', function ($data) {
                    return $data->relianceJobExpenseSummury->grand_total ?? '0.00';
                })
                ->orderColumn('total_bill_amount', function ($query, $order) {
                    return $query->orderBy('relianceJobExpenseSummury.grand_total', $order);
                })

                ->addColumn('buyer_name', function ($data) {
                    return $data->buyer_name ?? '';
                })
                ->orderColumn('buyer_name', function ($query, $order) {
                    return $query->orderBy('buyer_name', $order);
                })

                ->addColumn('terminal', function ($data) {
                    return $data->terminal?->terminal_name ?? '';
                })
                ->orderColumn('terminal', function ($query, $order) {
                    return $query->orderBy('terminal_name', $order);
                })

                ->addColumn('party_name', function ($data) {
                    return $data->party?->party_name ?? '';
                })
                ->orderColumn('party_name', function ($query, $order) {
                    return $query->orderBy('party_name', $order);
                })

                ->addColumn('agent', function ($data) {
                    return $data->agent?->display_name ?? '';
                })

                ->addColumn('invoice_no', function ($data) {
                    return $data->invoice_no ?? '';
                })
                ->orderColumn('invoice_no', function ($query, $order) {
                    return $query->orderBy('invoice_no', $order);
                })

                ->addColumn('job_type', function ($data) {
                    return ucfirst($data->job_type);
                })
                ->orderColumn('job_type', function ($query, $order) {
                    return $query->orderBy('job_type', $order);
                })
                ->addColumn('audited_amount', function ($data) {
                    return $data->relianceJobExpenseSummury->audited_amount ?? '0.00';
                })
                ->orderColumn('audited_amount', function ($query, $order) {
                    return $query->orderBy('relianceJobExpenseSummury.audited_amount', $order);
                })
                ->addColumn('actual_profit', function ($data) {
                    return ($data->relianceJobExpenseSummury->grand_total  - $data->voucher_amount) ?? '0.00';
                })
                ->orderColumn('actual_profit', function ($query, $order) {
                    return $query->orderBy('relianceJobExpenseSummury.grand_total', $order);
                })
                ->addColumn('vat', function ($data) {
                    $vatExpense = $data->relianceJobExpense->firstWhere('job_expend_field', 'Vat');
                    return $vatExpense ? $vatExpense->amount : '0.00';
                })

                ->addColumn('status', function ($data) {
                    $statusColors = [
                        'COMPLETED' => 'success',
                        'PROCESSING' => 'primary',
                        'CANCELLED' => 'danger',
                        'INITIALIZED_BY_AGENT' => 'warning',
                    ];
                    $statusColor = $statusColors[strtoupper($data->status)] ?? 'secondary';
                    return '<span class="badge badge-light-' . $statusColor . '">' . ucfirst(strtolower($data->status)) . '</span>';
                })
                ->orderColumn('status', function ($query, $order) {
                    return $query->orderBy('status', $order);
                })

                ->addColumn('action', function ($data) {
                    $guard = auth()->guard('agent')->check() ? 'agent' : 'web';
                    $editUrl = route('job.edit', ['job' => $data->uid]);
                    $deleteUrl = route('job.destroy', ['job' => $data->uid]);

                    $actions = [];

                    // View icon button
                    $actions[] = '<a href="javascript:void(0)" class=" me-2 view" data-id="' . $data->uid . '" title="View">
                    <i class="fas fa-eye text-info"></i>
                        </a>';

                    // Edit icon button (only if web)
                    if ($guard === 'web') {
                        $actions[] = '<a href="' . $editUrl . '" class="text-primary me-2" title="Edit">
                                <i class="fas fa-edit text-primary"></i>
                            </a>';
                    }

                    // Delete icon button
                    $actions[] = '<a href="javascript:void(0)" class="text-danger delete" data-id="' . $data->uid . '" title="Delete">
                            <i class="fas fa-trash text-danger"></i>
                        </a>';

                    return '<div class="d-flex align-items-center gap-2 justify-content-center">' . implode('', $actions) . '</div>';
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? $data->created_at->format('Y-m-d H:i:s') : '';
                })
                ->orderColumn('created_at', function ($query, $order) {
                    return $query->orderBy('created_at', $order);
                })

                ->rawColumns(['action', 'status'])
                ->toJson();
        }
    }



    public function create(Request $request)
    {
        // Fetch approved agents
        $agents = Agent::fetchByStatus('status', AgentStatus::APPROVED()->value);

        $terminals = Terminal::where('status', TerminalStatusEnum::ACTIVE()->value)
            ->whereHas('terminalExpense')
            ->get();
        // Fetch approved parties
        $parties = Party::fetchByStatus('status', PartyStatusEnum::APPROVED()->value);

        // Pass the agents, terminals, and parties to the view
        return view('job.create', [
            'agents' => $agents,
            'terminals' => $terminals,
            'parties' => $parties
        ]);
    }



    /**
     * Store a newly created job in storage.
     *
     * @param  \App\Http\Requests\Job\StoreJobRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreJobRequest $request)
    {
        try {
            // Get validated data from the request
            $data = $request->validated();
            // Use the service to store the job
            $job = $this->jobService->storeJob($data);

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Job created successfully!',
                'data' => $job,
            ], 201);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the job.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(RelianceJob $job)
    {
        // Fetch approved agents
        $agents = Agent::fetchByStatus('status', AgentStatus::APPROVED()->value);

        // Fetch active terminals
        $terminals = Terminal::fetchByStatus('status', TerminalStatusEnum::ACTIVE()->value);

        // Fetch approved parties
        $parties = Party::fetchByStatus('status', PartyStatusEnum::APPROVED()->value);

        if ($job->status == JobStatusEnum::COMPLETED()->value) {
            $terminalExpense = $job->relianceJobExpense;
        } else {
            $terminalExpense = $job->terminal->terminalExpense->where('job_type', $job->job_type)->first()->jobExpense;
            // dd($terminalExpense);
        }



        // Pass the agents, terminals, and parties to the view
        return view('job.edit', compact('job', 'agents', 'terminals', 'parties', 'terminalExpense'));
    }

    public function update(UpdateJobRequest $request, $id)
    {
        try {
            // Get validated data from the request
            $data = $request->validated();

            // Use the service to update the job
            $job = $this->jobService->updateJob($id, $data);

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Job updated successfully!',
                'data' => $job,
            ], 200);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the job.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(RelianceJob $job)
    {
        try {
            $job->relianceJobExpense()->delete();
            $job->relianceJobExpenseSummury()->delete();
            $job->billRegister()->delete();
            $job->delete();
            return response()->json([
                'success' => true,
                'message' => 'Job deleted successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the job.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // job report
    public function reportIndex()
    {
        return view('job.report.index');
    }
}
