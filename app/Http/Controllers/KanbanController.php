<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Grid;
use App\Models\Zone;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KanbanController extends Controller
{
    public function index()
    {
       
        return Inertia::render('Kanban/Index');
    }
}
