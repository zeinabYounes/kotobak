<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use App\Http\Requests\StoreShelfRequest;
use App\Http\Requests\UpdateShelfRequest;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShelfRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Shelf $shelf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shelf $shelf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShelfRequest $request, Shelf $shelf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shelf $shelf)
    {
        //
    }
}
