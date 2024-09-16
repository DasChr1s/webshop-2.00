<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('app.webshop') }}</title>
    @vite('resources/scss/app.scss')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <x-header title="{{ __('app.welcome') }}" :links="[
        ['url' => route('login'), 'label' => __('app.login')],
        ['url' => route('register'), 'label' => __('app.register')],
        ['url' => url('/'), 'label' => __('app.home')],
    ]"/>

    <main>
        <div class="container">
            <h2>{{ __('app.discoverProducts') }}</h2>

            <!-- Bootstrap Carousel -->
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    @foreach ($images as $index => $image)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ $image }}" class="d-block w-100" alt="Produktbild {{ $index + 1 }}">
                        </div>
                    @endforeach
                </div>
                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2 class="mb-4">{{ __('app.welcomeShop') }}</h2>
                        <p class="lead">{{ __('app.discoverText') }}</p>
                        <p class="mb-0">{{ __('app.ourGoal') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <x-footer :links="[
        ['url' => url('/about'), 'label' => __('app.footer.aboutUs')],
        ['url' => url('/contact'), 'label' => __('app.footer.contact')],
        ['url' => url('/privacy'), 'label' => __('app.footer.privacy')],
        ['url' => url('/terms'), 'label' => __('app.footer.terms')],
    ]" />
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
