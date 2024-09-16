<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    @vite('resources/scss/app.scss')
</head>

<body>
    <x-header :links="[
        ['url' => route('login'), 'label' => 'Produkte'],
        ['url' => route('logout'), 'label' => 'Profil'],
        ['type' => 'logout', 'label' => 'Logout'],
    ]" />
    <main>
        <h1>Welcome to your admin dashboard, {{ Auth::user()->name }}!</h1>
    </main>
</body>

</html>
