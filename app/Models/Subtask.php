<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    // protected $fillable = [
    //     'task_id',
    //     'name',
    //     'value',
    //     'completed',
    //     'pelaksana',
    //     'biaya',
    //     'started_at',
    //     'end_at',
    //     'keterangan',
    //     'url',
    //     'status_id',
    // ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
