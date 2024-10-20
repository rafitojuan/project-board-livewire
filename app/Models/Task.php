<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['tasklist_column_id', 'name', 'order', 'status_id'];

    public function tasklistColumn()
    {
        return $this->belongsTo(TasklistColumn::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
