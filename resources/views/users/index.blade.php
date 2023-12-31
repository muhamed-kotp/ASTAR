@extends('layout')

@section('title')
    All Users
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @php $x = 1 ;@endphp
                @foreach ($users as $user)
                    <tr class="table-warning">

                        <th scope="row">{{ $x }}</th>
                        <td class="fw-bold">{{ $user->name }}</td>
                        <td class="fw-bold">{{ $user->email }}</td>
                        <td class="fw-bold">{{ $user->role }}</td>
                        <td><a class="fw-bold btn default-btn"href="{{ route('users.edit', $user->id) }}">Edit
                                Role</a>
                        </td>


                    </tr>
                    <div class="d-none">{{ $x++ }}</div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
