<?php

namespace App\Http\Controllers\Job;

use App\Enums\AgentStatus;
use App\Enums\PartyStatusEnum;
use App\Enums\TerminalStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobRequest;
use App\Models\Agent;
use App\Models\Party;
use App\Models\Terminal;
use App\Services\JobService;
use Illuminate\Http\Request;

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

    public function create(Request $request)
    {
        // Fetch approved agents
        $agents = Agent::fetchByStatus('status', AgentStatus::APPROVED()->value);

        // Fetch active terminals
        $terminals = Terminal::fetchByStatus('status', TerminalStatusEnum::ACTIVE()->value);

        // Fetch approved parties
        $parties = Party::fetchByStatus('status', PartyStatusEnum::APPROVED()->value);

        // Pass the agents, terminals, and parties to the view
        return view('job.create',[
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
}
