<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RolesAndPermissionsController extends Controller
{
    public function index()
    {
        return Inertia::render('RolesAndPermissions/Index');
    }
}
