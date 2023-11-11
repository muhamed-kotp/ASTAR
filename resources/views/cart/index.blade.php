@extends('layout')

@section('content')
    {{-- @php dd(session('cart')) @endphp --}}

    @if (session('cart'))
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('fail'))
            <div class="alert alert-danger">
                {{ session('fail') }}
            </div>
        @endif
        <table id="cart" class=" my-5 table table-hover">
            <thead>
                <tr>
                    <th>Image</th>
                    <th class="dis_none_sm">Name</th>
                    <th>Total Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @foreach (session('cart') as $id => $details)
                    <tr>
                        <td><a href="{{ route('items.show', $id) }}">
                                <img src="{{ asset('uploads/items/') }}/{{ $details['img'] }}" class="img-fluid cart-img" />
                            </a>
                        </td>
                        <td class="dis_none_sm">{{ $details['title'] }}</td>
                        <td>${{ $details['price'] }}</td>

                        <td class="actions">

                            <a href="{{ route('plus.quantity', $id) }}" class="btn btn-outline-success btn-sm"><i
                                    class="fa-solid fa-plus blus"></i></a>
                            <span class="break">|</span>
                            <span class="">{{ $details['quantity'] }}</span>
                            <span class="break">|</span>
                            @if ($details['quantity'] > 1)
                                <a href="{{ route('minus.quantity', $id) }}" class="btn btn-outline-success btn-sm"><i
                                        class="fa-solid fa-minus minus"></i></a>
                            @endif
                            <a href="{{ route('delete.cart.product', $id) }}" class="btn btn-outline-danger btn-sm "><i
                                    class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    @php
                        $total = $total + $details['price'];
                    @endphp
                @endforeach

                @php
                    session(['total' => $total]);
                @endphp

            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right cart-btns-cont">
                        <div class="btns-box">
                            <a href="{{ route('checkOut') }}" class=" me-3 mb-3 btn default-btn">Checkout</a>
                            <a href="{{ route('welcome') }}" class=" me-3 mb-3 btn btn-primary"><i
                                    class="fa fa-angle-left"></i>
                                Continue Shopping</a>
                        </div>
                        @php
                            $total = session('total');
                        @endphp
                        <div class="mb-3 fs-5 fw-bold">Total: ${{ $total }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    @else
        <div class="container d-flex flex-column justify-content-center align-items-center"
            style=" margin-bottom:250px;margin-top: 6rem;">
            <h3 class="text-center mb-5">Your Cart Is Empty !</h3>
            <a href="{{ route('welcome') }}" class="btn default-btn fw-bolder  ">Continue Shopping </a>
        </div>
    @endif
@endsection
