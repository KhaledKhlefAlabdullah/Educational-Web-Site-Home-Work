@extends('welcome')
@section('title','Student courses')
@section('content')
    <main id="main" data-aos="fade-in">
        <section class="container mt-4">
            <div class="row">
                <div class="col-md-8">
                    <h1>{{ $course->course }}</h1>
                    <p>{{ $course->description }}</p>
                </div>
            </div>
        </section>

        <section class="container mt-4">
            <div class="row">
                @if(isset($videos) && count($videos) > 0)
                    @foreach($videos as $video)
                        <div class="col-md-6 ">
                            <div class="card mb-4">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <video class="embed-responsive-item" controls>
                                        <source src="{{ $video->video }}/{{ $video->title }}" type="video/m4v,avi,flv,mp4,mov" >
                                    </video>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-12">
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading">{{__('No Videos')}}</h4>
                            <p>{{__('There are no videos for this course yet. Please check back later.')}}</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main><!-- End #main -->
@endsection
