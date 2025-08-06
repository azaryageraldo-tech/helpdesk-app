<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Judul Sambutan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold">Selamat datang kembali, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-500 mt-1">Berikut adalah ringkasan aktivitas sistem helpdesk Anda.</p>
                </div>
            </div>

            {{-- Tampilkan Statistik jika ada --}}
            @if(isset($stats))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Card Total Tiket -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-400">Total Tiket</div>
                            <div class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['totalTickets'] }}</div>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h3m10 0h3a2 2 0 002-2v-3a2 2 0 00-2-2h-3m-3-3a2 2 0 00-2-2h-3a2 2 0 00-2 2v3a2 2 0 002 2h3a2 2 0 002-2v-3z"></path></svg>
                        </div>
                    </div>

                    <!-- Card Tiket Open -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-400">Tiket Open</div>
                            <div class="text-3xl font-bold text-green-500 mt-1">{{ $stats['openTickets'] }}</div>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                    </div>

                    <!-- Card Tiket Closed -->
                    <div class="bg-white p-6 rounded-xl shadow-lg flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-400">Tiket Closed</div>
                            <div class="text-3xl font-bold text-gray-500 mt-1">{{ $stats['closedTickets'] }}</div>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>

                    {{-- Card ini hanya untuk Admin --}}
                    @if(Auth::user()->is_admin)
                        <div class="bg-white p-6 rounded-xl shadow-lg flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-400">Total Pengguna</div>
                                <div class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['totalUsers'] }}</div>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-full">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
