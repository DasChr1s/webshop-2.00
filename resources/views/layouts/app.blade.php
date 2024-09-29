<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('app.webshop'))</title>

    @vite('resources/scss/app.scss')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Header -->
    <x-header />

    {{-- Content aller Blades je nachdem was geladen wird --}}
    @yield('content')

    <!-- Footer -->
    <x-footer :links="[
        ['url' => url('/about'), 'label' => __('app.footer.aboutUs')],
        ['url' => url('/contact'), 'label' => __('app.footer.contact')],
        ['url' => url('/privacy'), 'label' => __('app.footer.privacy')],
        ['url' => url('/terms'), 'label' => __('app.footer.terms')],
    ]" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/app.js')
</body>
</html>
