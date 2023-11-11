@extends('layout')

@section('title')
    Order Details
@endsection

@section('content')
    <div>
        <table class="table table-hover table-responsive">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">name</th>
                    <th scope="col">PriceEach</th>
                    <th scope="col">Quantity</th>

                </tr>
            </thead>
            <tbody id="courses-cont">
                @php $x = 1 ;@endphp
                @foreach ($userOrders as $qantity => $item)
                    <tr class="table-warning">

                        <th scope="row">{{ $x }}</th>
                        <td> <img src="{{ asset('uploads/items/') }}/{{ $item->img }}" class="img-fluid cart-img" />
                        </td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $qantity }}</td>
                        {{-- <td>{{ $order->total }}</td> --}}

                    </tr>
                    <div class="d-none">{{ $x++ }}</div>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container my-3">
        <h4>- Cutomer Name: <span class="fw-bold varient-danger">{{ $order->user['name'] }}</span> </h4>
        <h4>- Cutomer Phone: <span class="fw-bold ">{{ $order->phone }}</span> </h4>
        <h4>- Cutomer Address: <span class="fw-bold ">{{ $order->address }}</span></h4>
        <h4>- The Total: <span class="fw-bold ">${{ $order->total }}</span></h4>
    </div>

    <div class="d-flex justify-content-center my-5">
        <a href="{{ route('order.index') }}" class="btn default-btn fw-bolder  ">Back </a>
    </div>
@endsection
