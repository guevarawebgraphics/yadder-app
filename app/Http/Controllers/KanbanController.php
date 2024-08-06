<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Grid;
use App\Models\Zone;
use App\Models\Kanban\Stages;
use App\Models\Kanban\Assignees;
use App\Models\Kanban\Tasks;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KanbanController extends Controller
{
    public function index() {
       
        return Inertia::render('Kanban/Index');
    }

    public function storeStages(Request $request) {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $data = $request->all();
        $stages = new Stages();
        $stages->user_id = auth()->user()->id;
        $stages->fill($data);
        $stages->save();

        return redirect()->route('kanban.index');
    }

    public function storeTasks(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'due_date' => ['required'],
        ]);
        $data = $request->all();
        $stages = new Tasks();
        $stages->fill($data);
        $stages->save();

        return redirect()->route('kanban.index');
    }
    
}
