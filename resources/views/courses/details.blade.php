@extends('welcome')
@section('title', $course->course)
@section('content')
    <main id="main" data-aos="fade-in">

    <section class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h1>{{ $course->course }}</h1>
                <p>{{ $course->description }}</p>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{__("Upload Video")}}</h4>
                        <form action="{{ route('video.store', $course->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="video" class="form-control-file" accept="video/*" required>
                            </div><br>
                            <button type="submit" class="btn btn-primary">{{__("Upload")}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-4">
        <div class="row">
            @if(isset($videos) && count($videos) > 0)
                @foreach($videos as $video)
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item col-8" controls>
                                    <source src="/{{ $video->video }}/{{ $video->title }}" type="video/m4v,avi,flv,mp4,mov" >
                                </video>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('video.destroy', ['vid' => $video->id, 'cid' => $course->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger float-right"><i class="fas fa-trash-alt"></i>
                                        {{__('Delete')}}</button>
                                </form>
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
