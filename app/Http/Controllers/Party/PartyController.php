<?php

namespace App\Http\Controllers\Party;

use App\Http\Controllers\Controller;
use App\Http\Requests\Party\PartyStoreRequest;
use App\Models\Party;
use App\Services\PartyService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
     * Show the party index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('party.index');
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

    public function datatable(Request $request)
    {

        if ($request->ajax()) {
            $query = Party::query();


            return DataTables::of($query)
                // Agent ID (Sortable & Searchable)
                ->addColumn('party_id', function ($data) {
                    return $data->party_id ?? '';
                })


                // Full Name (Concatenated, needs custom sorting & filtering)
                ->addColumn('party_name', function ($data) {
                    return $data->party_name;
                })
                ->filterColumn('party_name', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(party_name) LIKE ?", ["%{$keyword}%"]);
                })
                ->orderColumn('party_name', function ($query, $order) {
                    $query->orderByRaw("CONCAT(party_name) {$order}");
                })


                // Phone, Email, Age, Address (Sortable & Searchable)
                ->addColumn('phone', function ($data) {
                    return $data->phone ?? '';
                })
                ->addColumn('email', function ($data) {
                    return $data->email ?? '';
                })
                ->addColumn('address', function ($data) {
                    return $data->address ?? '';
                })


                ->addColumn('status', function ($data) {
                    // Define status colors and labels
                    $statusColors = [
                        'APPROVED' => 'success',
                        'UNAPPROVED' => 'warning',
                        'DELETED' => 'danger',
                        'LOCK' => 'secondary',
                        'SUSPENDED' => 'info',
                    ];

                    // Get the status label and color
                    $statusLabel = strtolower($data->status); // Ensure lowercase for consistency
                    $statusColor = $statusColors[strtoupper($data->status)] ?? 'secondary'; // Default to 'secondary' if status is not found

                    // Return the formatted status badge
                    return '<span class="status badge badge-light-' . $statusColor . '" 
                            title="Status: ' . ucfirst($statusLabel) . '" data-id="' . $data->uid . '">' .
                        ucfirst($statusLabel) . '</span>';
                })
                ->filterColumn('status', function ($query, $keyword) {
                    // Map keyword to status values
                    $statusMap = [
                        'approved' => 'APPROVED',
                        'unapproved' => 'UNAPPROVED',
                        'deleted' => 'DELETED',
                        'lock' => 'LOCK',
                        'suspended' => 'SUSPENDED',
                    ];

                    // Convert keyword to lowercase for case-insensitive comparison
                    $keyword = strtolower($keyword);

                    // Check if the keyword matches any status
                    if (array_key_exists($keyword, $statusMap)) {
                        $query->where('status', $statusMap[$keyword]);
                    }
                })
                ->orderColumn('status', function ($query, $order) {
                    $query->orderBy('status', $order);
                })


                // Action Buttons (Not Sortable or Searchable)
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
                ->rawColumns(['action', 'status'])
                ->toJson();
        }
    }
}
