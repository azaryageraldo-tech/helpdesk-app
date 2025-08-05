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
                class="bg-gray-800 text-white w-64 fixed inset-y-0 left-0 transform md:translate-x-0 transition-transform duration-300 ease-in-out z-30"
                :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
                @click.away="sidebarOpen = false"
            >
                <!-- Logo and Navigation Links -->
                @include('layouts.navigation')
            </aside>

            <!-- Main Content Area -->
            <div class="md:ml-64 flex flex-col flex-1">
                <!-- Top Header -->
                <header class="bg-white shadow-sm">
                    <div class="w-full mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                        <!-- Hamburger Button (Mobile Only) -->
                        <button @click.stop="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <!-- Page Title -->
                        <div class="flex-1 text-center md:text-left">
                            @if (isset($header))
                                {{ $header }}
                            @endif
                        </div>

                        <!-- User Profile Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
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

                <!-- Main Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            <!-- Real-time Notification Toast -->
            <div 
                x-data="{ show: false, message: '', url: '#' }"
                x-on:new-notification.window="show = true; message = $event.detail.message; url = $event.detail.url; setTimeout(() => show = false, 5000)"
                x-show="show"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed bottom-5 right-5 w-full max-w-sm bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
                style="display: none;"
            >
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900">Notifikasi Baru!</p>
                            <a :href="url" class="mt-1 text-sm text-gray-500 hover:underline" x-text="message"></a>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button @click="show = false" type="button" class="inline-flex text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laravel Echo Event Listener Script -->
        @auth
        <script type="module">
            // Dengarkan event di channel publik 'notifications'
            Echo.channel('notifications')
                .listen('NewReplyNotification', (e) => {
                    // Kirim event ke komponen Alpine.js untuk ditampilkan
                    window.dispatchEvent(new CustomEvent('new-notification', {
                        detail: {
                            message: e.message,
                            url: e.url
                        }
                    }));
                });
        </script>
        @endauth
    </body>
</html>
