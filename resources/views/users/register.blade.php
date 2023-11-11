@extends('layout')

@section('title')
    Register
@endsection

@section('content')
    <div style="margin-bottom: 250px; margin-top: 50px" class="container">
        <form method="POST" action="{{ route('auth.handleRegister') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fs-1"> Name</label>
                <input placeholder="Your User Name" class="form-control" type="text" name="name"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fs-1">E-mail</label>
                <input placeholder="Please Write your personal E-mail" class="form-control" type="text" name="email"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label class="form-label fs-1">Password</label>
                <input placeholder="Please Write a Strong Password" class="form-control" type="password" name="password"
                    value="{{ old('password') }}">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn default-btn mb-3">Sign Up</button>
        </form>

    </div>
@endsection
