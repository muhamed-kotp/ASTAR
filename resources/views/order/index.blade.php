@extends('layout')

@section('title')
    All Orders
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Method</th>
                    <th scope="col">Total</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody id="courses-cont">
                @php $x = 1 ;@endphp
                @foreach ($orders as $order)
                    <tr class="table-warning">

                        <th scope="row">{{ $x }}</th>
                        <td><a href="{{ route('order.show', $order->id) }}"> {{ $order->user['name'] }} </a></td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->created_at }}</td>

                    </tr>
                    <div class="d-none">{{ $x++ }}</div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
