@extends('layout')

@section('title')
    Create New Role
@endsection

@section('content')
    <div class="container"style="margin-bottom: 250px; margin-top: 50px">
        <form method="POST" action="{{ route('role-permission.store') }}">

            @csrf
            <div class="mb-3">
                <label class="form-label fs-4">Role Name</label>
                <input placeholder="This will be the Name of Role" type="text" name="role" class="form-control"
                    value="{{ old('role') }}">
                @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                @foreach ($permissions as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $permission->name }}"
                            name="permissions[]">
                        <label class="form-check-label">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
                @error('permissions')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror


                <button type="submit" class="btn default-btn">Submit</button>
        </form>
    </div>
@endsection
