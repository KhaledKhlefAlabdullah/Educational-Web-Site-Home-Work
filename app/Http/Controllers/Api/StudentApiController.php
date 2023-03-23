<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Details;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StudentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students=Details::with('user')->where('user_type','student')->get();
        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->details()->create([
            'user_id' => $user->id,
            'user_type'=>'student'
            // Add any other details fields you want to create here
        ]);
        $detail=Details::where('user_id',$user->id)->first();
        $image = new Image;
        $image->title = 'image.png';
        $image->image = 'images/profile_photo';
        $image->save();
        $detail->images()->attach($image->id);
        return response()->json([
            'status'=>'sucses'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(){}
    public function get_students_course(string $id)
    {
        $students_course=DB::table('courses')
            ->join('user_courses','courses.id','=','user_courses.course_id')
            ->join('users','user_courses.user_id','=','users.id')
            ->join('details','users.id','=','details.user_id')
            ->where('details.user_type','student')
            ->where('courses.id',$id)
            ->select('users.*')->get();
        return response()->json($students_course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $user = $request->user()->find($id);
        $user->update([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        ]);
        $user->details()->update([
            'user_id' => $user->id,
            'user_type'=>'student'
            // Add any other details fields you want to create here
        ]);
        $detail=Details::where('user_id',$user->id)->first();
        $image = new Image;
        $image->title = 'image.png';
        $image->image = 'images/profile_photo';
        $image->save();
        $detail->images()->attach($image->id);
        return response()->json([
            'status'=>'updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
