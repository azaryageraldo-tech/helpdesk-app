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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Kolom Kiri: Gambar Branding -->
            <div 
                class="hidden lg:flex w-1/2 items-center justify-center p-12 relative bg-no-repeat bg-cover bg-center"
                style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop');"
            >
                <!-- Lapisan Gradien Gelap -->
                <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-indigo-900 to-black opacity-80"></div>
                
                <div class="z-10 text-white text-center">
                    <a href="/">
                        <x-application-logo class="w-24 h-24 mx-auto fill-current text-white" />
                    </a>
                    <h1 class="text-4xl font-bold mt-4 tracking-tight">Internal Helpdesk</h1>
                    <p class="mt-2 text-indigo-200">Tingkatkan efisiensi dan produktivitas tim di Perusahaan Anda.</p>
                </div>
            </div>

            <!-- Kolom Kanan: Formulir -->
            <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-100 p-6 sm:p-12">
                <div class="w-full max-w-md">
                    <div class="lg:hidden text-center mb-8">
                         <a href="/">
                            <x-application-logo class="w-20 h-20 mx-auto fill-current text-gray-500" />
                        </a>
                    </div>
                    
                    <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-2xl">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
