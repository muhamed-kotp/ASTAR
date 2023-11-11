@extends('layout')

@section('title')
    Create New Item
@endsection

@section('content')
    <div class="container"style="margin-bottom: 250px; margin-top: 50px">
        <form enctype="multipart/form-data" method="POST" action="{{ route('items.store') }}">

            @csrf
            <div class="mb-3">
                <label class="form-label fs-4">Item title</label>
                <input placeholder="This will be the title of the Item" type="text" name="title" class="form-control"
                    value="{{ old('title') }}">
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fs-4">Item description</label>
                <input placeholder="This will be the Description of the Item" type="text" name="description"
                    class="form-control" value="{{ old('description') }}">
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fs-4">Item Price</label>
                <input placeholder="Item Price" type="text" name="price" class="form-control"
                    value="{{ old('price') }}">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fs-4">Item Quantity</label>
                <input placeholder="Item Quantity" type="text" name="quantity" class="form-control"
                    value="{{ old('quantity') }}">
                @error('quantity')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="dropdown mb-3">
                <label class="form-label fs-4">Partition</label>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="partition_id">
                    <option>Choose Partition</option>

                    @foreach ($partitions as $partition)
                        <option value="{{ $partition->id }}" {{ old('partition_id') == $partition->id ? 'selected' : '' }}>
                            {{ $partition->title }} </option>
                    @endforeach

                </select>
                @error('partition_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <input class="form-control" type="file" name="img">
                @error('img')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn default-btn">Submit</button>
        </form>
    </div>
@endsection
