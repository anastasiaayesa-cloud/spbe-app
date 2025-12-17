

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
                    <div class="mb-4 relative" x-data="{ open: @entangle('showPegawaiDropdown') }">
                        <label class="font-semibold">Penerima Surat</label>

                        {{-- Selected --}}
                        <div class="flex flex-wrap gap-2 mb-2">
                            @foreach($this->pegawaiSelectedData as $pegawai)
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm flex items-center gap-2">
                                    {{ $pegawai->nama }}
                                    <button type="button"
                                            wire:click="removePegawai({{ $pegawai->id }})"
                                            class="text-red-600 font-bold">×</button>
                                </span>
                            @endforeach
                        </div>

                        {{-- Input --}}
                        <input type="text"
                            wire:model.live="pegawaiSearch"
                            wire:focus="showAllPegawai"
                            @click.away="$wire.closeDropdown()"
                            class="w-full border rounded px-3 py-2"
                            placeholder="Ketik nama penerima surat">

                        {{-- Dropdown --}}
                        @if($showPegawaiDropdown && count($pegawaiResults))
                            <div class="absolute z-10 w-full border rounded mt-1 bg-white max-h-56 overflow-y-auto shadow">
                                @foreach($pegawaiResults as $pegawai)
                                    <div class="px-3 py-2 hover:bg-gray-100 cursor-pointer"
                                        wire:click="addPegawai({{ $pegawai['id'] }})">
                                        {{ $pegawai['nama'] }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Nama File *</label>
                        <input type="text" wire:model.defer="nama_surat" class="border rounded px-3 py-2 w-full" placeholder="Isi Nama Surat" autofocus>
                        @error('nama_surat') <span class="text-red-600">{{ $message }}</span> @enderror
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
    <label class="block mb-1">File PDF *</label>
    <input type="file" wire:model="file_pdf" accept="application/pdf" class="border rounded px-3 py-2 w-full">
    @error('file_pdf') <span class="text-red-600">{{ $message }}</span> @enderror
</div>

{{-- <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded">
    Simpan
</button> --}}

                    <div class="mb-3">
                        <label class="block mb-1">Tanggal Upload *</label>
                        <input type="date" wire:model="tanggal_upload" class="border rounded px-3 py-2 w-full">
                        @error('tanggal_upload') <span class="text-red-600">{{ $message }}</span> @enderror
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