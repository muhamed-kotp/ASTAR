@extends('layout')

@section('title')
    Edit Category
@endsection

@section('content')
    <div class="container" style="margin-bottom: 250px; margin-top: 50px">
        <form method="POST" action="{{ route('category.update', $cat->id) }}">

            @csrf
            <div class="mb-3">
                <label class="form-label fs-1">Category Name</label>
                <input placeholder="This will be the Name of the Category" type="text" name="name" class="form-control"
                    value="{{ $cat->name }}">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn default-btn">Edit</button>
                <a class="btn default-btn" href="{{ route('category.delete', $cat->id) }}">Delete</a>
            </div>
            <div>
                <a class="btn back_btn" href="{{ route('welcome') }}">Back</a>
            </div>
        </form>
    </div>
@endsection
