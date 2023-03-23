@extends('welcome')
@section('title','Create Course')
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <h1>{{__('Update Course')}}</h1>
        </div>
    </div><!-- End Breadcrumbs -->

    <div class="container mt-16">
        <form action="{{ route('courses.update',$course->id) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <input type="text" placeholder="{{__('Course Name')}}:" class="m-2 form-control @error('name') is-invalid @enderror" name="course" id="course" value="{{ old('course',$course->course) }}" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">

                <textarea placeholder="{{__('Description')}}:" class="m-2 form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{ old('description',$course->description) }}</textarea>
                @error('description')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input type="number" placeholder="{{__('Price')}}:" class="m-2 form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{ old('price',$course->price) }}" required>
                @error('price')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
                @enderror
            </div>
            <div class="form-group m-2">
                <select class="form-control @error('department_id') is-invalid @enderror" name="department_id" id="department_id"  required>
                    <option value="">{{__('Select Department')}}t</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->department }}</option>
                    @endforeach
                </select>
                @error('department_id')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="submet btn btn-primary">{{__("Create Course")}}</button>
        </form>
    </div>
@endsection
