<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    
    public function city()
    {
        return $this->author->city();
    }
    
    public function path()
    {
        return route('posts.show', $this);
    }
    
    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            ['path' => $this->path()]
        );
    }
}
