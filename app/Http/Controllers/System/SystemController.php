<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\SystemManagement\SystemRequest;
use App\Services\MediaService;
use App\Services\SysmentManagementService;
use Illuminate\Http\Request;
use PHPUnit\Event\Telemetry\System;

class SystemController extends Controller
{
    /**
     * The SysmentManagementService instance.
     *
     * @var \App\Services\SysmentManagementService
     */
    protected $SysmentManagementService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\SysmentManagementService  $SysmentManagementService
     * @return void
     */
    public function __construct(SysmentManagementService $SysmentManagementService)
    {
        $this->SysmentManagementService = $SysmentManagementService;
    }
    /**
     * Display the system config page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('system.index');
    }

    /**
     * Handle the system config form submission.
     *
     * @param  \App\Http\Requests\SystemManagement\SystemRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function systemPost(SystemRequest $request)
    {
        // Store the system content
        // The store method of the SysmentManagementService class is used to store the system content,
        // which takes the validated request data as an argument.
        $SysmentManagementService = $this->SysmentManagementService->store($request->validated());

        // Return a success response
        // A JSON response with a success message and status code 201 is returned.
        return response()->json([
            'success' => true,
            'message' => 'System content Updated successfully.',
        ], 201);
    }
}
