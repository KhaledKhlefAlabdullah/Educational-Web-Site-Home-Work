<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\department;
use App\Models\Details;
use App\Models\Event;
use App\Models\Image;
use App\Models\Trainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StaticController extends Controller
{

    public function index()
    {
        $icon=[
            'Mathematics' => "bi bi-calculator",
            'Science' => "bi bi-flask",
            'History' => "bi bi-journal",
            'English' => "bi bi-book",
            'Art' => "bi bi-easel",
            'Physical Education' => "bi bi-basketball",
            'Computer Science' => "bi bi-laptop",
            'Business Studies' => "bi bi-building",
            'Social Studies' => "bi bi-people-fill",
            'Geography' => "bi bi-globe2",
            'Music' => "bi bi-music-note",
            'Foreign Languages' => "bi bi-translate",
            'Health Education' => "bi bi-heart-fill",
            'Religious Studies' => "bi bi-star-fill",
            'Psychology' => "bi bi-people",
            'Philosophy' => "bi bi-lightbulb",
            'Economics' => "bi bi-cash-coin",
            'Political Science' => "bi bi-flag",
            'Environmental Science' => "bi bi-tree-fill",
            'Law' => "bi bi-balance-scale",
            'Engineering' => "bi bi-gear",
            'Architecture' => "bi bi-house",
            'Journalism' => "bi bi-megaphone",
            'Media Studies' => "bi bi-camera-video",
            'Hospitality Management' => "bi bi-kanban",
            'Fashion Design' => "bi bi-yelp",
            'Culinary Arts' => "bi bi-egg-fried",
            'Film Studies' => "bi bi-film",
            'Animation' => "bi bi-animation",
            'Graphic Design' => "bi bi-pencil-square",
            'Industrial Design' => "bi bi-hammer",
            'Interior Design' => "bi bi-house-door",
            'Performing Arts' => "bi bi-mic",
            'Dance' => "bi bi-dance",
            'Theater' => "bi bi-theater-masks",
            'Fine Arts' => "bi bi-palette",
            'Visual Arts' => "bi bi-image-fill",
            'Photography' => "bi bi-camera-fill",
            'Communication Studies' => "bi bi-chat-left",
            'Education' => "bi bi-award",
            'Library Science' => "bi bi-bookshelf",
            'Public Administration' => "fas fa-landmark",
            'Web Development' => "fas fa-code",
            'Mobile Development' => "fas fa-mobile-alt",
            'Game Development' => "fas fa-gamepad",
            'Database Administration' => "fas fa-database",
            'Cybersecurity' => "fas fa-shield-alt",
            'Software Engineering' => "fas fa-cogs",
            'Artificial Intelligence' => "fas fa-robot",
            'Machine Learning' => "fas fa-robot",
            'Data Science' => "fas fa-chart-line",
            'Cloud Computing' => "fas fa-cloud",
            'DevOps' => "fas fa-server",
            'Networking' => "fas fa-network-wired",
            'Operating Systems' => "fab fa-windows",
            'Embedded Systems' => "fas fa-microchip",
            'Computer Graphics' => "fas fa-paint-brush",
            'Computer Vision' => "fas fa-camera-retro",
            'Natural Language Processing' => "fas fa-language",
            'Robotics' => "fas fa-robot",
            'Blockchain' => "fab fa-bitcoin",
            'Internet of Things'=>"",
            'Quantum Computing'=>"",
            'Programming Languages'=>"",
            'Algorithms and Data Structures'=>"",
            'Computer Architecture'=>"",
            'Computer Organization'=>"",
            'Compiler Design'=>"",
            'Software Testing'=>"",
            'Software Quality Assurance'=>"",
            'Agile Development'=>"",
            'Project Management'=>"",
            'Technical Writing'=> "bi bi-file-earmark-break-fill",
            'User Experience Design' => "bi bi-palette-fill",
            'User Interface Design'=> "bi bi-window-sidebar-fill"
        ];
        $numberOfCourses = Course::count();
        $numberOfStudents = Details::where('user_type','student')->count();
        $numberOfEvents = Event::count();
        $numberOfTrainers = Details::where('user_type', 'teacher')->count();

        $departments= Department::all();
        return view('blade/home',[
            'numberOfCourses'=>$numberOfCourses,
            'numberOfStudents'=>$numberOfStudents,
            'numberOfEvents'=>$numberOfEvents,
            'numberOfTrainers'=>$numberOfTrainers,
            'departments'=> $departments,
            'icon'=>$icon,
            ]);
    }
    public function about()
    {
        return view('blade/about');
    }public function contact()
    {
        return view('blade/contact');
    }
    public function course_details()
    {
        return view('blade/course_details');
    }

    public function events()
    {
        return view('blade/events');
    }

    public function pricing()
    {
        return view('blade/pricing');
    }

    public function trainers()
    {
        return view('blade/trainers');
    }
}
