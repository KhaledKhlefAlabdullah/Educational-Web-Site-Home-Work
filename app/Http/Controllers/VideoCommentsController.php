<?php

namespace App\Http\Controllers;

use App\Models\VideoComments;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VideoComments $videoComments): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VideoComments $videoComments): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoComments $videoComments): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoComments $videoComments): RedirectResponse
    {
        //
    }
}
