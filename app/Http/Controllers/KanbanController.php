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
    public function index($gridID) {
        $stage = Stages::where('grid_id', $gridID)
                       ->whereNull('deleted_at')
                       ->orderBy('created_at', 'DESC')
                       ->get();
    
        if ($stage->isEmpty()) {
            $stage_array = [
                ['name' => 'To Schedule', 'slug' => 'to-schedule'],
                ['name' => 'In Schedule', 'slug' => 'in-schedule'],
                ['name' => 'Today', 'slug' => 'today'],
                ['name' => 'Doing', 'slug' => 'doing'],
                ['name' => 'Done', 'slug' => 'done']
            ];
    
            foreach ($stage_array as $index => $field) {
                Stages::create([
                    'name' => $field['name'],
                    'slug' => $field['slug'], // Ensure slug is included
                    'user_id' => auth()->user()->id,
                    'grid_id' => $gridID,
                    'position' => $index + 1
                ]);
            }
    
            $stage = Stages::where('grid_id', $gridID)
                           ->whereNull('deleted_at')
                           ->orderBy('created_at', 'DESC')
                           ->get();
        }
    
        $zones = Zone::with('actions')->where('grid_id', $gridID)->orderBy('key', 'DESC')->get();
        return Inertia::render('Kanban/Index', ['stages' => $stage, 'zones' => $zones]);
    }
    
    public function updateTasksStatus(Request $request) {
        $request->validate([
            'taskId' => 'required|integer|exists:actions,id',
            'kanbanStatus' => 'required|string'
        ]);
    
        $action = Action::findOrFail($request->taskId);
        $action->kanban_status = $request->kanbanStatus;
        $action->save();
    
        return response()->json(['message' => 'Status updated successfully']);
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
