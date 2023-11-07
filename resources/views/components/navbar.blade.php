<div class="world-wide">WORLDWIDE SHIPPING | 30 DAY FREE RETURNS</div>
<div>
    <nav class=" primary-nav navbar navbar-expand-lg navbar-dark bg-dark ">
        <div class="container-fluid">
            <a class="navbar-brand ms-5 nav-title" href="{{ route('welcome') }}">A STAR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-row-reverse" id="navbarNav">
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="disabled nav-link active me-5 home-nav color-light" aria-current="page"
                                href="#">{{ Auth::user()->name }} </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active me-5 home-nav color-light" aria-current="page"
                                href="{{ route('auth.logout') }}">Logout </a>
                        </li>
                        <div class="dropdown me-3">
                            <a class=" nav-link active dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Add New
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('items.create') }}">Item</a></li>
                                <li><a class="dropdown-item" href="{{ route('category.create') }}">Category</a>
                                <li><a class="dropdown-item" href="{{ route('partition.create') }}">Partition</a>
                                </li>
                            </ul>
                        </div>
                    @endauth

                    @guest
                        <li class="nav-item">
                            <a class="nav-link active  me-5 home-nav color-light" aria-current="page"
                                href="{{ route('auth.login') }}">Login </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active me-5 home-nav " aria-current="page"
                                href="{{ route('auth.register') }}">Register </a>
                        </li>
                    @endguest
                    {{-- <div class="btn-group">
                        <a href="{{ route('category.index') }}" type="btn"
                            class="nav-link active  home-nav color-light">Categories</a>
                        <button type="button"
                            class="btn nav-link active  me-5 home-nav color-light dropdown-toggle dropdown-toggle-split"
                            id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-reference="parent">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                            @foreach ($cats as $cat)
                                <li><a class="dropdown-item"
                                        href="{{ route('category.show', $cat->id) }}">{{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </div> --}}


                    <li class="nav-item">
                        <a class="nav-link active me-5 home-nav color-light" aria-current="page"
                            href="{{ route('welcome') }}">Home</a>
                    </li>



                </ul>
            </div>
        </div>
    </nav>

</div>
