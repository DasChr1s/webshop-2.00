<header class="{{ $title ? 'header-with-title' : 'header-no-title' }}">
    <div class="container">
        @if ($title)
        <a href="{{ route('products.index') }}" class="logo-container">
            <img src="{{ asset('logo/cat-logo.png') }}" alt="Logo" class="logo">
            <div class="hover-text">Miau!</div>
        </a>
        @endif
        <nav class="nav-menu">
            <ul>
                @foreach ($links as $link)
                    @if (isset($link['type']) && $link['type'] === 'logout')
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="button">{{ $link['label'] }}</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
        @if (!auth()->check() || !auth()->user()->isAdmin())
        <div class="cart-container">
            <a href="{{ route('cart.show') }}" class="cart-icon">
                <img src="{{ asset('icons/cart.png') }}" alt="Warenkorb">
                <span class="badge" id="cart-count">0</span>
            </a>
        </div>
        @endif
    </div>
</header>