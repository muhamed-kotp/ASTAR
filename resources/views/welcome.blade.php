@extends('layout')


@section('title')
    Welcome To A STAR shop
@endsection


@section('content')
    <div style="margin-bottom: 250px;">
        <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                @foreach ($categories as $category)
                    <div class="dropdown me-3">
                        <a class=" nav-link active dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $category->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('items.create') }}">Item</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.create') }}">Category</a>
                            <li><a class="dropdown-item" href="{{ route('partition.create') }}">Partition</a>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </nav>
    </div>
@endsection
