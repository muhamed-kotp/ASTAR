@extends('layout')

@section('title')
    All Roles
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                </tr>
            </thead>
            <tbody id="courses-cont">
                @php $x = 1 ;@endphp
                @foreach ($roles as $role)
                    <tr class="table-warning">

                        <th scope="row">{{ $x }}</th>
                        <td><a class="fs-5 fw-bold " href="{{ route('role-permission.show', $role->id) }}">
                                {{ $role->name }}
                            </a></td>

                    </tr>
                    <div class="d-none">{{ $x++ }}</div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
