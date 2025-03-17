<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentLoginRequest;
use App\Http\Requests\Login\LoginRequest;
use App\Services\AgentLoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentLoginController extends Controller
{
    protected $agentLoginService;

    /**
     * Constructor to inject the agentLoginService class
     *
     * @param AgentLoginService $agentLoginService The agentLoginService class to handle the login request
     */
    public function __construct(AgentLoginService $agentLoginService)
    {
        // Inject the LoginService class
        $this->agentLoginService = $agentLoginService;
    }

    /**
     * Show the agent login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.agent.login');
    }

    /**
     * Handle the login request and return the user data if the login is successful
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginPost(AgentLoginRequest $request)
    {
        // Simplifying the login process by directly returning the response
        $result = $this->agentLoginService->login($request->only('email', 'password'));

        return $result ? response()->json([
            'redirect' => $result['redirect'],
            'agent' => $result['agent'],
            'success' => true,
            'message' => 'Agent Login Successfully',
        ]) : response()->json([
            'success' => false,
            'message' => 'Invalid Cridentials',
        ], 201);
    }

    /**
     * Logout the user and redirect to the login page
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        // Get the agent
        $agent = Auth::guard('agent')->user();

        // Log the agent out
        $this->agentLoginService->agentLogout();

        // Redirect to the agent login page
        return response()->json([
            'redirect' => route('agent.login'),
            // 'agent' => $agent
        ]);
    }
}
