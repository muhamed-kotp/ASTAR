@extends('layout')

{{-- @section('style')
    <link rel="stylesheet" href="{{ asset('css/booksIndex.css') }}">
@endsection --}}

@section('content')
    <div class="container " style="margin-bottom :250px; margin-top: 50px ">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class=" row ">
            @if ($item !== null)
                <div class="col-lg-6 mt-5">
                    <img src="{{ asset('uploads/items/') }}/{{ $item->img }}" class="img-fluid ">
                </div>
                <div class="mt-5 col-lg-6">
                    <div class="ms-5">
                        <h4 class="fw-normal">{{ $item->title }}</h4>

                        <p>{{ $item->description }}</p>
                        <p>Price: ${{ $item->price }}</p>



                        <a href="{{ route('add.to.cart', $item->id) }}" class="btn default-btn">Add to
                            Cart</a>


                        @can('edit-items')
                            <p>There are {{ $item->quantity }} Pieces</p>
                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-info">Edit</a>
                            <a href="{{ route('items.delete', $item->id) }}" class="btn btn-danger">delete</a>
                        @endcan

                        <div class="my-5">
                            <a href="{{ route('partition.show', $item->partition_id) }}" class="btn back_btn">Back</a>
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
