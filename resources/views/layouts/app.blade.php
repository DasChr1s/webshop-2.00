{{-- hauptdokument, hier wird der content geladen --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title',  __('app.webshop') )</title>
    
    <!-- CSS via Vite laden -->
    @vite('resources/scss/app.scss')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
    <!-- Header -->
    <x-header title="{{ __('app.welcome') }}" :links="[
        ['url' => route('login'), 'label' => __('app.login')],
        ['url' => route('register'), 'label' => __('app.register')],
        ['url' => route('products.index'), 'label' => __('app.home')],
    ]"/>

    {{-- content aller blades je nachdem was geladen wird --}}
    @yield('content')

</body>

<!-- Footer -->
<x-footer :links="[
    ['url' => url('/about'), 'label' => __('app.footer.aboutUs')],
    ['url' => url('/contact'), 'label' => __('app.footer.contact')],
    ['url' => url('/privacy'), 'label' => __('app.footer.privacy')],
    ['url' => url('/terms'), 'label' => __('app.footer.terms')],
]" />

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript via Vite laden -->
@vite('resources/js/app.js')
</html>
