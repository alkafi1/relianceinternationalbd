<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
