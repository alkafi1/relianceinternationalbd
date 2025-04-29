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
        return view('job.index',[
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
                'agent'
            ])->where('agent_id', auth('agent')->user()->uid);
        } else {
            $query = RelianceJob::with([
                'billRegister',
                'terminal',
                'party',
                'agent'
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
        
                ->addColumn('value_usd', function ($data) {
                    return number_format($data->value_usd, 2);
                })
                ->orderColumn('value_usd', function ($query, $order) {
                    return $query->orderBy('value_usd', $order);
                })
        
                ->addColumn('usd_rate', function ($data) {
                    return number_format($data->usd_rate, 2);
                })
                ->orderColumn('usd_rate', function ($query, $order) {
                    return $query->orderBy('usd_rate', $order);
                })
        
                ->addColumn('job_type', function ($data) {
                    return ucfirst($data->job_type);
                })
                ->orderColumn('job_type', function ($query, $order) {
                    return $query->orderBy('job_type', $order);
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
                    $actions = [
                        'view' => '<a href="javascript:void(0)" class="dropdown-item view" data-id="' . $data->id . '">
                                <i class="fas fa-eye text-info"></i> View
                            </a>',
                        'edit' => $guard === 'web' ? '<a href="' . $editUrl . '" class="dropdown-item">
                                <i class="fas fa-edit text-primary"></i> Edit
                            </a>' : '',
                        'delete' => '<a href="javascript:void(0)" class="dropdown-item delete text-danger" data-id="' . $data->id . '">
                                <i class="fas fa-trash text-danger"></i> Delete
                            </a>',
                    ];
                    return '
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton' . $data->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $data->id . '">
                            ' . implode('', $actions) . '
                        </ul>
                    </div>';
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

        // Fetch active terminals
        $terminals = Terminal::fetchByStatus('status', TerminalStatusEnum::ACTIVE()->value);

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
}
