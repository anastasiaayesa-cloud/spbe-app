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
                        <label class="block mb-1">Komponen *</label>
                        <input type="text" wire:model.defer="komponen" class="border rounded px-3 py-2 w-full" placeholder="Isi Komponen" autofocus>
                        @error('komponen') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Uraian Komponen</label>
                        <input type="text" wire:model.defer="uraian_komponen" class="border rounded px-3 py-2 w-full">
                        @error('uraian_komponen') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Sub Komponen *</label>
                        <input type="text" wire:model.defer="sub_komponen" class="border rounded px-3 py-2 w-full">
                        @error('sub_komponen') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Uraian Sub Komponen</label>
                        <input type="text" wire:model.defer="uraian_sub_komponen" class="border rounded px-3 py-2 w-full">
                        @error('uraian_sub_komponen') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="block mb-1">Nama Aktivitas *</label>
                        <input type="text" wire:model.defer="nama_aktivitas" class="border rounded px-3 py-2 w-full" autofocus>
                        @error('nama_aktivitas') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Tanggal Rencana Mulai *</label>
                        <input type="date" wire:model="rencana_mulai" class="border rounded px-3 py-2 w-full">
                        @error('rencana_mulai') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Tanggal Rencana Selesai *</label>
                        <input type="date" wire:model="rencana_selesai" class="border rounded px-3 py-2 w-full">
                        @error('rencana_selesai') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1">Keterangan</label>
                        <textarea wire:model="keterangan" class="border rounded px-2 py-1 w-full" rows="2"></textarea>
                        @error('keterangan') <span class="text-red-600">{{ $message }}</span> @enderror
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