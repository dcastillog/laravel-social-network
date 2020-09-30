<?php

namespace App\Traits;

use App\Models\Like;

trait HasLikes
{
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like() // Ejecuta el like 
    {
        $this->likes()->firstOrCreate([
            'user_id' => auth()->id()
        ]);
    }

    public function isLiked()
    {   
        return $this->likes()->where('user_id', auth()->id())->exists(); //nos interesa saber si existe en bd
    }

    public function unlike()
    {
        $this->likes()->where([
            'user_id' => auth()->id()
        ])->delete();
    }

    public function likesCount()
    {
        return $this->likes()->count();
    }
}
