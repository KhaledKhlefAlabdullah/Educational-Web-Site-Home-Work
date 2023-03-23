<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{

    public function uploadVideo(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'video' => 'required|file|mimetypes:video/m4v,avi,flv,mp4,mov',
        ]);
        $video = new Video;
        $video->title = $request->title;
        if ($request->hasFile('video'))
        {
            $path = $request->file('video')->store('videos', ['disk' =>      'videos']);
            $video->video = $path;
        }
        $video->save();

    }
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$id)
    {
        $request->validate([
            'video'=>'required|mimes:mp4,mov,ogg,qt | max:20000'
        ]);
        $file_extension=$request->video->getClientOriginalExtension();
        $file_name=time().'.'.$file_extension;
        $path='video/course_video';
        $request->video->move($path,$file_name);
        $video = Video::create([
            'title' => $file_name,
            'video' => $path,
        ]);
        $course=Course::findOrFail($id);
        $course->video()->attach($video);

        return redirect()->route('courses.details',['course'=>$course->id])->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $videoId,$courseId)
    {
        $course = Course::find($courseId);
        $course->video()->detach($videoId);
        $video=Video::where('id',$videoId)->first();
        Storage::disk('public')->delete($video->video.'/'.$video->title);
        $video->delete($videoId);
        return redirect()->route('courses.details',['course'=>$courseId]);

    }
}
