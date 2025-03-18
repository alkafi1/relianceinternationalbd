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
        return view('job.index');
    }

    public function datatable(Request $request)
    {
        $query = RelianceJob::with([
            'billRegister',
            'terminal',
            'party',
            'agent'
        ])->latest();

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addColumn('job_no', fn($data) => $data->job_no ?? '')
                ->filterColumn('job_no', fn($query, $keyword) => $query->where('job_no', 'LIKE', "%{$keyword}%"))
                ->orderColumn('job_no', fn($query, $order) => $query->orderBy('job_no', $order))

                ->addColumn('bill_no', fn($data) => $data->billRegister->bill_no ?? '')
                ->filterColumn(
                    'bill_no',
                    fn($query, $keyword) =>
                    $query->whereHas('billRegister', fn($q) => $q->where('bill_no', 'LIKE', "%{$keyword}%"))
                )
                ->orderColumn('bill_no', fn($query, $order) => $query->orderBy('billRegister.bill_no', $order))

                ->addColumn('buyer_name', fn($data) => $data->buyer_name ?? '')
                ->filterColumn('buyer_name', fn($query, $keyword) => $query->where('buyer_name', 'LIKE', "%{$keyword}%"))
                ->orderColumn('buyer_name', fn($query, $order) => $query->orderBy('buyer_name', $order))

                ->addColumn('terminal', fn($data) => $data->terminal?->terminal_name ?? '')
                ->filterColumn(
                    'terminal',
                    fn($query, $keyword) =>
                    $query->whereHas('terminal', fn($q) => $q->where('terminal_name', 'LIKE', "%{$keyword}%"))
                )
                ->orderColumn('terminal', fn($query, $order) => $query->orderBy('terminal_name', $order))

                ->addColumn('party_name', fn($data) => $data->party?->party_name ?? '')
                ->filterColumn(
                    'party_name',
                    fn($query, $keyword) =>
                    $query->whereHas('party', fn($q) => $q->where('party_name', 'LIKE', "%{$keyword}%"))
                )
                ->orderColumn('party_name', fn($query, $order) => $query->orderBy('party_name', $order))

                ->addColumn('agent', fn($data) => $data->agent?->display_name ?? '')
                ->filterColumn(
                    'agent',
                    fn($query, $keyword) =>
                    $query->whereHas('agent', fn($q) => $q->where('display_name', 'LIKE', "%{$keyword}%"))
                )
                ->orderColumn('agent', fn($query, $order) => $query->orderBy('display_name', $order))

                ->addColumn('invoice_no', fn($data) => $data->invoice_no ?? '')
                ->filterColumn('invoice_no', fn($query, $keyword) => $query->where('invoice_no', 'LIKE', "%{$keyword}%"))
                ->orderColumn('invoice_no', fn($query, $order) => $query->orderBy('invoice_no', $order))

                ->addColumn('value_usd', fn($data) => number_format($data->value_usd, 2))
                ->filterColumn('value_usd', fn($query, $keyword) => $query->where('value_usd', 'LIKE', "%{$keyword}%"))
                ->orderColumn('value_usd', fn($query, $order) => $query->orderBy('value_usd', $order))

                ->addColumn('usd_rate', fn($data) => number_format($data->usd_rate, 2))
                ->filterColumn('usd_rate', fn($query, $keyword) => $query->where('usd_rate', 'LIKE', "%{$keyword}%"))
                ->orderColumn('usd_rate', fn($query, $order) => $query->orderBy('usd_rate', $order))

                ->addColumn('job_type', fn($data) => ucfirst($data->job_type))
                ->filterColumn('job_type', fn($query, $keyword) => $query->where('job_type', 'LIKE', "%{$keyword}%"))
                ->orderColumn('job_type', fn($query, $order) => $query->orderBy('job_type', $order))

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
                ->filterColumn('status', function ($query, $keyword) {
                    $statusMap = [
                        'approved' => 'APPROVED',
                        'pending' => 'PENDING',
                        'cancelled' => 'CANCELLED',
                        'completed' => 'COMPLETED',
                    ];
                    if (isset($statusMap[strtolower($keyword)])) {
                        $query->where('status', $statusMap[strtolower($keyword)]);
                    }
                })
                ->orderColumn('status', fn($query, $order) => $query->orderBy('status', $order))

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

                ->editColumn('created_at', fn($data) => $data->created_at ? $data->created_at->format('Y-m-d H:i:s') : '')
                ->filterColumn(
                    'created_at',
                    fn($query, $keyword) =>
                    $query->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') LIKE ?", ["%{$keyword}%"])
                )
                ->orderColumn('created_at', fn($query, $order) => $query->orderBy('created_at', $order))

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

        if ($job->status != JobStatusEnum::COMPLETED()->value) {
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
