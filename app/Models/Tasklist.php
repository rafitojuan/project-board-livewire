<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Tasklist extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $table = 'tasklists';

    protected $fillable = ['column_id', 'name', 'work_id', 'order', 'adendum_value', 'company', 'location', 'value', 'status_id', 'started_at', 'end_at', 'url', 'contract_number', 'pengadaan', 'conract_sign', 'adendum', 'color', 'user_id'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => match ($eventName) {
                'created' => 'Project berhasil dibuat',
                'updated' => 'Project berhasil diperbarui',
                'deleted' => 'Project berhasil dihapus',
                'forceDeleted' => 'Project berhasil dihapus permanent',
                default => "Project telah di{$eventName}"
            })
            ->useLogName('Tasklist');
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->timezone('Asia/Jakarta');
    // }

    // public function getUpdatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->timezone('Asia/Jakarta');
    // }

    // public function getDeletedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->timezone('Asia/Jakarta');
    // }

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
