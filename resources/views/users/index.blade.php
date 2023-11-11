@extends('layout')

@section('title')
    All Users
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Is Admin</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @php $x = 1 ;@endphp
                @foreach ($users as $user)
                    <tr class="table-warning">

                        <th scope="row">{{ $x }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->Is_admin == 0 ? 'no' : 'yes' }}</td>
                        <td><a style="width: 250px"
                                class="btn default-btn"href="{{ route('users.edit', $user->id) }}">{{ $user->Is_admin == 0 ? 'Make Admin' : 'Remove Admin' }}</a>
                        </td>


                    </tr>
                    <div class="d-none">{{ $x++ }}</div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
