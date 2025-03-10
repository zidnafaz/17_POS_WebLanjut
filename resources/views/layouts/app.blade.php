{{-- -- resources/views/layouts/app.blade.php -- --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">POS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('products') || Request::is('category/*') ? 'active' : '' }}" href="{{ route('products.index') }}">Products</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Request::is('user/*') ? 'active' : '' }}" href="{{ url('/user/1/name/Faza') }}">User</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('user') ? 'active' : '' }}" href="{{ url('/user') }}">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('user_count') ? 'active' : '' }}" href="{{ url('/user_count') }}">Jumlah User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('penjualan') ? 'active' : '' }}" href="{{ route('selling.index') }}">Penjualan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('Level') ? 'active' : '' }}" href="{{ url('/Level') }}">Level</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
