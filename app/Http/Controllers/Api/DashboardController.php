<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Admin dashboard
     */
    function admin() {

        return view('dashboards.admin');
    }
}
