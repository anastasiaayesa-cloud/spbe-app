<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Perencanaans') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 max-w-lg">
                <h2 class="text-xl mb-4">{{ $perencanaan_id ? 'Edit Perencanaan' : 'Tambah Perencanaan' }}</h2>                

                @if (session('success'))
                    <div class="mb-4 text-green-700">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 text-red-700">{{ session('error') }}</div>
                @endif

                <form wire:submit.prevent="submit" autocomplete="off">
                    <div class="mb-3">
                        <label class="block mb-1">Dokumen *</label>
                        <select wire:model="dokumen_perencanaan_id" class="border rounded px-3 py-2 w-full">
                            <option value="">-- Pilih Dokumen--</option>
                            @foreach ($dokumenperencanaanList as $dokumenperencanaan)
                                <option value="{{ $dokumenperencanaan->id }}">{{ $dokumenperencanaan->nama }}</option>
                            @endforeach
                        </select>
                        @error('dokumenperencanan_id') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Kode *</label>
                        <input type="text" wire:model.defer="kode" class="border rounded px-3 py-2 w-full">
                        @error('kode') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Nama *</label>
                        <input type="text" wire:model.defer="nama" class="border rounded px-3 py-2 w-full">
                        @error('nama') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Volume *</label>
                        <input type="text" wire:model.defer="volume" class="border rounded px-3 py-2 w-full">
                        @error('volume') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Jumlah Biaya (Rp) *</label>
                        <input 
                            type="integer" 
                            wire:model.defer="jumlah_biaya" 
                            class="border rounded px-3 py-2 w-full"
                            placeholder="Contoh: 50000"
                        >
                        @error('jumlah_biaya') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center space-x-2">
                        <button type="submit" class=" px-4 py-2 rounded">
                            {{ $perencanaan_id ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                        <a href="{{ route('perencanaans.index') }}" class="px-4 py-2 border rounded">Batal</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>