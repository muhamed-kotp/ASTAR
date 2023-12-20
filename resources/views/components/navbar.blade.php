<div class="world-wide">WORLDWIDE SHIPPING | 30 DAY FREE RETURNS</div>
<div class="nav-Box fixed-top">
    <nav class=" primary-nav navbar navbar-expand-lg navbar-dark bg-dark  ">
        <div class="container-fluid">
            <a class="navbar-brand nav-title" href="{{ route('welcome') }}">A STAR</a>
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
                        @can('create-categories')
                            <div class="dropdown me-3">
                                <a class=" nav-link active dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Add New
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="{{ route('items.create') }}">Item</a></li>
                                    <li><a class="dropdown-item" href="{{ route('category.create') }}">Category</a>
                                    <li><a class="dropdown-item" href="{{ route('partition.create') }}">Partition</a>
                                    <li><a class="dropdown-item" href="{{ route('role-permission.create') }}">Role</a>
                                    </li>
                                </ul>
                            </div>
                        @endcan
                        @can('edit-categories')
                            <div class="dropdown me-3">
                                <a class=" nav-link active dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Edit Categories
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @foreach ($categories as $category)
                                        <li><a class="dropdown-item"
                                                href="{{ route('category.edit', $category->id) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endcan
                        @can('view-orders')
                            <li class="nav-item">
                                <a class="nav-link active me-5 home-nav color-light" aria-current="page"
                                    href="{{ route('order.index') }}">Orders </a>
                            </li>
                        @endcan
                        @can('view-settings')
                            <li class="nav-item">
                                <a class="nav-link active me-5 home-nav color-light" aria-current="page"
                                    href="{{ route('role-permission.index') }}">Roles </a>
                            </li>
                        @endcan
                        @can('view-users')
                            <li class="nav-item">
                                <a class="nav-link active me-5 home-nav color-light" aria-current="page"
                                    href="{{ route('users.index') }}">Users </a>
                            </li>
                        @endcan
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

                    <li class="nav-item">
                        <a class="nav-link active me-5 home-nav color-light" aria-current="page"
                            href="{{ route('welcome') }}">Home</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div>
        <nav class="navbar navbar-danger  border-bottom sec-nav ">
            <div class="container-fluid justify-content-center">
                @foreach ($categories as $category)
                    <div class="dropdown me-3">
                        <a class="nav-Cat-Name nav-link active dropdown-toggle " href="#" role="button"
                            id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $category->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach ($category->partitions as $partition)
                                <li><a class="dropdown-item"
                                        href="{{ route('partition.show', $partition->id) }}">{{ $partition->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
                <a class="btn btn-outline-dark" href="{{ route('shopping.cart') }}">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span
                        class="{{ session('cart') ? 'badge bg-danger' : 'badge bg-success' }}">{{ count((array) session('cart')) }}</span>
                </a>
            </div>
        </nav>
    </div>
</div>
