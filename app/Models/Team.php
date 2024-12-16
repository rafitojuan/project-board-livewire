<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teamAccess()
    {
        return $this->hasMany(TeamAccess::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function scopeUserTeam($query, $userId)
    {
        return $query->whereHas('teamAccess', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }

    public function tasklists()
    {
        return $this->hasMany(Tasklist::class);
    }
}
