<?php

namespace App\Models\Kanban;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stages extends Model
{
    use HasFactory;

    protected $table = 'kanban_stages';

    protected $fillable = [
        'name',
        'position',
        'user_id'
    ];
}
