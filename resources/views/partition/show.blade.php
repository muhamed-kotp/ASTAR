@extends('layout')

@section('title')
    show category details
@endsection

@section('content')
    <div style="margin-bottom: 250px; margin-top: 50px">

        <div class=" container d-flex  justify-content-center ">
            <h1> {{ $partition->title }}</h1>
        </div>

        <div class= "d-flex  row mx-3" style=" grid-column-gap: 20px; justify-content: center;">
            @foreach ($partition->items as $item)
                <div class="mb-3  prod-col-cont">
                    <div style="height:80%; overflow:hidden">
                        <a href="{{ route('items.show', $item->id) }}">
                            <div class="card prod-img "
                                style="background-image: url('{{ asset('uploads/items/') }}/{{ $item->img }} ')">
                            </div>
                        </a>
                    </div>
                    <div class="card-body" style="height:300px ;padding: 0; ">
                        <h5 class="card-title prod-name fw-normal">{{ $item->title }}</h5>
                        <h5 class="card-title prod-price fw-normal">$ <span
                                class="fw-lighter fs-5">{{ $item->price }}</span></h5>
                    </div>
                </div>
            @endforeach
        </div>



        <div class="d-flex justify-content-center">
            <a style="margin-bottom: 250px;" class="btn default-btn" href="{{ route('welcome') }}">Back</a>
        </div>
    @endsection
