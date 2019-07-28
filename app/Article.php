<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function topLevelComments()
    {
        return $this->comments()->where('parent_id', NULL);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getSummaryAttribute()
    {
        return Str::words($this->content, 10);
    }
}
