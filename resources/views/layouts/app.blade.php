<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">
            <!-- Sidebar -->
            <aside 
                class="bg-gray-900 text-white w-64 fixed inset-y-0 left-0 transform md:translate-x-0 transition-transform duration-300 ease-in-out z-30"
                :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
                @click.away="sidebarOpen = false"
            >
                <!-- Logo dan Navigasi ditarik dari file navigation.blade.php -->
                @include('layouts.navigation')
            </aside>

            <!-- Main Content Area -->
            <div class="md:ml-64 flex flex-col flex-1">
                <!-- Top Header -->
                <header class="bg-white shadow-sm">
                    <div class="w-full mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                        <!-- Tombol Hamburger (Hanya untuk Mobile) -->
                        <button @click.stop="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <!-- Judul Halaman -->
                        <div class="flex-1 text-center md:text-left">
                            @if (isset($header))
                                {{ $header }}
                            @endif
                        </div>

                        <!-- Menu Header Kanan (Lonceng & Profil) -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Lonceng Notifikasi -->
                            <div class="me-4">
                                <x-notification-bell />
                            </div>

                            <!-- Menu Profil Pengguna -->
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->name }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                <!-- Konten Utama Halaman -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Script Pendengar Event Laravel Echo -->
        @auth
        <script type="module">
            // Dengarkan notifikasi di channel privat milik user yang sedang login
            Echo.private('App.Models.User.{{ auth()->id() }}')
                .notification((notification) => {
                    // Kirim event ke komponen Alpine.js (notification-bell) untuk di-refresh
                    window.dispatchEvent(new CustomEvent('new-notification-received'));
                });
        </script>
        @endauth
    </body>
</html>
