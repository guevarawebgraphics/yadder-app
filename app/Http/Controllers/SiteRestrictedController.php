<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteRestrictedController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth/Restricted');
    }

    public function verifyPassword(Request $request)
    {

        $request->validate([
            'password' => 'required'
        ]);

        if ($request->password != config('yadder.site.restriction-password')) {
            return redirect()->back()->withErrors(['password' => 'Invalid Password']);
        }

        session()->put('restricted_verified', true);

        return redirect()->route('dashboard');
    }
}
