<?php

namespace App\Models\Kanban;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignees extends Model
{
    use HasFactory;

    protected $table = 'kanban_assignees';

    protected $fillable = [
        'user_id',
        'kanban_stage_id',
        'kanban_task_id'
    ];
}
