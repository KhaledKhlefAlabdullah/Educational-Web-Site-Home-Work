<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Details;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {

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
            ->where('users.id',$id)
            ->select('c_i.title AS c_t','c_i.image AS c_m', 'details.*', 'courses.*','courses.id AS c_id', 'departments.*')
            ->get();
        $users=User::query()->with('details')->get();
        $users_images=Details::with('images')->get();
        return view('profile.index', [
            'user' => $user_,
            'details'=>$details,
            'users'=>$users,
            'users_images'=>$users_images,
            'image'=>$prof_image
        ]);

    }
    public function store(Request $request){
        $validted=$request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birth_date' => 'required|date',
            'phone_number' => 'required|numeric',
            'whatsapp_link' => 'nullable|url',
            'github_link' => 'nullable|url',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'user_type' => 'required|string',
        ]);

        $request->user()->details()->create($validted);
        return redirect()->route('profile.index');
    }
    public function edit(Request $request): View
    {
        $id = $request->user()->id;
        $user_ = Details::where('user_id', $id)->first();

        return view('profile.edit', [
            'user' => $request->user(),
            'user_details'=> $user_
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $validation = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birth_date' => 'required|date',
            'phone_number' => 'required|numeric',
            'whatsapp_link' => 'nullable|url',
            'github_link' => 'nullable|url',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url'
        ]);
        $request->validate([
            'image'=>'image|max:2048',
        ]);
        $file_extension = $request->image->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = 'images/profile_photo';
        $request->image->move($path, $file_name);

        $userValidated = $request->validate([
            'email' => 'email',
        ]);
        $id = $request->user()->id;
        $request->user()->details()->update($validation);
        $detail = Details::where('user_id',$id)->first();
        $image = new Image;
        $image->title =  $file_name;
        $image->image =  $path;
        $image->save();
        DB::table('users_images')->where('details_id', $detail->id)->delete();
        $detail->images()->attach($image->id);
        $user = User::findOrFail($id);
        $user->email = $userValidated['email'];
        $user->save();
        return redirect()->route('profile.index');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
