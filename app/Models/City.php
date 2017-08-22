<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    
    public function authors()
    {
        return $this->hasMany(Author::class);
    }
    
    public function posts()
    {
        return $this->hasManyThrough(Post::class, Author::class);
    }
}
