<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Tiket Bantuan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-8 bg-white border-b border-gray-200">

                    <h3 class="text-xl font-semibold text-gray-700 mb-6">Formulir Tiket Baru</h3>

                    <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Judul Tiket -->
                        <div>
                            <x-input-label for="title" :value="__('Judul Masalah')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="Contoh: Printer tidak bisa mencetak" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Kategori -->
                        <div class="mt-4">
                            <x-input-label for="category_id" :value="__('Kategori Masalah')" />
                            <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsikan Masalah Anda Secara Rinci')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Sebutkan detail error, langkah yang sudah dicoba, dll." required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        
                        <!-- Lampiran File -->
                        <div class="mt-4">
                            <x-input-label for="attachment" :value="__('Lampiran (Opsional)')" />
                            <input id="attachment" name="attachment" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                            <p class="mt-1 text-sm text-gray-500">Tipe file: JPG, PNG, PDF. Maksimal 2MB.</p>
                            <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                        </div>
                        
                        <!-- Prioritas -->
                        <div class="mt-4">
                             <x-input-label for="priority" :value="__('Tingkat Prioritas')" />
                             <select name="priority" id="priority" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                 <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Rendah</option>
                                 <option value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'selected' : '' }}>Sedang</option>
                                 <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>Tinggi</option>
                             </select>
                             <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('tickets.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4">
                                Batal
                            </a>

                            <x-primary-button>
                                {{ __('Kirim Tiket') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
