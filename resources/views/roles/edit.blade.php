@extends('layout')

@section('title')
    Edit Role
@endsection

@section('content')
    <div class="d-flex justify-content-center w-100 mt-3 ">
        <h4 class="bg-danger p-2 rounded text-white text-capitalize fw-bold">{{ $role->name }} </h4>
    </div>
    <div class="container"style="margin-bottom: 250px; margin-top: 20px">
        <form method="POST" action="{{ route('role-permission.update', $role->id) }}">

            @csrf

            @method('PUT')
            <div class="mb-3">
                <label class="form-label fs-4">Role Name</label>
                <input placeholder="This will be the Name of Role" type="text" name="role" class="form-control"
                    value="{{ old('role') ?? $role->name }}">
                @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3  ">
                @php
                    $rolePermissionArray = [];
                    foreach ($permissionsPerRole as $key => $value) {
                        array_push($rolePermissionArray, $value['name']);
                    }
                    // dd($rolePermissionArray);
                @endphp
                @foreach ($permissions as $permission)
                    <div class="form-check">
                        <input {{ in_array($permission->name, $rolePermissionArray) ? 'checked' : '' }}
                            class="form-check-input" type="checkbox" value="{{ $permission->name }}" name="permissions[]">
                        <label class="form-check-label">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
                @error('permissions')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror


                <button type="submit" class="btn default-btn my-3">Submit</button>
                <a class="btn back_btn fw-bold" style="margin-top: -2px"
                    href="{{ route('role-permission.show', $role->id) }}">Back</a>
        </form>
    </div>
@endsection
