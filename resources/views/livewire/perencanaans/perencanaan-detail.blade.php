<div class="p-6 bg-white rounded-lg shadow">
    <div class="grid grid-cols-2 gap-4 mb-6">
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="mb-3">
            <select wire:model="dokumen_perencanaan_id" class="border rounded px-3 py-2 w-full">
                <option value="">-- Pilih Dokumen--</option>
                @foreach ($dokumenperencanaanList as $dokumenperencanaan)
                    <option value="{{ $dokumenperencanaan->id }}">{{ $dokumenperencanaan->nama }}</option>
                @endforeach
            </select>
            @error('dokumenperencanan_id') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <input type="text" wire:model="kode" class="w-full border rounded p-2" placeholder="Kode">
            <input type="text" wire:model="nama" class="w-full border rounded p-2 mt-2" placeholder="Nama Komponen">
            <input type="text" wire:model="volume" class="w-full border rounded p-2 mt-2" placeholder="Volume">

        </div>
    </div>

    <table class="w-full border-collapse border border-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="border p-2 text-left">Uraian Rincian</th>
                <th class="border p-2 w-20">Volume</th>
                <th class="border p-2 w-24">Volume Satuan</th>
                <th class="border p-2 w-40">Harga Satuan</th>
                <th class="border p-2 w-40">Subtotal Biaya</th>
                <th class="border p-2 w-10">#</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $index => $detail)
            <tr>
                <td class="border p-1">
                    <input type="text" wire:model.blur="details.{{$index}}.uraian_rincian" class="w-full p-1 border-none outline-none">
                </td>
                <td class="border p-1">
                    <input type="number" wire:model.live="details.{{$index}}.volume" class="w-full p-1 text-center border-none outline-none">
                </td>
                <td class="border p-1">
                    <input type="text" wire:model.blur="details.{{$index}}.volume_satuan" class="w-full p-1 text-center border-none outline-none uppercase">
                </td>
                <td class="border p-1">
                    <input type="number" wire:model.live="details.{{$index}}.harga_satuan" class="w-full p-1 text-right border-none outline-none">
                </td>
                <td class="border p-1 text-right bg-gray-50">
                    {{ number_format($details[$index]['subtotal_biaya'], 0, ',', '.') }}
                </td>
                <td class="border p-1 text-center">
                    <button wire:click="removeDetail({{$index}})" class="text-red-500 font-bold">&times;</button>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-blue-50 font-bold">
                <td colspan="4" class="p-2 text-right border">TOTAL JUMLAH</td>
                <td class="p-2 text-right border text-blue-700">
                    Rp {{ number_format(collect($details)->sum('subtotal_biaya'), 0, ',', '.') }}
                </td>
                <td class="border"></td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-4 flex justify-between">
        <button wire:click="addDetail" class="bg-green-500 text-white px-4 py-2 rounded text-sm hover:bg-green-600">
            + Tambah Baris Rincian
        </button>
        <button wire:click="save" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700">
            Simpan Perencanaan
        </button>
        <a href="{{ route('perencanaans.index') }}" class="px-4 py-2 border rounded">Batal</a>
    </div>
</div>
