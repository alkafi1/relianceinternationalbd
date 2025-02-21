<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use App\Services\LoginService;
use Carbon\Carbon;
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
        // Get the email and password from the request
        $credentials = $request->only('email', 'password');

        // Call the login service to handle the login request
        $result = $this->loginService->login($credentials);

        // If the login is successful, return the user data
        if ($result) {
            return response()->json([
                // The redirect URL after the login
                'redirect' => $result['redirect'],
                // The user data
                'user' => $result['user'],
            ]);
        }

        // If the login is not successful, return a 401 error with a message
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }


    /**
     * Logout the user and redirect to the login page
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        // Logout the user
        $this->loginService->logout(Auth::user());

        // Redirect to the login page
        return redirect()->route('login');
    }
}
