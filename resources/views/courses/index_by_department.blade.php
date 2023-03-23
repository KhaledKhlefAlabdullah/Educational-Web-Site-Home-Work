@extends('welcome')
@section('title','course by department')
@section('content')
    <main id="main" data-aos="fade-in">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs">
            <div class="container">
                <h2>{{__('Courses')}}</h2>
                <p>{{__('Courses Available Now In This Department')}} </p>
            </div>
        </div><!-- End Breadcrumbs -->

        <!-- ======= courses Section ======= -->
        <section id="courses" class="courses">
            <div class="container" data-aos="fade-up">
                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    @foreach($details as $course)
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                            <div class="course-item">
                                <img src="@if(isset($course->c_t)) {{asset($course->c_m.'/'.$course->c_t)}}@else images/courses_photo/course.jpg @endif" style="max-height:150px; max-width:250px;  " class="img-fluid" alt="...">

                                <div class="course-content">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="color-w">
                                            @if (Route::has('login'))
                                                @auth
                                                    <a href="{{route('courses.addToStudent',$course->c_id)}}" style="color: #e2e8f0" class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 btn">{{__($course->course)}}</a>
                                                @endauth
                                            @else
                                                <a href="{{ route('login') }}" style="color: #e2e8f0" class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 btn">{{__($course->course)}}</a>
                                                @if (Route::has('register'))
                                                    <a href="{{route('register')}}" style="color: #e2e8f0" class="col-lg-2 col-md-1 d-flex align-items-stretch mt-4 mt-md-0 btn">{{__($course->course)}}</a>
                                                @endif
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
                                </div>
                            </div>
                        </div> <!-- End Course Item-->

                    @endforeach
                </div>
            </div>
        </section><!-- End courses Section -->

    </main><!-- End #main -->


@endsection
