<?php

namespace App\Http\Controllers;

use App\Models\EventSecurity;
use Illuminate\Http\Request;

class EventSecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventSecurities = EventSecurity::query()
            ->included()
            ->filter()
            ->get();
        return response()->json($eventSecurities);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EventSecurity $eventSecurity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventSecurity $eventSecurity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventSecurity $eventSecurity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventSecurity $eventSecurity)
    {
        //
    }
}
