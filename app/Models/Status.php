<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = []; // Desabilita la protección de asignación masiva, si se usa nunca debemos guardar de la manera Status::create($request->all())
}
