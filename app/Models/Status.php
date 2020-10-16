<?php

namespace App\Models;

use App\Models\User;
use App\Models\Like;
use App\Models\Comment;

use App\Traits\HasLikes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;
        
    use HasLikes;

    protected $guarded = []; // Desabilita la protección de asignación masiva, si se usa nunca debemos guardar de la manera Status::create($request->all())

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function path()
    {
        // return route('statuses.show', $this);

        return 'estado/' . $this->id;

    }
}
