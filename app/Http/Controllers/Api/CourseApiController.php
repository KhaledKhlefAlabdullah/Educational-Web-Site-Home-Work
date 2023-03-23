<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses=Course::all();
        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course' => ['bail','required','string','max:255'],
            'description' => ['bail','required','string','max:255'],
            'price'=>['bail','required','max:1000'],
            'department_id' => 'required',
        ]);
        $request->validate([
            'image'=>'required|image|max:2048'
        ]);
        $file_extension=$request->image->getClientOriginalExtension();
        $file_name=time().'.'.$file_extension;
        $path='images/courses_photo';
        $request->image->move($path,$file_name);

        $course=auth()->user()->courses()->create($validatedData);
        $course->image()->create([
            'title'=>$file_name,
            'image'=>$path
        ]);

        return response()->json([
            'status'=>'created',
            'object'=>$course
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'course' => ['bail','required','string','max:255'],
            'description' => ['bail','required','string','max:255'],
            'price'=>['bail','required','max:1000'],
            'department_id' => 'required',
        ]);
        $request->validate([
            'image'=>'image|max:2048'
        ]);
        $course = $request->user()->courses()->find($id);
        $course->update($validatedData);
        if (isset($request['image'])){
            $oldImage = $course->image;
            Storage::delete($oldImage);
            $file_extension=$request->image->getClientOriginalExtension();
            $file_name=time().'.'.$file_extension;
            $path='images/courses_photo';
            $request->image->move($path,$file_name);
            $course->image()->update([
                'title'=>$file_name,
                'image'=>$path
            ]);
        }
        return response()->json([
            'status'=>'updated',
            'object'=>$course
        ]);
    }
    public function get_lectures_by_course($id){
        $videos = Course::find($id)->video;
        return response()->json($videos);
    }
    public function upload_lectures_to_course(Request $request,$id){
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
        return response()->json([
            'status'=>'uploaded'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy_lectures_from_course($courseId,$videoId){
        $course = Course::find($courseId);
        $course->video()->detach($videoId);
        $video=Video::where('id',$videoId)->first();
        Storage::disk('public')->delete($video->video.'/'.$video->title);
        $video->delete($videoId);
        return response()->json([
            'status'=>'deleted'
        ]);
    }
    public function destroy($id)
    {
        // Delete the records in the course_image table for the given course ID
        DB::table('course_image')->where('course_id', $id)->delete();
        DB::table('course_videos')->where('course_id', $id)->delete();

        // Delete the records in the images table that are no longer associated with any courses
        DB::table('images')->whereNotIn('id', function ($query) {
            $query->select('image_id')->from('course_image');
        })->delete();
        DB::table('videos')->whereNotIn('id', function ($query) {
            $query->select('video_id')->from('course_videos');
        })->delete();

        // Delete the course record itself
        Course::find($id)->delete();
        return response([
           'status'=>'deleted',
           'object_id'=>$id
        ]);
    }
}
