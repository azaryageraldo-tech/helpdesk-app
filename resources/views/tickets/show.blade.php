<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Tiket #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-8 bg-white">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Kolom Kiri: Detail Masalah & Lampiran -->
                        <div class="md:col-span-2">
                            <div class="border-b pb-4 mb-4">
                                <h3 class="text-lg font-medium text-gray-500">Judul Masalah</h3>
                                <p class="text-xl font-semibold text-gray-800 mt-1">{{ $ticket->title }}</p>
                            </div>
                            
                            <h3 class="text-lg font-medium text-gray-500">Deskripsi Lengkap</h3>
                            <div class="prose max-w-none text-gray-800 mt-2">
                                {!! nl2br(e($ticket->description)) !!}
                            </div>

                            @if($ticket->attachment)
                                <div class="mt-6">
                                    <h4 class="font-medium text-gray-500 mb-2">Lampiran:</h4>
                                    <a href="{{ Storage::url($ticket->attachment) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-100 border border-transparent rounded-md font-semibold text-xs text-blue-700 uppercase tracking-widest hover:bg-blue-200">
                                        Lihat Lampiran
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Kolom Kanan: Info & Aksi Tiket -->
                        <div class="md:col-span-1 space-y-6">
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Informasi Tiket</h3>
                                <div class="space-y-4 text-sm">
                                    <p><strong>Dibuat Oleh:</strong><br>{{ $ticket->user->name }}</p>
                                    <p><strong>Kategori:</strong><br>{{ $ticket->category->name ?? 'N/A' }}</p>
                                    <p><strong>Tanggal Dibuat:</strong><br>{{ $ticket->created_at->format('d M Y, H:i') }}</p>
                                    <p><strong>Prioritas:</strong><br>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($ticket->priority == 'High') bg-red-100 text-red-800 @endif
                                            @if($ticket->priority == 'Medium') bg-yellow-100 text-yellow-800 @endif
                                            @if($ticket->priority == 'Low') bg-blue-100 text-blue-800 @endif
                                        ">{{ $ticket->priority }}</span>
                                    </p>
                                    <p><strong>Status:</strong><br>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($ticket->status == 'Open') bg-green-100 text-green-800 @endif
                                            @if($ticket->status == 'In Progress') bg-orange-100 text-orange-800 @endif
                                            @if($ticket->status == 'Closed') bg-gray-200 text-gray-800 @endif
                                        ">{{ $ticket->status }}</span>
                                    </p>
                                    <p><strong>Ditugaskan Kepada:</strong><br> 
                                        <span class="font-semibold">{{ $ticket->assignedTo->name ?? 'Belum Ditugaskan' }}</span>
                                    </p>
                                </div>
                            </div>

                            @if(Auth::user()->is_admin)
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Aksi Admin</h3>
                                <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="status" class="block font-medium text-sm text-gray-700">Ubah Status Tiket</label>
                                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="Open" @if($ticket->status == 'Open') selected @endif>Open</option>
                                            <option value="In Progress" @if($ticket->status == 'In Progress') selected @endif>In Progress</option>
                                            <option value="Closed" @if($ticket->status == 'Closed') selected @endif>Closed</option>
                                        </select>
                                    </div>
                                    <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST">
                                        @csrf
                                        <div>
                                            <label for="admin_id" class="block font-medium text-sm text-gray-700">Tugaskan Kepada</label>
                                            <select name="admin_id" id="admin_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                <option value="">-- Pilih Admin --</option>
                                                @foreach($admins as $admin)
                                                    <option value="{{ $admin->id }}" @if($ticket->assigned_to == $admin->id) selected @endif>{{ $admin->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-4">
                                            <x-primary-button>Simpan Perubahan</x-primary-button>
                                        </div>
                                    </form>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                
                    <div class="border-t mt-6 pt-6">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Utas Percakapan</h3>
                        <div class="space-y-4">
                            @forelse($ticket->replies as $reply)
                                <div class="p-4 rounded-lg 
                                    {{ $reply->user->is_admin ? 'bg-blue-50 border border-blue-200' : 'bg-gray-50 border' }}">
                                    <div class="flex justify-between items-center mb-2">
                                        <p class="font-semibold text-gray-800">{{ $reply->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="prose prose-sm max-w-none text-gray-700">
                                        {!! nl2br(e($reply->body)) !!}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 py-4">Belum ada balasan. Jadilah yang pertama!</div>
                            @endforelse

                            <div class="border-t pt-4 mt-6">
                                <form action="{{ route('replies.store', $ticket->id) }}" method="POST">
                                    @csrf
                                    <h4 class="font-semibold mb-2 text-gray-700">Tinggalkan Balasan</h4>
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
    </div>
</x-app-layout>
