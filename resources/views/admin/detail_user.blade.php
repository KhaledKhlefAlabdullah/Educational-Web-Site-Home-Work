@extends('welcome')
@section('title','User Courses')
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
                                <h4>{{ $detail->first_name }} {{ $detail->last_name }}</h4>
                                <p class="text-muted">{{ $detail->user_type }}</p>
                                <p class="text-muted">{{ $detail->phone_number }}</p>
                                <p class="text-muted">{{ $detail->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <h3>About Me</h3>
                                <p class="text-muted">Birth Date: {{ $detail->birth_date }}</p>
                                <hr>
                                <h4>Links</h4>
                                <ul class="list-unstyled">
                                    @if ($detail->whatsapp_link)
                                        <li>
                                            <a class="bi bi-whatsapp fa-lg me-2" href="{{ $detail->whatsapp_link }}" target="_blank">{{__('Whatsapp')}}</a>
                                        </li>
                                    @endif
                                    @if ($detail->github_link)
                                        <li>
                                            <a class="bi bi-github fa-lg me-2" href="{{ $detail->github_link }}" target="_blank">{{ __('Github')}}</a>
                                        </li>
                                    @endif
                                    @if ($detail->facebook_link)
                                        <li>
                                            <a class="bi bi-facebook fa-lg me-2" href="{{ $detail->facebook_link }}" target="_blank">{{ __('Facebook') }}</a>
                                        </li>
                                    @endif
                                    @if ($detail->instagram_link)
                                        <li>
                                            <a class="bi bi-instagram fa-lg me-2" href="{{ $detail->instagram_link }}" target="_blank">{{ __('Instagram') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{route('profile.edit')}} " class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 ">{{__('edite profile')}}</a>
            </div>

        </section>

        <section id="courses" class="courses">
            <div class="container" data-aos="fade-up">
                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    <h3 class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                        @if($detail->user_type=='admin')
                            {{__('Courses')}}
                        @else
                            {{__('Your Courses')}}
                        @endif

                    </h3><br>
                    <h4>
                        @if($detail->user_type == 'teacher')
                            <a href="{{route('admin.create_course',$detail->user_id)}}" class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 btn btn-success">{{__('Add New Course')}}</a>
                        @elseif($detail->user_type == 'student')
                            <a href="{{route('admin.add_student_to_course')}}" class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 btn btn-success">{{__('join To Course')}}</a>
                        @endif
                    </h4><hr>
                    @foreach($courses as $course)
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                            <div class="course-item">
                                <img src="@if(isset($course->c_t)) {{asset($course->c_m.'/'.$course->c_t)}}@else images/courses_photo/course.jpg @endif" style="max-height:200px; max-width:350px;  " class="img-fluid" alt="...">

                                <div class="course-content row">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="color-w">
                                            @if($user->user_type == 'teacher' || $user->user_type == 'admin')
                                                {{__($course->course)}}
                                            @else
                                                <a href="{{route('courses.addToStudent',$course->c_id)}}" class="align-items-stretch  btn">{{__($course->course)}}</a>
                                            @endif
                                        </h4>

                                        <p class="price">{{$course->price}}</p>
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
                                    @if($course->user_type == 'teacher' || $course->user_type == 'admin')
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
