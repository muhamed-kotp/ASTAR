@extends('layout')

@section('title')
    Check Out
@endsection

@section('content')
    <div class="container" style="margin-bottom: 250px; margin-top: 50px">
        <form method="POST" action="{{ route('handle.checkOut') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fs-4">Address</label>
                <input placeholder="Please Enter Your Address " class="form-control" type="text" name="address"
                    value="{{ old('address') }}">
                @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>
            <div class="mb-3">
                <label class="form-label fs-4">Phone</label>
                <input placeholder="Please Enter a Strong Phone" class="form-control" type="text" name="phone"
                    value="{{ old('phone') }}">
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="dropdown mb-3">
                <label class="form-label fs-4">Payment Method</label>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="payment_method">
                    <option>Choose Payment Method</option>
                    <option value="Visa" {{ old('payment_method') == 'Visa' ? 'selected' : '' }}>Visa Card</option>
                    <option value="Master" {{ old('payment_method') == 'Master' ? 'selected' : '' }}>Master Card
                    </option>
                    <option value="Paypal" {{ old('payment_method') == 'Paypal' ? 'selected' : '' }}>Paypal</option>
                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                </select>
                @error('payment_method')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn default-btn mb-3">Submit</button>
        </form>

    </div>
@endsection
