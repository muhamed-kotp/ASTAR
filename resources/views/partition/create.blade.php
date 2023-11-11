@extends('layout')

@section('title')
    Create Partition
@endsection

@section('content')
    <div class="container" style="margin-bottom: 250px; margin-top: 50px">
        <form method="POST" action="{{ route('partition.store') }}" enctype="multipart/form-data">

            @csrf
            <div class="mb-3">
                <label class="form-label fs-4">Partition Name</label>
                <input placeholder="This will be the name of the Partition " type="text" name="title" class="form-control"
                    value="{{ old('title') }}">
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="dropdown mb-3">
                <label class="form-label fs-4">Category</label>
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
                <label class="form-label fs-4">Upload Image</label>
                <input class="form-control" type="file" name="img">
                @error('img')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn default-btn">Submit</button>
        </form>
    </div>
@endsection
