<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

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
