<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display the dashboard index view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Return the dashboard index view
        return view('dashboard.index');
    }

    /**
     * Display the agent dashboard index view.
     *
     * @return \Illuminate\View\View
     */
    public function agentIndex()
    {
        // Return the dashboard index view
        return view('dashboard.agent.index');
    }
}
