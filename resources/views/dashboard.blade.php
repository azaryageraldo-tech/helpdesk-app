<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pesan Selamat Datang Awal --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            {{-- Tampilkan Statistik jika ada --}}
            @if(isset($stats))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-600">Total Tiket Anda</h3>
                            <p class="text-3xl font-bold mt-2">{{ $stats['totalTickets'] }}</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-600">Tiket Open</h3>
                            <p class="text-3xl font-bold mt-2 text-green-600">{{ $stats['openTickets'] }}</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-600">Tiket Closed</h3>
                            <p class="text-3xl font-bold mt-2 text-gray-500">{{ $stats['closedTickets'] }}</p>
                        </div>
                    </div>

                    {{-- Card ini hanya untuk Admin --}}
                    @if(Auth::user()->is_admin)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-600">Total Pengguna</h3>
                                <p class="text-3xl font-bold mt-2">{{ $stats['totalUsers'] }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>