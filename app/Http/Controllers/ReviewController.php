<?php

namespace App\Http\Controllers;

use App\Models\ReviewReplay;
use Illuminate\Http\Request;

class ReviewController extends Controller
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
    public function reply(Request $request)
    {
        if(!isAdmin()){
            return back()->with('error',__('message.action_forbidden'));
        }

        ReviewReplay::create([
            'content'=>$request->content,
            'user_id'=>auth()->id(),
            'review_id' =>$request->review_id,
        ]);

        return back()->with('success',__('message.saved succefully'));
        
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
