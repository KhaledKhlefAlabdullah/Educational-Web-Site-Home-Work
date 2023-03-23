@extends('welcome')
@section('title','Profile')
@section('content')
    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs" data-aos="fade-in">
            <div class="container">
                <h2>{{__("Profile")}}</h2>

            </div>
        </div><!-- End Breadcrumbs -->
    <section>
        <div class="container  card card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{asset($image->image.'/'.$image->title)}}" alt="Profile Image" class="img-fluid fixed-size-image mb-2">
                            <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                            <p class="text-muted">{{ $user->user_type }}</p>
                            <p class="text-muted">{{ $user->phone_number }}</p>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <h3>{{__('About Me')}}</h3>
                            <p class="text-muted">{{__("Birth Date")}}: {{ $user->birth_date }}</p>
                            <hr>
                            <h4>{{__('Social')}}</h4>
                            <ul class="list-unstyled">
                                @if ($user->whatsapp_link)
                                    <li>
                                        <a class="bi bi-whatsapp fa-lg me-2" href="{{ $user->whatsapp_link }}" target="_blank"></a>
                                    </li>
                                @endif
                                @if ($user->github_link)
                                    <li>
                                        <a class="bi bi-github fa-lg me-2" href="{{ $user->github_link }}" target="_blank"></a>
                                    </li>
                                @endif
                                @if ($user->facebook_link)
                                    <li>
                                        <a class="bi bi-facebook fa-lg me-2" href="{{ $user->facebook_link }}" target="_blank"></a>
                                    </li>
                                @endif
                                @if ($user->instagram_link)
                                    <li>
                                        <a class="bi bi-instagram fa-lg me-2" href="{{ $user->instagram_link }}" target="_blank"></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{route('profile.edit')}} " class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 ">{{__('edite profile')}}</a>
            @if($user->user_type == 'admin')
                <a href="{{route('admin.create_users')}}" class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 ">{{__('Create User')}}</a>
            @endif
        </div>

    </section>
        @if($user->user_type == 'admin')
            <section id="trainers" class="trainers">
                <div class="container" data-aos="fade-up">
                    <div class="row" data-aos="zoom-in" data-aos-delay="100">
                        @foreach($users as $user1)
                            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                <div class="member">
                                    @foreach($users_images as $ui)
                                        <img src="@if($user1->user_id == $ui->user_id){{assert($ui->image.'/'.$ui->title)}} @break @else {{asset('images/profile_photo/image.png')}}  @endif " class="img-fluid" alt="">
                                        @break
                                    @endforeach

                                    <div class="member-content">
                                        <h3>{{$user1->details->first_name}} {{$user1->details->last_name}}</h3>
                                        <h4>{{$user1->user_type}}</h4>
                                        <h5>{{__('Phone Number')}}:{{$user1->details->phone_number}}</h5>
                                        <h5>{{__('Email:')}}:{{$user1->email}}</h5>
                                        <div class="social">
                                            <a href="{{$user1->details->whatsapp_link}}"><i class="bi bi-whatsapp"></i></a>
                                            <a href="{{$user1->details->facebook_link}}"><i class="bi bi-facebook"></i></a>
                                            <a href="{{$user1->details->instagram_link}}"><i class="bi bi-instagram"></i></a>
                                            <a href="{{$user1->details->github_link}}"><i class="bi bi-github"></i></a>
                                        </div>
                                    </div>
                                        <form class="" {{--action="{{route('admin.destroy_user',$user1->details->user_id)}}" method="POST"--}}>
                                            @csrf
                                            @method('DELETE')
                                            <button {{--type="submit"--}} class="btn btn-danger">{{__('Delete')}}</button>
                                        </form>
                                        <br>
                                        <a href="{{route('admin.detail_user',$user1->details->user_id)}}" class="row btn btn-info">{{__('User Details')}}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    <section id="courses" class="courses">
        <div class="container" data-aos="fade-up">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <h3 class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                    @if($user->user_type=='admin')
                        {{__('Courses')}}
                    @else
                        {{__('Your Courses')}}
                    @endif

                </h3><br>
                <h4>
                @if($user->user_type == 'teacher')
                    <a href="{{route('courses.create')}}" class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 btn btn-success">{{__('Add New Course')}}</a>
                @elseif($user->user_type == 'student')
                    <a href="{{route('courses.index')}}" class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 btn btn-success">{{__('join To Course')}}</a>
                @endif
                </h4><hr>
                @foreach($details as $course)
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                        <div class="course-item">
                            <img src="@if(isset($course->c_t)) {{asset($course->c_m.'/'.$course->c_t)}}@else images/courses_photo/course.jpg @endif" style="max-height:200px; max-width:350px;  " class="img-fluid" alt="...">

                            <div class="course-content row">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="color-w">
                                        @if($user->user_type == 'teacher' || $user->user_type == 'admin')
                                                {{__($course->course)}}
                                        @elseif($user->user_type == 'student')
                                            <a href="{{route('courses.addToStudent',$course->c_id)}}" class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 btn">{{__($course->course)}}c</a>
                                        @endif
                                    </h4>

                                    <p class="price">{{$course->price}}$</p>
                                </div>

                                <h3><a href="{{route('courses.index_by_department',$course->department_id)}}">{{__($course->department)}}</a></h3>
                                <p>{{__($course->description)}}</p>
                                <div class="trainer d-flex justify-content-between align-items-center">
                                    <div class="trainer-profile d-flex align-items-center">

                                        <span>{{__($course->first_name)}} {{__($course->last_name)}}</span>
                                    </div>

                                    <div class="trainer-rank d-flex align-items-center">
                                        <i class="bx bx-user"></i>&nbsp;35
                                        &nbsp;&nbsp;
                                        <i class="bx bx-heart"></i>&nbsp;42
                                    </div>
                                </div>
                                @if($user->user_type == 'teacher' || $user->user_type == 'admin')
                                <form class="col-3" {{--action="{{route('courses.destroy',$course->c_id)}}" method="POST"--}}>
                                    @csrf
                                    @method('DELETE')
                                    <button {{--type="submit"--}} class="btn btn-danger">{{__('Delete')}}</button>
                                </form>
                                &nbsp;
                                    <a href="{{route('courses.edit',$course->c_id)}}" class="btn btn-info col-3">{{__('Edit')}}</a>
                                    &nbsp;
                                    <a href="{{route('courses.details',$course->c_id)}}" class="btn btn-primary col-3">{{__('Details')}}</a>
                                @else
                                    <form class="col-3" {{--action="{{route('courses.GoOutFromCourse',$course->c_id)}}" method="POST"--}}>
                                        @csrf
                                        @method('DELETE')
                                        <button {{--type="submit"--}} class="btn btn-danger">{{__('Delete')}}</button>
                                    </form>
                                @endif
                            </div>
                        </div>


                    </div> <!-- End Course Item-->

                @endforeach
            </div>

        </div>
    </section><!-- End courses Section -->

        <main>
@endsection
