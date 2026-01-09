<div>
    <h2 class="text-xl font-semibold mb-4">
        Form Keuangan Perjalanan Dinas
    </h2>

    <form wire:submit.prevent="submit" class="space-y-4">

        {{-- NO SPPD --}}
        <div>
            <label class="block font-medium">Nomor SPPD</label>
            <input
                type="text"
                wire:model.defer="no_sppd"
                class="w-full border rounded px-3 py-2"
                placeholder="Masukkan Nomor SPPD"
            >
            @error('no_sppd')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- PILIH PELAKSANAAN --}}
        <div>
            <label class="block font-medium">Pelaksanaan / Kegiatan</label>
            <select
                wire:model="pelaksanaan_id"
                class="w-full border rounded px-3 py-2"
            >
                <option value="">-- Pilih Pelaksanaan --</option>

                @foreach ($pelaksanaanList as $pelaksanaan)
                    <option value="{{ $pelaksanaan->id }}">
                        {{ $pelaksanaan->perencanaanNama ?? 'Pelaksanaan #' . $pelaksanaan->id }}
                    </option>
                @endforeach
            </select>

            @error('pelaksanaan_id')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- TANGGAL SPPD (AUTO DARI PELAKSANAAN) --}}
        <div>
            <label class="block font-medium">Tanggal SPPD</label>
            <input
                type="date"
                wire:model="tanggal_sppd"
                class="w-full border rounded px-3 py-2 bg-gray-100"
                readonly
            >
            @error('tanggal_sppd')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- ACTION --}}
        <div class="flex gap-2 pt-4">
            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                Simpan
            </button>

            <a
                href="{{ route('keuangans.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
            >
                Batal
            </a>
        </div>

    </form>
</div>
