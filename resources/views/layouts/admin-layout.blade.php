<!-- resources/views/layouts/admin-layout.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/scss/app.scss', 'resources/scss/admin.scss'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <x-header :links="[
        ['url' => route('login'), 'label' => 'Produkte'],
        ['url' => route('logout'), 'label' => 'Profil'],
    ]" />
    <div class="wrapper">
        <div class="sidebar">
            <h2>Admin</h2>
            <a href="{{ route('admin.orders') }}">Manage Orders</a>
            <a href="{{ route('admin.products') }}">Manage Products</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger mt-3">Logout</button>
            </form>
        </div>
        <div class="main-content">
            @yield('admin-content')
        </div>
    </div>
</body>

</html>