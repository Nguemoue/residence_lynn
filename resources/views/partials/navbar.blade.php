<nav class="navbar sticky top-0 z-50 bg-base-100 shadow">
    <div class="container mx-auto flex justify-between items-center">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="text-2xl font-bold navbar-start">
            Nove<span class="text-primary">den</span>
        </a>

        {{-- Zone droite : menu desktop · panier · thème · burger --}}
        <div class="navbar-end flex items-center gap-4">

            {{-- MENU (≥ lg) --}}
            <ul class="menu menu-horizontal gap-3 hidden lg:flex">
                <li>
                    <a class="{{ request()->routeIs('home') ? 'active font-semibold' : '' }}" href="{{ route('home') }}">Accueil</a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('products.*') ? 'active font-semibold' : '' }}" href="{{ route('products.index') }}">Produits</a>
                </li>
                <li><a class="scroll-link" href="{{ url('/#guide') }}">Guide</a></li>
                <li><a class="scroll-link" href="{{ url('/#about') }}">À propos</a></li>
                <li>
                    <a class="{{ request()->routeIs('blog.*') ? 'active font-semibold' : '' }}" href="{{ route('blog.index') }}">Blog</a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('faq.index') ? 'active font-semibold' : '' }}" href="{{ route('faq.index') }}">FAQ</a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('contact.create') ? 'active font-semibold' : '' }}" href="{{ route('contact.create') }}">Contact</a>
                </li>
            </ul>

            {{-- Panier --}}
            <div class="indicator">
                <a href="{{ route('cart.show') }}" class="btn btn-ghost btn-sm gap-1 {{ request()->routeIs('cart.*') ? 'active font-semibold' : '' }}">
                    @svg('heroicon-o-shopping-cart','h-5 w-5')
                    <span class="hidden md:inline">Panier</span>
                </a>
                @if(($cartCount ?? 0) > 0)
                    <span class="indicator-item badge badge-sm badge-primary">{{ $cartCount }}</span>
                @endif
            </div>

            {{-- Theme toggle --}}
            <label class="swap swap-rotate">
                <input type="checkbox" class="theme-controller" value="dark"/>
                @svg('heroicon-o-sun','swap-off w-5 h-5')
                @svg('heroicon-o-moon','swap-on w-5 h-5')
            </label>

            {{-- Burger (mobile) --}}
            <div class="dropdown dropdown-end lg:hidden">
                <label tabindex="0" class="btn btn-ghost btn-square">
                    @svg('heroicon-o-bars-3','w-6 h-6')
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[60] p-2 shadow bg-base-100 rounded-box w-56">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('products.index') }}">Produits</a></li>
                    <li><a href="{{ url('/#guide') }}">Guide</a></li>
                    <li><a href="{{ url('/#about') }}">À propos</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('faq.index') }}">FAQ</a></li>
                    <li><a href="{{ route('contact.create') }}">Contact</a></li>
                    <li>
                        <a href="{{ route('cart.show') }}">
                            @svg('heroicon-o-shopping-cart','h-4 w-4')
                            <span>Panier</span>
                            @if(($cartCount ?? 0) > 0)
                                <span class="badge badge-xs badge-primary ml-2">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>
