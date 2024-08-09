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
use Str;

class KanbanController extends Controller
{
    public function index($gridID) {


        $grid = Grid::with(['zones','zones.actions'])
            ->where('user_id', auth()->user()->id )
            ->where(function () {

            })
            ->where('id', $gridID)
            ->first();
        
        if (empty($grid)) {
            abort(404,404);
        }

        $stage = Stages::where('grid_id', $gridID)
                       ->whereNull('deleted_at')
                       ->orderBy('position', 'ASC')  // Ensure stages are ordered by position
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
                           ->orderBy('position', 'ASC')  // Ensure stages are ordered by position
                           ->orderBy('created_at', 'DESC')
                           ->get();
        }
    
        $zones = Zone::with('actions')->where('grid_id', $gridID)->orderBy('key', 'DESC')->get();

        return Inertia::render('Kanban/Index', ['stages' => $stage, 'zones' => $zones, 'grid_id'  =>  $gridID])->with(['grid' => $grid]);
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


    public function updateStageName(Request $request) {
        $request->validate([
            'stageId' => 'required|integer|exists:kanban_stages,id',
            'name' => 'required|string|max:255'
        ]);
    
        $stage = Stages::findOrFail($request->stageId);
        $stage->name = $request->name;
        $stage->save();
    
        return response()->json(['message' => 'Stage name updated successfully']);
    }

    public function createStage(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'grid_id' => 'required|integer|exists:grids,id'
        ]);
    
        $slug = Str::slug($request->name);
    
        $stage = Stages::create([
            'name' => $request->name,
            'slug' => $slug,
            'user_id' => auth()->user()->id,
            'grid_id' => $request->grid_id,
            'position' => Stages::where('grid_id', $request->grid_id)->max('position') + 1
        ]);
    
        return response()->json($stage);
    }
    
    
    public function deleteStage(Request $request)
    {
        $stageId = $request->input('stageId');
        // Assuming you have a Stage model
        $stage = Stages::find($stageId);

        if ($stage) {
            $stage->delete();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Stage not found'], 404);
    }

    
}
