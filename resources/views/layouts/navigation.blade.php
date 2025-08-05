<div>
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-gray-900">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-white" />
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-5">
        <x-side-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            {{ __('Dashboard') }}
        </x-side-nav-link>
        
        <x-side-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h3m10 0h3a2 2 0 002-2v-3a2 2 0 00-2-2h-3m-3-3a2 2 0 00-2-2h-3a2 2 0 00-2 2v3a2 2 0 002 2h3a2 2 0 002-2v-3z"></path></svg>
            {{ __('Daftar Tiket') }}
        </x-side-nav-link>
        
        {{-- Admin Menu --}}
        @if(Auth::user()->is_admin)
            <div class="mt-4 pt-4 border-t border-gray-700">
                <p class="px-4 text-xs uppercase text-gray-400 mb-2">Admin Area</p>
                
                <x-side-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-1a6 6 0 00-1.78-4.125a4 4 0 00-6.44 0A6 6 0 003 20v1h12z"></path></svg>
                    {{ __('Manajemen User') }}
                </x-side-nav-link>

                <x-side-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"></path></svg>
                    {{ __('Kategori') }}
                </x-side-nav-link>

                <x-side-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    {{ __('Laporan') }}
                </x-side-nav-link>
            </div>
        @endif

        {{-- Logout (ditampilkan di sidebar pada tampilan mobile) --}}
        <div class="mt-5 pt-5 border-t border-gray-700 md:hidden">
            <div class="px-2 space-y-1">
                <p class="px-2 font-semibold text-white">{{ Auth::user()->name }}</p>
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </nav>
</div>
