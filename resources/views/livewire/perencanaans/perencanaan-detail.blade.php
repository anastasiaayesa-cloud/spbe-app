<div class="p-6 bg-white rounded-lg shadow"> <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700">Dokumen Perencanaan</label>
                <select wire:model="dokumen_perencanaan_id" class="border rounded px-3 py-2 w-full">
                    <option value="">-- Pilih Dokumen --</option>
                    @foreach ($dokumenperencanaanList as $dokumenperencanaan)
                        <option value="{{ $dokumenperencanaan->id }}">{{ $dokumenperencanaan->nama }}</option>
                    @endforeach
                </select>
            </div>

            <input type="text" wire:model="kode" class="w-full border rounded p-2" placeholder="Kode">
            <input type="text" wire:model="nama" class="w-full border rounded p-2 mt-2" placeholder="Nama Komponen">
            <input type="text" wire:model="volume" class="w-full border rounded p-2 mt-2" placeholder="Volume">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-xs uppercase font-bold">
                        <th class="border p-2 text-left">Uraian Rincian</th>
                        <th class="border p-2 w-20">Vol</th>
                        <th class="border p-2 w-24">Satuan</th>
                        <th class="border p-2 w-32">Harga</th>
                        <th class="border p-2 w-32">Subtotal</th>
                        <th class="border p-2 w-10">#</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($details as $index => $detail)
                        <tr wire:key="detail-{{ $index }}">
                            <td class="border p-1">
                                <input type="text" wire:model="details.{{$index}}.uraian_rincian" class="w-full p-1 border-none outline-none">
                            </td>
                            <td class="border p-1">
                                <input type="number" wire:model.live="details.{{$index}}.volume" class="w-full p-1 text-center border-none outline-none">
                            </td>
                            <td class="border p-1">
                                <input type="text" wire:model="details.{{$index}}.volume_satuan" class="w-full p-1 text-center border-none outline-none">
                            </td>
                            <td class="border p-1">
                                <input type="number" wire:model.live="details.{{$index}}.harga_satuan" class="w-full p-1 text-right border-none outline-none">
                            </td>
                            <td class="border p-1 text-right bg-gray-50 text-sm">
                                {{ number_format($details[$index]['subtotal_biaya'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="border p-1 text-center">
                                <button type="button" wire:click="removeDetail({{ $index }})" class="text-red-500 font-bold">&times;</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500 italic">Tidak ada rincian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 flex justify-between items-center">

    <button type="button" wire:click="addDetail"
        class="bg-green-500 text-white px-4 py-2 rounded text-sm">
        + Tambah Baris Rincian
    </button>

    <div class="flex gap-2">
        <button type="button" wire:click="save"
            class="bg-blue-600 text-white px-6 py-2 rounded font-bold">
            Simpan Perencanaan
        </button>

        <button type="button"
            onclick="window.location='{{ route('perencanaans.index') }}'"
            class="bg-gray-500 text-white px-4 py-2 rounded">
            Batal
        </button>
    </div>

</div>
</div>