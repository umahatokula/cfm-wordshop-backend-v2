<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Admin dashboard
     */
    function admin() {

        return view('dashboards.admin');
    }
}
