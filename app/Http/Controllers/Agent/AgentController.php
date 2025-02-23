<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentStoreRequest;
use App\Models\Agent;
use App\Services\AgentService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
    /**
     * Show the form for creating a new agent.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Display the view for creating a new agent.
        return view('agent.create');
    }


    public function store(AgentStoreRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();

        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validatedData['image'] = $imageName;
        }
        $agent = $this->agentService->store($validatedData);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Agent created successfully.',
            'data' => $agent,
        ], 201);

        // Handle the validated data, e.g., save it to the database
    }
}
