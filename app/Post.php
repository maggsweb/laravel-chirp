<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $appends = [
        'humanDate'
    ];

    protected $fillable = [
        'body'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getHumanDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }


}
