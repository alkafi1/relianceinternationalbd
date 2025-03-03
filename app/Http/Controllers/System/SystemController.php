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

    public function systemPost(SystemRequest $request)
    {
        $SysmentManagementService = $this->SysmentManagementService->store($request->validated());
        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Agent created successfully.',
            'data' => $SysmentManagementService,
        ], 201);

        dd($SysmentManagementService);
    }
}
