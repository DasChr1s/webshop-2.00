<footer>
   
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>{{ __('app.footer.aboutUs') }}</h5>
                <p>{{ __('app.footer.descriptionCompany') }}</p>
            </div>
            <div class="col-md-4">
                <h5>{{ __('app.footer.navigation') }}</h5>
                <ul class="list-unstyled">
                    @foreach ($links as $link)
                        <li><a href="{{ $link['url'] }}" class="text-white">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <h5>{{ __('app.footer.contact') }}</h5>
                <p>{{ __('app.footer.email') }}: info@deinwebshop.de</p>
                <p>{{ __('app.footer.phone') }}: +49 123 456 7890</p>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>&copy; {{ date('Y') }} {{ __('app.footer.yourWebshop') }}</p>
        </div>
    </div>
</footer>
