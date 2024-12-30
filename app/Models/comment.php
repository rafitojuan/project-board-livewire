<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected $table = 'comments';
    protected $guarded = ['id'];

    public function children()
    {
        return $this->hasMany(comment::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
