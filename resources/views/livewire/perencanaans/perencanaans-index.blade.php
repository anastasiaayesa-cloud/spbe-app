<div class="livewire-wrapper">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Perencanaan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-200 rounded">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-200 rounded">{{ session('error') }}</div>
                    @endif

                    <div class="flex items-center justify-between mb-4">
                        {{-- Tombol tambah perencaan (opsional) --}}
                        <div class="flex items-center space-x-2">
                            <a href="/perencanaans/create" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Perencanaan</a>

                            <div class="flex items-center border p-1 rounded bg-gray-50">
                                <input type="file" wire:model="file_excel" class="text-sm text-gray-500">
                                <button wire:click="importExcel" wire:loading.attr="disabled" class="bg-green-600 text-white px-4 py-2 rounded">
                                    <span wire:loading.remove>Upload Excel</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                            </div>
                        </div>

                        {{-- Search bar (disesuaikan untuk Livewire) --}}
                        <div>
                            <input type="text" wire:model.live="search"
                                placeholder="Cari perencanaan..."
                                class="border rounded px-3 py-2 w-64 focus:ring focus:ring-blue-200">
                        </div>
                    </div>

                    {{-- Tabel Detail Data Asli (Dipindahkan ke Bawah Visualisasi) --}}
                    <h3 class="font-semibold text-lg mt-8 mb-4 text-gray-800">Tabel Detail Data</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border">#</th>
                                    <th class="px-4 py-2 border">Dokumen</th>
                                    <th class="px-4 py-2 border">Kode</th>
                                    <th class="px-4 py-2 border">Nama</th>
                                    <th class="px-4 py-2 border">Volume</th>
                                    <th class="px-4 py-2 border">Jumlah Biaya</th>
                                    <th class="px-4 py-2 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($perencanaans as $perencanaan)
                                    {{-- Baris Utama --}}
                                    <tr class="{{ in_array($perencanaan->id, $openedRows) ? 'bg-blue-50' : '' }}">
                                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 border italic text-gray-500 text-sm">{{ $perencanaan->dokumen_perencanaan_id }}</td>
                                        <td class="px-4 py-2 border font-medium">{{ $perencanaan->kode }}</td>
                                        <td class="px-4 py-2 border">{{ $perencanaan->nama }}</td>
                                        <td class="px-4 py-2 border italic text-gray-500 text-sm">{{ $perencanaan->volume }}</td>
                                        <td class="px-4 py-2 border text-right font-bold">
                                            {{ number_format($perencanaan->jumlah_biaya, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 border text-center">
                                            <div class="flex gap-2 justify-center">
                                                <button wire:click="toggleRow({{ $perencanaan->id }})" class="bg-gray-200 px-2 py-1 rounded text-xs font-bold uppercase">
                                                    DETAIL
                                                </button>

                                                <a href="{{ route('perencanaans.edit', $perencanaan->id) }}" 
                                                    class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold uppercase hover:bg-blue-700 transition">
                                                    EDIT
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Baris Expandable (Hanya muncul jika di-toggle) --}}
                                    @if (in_array($perencanaan->id, $openedRows))
                                    <tr>
                                        <td colspan="6" class="p-4 bg-gray-50 border-b shadow-inner">
                                            <div class="bg-white rounded border overflow-hidden">
                                                <table class="min-w-full text-sm">
                                                    <thead class="bg-gray-100 text-gray-700">
                                                        <tr>
                                                            <th class="px-4 py-2 border-b text-left">Uraian Rincian</th>
                                                            <th class="px-4 py-2 border-b text-center">Vol</th>
                                                            <th class="px-4 py-2 border-b text-center">Satuan</th>
                                                            <th class="px-4 py-2 border-b text-right">Harga Satuan</th>
                                                            <th class="px-4 py-2 border-b text-right">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($perencanaan->details as $detail)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-4 py-2 border-b">{{ $detail->uraian_rincian }}</td>
                                                            <td class="px-4 py-2 border-b text-center">{{ $detail->volume }}</td>
                                                            <td class="px-4 py-2 border-b text-center">{{ $detail->volume_satuan }}</td>
                                                            <td class="px-4 py-2 border-b text-right">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                                            <td class="px-4 py-2 border-b text-right font-semibold">{{ number_format($detail->subtotal_biaya, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="px-4 py-4 text-center text-gray-400 italic">Belum ada rincian belanja untuk kegiatan ini.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 border text-center text-gray-500">
                                            Tidak ada Perencanaans.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $perencanaans->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>