<footer>
   
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>{{ __('app.footer.aboutUs') }}</h5>
                <p>{{ __('app.footer.descriptionCompany') }}</p>
            </div>
            <div class="col-md-4">
                
                <img src="{{ asset('logo/logo.png') }}" alt="Logo" class="logo white-logo">

            </div>
            <div class="col-md-4">
                <h5>{{ __('app.footer.contact') }}</h5>
                <p>{{ __('app.footer.email') }}: chp-test-shop@gmx.at</p>
                <p>{{ __('app.footer.phone') }}: Telefonnummer</p>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>&copy; {{ date('Y') }} {{ __('app.footer.yourWebshop') }}</p>
        </div>
    </div>
</footer>
