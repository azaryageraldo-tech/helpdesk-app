<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Tiket Bantuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-8 bg-white border-b border-gray-200">
                    
                    <div class="flex flex-col md:flex-row justify-between md:items-center mb-4">
                        <!-- Tombol Tambah Tiket Baru -->
                        <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-2 md:mb-0">
                            + Buat Tiket Baru
                        </a>

                        <!-- Form Pencarian -->
                        <form action="{{ route('tickets.index') }}" method="GET" class="flex items-center">
                            <input type="text" name="search" placeholder="Cari berdasarkan judul..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" value="{{ request('search') }}">
                            <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Cari
                            </button>
                        </form>
                    </div>

                    {{-- TOMBOL FILTER HANYA UNTUK ADMIN --}}
                    @if(Auth::user()->is_admin)
                    <div class="flex items-center space-x-2 border-t border-b py-2 mb-4">
                        <span class="text-sm font-medium text-gray-600">Filter Cepat:</span>
                        <a href="{{ route('tickets.index') }}" class="px-3 py-1 text-sm rounded-full {{ !request('filter') ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">Semua Tiket</a>
                        <a href="{{ route('tickets.index', ['filter' => 'mine']) }}" class="px-3 py-1 text-sm rounded-full {{ request('filter') == 'mine' ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">Tiket Saya</a>
                        <a href="{{ route('tickets.index', ['filter' => 'unassigned']) }}" class="px-3 py-1 text-sm rounded-full {{ request('filter') == 'unassigned' ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">Belum Ditugaskan</a>
                    </div>
                    @endif
                    
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    @if(Auth::user()->is_admin)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Prioritas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ditugaskan Kepada</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($tickets as $ticket)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ Str::limit($ticket->title, 25) }}</td>
                                        @if(Auth::user()->is_admin)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->user->name }}</td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->category->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($ticket->status == 'Open') bg-green-100 text-green-800 @endif
                                                @if($ticket->status == 'In Progress') bg-orange-100 text-orange-800 @endif
                                                @if($ticket->status == 'Closed') bg-gray-200 text-gray-800 @endif
                                            ">{{ $ticket->status }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($ticket->priority == 'High') bg-red-100 text-red-800 @endif
                                                @if($ticket->priority == 'Medium') bg-yellow-100 text-yellow-800 @endif
                                                @if($ticket->priority == 'Low') bg-blue-100 text-blue-800 @endif
                                            ">{{ $ticket->priority }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->assignedTo->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->is_admin ? '8' : '7' }}" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Tidak ada tiket yang cocok dengan pencarian atau filter Anda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $tickets->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
