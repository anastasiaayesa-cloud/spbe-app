

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Persuratan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 max-w-lg">
                <h2 class="text-xl mb-4">{{ $persuratan_id ? 'Edit Surat' : 'Tambah Surat' }}</h2>                

                @if (session('success'))
                    <div class="mb-4 text-green-700">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 text-red-700">{{ session('error') }}</div>
                @endif

                <form wire:submit.prevent="submit" autocomplete="off">
                    <div class="mb-3">
                        <label class="block mb-1">Nama File *</label>
                        <input type="text" wire:model.defer="nama_surat" class="border rounded px-3 py-2 w-full" placeholder="Isi Nama File
                        " autofocus>
                        @error('nama_surat') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Penerima Surat</label>
                        
                        <div class="flex flex-wrap gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                            @php
                                // Memecah string nama yang digabung di mount menjadi array
                                $daftarPenerima = explode(', ', $penerima_surat);
                            @endphp

                            @forelse($daftarPenerima as $nama)
                                @if($nama)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        {{ $nama }}
                                    </span>
                                @endif
                            @empty
                                <span class="text-gray-400 italic text-sm">Tidak ada pegawai yang diusulkan</span>
                            @endforelse
                        </div>
                        {{-- Input tersembunyi agar data tetap terkirim saat save --}}
                        <input type="hidden" wire:model="penerima_surat">
                    </div>

                     <div class="mb-3">
                        <label class="block mb-1">Kategori Surat</label>
                        <select wire:model="persuratan_kategori_id" class="border rounded px-3 py-2 w-full">
                            <option value="">-- Pilih Kategori Surat--</option>
                            @foreach ($persuratanKategoriList as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('persuratan_kategori_id') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Perihal *</label>
                        <input type="text" wire:model="perihal" class="border rounded px-3 py-2 w-full">
                        @error('perihal') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">File PDF *</label>
                        <input type="file" wire:model="file_pdf" accept="application/pdf" class="border rounded px-3 py-2 w-full">
                        @error('file_pdf') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    {{-- <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Simpan
                    </button> --}}

                    <!-- <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tanggal Upload *</label>
                        <input type="date" 
                            wire:model="tanggal_upload" {{-- Pastikan baris ini ada --}}
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" 
                            readonly>
                        <p class="text-xs text-gray-500 mt-1 italic">* Tanggal diset otomatis ke hari ini.</p>
                    </div> -->

                    <div class="mb-3">
                        <label class="block mb-1">Jenis Anggaran</label>
                        <select wire:model="jenis_anggaran" class="border rounded px-3 py-2 w-full">
                            <option value="">-- Pilih Jenis Anggaran --</option>
                            <option value="BPMP">BPMP</option>
                            <option value="Luar BPMP">Luar BPMP</option>                            
                        </select>
                        @error('jenis_anggaran') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>


                    <div class="flex items-center space-x-2">
                        <button type="submit" class=" px-4 py-2 rounded">
                            {{ $persuratan_id ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                        @if ($persuratan_id)
                        <button type="button" wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded">
                            Hapus
                        </button>
                        @endif
                        <a href="{{ route('persuratans.index') }}" class="px-4 py-2 border rounded">Batal</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>