<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Details;
use App\Models\Image;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
class AdminController extends Controller
{
    public function index(Request $request){

        $id = $request->user()->id;
        $user_ = Details::where('user_id', $id)->first();

        $id2=DB::table('details')
            ->join('users_images','details.id','=','users_images.details_id')
            ->where('details.user_id',$id)
            ->select('users_images.image_id')
            ->get();
        $prof_image=new Image();
        if (isset($id2->last()->image_id)){
            $prof_image=Image::where('id',$id2->last()->image_id)->first();
        }else{
            $prof_image['title']='image.png';
            $prof_image['image']='images/profile_photo';
        }
        $details = DB::table('details')
            ->join('users', 'details.user_id', '=', 'users.id')
            ->join('user_courses', 'users.id', '=', 'user_courses.user_id')
            ->join('courses', 'user_courses.course_id', '=', 'courses.id')
            ->leftJoin('course_image', 'courses.id', '=', 'course_image.course_id')
            ->leftJoin('images AS c_i','course_image.image_id','=','c_i.id')
            ->join('departments', 'courses.department_id', '=', 'departments.id')
            ->select('c_i.title AS c_t','c_i.image AS c_m', 'details.*', 'courses.*','courses.id AS c_id', 'departments.*')
            ->get();
        $users=User::query()->with('details')->get();
        $users_images=Details::with('images')->get();

        return view('profile.index', [
            'user' => $user_,
            'users'=>$users,
            'users_images'=>$users_images,
            'details'=>$details,
            'image'=>$prof_image
        ]);
    }
    public function create()
    {
        return view('admin.create_users');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'user_type' => ['required', 'string', 'max:255', Rule::in(['admin', 'teacher', 'student'])],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->details()->create([
            'user_id' => $user->id,
            'user_type'=>$request['user_type']
            // Add any other details fields you want to create here
        ]);
        $detail=Details::where('user_id',$user->id)->first();
        $image = new Image;
        $image->title = 'image.png';
        $image->image = 'images/profile_photo';
        $image->save();
        $detail->images()->attach($image->id);
        return redirect()->route('profile.index');
    }

    /**
     * Display the specified resource.
     */
    public function details($id)
    {
        $user=User::where('id',$id)->first();
        $detail=$user->details;

        $courses=DB::table('details')
            ->join('users', 'details.user_id', '=', 'users.id')
            ->join('user_courses', 'users.id', '=', 'user_courses.user_id')
            ->join('courses', 'user_courses.course_id', '=', 'courses.id')
            ->leftJoin('course_image', 'courses.id', '=', 'course_image.course_id')
            ->leftJoin('images AS c_i','course_image.image_id','=','c_i.id')
            ->join('departments', 'courses.department_id', '=', 'departments.id')
            ->where('users.id',$id)
            ->select('c_i.title AS c_t','c_i.image AS c_m', 'details.*', 'courses.*','courses.id AS c_id', 'departments.*')
            ->get();
        return view('admin.detail_user',[
            'user'=>$user,
            'detail'=>$detail,
            'courses'=>$courses
        ]);
    }
    public function create_course($id){
        $deparments=Department::all();
        return \view('admin.create_course',[
            'departments'=>$deparments,
            'id'=>$id
        ]);
    }
    public function store_course(Request $request,$id){
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

        $user=User::where('id',$id)->first();
        $course=$user->courses()->create($validatedData);
        $course->image()->create([
            'title'=>$file_name,
            'image'=>$path
        ]);
        return redirect()->route('admin.detail_user',[
            'id'=>$id
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function show(){}

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
    public function destroy_user($id)
    {
        //
    }
}
