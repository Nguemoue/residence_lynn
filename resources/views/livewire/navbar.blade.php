<nav class="navbar  top-0 z-50 bg-base-100 shadow">
    <div class="container mx-auto flex justify-around gap-2 items-center">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="text-2xl font-bold navbar-start ">
{{--            Nove<span class="text-primary">den</span>--}}
            <img src="{{asset('assets/images/logo.png')}}" alt="Logo {{config('app.name')}}"  class="w-[8rem] h-auto" >
            <span class="text-primary mx-3">Residence Lynn</span>
        </a>

        {{-- Zone droite --}}
        <div class="navbar-end flex items-center gap-4  w-full">
            {{-- Menu desktop --}}
            <ul class="menu menu-horizontal gap-3 hidden lg:flex">
                <li><a class="{{ request()->routeIs('home') ? 'active font-semibold' : '' }}" href="{{ route('home') }}">Accueil</a></li>
                <li><a class="{{ request()->routeIs('accommodation_types.*') ? 'active font-semibold' : '' }}" href="{{ route('accommodation_types.index') }}">Reservation</a></li>
                <li><a class="{{ request()->routeIs('about.*') ? 'active font-semibold' : '' }}" href="{{ route('about.show') }}">À propos</a></li>
                <li><a class="{{ request()->routeIs('blog.*') ? 'active font-semibold' : '' }}" href="{{ route('blog.index') }}">Blog</a></li>
                <li><a class="{{ request()->routeIs('faq.index') ? 'active font-semibold' : '' }}" href="{{ route('faq.index') }}">FAQ</a></li>
                <li><a class="{{ request()->routeIs('contact.create') ? 'active font-semibold' : '' }}" href="{{ route('contact.create') }}">Contact</a></li>
                <li><a class="{{ request()->routeIs('gallery.*') ? 'active font-semibold' : '' }}" href="{{ route('gallery.index') }}">Galerie</a></li>
                <li><a href="{{ url('dashboard') }}">Mon compte</a></li>
            </ul>

            {{-- Thème --}}
            <label class="swap swap-rotate">
                <input type="checkbox" class="theme-controller" value="dark" />
                @svg('heroicon-o-sun','swap-off w-5 h-5')
                @svg('heroicon-o-moon','swap-on w-5 h-5')
            </label>

            {{-- Burger mobile --}}
            <div class="dropdown dropdown-end lg:hidden">
                <label tabindex="0" class="btn btn-ghost btn-square">
                    @svg('heroicon-o-bars-3','w-6 h-6')
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[60] p-2 shadow bg-base-100 rounded-box w-[70vw] text-center">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('accommodation_types.index') }}">Produits</a></li>
                    <li><a href="{{ route('about.show') }}">Reservation</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('faq.index') }}">FAQ</a></li>
                    <li><a href="{{ route('contact.create') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
