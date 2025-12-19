

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Dokumen Perencanaan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 max-w-lg">
                <h2 class="text-xl mb-4">{{ $dokumenperencanaan_id ? 'Edit Dokumen' : 'Tambah Dokumen' }}</h2>                

                @if (session('success'))
                    <div class="mb-4 text-green-700">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 text-red-700">{{ session('error') }}</div>
                @endif

                <form wire:submit.prevent="submit" autocomplete="off">
                    <div class="mb-3">
                        <label class="block mb-1">Nama *</label>
                        <input type="text" wire:model.defer="nama" class="border rounded px-3 py-2 w-full" placeholder="Isi Nama Dokumen" autofocus>
                        @error('nama') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">File *</label>
                        <input type="file" wire:model="file_pdf" accept="application/pdf" class="border rounded px-3 py-2 w-full">
                        @error('file_pdf') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    {{-- <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Simpan
                    </button> --}}

                    <div class="mb-3">
                        <label class="block mb-1">Tanggal*</label>
                        <input type="date" wire:model="tanggal" class="border rounded px-3 py-2 w-full">
                        @error('tanggal') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>


                    <div class="flex items-center space-x-2">
                        <button type="submit" class=" px-4 py-2 rounded">
                            {{ $dokumenperencanaan_id ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                        @if ($dokumenperencanaan_id)
                        <button type="button" wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded">
                            Hapus
                        </button>
                        @endif
                        <a href="{{ route('dokumen-perencanaan.index') }}" class="px-4 py-2 border rounded">Batal</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>