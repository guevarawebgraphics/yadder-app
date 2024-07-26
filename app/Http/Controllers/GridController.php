<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Grid;
use App\Models\Zone;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GridController extends Controller
{
    public function index()
    {
        $grid = auth()->user()->grids()->first();

        if ($grid) {
            $grid->load(['zones', 'zones.actions']);
        }

        return Inertia::render('Grids/Index')->with(['grid' => $grid]);
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

        $data = $request->all();

        $grid = new Grid();
        $grid->fill($data);
        $grid->user()->associate(auth()->user());

        $grid->save();

        $this->saveZones($grid, $data['zones']);

        return redirect()->route('grids');
    }

    public function saveZones(Grid $grid, array $zones)
    {
        foreach ($zones as $key => $_zone) {
            $zoneData = [
                'key' => $key,
                'name' => $_zone['name'],
            ];

            $zone = new Zone();
            $zone->fill($zoneData);
            $zone->grid()->associate($grid);
            $zone->save();

            $this->saveActions($zone, $_zone['actions']);
        }
    }

    public function saveActions(Zone $zone, array $actions)
    {
        foreach ($actions as $key => $action) {
            $actionData = [
                'key' => $key,
                'name' => $action['name'],
            ];

            $action = new Action();
            $action->fill($actionData);
            $action->zone()->associate($zone);

            $action->save();
        }
    }

    public function edit(Request $request, Grid $grid)
    {
        return Inertia::render('Grids/Edit');
    }
}
