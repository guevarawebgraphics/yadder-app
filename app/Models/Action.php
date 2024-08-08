<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'key','kanban_status'];


    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
