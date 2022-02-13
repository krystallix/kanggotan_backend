<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePiketRequest;
use App\Http\Requests\UpdatePiketRequest;
use App\Models\Piket;
use App\Http\Controllers\Api\Controller;

class PiketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pikets  = Piket::all();
        return $this->ok($pikets, "Success");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePiketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePiketRequest $request)
    {
        if(auth()->user()->hasAnyRole(['Super Admin','Admin','Officer'])){
            $data = Piket::create($request->all());
            return $this->ok($data,"Success");
        }else {
            return $this->error("Not Authorized");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Piket  $piket
     * @return \Illuminate\Http\Response
     */
    public function show(Piket $piket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Piket  $piket
     * @return \Illuminate\Http\Response
     */
    public function edit(Piket $piket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePiketRequest  $request
     * @param  \App\Models\Piket  $piket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePiketRequest $request, Piket $piket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Piket  $piket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Piket $piket)
    {
        //
    }
}
