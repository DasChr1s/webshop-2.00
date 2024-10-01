<!-- resources/views/components/header.blade.php -->
<header>
    <div class="container">
        <a href="{{ Auth::check() && Auth::user()->is_admin ? route('admin.adminDashboard') : route('products.index') }}" class="logo-container">            
            <img src="{{ asset('logo/logo.png') }}" alt="Logo" class="logo white-logo">
            <div class="hover-text bg-black text-white">Startseite</div>
        </a>

        <!-- Navigation mit Links -->
        <nav class="nav-menu">
            <ul>
                @guest
                    <!-- Links für Gäste -->
                    <li><a href="{{ route('login') }}">{{ __('app.login') }}</a></li>
                    <li><a href="{{ route('register') }}">{{ __('app.register') }}</a></li>
                    <li><a href="{{ route('products.index') }}">{{ __('app.home') }}</a></li>
                    <!-- Warenkorb anzeigen -->
                    <div class="cart-container">
                        <a href="{{ route('cart.show') }}" class="cart-icon">
                            <img src="{{ asset('icons/cart.png') }}" alt="Warenkorb">
                            <span class="badge" id="cart-count">0</span>
                        </a>
                    </div>
                @else
                    <!-- Links für eingeloggte Benutzer -->
                    <li>
                        @if (auth()->check() && auth()->user()->isAdmin())
                            <a href="{{ route('admin.adminDashboard') }}">{{ __('app.home') }}</a>
                            <a href="{{ route('admin.products') }}">Produkte</a>
                            <a href="">Bestellungen</a>
                        @else
                            <a href="{{ route('products.index') }}">{{ __('app.home') }}</a>
                        @endif
                    </li>  
                    <!-- Logout-Link -->
                    <li>
                        <a href="#" class="logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('app.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    @if (!auth()->user()->isAdmin())
                        <!-- Warenkorb anzeigen, wenn der Benutzer kein Admin ist -->
                        <div class="cart-container">
                            <a href="{{ route('cart.show') }}" class="cart-icon">
                                <img src="{{ asset('icons/cart.png') }}" alt="Warenkorb">
                                <span class="badge" id="cart-count">0</span>
                            </a>
                        </div>
                        <!-- Profil-Icon mit Abstand -->
                        <div class="profile-badge" title="Eingeloggt als {{ auth()->user()->name }}">
                            <i class="bi bi-person-square user-icon"></i>
                        </div>
                    @endif
                @endguest

            </ul>
        </nav>
    </div>
</header>
