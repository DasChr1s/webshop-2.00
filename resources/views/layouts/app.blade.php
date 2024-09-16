<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title',  __('app.webshop') )</title>
    @vite('resources/scss/app.scss')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    @vite('resources/js/app.js')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
    <x-header title="{{ __('app.welcome') }}" :links="[
        ['url' => route('login'), 'label' => __('app.login')],
        ['url' => route('register'), 'label' => __('app.register')],
        ['url' => route('products.index'), 'label' => __('app.home')],
    ]"/>

   
    @yield('content')

  
</body>
<x-footer :links="[
    ['url' => url('/about'), 'label' => __('app.footer.aboutUs')],
    ['url' => url('/contact'), 'label' => __('app.footer.contact')],
    ['url' => url('/privacy'), 'label' => __('app.footer.privacy')],
    ['url' => url('/terms'), 'label' => __('app.footer.terms')],
]" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
