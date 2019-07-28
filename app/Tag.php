<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag'];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function getRouteKeyName()
    {
        return 'tag';
    }
}
