<?php

namespace App\Http\Controllers\Party;

use App\Http\Controllers\Controller;
use App\Http\Requests\Party\PartyStoreRequest;
use App\Services\PartyService;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    protected $partyService;

    /**
     * Instantiate a new PartyController instance.
     *
     * @param \App\Services\PartyService $partyService
     */
    public function __construct(PartyService $partyService)
    {
        $this->partyService = $partyService;
    }
    /**
     * Show the form for creating a new party.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Display the view for creating a new agent.
        return view('party.create');
    }

    public function store(PartyStoreRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();
        
        // Store the party
        $party = $this->partyService->store($validatedData);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Party created successfully.',
            'data' => $party,
        ], 201);

        // Handle the validated data, e.g., save it to the database
    }
}
