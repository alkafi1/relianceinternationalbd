<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use App\Services\LoginService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $loginService;

    /**
     * Constructor to inject the LoginService class
     *
     * @param LoginService $loginService The LoginService class to handle the login request
     */
    public function __construct(LoginService $loginService)
    {
        // Inject the LoginService class
        $this->loginService = $loginService;
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        // Show the login form
        return view('auth.login.login');
    }

    /**
     * Handle the login request and return the user data if the login is successful
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginPost(LoginRequest $request)
    {
        // Simplifying the login process by directly returning the response
        $result = $this->loginService->login($request->only('email', 'password'));
        
        return $result ? response()->json([
            'redirect' => $result['redirect'],
            'user' => $result['user'],
        ]) : response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }


    /**
     * Logout the user and redirect to the login page
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Logout the user
        $this->loginService->logout(Auth::user());

        return response()->json([
            'redirect' => route('login')
        ]);
    }
}
