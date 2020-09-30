<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Models\Status;
use App\Events\StatusCreated;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        return StatusResource::collection(
            Status::latest()->paginate()
        );
    }

    public function store(Request $request)
    {
        // request()->validate([ // Las validaciones se ejecutarán en el test
        //     'body' => 'required|min:5'
        // ]);
        
        // $status = Status::create([
        //     'body' => request('body'),
        //     'user_id' => auth()->id()
        // ]);

        $validStatus = $request->validate([ // Las validaciones se ejecutarán en el test
            'body' => 'required|min:5'
        ]);
        
        $status = $request->user()->statuses()->create($validStatus);

        $statusResource = StatusResource::make($status);

        StatusCreated::dispatch($statusResource);

        return $statusResource;
    }
}
