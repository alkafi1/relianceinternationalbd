<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Party;
use App\Models\RelianceJob;
use App\Models\Terminal;

class DashboardController extends Controller
{
    /**
     * Display the dashboard index view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalJobs = RelianceJob::count();
        $totaAgents = Agent::count();
        $totalTerminals = Terminal::count();
        $totalParties = Party::count();

        $total = [
            'totalJobs' => $totalJobs,
            'totaAgents' => $totaAgents,
            'totalTerminals' => $totalTerminals,
            'totalParties' => $totalParties
        ];
        // Return the dashboard index view
        return view('dashboard.index', compact('total'));
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
