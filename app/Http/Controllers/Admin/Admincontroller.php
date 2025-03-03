<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStatusUpdateRequest;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Http\Resources\Admin\AdminEditResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Admincontroller extends Controller
{
    
    /**
     * The UserService instance.
     *
     * @var \App\Services\UserService
     */
    protected $adminService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService  $UserService
     * @return void
     */
    public function __construct(UserService $adminService)
    {
        $this->adminService = $adminService;
    }
    /**
     * Display the admin index view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Display the view for creating a new admin.
        return view('admin.create');
    }

    public function store(AdminStoreRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();
        // Store the admin
        $admin = $this->adminService->store($validatedData);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Admin created successfully.',
            'data' => '',
        ], 201);

        // Handle the validated data, e.g., save it to the database
    }

    /**
     * Handle AJAX request to retrieve and format admin data for DataTables.
     *
     * This function processes the incoming AJAX request, queries the User model,
     * and formats various columns for display in the DataTable. It supports custom
     * sorting and filtering on specific fields, including concatenated names and
     * status labels. Additionally, it provides HTML rendering for image and action
     * columns.
     *
     * @param \Illuminate\Http\Request $request The incoming request instance.
     *
     * @return \Yajra\DataTables\DataTableAbstract The formatted DataTable response.
     */
    public function datatable(Request $request)
    {

        if ($request->ajax()) {
            $query = User::query();

            return DataTables::of($query)
                // Full Name (Concatenated, needs custom sorting & filtering)
                ->addColumn('display_name', function ($data) {
                    return $data->displayName();
                })
                ->filterColumn('full_name', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"]);
                })
                ->orderColumn('full_name', function ($query, $order) {
                    $query->orderByRaw("CONCAT(first_name, ' ', last_name) {$order}");
                })
                ->addColumn('email', function ($data) {
                    return $data->email ?? '';
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

                // Image (Display the user's image if available)
                ->addColumn('image', function ($data) {
                    return $data->image ? '<img src="' . asset('storage/' . $data->image) . '" width="50" height="50" class="img-thumbnail">' : '';
                })

                // Action Buttons (Not Sortable or Searchable)
                ->addColumn('action', function ($data) {
                    $editUrl = route('admin.edit', $data->uid);
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

                // Allow raw HTML in action, status, and image columns
                ->rawColumns(['action', 'status', 'image'])
                ->toJson();
        }
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param \App\Models\admin $admin The admin instance to be edited
     * @return \Illuminate\View\View
     */
    public function edit(User $admin)
    {
        $admin = new AdminEditResource($admin);
        return view('admin.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\admin $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateRequest $request, User $admin)
    {
        // Validate the request
        $validatedData = $request->validated();
        // $admin = admin::find($admin);
        $admin->update($validatedData);

        return redirect()->route('admin.index')->with([
            'success' => 'Admin updated successfully.',
        ]);
    }

    /**
     * Update the status of an admin.
     *
     * @param \App\Http\Requests\admin\adminStatusUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate(AdminStatusUpdateRequest $request)
    {
        return $result = User::updateByColumn('uid', $request['uid'], [
            'status' => $request['status'],
        ]);
    }



    /**
     * Remove the specified admin from storage.
     *
     * @param \App\Models\admin $admin The admin instance to be destroyed
     * @return bool|null True if the admin was successfully deleted, false if the deletion failed, or null if the admin doesn't exist
     */
    public function destroy(User $user)
    {
        return User::destroyModel($user);
    }

    public function getStatusByUid($user)
    {
        return User::getStatus($user);
    }
}
