<?php

namespace App\Models;

use App\Models\User;
use App\Models\Like;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;
        
    protected $guarded = []; // Desabilita la protección de asignación masiva, si se usa nunca debemos guardar de la manera Status::create($request->all())

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
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
