@extends('layout')

@section('title')
    Welcome To A STAR shop
@endsection


@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div id="carouselExampleInterval" class="carousel slide mb-3 " data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img style="height:800px ;" src="{{ asset('uploads/pexels-pixabay-356056.jpg') }}" class="d-block w-100 "
                    alt="...">
            </div>
        </div>
    </div>

    <div class= "d-flex  row mx-3" style=" grid-column-gap: 20px; justify-content: center;">
        @foreach ($categories as $category)
            @foreach ($category->partitions as $partition)
                <div class="mb-3  prod-col-cont">
                    <div style="height:100%; overflow:hidden">

                        <div class="card prod-img "
                            style="background-image: url('{{ asset('uploads/partitions/') }}/{{ $partition->img }} ')">
                            <h5 class="partition-title fw-normal text-center">{{ $partition->title }}</h5>
                            <a class="btn default-btn" href="{{ route('partition.show', $partition->id) }}">View
                                Products</a>
                            @auth
                                @if (Auth::user()->Is_admin == 1)
                                    <div class="btns-box">
                                        <a class="btn back_btn" href="{{ route('partition.edit', $partition->id) }}">edit</a>
                                        <a class="btn back_btn"
                                            href="{{ route('partition.delete', $partition->id) }}">Delete</a>
                                    </div>
                                @endif
                            @endauth
                        </div>

                    </div>

                </div>
            @endforeach
        @endforeach
    </div>
@endsection
