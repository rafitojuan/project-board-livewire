<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasklistColumn extends Model
{
    protected $fillable = ['tasklist_id', 'name', 'order'];

    public function tasklist()
    {
        return $this->belongsTo(Tasklist::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('order');
    }
}
