<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tasklist extends Model
{
    use SoftDeletes;

    protected $fillable = ['column_id', 'name', 'order', 'company', 'location', 'value', 'status_id', 'started_at', 'end_at'];

    public function column()
    {
        return $this->belongsTo(Column::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function tasklistColumns()
    {
        return $this->hasMany(TasklistColumn::class)->orderBy('order');
    }
}
