<?php

namespace App\Models\Kanban;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    
    protected $table = 'kanban_actions';

    protected $fillable = [
        'action_id',
        'description',
        'stage_id',
        'due_date'
    ];
}
