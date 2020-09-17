<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;
        
    protected $guarded = []; // Desabilita la protección de asignación masiva, si se usa nunca debemos guardar de la manera Status::create($request->all())
}
