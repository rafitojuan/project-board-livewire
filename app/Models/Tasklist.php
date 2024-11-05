<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Tasklist extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $fillable = ['column_id', 'name', 'work_id', 'order', 'adendum_value', 'company', 'location', 'value', 'status_id', 'started_at', 'end_at', 'url', 'contract_number', 'pengadaan', 'conract_sign', 'adendum', 'color', 'user_id'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['column_id', 'name', 'work_id', 'order', 'adendum_value', 'company', 'location', 'value', 'status_id', 'started_at', 'end_at', 'url', 'contract_number', 'pengadaan', 'conract_sign', 'adendum', 'color', 'user_id'])
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => match ($eventName) {
                'created' => 'Project telah dibuat',
                'updated' => 'Project telah diperbarui',
                'deleted' => 'Project telah dihapus',
                'forceDeleted' => 'Project telah dihapus permanent',
                default => "Project telah di{$eventName}"
            })
            ->useLogName('Tasklist');
    }

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
