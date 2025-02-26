<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentStoreRequest;
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
     * Remove the specified agent from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        // Delete the agent
        $agent->delete();

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Agent deleted successfully.',
        ]);
    }


    /**
     * Tenant Datatable list
     */
    public function datatable(Request $request)
    {
        $query = Agent::latest();

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addColumn('agent_id', function ($data) {
                    return $data->agent_id ?? '';
                })
                ->addColumn('agent_name', function ($data) {
                    return $data->first_name . ' ' . $data->last_name;
                })
                ->addColumn('todays_job', function ($data) {
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
                    return $data->age ?? '';
                })
                ->addColumn('status', function ($data) {
                    $status = $data->status ?? '';
                    return $status ? '<span class="status badge badge-light-' . ($status === 1 ? 'success' : 'danger') . '" data-toggle="tooltip" title="Status: ' . ($status === 1 ? 'Active' : 'Inactive') . '">' . ($status === 1 ? 'Active' : 'Inactive') . '</span>' : '';
                })
                ->addColumn('action', function ($data) {
                    return '
                <a href="javascript:void(0)" class="view text-info mr-2 me-2" data-id="' . $data->uid . '">
                    <i class="fas fa-eye text-info" style="font-size: 16px;"></i>
                </a>
                <a href="javascript:void(0)" class="edit text-primary mr-2 me-2 " data-id="' . $data->uid . '">
                    <i class="fas fa-edit text-primary" style="font-size: 16px;"></i> <!-- Adjust font-size here -->
                </a>
                <a href="javascript:void(0)" class="text-danger delete" data-id="' . $data->uid . '">
                    <i class="fas fa-trash text-danger" style="font-size: 16px;"></i> <!-- Adjust font-size here -->
                </a>
                ';
                })
                ->addColumn('last_updated', function ($data) {
                    return $data->updated_at ?? '';
                })
                ->addColumn('created_at', function ($data) {
                    return $data->created_at ?? '';
                })
                ->rawColumns(['action', 'status'])
                ->toJSON();
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
}
