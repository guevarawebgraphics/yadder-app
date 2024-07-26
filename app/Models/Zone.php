<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function grid()
    {
        return $this->belongsTo(Grid::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
