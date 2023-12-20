@extends('layout')

@section('title')
    Role {{ $role->name }}
@endsection

@section('content')
    <div class="d-flex justify-content-around">
        <div class="d-flex justify-content-center  mt-3 ">
            <h4 class="bg-danger p-2 rounded text-white text-capitalize fw-bold">{{ $role->name }} </h4>
        </div>
        <div class="d-flex">
            <a class="btn back_btn fw-bold pb-0 pt-2" href="{{ route('role-permission.edit', $role->id) }}">edit</a>
            <a class="btn back_btn fw-bold pb-0 pt-2" href="{{ route('role.delete', $role->id) }}">Delete</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Permission</th>
                </tr>
            </thead>
            <tbody id="courses-cont">
                @php $x = 1 ;@endphp
                @foreach ($permissions as $permission)
                    <tr class="table-warning">

                        <th scope="row">{{ $x }}</th>
                        <td> {{ $permission['name'] }} </td>

                    </tr>
                    <div class="d-none">{{ $x++ }}</div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
