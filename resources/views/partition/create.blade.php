@extends('layout')

@section('title')
    Create Category
@endsection

@section('content')
    <div class="container" style="margin-bottom: 250px; margin-top: 50px">
        <form method="POST" action="{{ route('partition.store') }}" enctype="multipart/form-data">

            @csrf
            <div class="mb-3">
                <label class="form-label fs-1">Partition Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                <div class="form-text">This will be the name of the category </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="dropdown mb-3">
                <label class="form-label fs-3">Category</label>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="category_id">
                    <option>Choose Category</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} </option>
                    @endforeach

                </select>
                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label class="form-label fs-1">Upload Image</label>
                <input class="form-control" type="file" name="img">
                @error('img')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
