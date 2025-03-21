<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentStatusUpdateRequest;
use App\Http\Requests\Agent\AgentStoreRequest;
use App\Http\Requests\Agent\AgentUpdateRequest;
use App\Http\Resources\Agent\AgentEditResource;
use App\Models\Agent;
use App\Models\District;
use App\Models\Division;
use App\Models\Thana;
use App\Services\AgentService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AgentController extends Controller
{
    /**
     * The AgentService instance.
     *
     * @var \App\Services\AgentService
     */
    protected $agentService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\AgentService  $agentService
     * @return void
     */
    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;
    }

    public function index()
    {
        return view('agent.index');
    }
    /**
     * Show the form for creating a new agent.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $divisions = Division::all();
        // Display the view for creating a new agent.
        return view('agent.create', compact('divisions'));
    }


    /**
     * Store a newly created agent in storage.
     *
     * @param  \App\Http\Requests\Agent\AgentStoreRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(AgentStoreRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();

        // Store the agent
        $agent = $this->agentService->store($validatedData);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Agent created successfully.',
            'data' => $agent,
        ], 201);

        // Handle the validated data, e.g., save it to the database
    }


    /**
     * Show the form for editing the specified agent.
     *
     * @param \App\Models\Agent $agent The agent instance to be edited
     * @return \Illuminate\View\View
     */
    public function edit(Agent $agent)
    {
        $agent = new AgentEditResource($agent);
        $divisions = Division::all();
        return view('agent.edit', compact('agent', 'divisions'));
    }

    /**
     * Update the specified agent in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Agent $agent
     * @return \Illuminate\Http\Response
     */
    public function update(AgentUpdateRequest $request, Agent $agent)
    {
        // Validate the request
        $validatedData = $request->validated();
        // $agent = Agent::find($agent);
        $agent->update($validatedData);

        return redirect()->route('agent.index')->with([
            'success' => 'Agent updated successfully.',
        ]);
    }

    /**
     * Update the status of an agent.
     *
     * @param \App\Http\Requests\Agent\AgentStatusUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate(AgentStatusUpdateRequest $request)
    {
        // Agent::where('uid', $request['uid'])->update(['status' => $request['status']]);
        return $result = Agent::updateByColumn('uid', $request['uid'], [
            'status' => $request['status'],
        ]);
    }



    /**
     * Remove the specified agent from storage.
     *
     * @param \App\Models\Agent $agent The agent instance to be destroyed
     * @return bool|null True if the agent was successfully deleted, false if the deletion failed, or null if the agent doesn't exist
     */
    public function destroy(Agent $agent)
    {
        return Agent::destroyModel($agent);
    }


    /**
     * Tenant Datatable list
     */
    public function datatable(Request $request)
{
    if ($request->ajax()) {
        $query = Agent::latest();

        // Apply Status Filter if Provided
        if ($request->has('status') && !empty($request->status)) {
            $statusMap = [
                'approved' => 'APPROVED',
                'unapproved' => 'UNAPPROVED',
                'deleted' => 'DELETED',
                'lock' => 'LOCK',
                'suspended' => 'SUSPENDED',
            ];

            $keyword = strtolower($request->status);

            if (array_key_exists($keyword, $statusMap)) {
                $query->where('status', $statusMap[$keyword]);
            } else {
                // Allow partial match if status doesn't match exactly
                $query->whereRaw("LOWER(status) LIKE ?", ["%{$keyword}%"]);
            }
        }

        return DataTables::of($query)
            ->addColumn('agent_id', function ($data) {
                return $data->agent_id ?? '';
            })
            ->filterColumn('agent_id', function ($query, $keyword) {
                $query->where('agent_id', 'LIKE', "%{$keyword}%");
            })
            ->orderColumn('agent_id', function ($query, $order) {
                $query->orderBy('agent_id', $order);
            })
            ->addColumn('agent_name', function ($data) {
                return $data->first_name . ' ' . $data->last_name;
            })
            ->filterColumn('agent_name', function ($query, $keyword) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"]);
            })
            ->orderColumn('agent_name', function ($query, $order) {
                $query->orderByRaw("CONCAT(first_name, ' ', last_name) {$order}");
            })
            ->addColumn('todays_job', function () {
                return 1;
            })
            ->addColumn('phone', function ($data) {
                return $data->phone ?? '';
            })
            ->addColumn('email', function ($data) {
                return $data->email ?? '';
            })
            ->addColumn('age', function ($data) {
                return $data->age ?? '';
            })
            ->addColumn('full_address', function ($data) {
                return $data->address ?? '';
            })
            ->addColumn('status', function ($data) {
                $statusColors = [
                    'APPROVED' => 'success',
                    'UNAPPROVED' => 'warning',
                    'DELETED' => 'danger',
                    'LOCK' => 'secondary',
                    'SUSPENDED' => 'info',
                ];

                $statusLabel = strtolower($data->status);
                $statusColor = $statusColors[strtoupper($data->status)] ?? 'secondary';

                return '<span class="status badge badge-light-' . $statusColor . '" 
                        title="Status: ' . ucfirst($statusLabel) . '" data-id="' . $data->uid . '">' .
                    ucfirst($statusLabel) . '</span>';
            })
            ->orderColumn('status', function ($query, $order) {
                $query->orderBy('status', $order);
            })
            ->addColumn('action', function ($data) {
                $editUrl = route('agent.edit', $data->uid);
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
            ->rawColumns(['action', 'status'])
            ->toJson();
    }
}



    public function getDistricts(Request $request)
    {
        // Get the districts related to the division
        $districts = District::where('division_id', $request->division_id)->get();
        if ($districts->count() == 0) {
            throw new \Exception('District not found.');
        }
        // Initialize the options
        $options = '<option value="">Select District</option>';
        // Build the options
        foreach ($districts as $district) {
            $options .= '<option value="' . $district->id . '">' . $district->name . '</option>';
        }
        // Return the districts
        return response()->json([
            'success' => true,
            'message' => 'Districts retrieved successfully.',
            'option' => $options
        ], 200);
    }
    public function getThanas(Request $request)
    {
        // Get the districts related to the division
        $thanas = Thana::where('district_id', $request->distr)->get();
        if ($thanas->count() == 0) {
            throw new \Exception('Thana not found.');
        }
        // Initialize the options
        $options = '<option value="">Select Thana</option>';
        // Build the options
        foreach ($thanas as $thana) {
            $options .= '<option value="' . $thanas->id . '">' . $thana->name . '</option>';
        }
        // Return the districts
        return response()->json([
            'success' => true,
            'message' => 'Districts retrieved successfully.',
            'option' => $options
        ], 200);
    }


    /**
     * Get the status of an agent by uid.
     *
     * @param int $agent The agent uid
     * @return string The status of the agent
     */
    public function getStatusByUid($agent)
    {
        return Agent::getStatus($agent);
    }
}
