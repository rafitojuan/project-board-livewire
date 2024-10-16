<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $fillable = ['name',];

    public function tasklists()
    {
        return $this->hasMany(Tasklist::class)->orderBy('id');
    }
}
