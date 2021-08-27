<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    /**
     * Get All System Roles
     */
    function getRoles() {
        $data['roles'] = Role::all();

        return view('roles.index', $data);
    }
}
