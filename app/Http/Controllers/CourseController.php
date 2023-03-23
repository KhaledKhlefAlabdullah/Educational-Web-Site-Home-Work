<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Image;
use App\Models\User;
use App\Models\user_courses;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = DB::table('details')
            ->join('users', 'details.user_id', '=', 'users.id')
            ->join('user_courses', 'users.id', '=', 'user_courses.user_id')
            ->join('courses', 'user_courses.course_id', '=', 'courses.id')
            ->leftJoin('course_image', 'courses.id', '=', 'course_image.course_id')
            ->leftJoin('images AS c_i','course_image.image_id','=','c_i.id')
            ->join('departments', 'courses.department_id', '=', 'departments.id')
            ->select('c_i.title AS c_t','c_i.image AS c_m', 'details.*', 'courses.*','courses.id AS c_id', 'departments.*')
            ->get();

        return view('courses.index',[
            'details'=>$details,
        ]);
    }
    public function index_by_department($department_id)
    {
        $details = DB::table('details')
            ->join('users', 'details.user_id', '=', 'users.id')
            ->join('user_courses', 'users.id', '=', 'user_courses.user_id')
            ->join('courses', 'user_courses.course_id', '=', 'courses.id')
            ->leftJoin('course_image', 'courses.id', '=', 'course_image.course_id')
            ->leftJoin('images AS c_i','course_image.image_id','=','c_i.id')
            ->join('departments', 'courses.department_id', '=', 'departments.id')
            ->where('departments.id',$department_id)
            ->select('c_i.title AS c_t','c_i.image AS c_m', 'details.*', 'courses.*','courses.id AS c_id', 'departments.*')
            ->get();
        return view('courses.index_by_department',[
            'details'=>$details,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $deparments=Department::all();
        return view('courses.create',[
            'departments'=>$deparments
        ]);
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

        $course=$request->user()->courses()->create($validatedData);
        $course->image()->create([
            'title'=>$file_name,
            'image'=>$path
        ]);
        return redirect()->route('profile.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    /////////////////// ADD USER TO COURSE
    public function addToStudent($id)
    {
        $user=auth()->user();
        $course=Course::where('id',$id)->first();
        $videos = Course::find($id)->video;
        $user_courses=user_courses::where('course_id',$id)->where('user_id',$user->id)->first();
        if (isset($user_courses) && $user_courses->count() > 0){
            return view('courses.addToStudent',[
                'videos'=>$videos,
                'course'=>$course
            ]);
        }else{
            user_courses::create([
                'user_id'=>$user->id,
                'course_id'=>$id
            ]);
            return view('courses.addToStudent',[
                'videos'=>$videos,
                'course'=>$course
            ]);
        }

    }

    /////////////////// DELETE USER FROM COURSE
    public function GoOutFromCourse($course_id){
        $user=Auth::user();
        DB::table('user_courses')->where('course_id', $course_id)->where('user_id', $user->id)->delete();
        return redirect()->route('profile.index');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course=Course::where('id',$id)->first();
        $deparments=Department::all();

        return view('courses.edit',[
            'departments'=>$deparments,
            'course'=>$course
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
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

        $course = $request->user()->courses()->find($id);

        // Delete old image
        $oldImage = $course->image;

        Storage::delete($oldImage);

        // Save new image
        $file_extension=$request->image->getClientOriginalExtension();
        $file_name=time().'.'.$file_extension;
        $path='images/courses_photo';
        $request->image->move($path,$file_name);

        // Update course with new image details
        $course->update($validatedData);
        $course->image()->update([
            'title' => $file_name,
            'image' => $path
        ]);

        return redirect()->route('profile.index')->with('success', 'Course created successfully.');
    }

    public function details($id){
        $course =Course::where('id',$id)->first();
        /*$videos=DB::table('courses')
            ->join('course_videos','courses.id','=','course_videos.course_id')
            ->join('videos','course_videos.video_id','=','videos.id')
            ->where('courses.id',$id)
            ->select('videos.id','videos.video','videos.title');*/
        $videos = Course::find($id)->video;

        return view('courses.details',[
            'course'=>$course,
            'videos'=>$videos
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
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

        // Redirect back to the course index page or show a success message
        return redirect()->route('profile.index')->with('success', 'Course deleted successfully.');
    }


}
