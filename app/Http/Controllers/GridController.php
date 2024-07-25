<?php

namespace App\Http\Controllers;

use App\Models\Grid;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GridController extends Controller
{
    public function index()
    {
        return Inertia::render('Grids/Index')->with(['grids' => auth()->user()->grids]);
    }

    public function create()
    {
        return Inertia::render('Grids/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $grid = new Grid();
        $grid->fill($request->all());
        $grid->user()->associate(auth()->user());

        $grid->save();

        return redirect()->route('grids');
    }

    public function edit(Request $request, Grid $grid)
    {
        return Inertia::render('Grids/Edit');
    }
}
