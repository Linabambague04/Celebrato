<?php

namespace App\Http\Controllers;

use App\Models\ActivityEvent;
use Illuminate\Http\Request;

class ActivityEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activityEvents = ActivityEvent::query()
            ->included()
            ->filter()
            ->get();
        return response()->json($activityEvents);
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
    public function show(ActivityEvent $eventActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityEvent $eventActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityEvent $activityEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityEvent $activityEvent)
    {
        //
    }
}
