<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Rencana Kegiatan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 max-w-lg">
                <h2 class="text-xl mb-4">{{ $rencana_id ? 'Edit Rencana Kegiatan' : 'Tambah Rencana Kegiatan' }}</h2>                

                @if (session('success'))
                    <div class="mb-4 text-green-700">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 text-red-700">{{ session('error') }}</div>
                @endif

                <form wire:submit.prevent="submit" autocomplete="off">
                    <div class="mb-3">
                        <label class="block mb-1">Nama Kegiatan *</label>
                        <input type="text" wire:model.defer="nama_kegiatan" class="border rounded px-3 py-2 w-full" placeholder="Isi Kegiatan" autofocus>
                        @error('nama_kegiatan') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Tanggal Kegiatan</label>
                        <input type="date" wire:model.defer="tanggal_kegiatan" class="border rounded px-3 py-2 w-full">
                        @error('tanggal_kegiatan') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4 relative" x-data="{ open: @entangle('showPegawaiDropdown') }">
                        <label class="font-semibold">Penerima Surat (Pegawai)</label>

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

                    <div class="flex items-center space-x-2">
                        <button type="submit" class=" px-4 py-2 rounded">
                            {{ $rencana_id ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                        <a href="{{ route('rencanas.index') }}" class="px-4 py-2 border rounded">Batal</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>