<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Tiket #{{ $ticket->id }} - {{ $ticket->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('success'))
                    <div class="p-4 sm:p-6 bg-green-100 border-b border-green-200 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="p-6 text-gray-900 grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="md:col-span-2">
                        <h3 class="text-lg font-bold border-b pb-2 mb-4">Deskripsi Masalah</h3>
                        <div class="prose max-w-none text-gray-800">
                            {!! nl2br(e($ticket->description)) !!}
                        </div>

                        @if($ticket->attachment)
                            <div class="mt-6">
                                <h4 class="font-bold mb-2">Lampiran:</h4>
                                <a href="{{ Storage::url($ticket->attachment) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    Lihat Lampiran
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="md:col-span-1 space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h3 class="text-lg font-bold border-b pb-2 mb-4">Informasi Tiket</h3>
                            <div class="space-y-3">
                                <p><strong>Dibuat Oleh:</strong> {{ $ticket->user->name }}</p>
                                <p><strong>Kategori:</strong> {{ $ticket->category->name ?? 'N/A' }}</p>
                                <p><strong>Tanggal Dibuat:</strong> {{ $ticket->created_at->format('d M Y, H:i') }}</p>
                                <p><strong>Prioritas:</strong> 
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($ticket->priority == 'High') bg-red-100 text-red-800 @endif
                                        @if($ticket->priority == 'Medium') bg-yellow-100 text-yellow-800 @endif
                                        @if($ticket->priority == 'Low') bg-blue-100 text-blue-800 @endif
                                    ">{{ $ticket->priority }}</span>
                                </p>
                                <p><strong>Status:</strong> 
                                     <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($ticket->status == 'Open') bg-green-100 text-green-800 @endif
                                        @if($ticket->status == 'In Progress') bg-orange-100 text-orange-800 @endif
                                        @if($ticket->status == 'Closed') bg-gray-200 text-gray-800 @endif
                                    ">{{ $ticket->status }}</span>
                                </p>
                                <p><strong>Ditugaskan Kepada:</strong> 
                                    <span class="font-semibold">
                                        {{ $ticket->assignedTo->name ?? 'Belum Ditugaskan' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        @if(Auth::user()->is_admin)
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h3 class="text-lg font-bold border-b pb-2 mb-4">Aksi Admin</h3>
                            <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST">
                                @csrf
                                <div>
                                    <label for="status" class="block font-medium text-sm text-gray-700">Ubah Status Tiket</label>
                                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="Open" @if($ticket->status == 'Open') selected @endif>Open</option>
                                        <option value="In Progress" @if($ticket->status == 'In Progress') selected @endif>In Progress</option>
                                        <option value="Closed" @if($ticket->status == 'Closed') selected @endif>Closed</option>
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-primary-button>Update Status</x-primary-button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h3 class="text-lg font-bold border-b pb-2 mb-4">Tugaskan Tiket</h3>
                            <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST">
                                @csrf
                                <div>
                                    <label for="admin_id" class="block font-medium text-sm text-gray-700">Pilih Admin</label>
                                    <select name="admin_id" id="admin_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">-- Pilih Admin --</option>
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->id }}" @if($ticket->assigned_to == $admin->id) selected @endif>
                                                {{ $admin->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-primary-button>Tugaskan</x-primary-button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="border-t mx-6 my-6"></div>

                <div class="px-6 pb-6">
                    <h3 class="text-lg font-bold mb-4">Balasan / Komentar</h3>
                    <div class="space-y-4">
                        @forelse($ticket->replies as $reply)
                            <div class="p-4 rounded-lg border 
                                {{ $reply->user->is_admin ? 'bg-blue-50 border-blue-200' : 'bg-gray-50' }}">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="font-semibold">{{ $reply->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="prose prose-sm max-w-none text-gray-800">
                                    {!! nl2br(e($reply->body)) !!}
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 py-4">Belum ada balasan.</div>
                        @endforelse

                        <div class="border-t pt-4 mt-6">
                            <form action="{{ route('replies.store', $ticket->id) }}" method="POST">
                                @csrf
                                <h4 class="font-semibold mb-2">Tinggalkan Balasan</h4>
                                <textarea name="body" id="body" rows="4" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ketik balasan Anda di sini..."></textarea>
                                <x-input-error :messages="$errors->get('body')" class="mt-2" />
                                <div class="mt-4">
                                    <x-primary-button>Kirim Balasan</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
