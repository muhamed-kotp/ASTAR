@extends('layout')

@section('title')
    Update User Settings
@endsection

@section('content')
    <div class="container"style="margin-bottom: 250px; margin-top: 50px">
        <div class="container my-3 d-flex justify-content-center">
            <h4>User Name: <span class="fw-bold text-danger">{{ $user->name }}</span> </h4>
        </div>
        <form method="POST" action="{{ route('users.update', $user->id) }}">

            @csrf
            <h3>- Choose Role for {{ $user->name }} :-</h3>
            <div class="mb-3">
                @foreach ($roles as $role)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="{{ $role->name }}"
                            value="{{ $role->name }}">
                        <label class="form-check-label" for="{{ $role->name }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
                @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror


                <button type="submit" class="btn default-btn">Submit</button>
        </form>
    </div>
@endsection
