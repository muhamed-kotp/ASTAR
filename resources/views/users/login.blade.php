@extends('layout')

@section('title')
    Login
@endsection

@section('content')
    <div class="container" style="margin-bottom: 250px; margin-top: 50px">
        <form method="POST" action="{{ route('auth.handleLogin') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fs-1">E-mail</label>
                <input placeholder="Please Enter Your E-mail " class="form-control" type="text" name="email"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>
            <div class="mb-3">
                <label class="form-label fs-1">Password</label>
                <input placeholder="Please Enter a Strong password" class="form-control" type="password" name="password"
                    value="{{ old('password') }}">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            @if (session('fail'))
                <div class="alert alert-danger">
                    {{ session('fail') }}
                </div>
            @endif
            <button type="submit" class="btn default-btn mb-3">Sign In</button>
        </form>

    </div>
@endsection
