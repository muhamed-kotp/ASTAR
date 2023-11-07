@extends('layout')

@section('title')
    Create Category
@endsection

@section('content')
    <div class="container" style="margin-bottom: 250px; margin-top: 50px">
        <form method="POST" action="{{ route('category.store') }}">

            @csrf
            <div class="mb-3">
                <label class="form-label fs-1">Category Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                <div class="form-text">This will be the name of the category </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
