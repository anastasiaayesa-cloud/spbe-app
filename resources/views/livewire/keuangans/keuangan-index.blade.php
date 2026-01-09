<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Keuangan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                {{-- Header action --}}
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('keuangans.create') }}"
                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded">
                        Tambah Keuangan
                    </a>

                    {{-- Search --}}
                    <input
                        type="text"
                        wire:model.debounce.500ms="search"
                        placeholder="Cari No SPPD / Pegawai / Pelaksanaan..."
                        class="border rounded px-3 py-2 w-64"
                    >
                </div>

                {{-- Flash message --}}
                @if (session('success'))
                    <div class="mb-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">No SPPD</th>
                                <th class="px-4 py-2 border">Tanggal SPPD</th>
                                <th class="px-4 py-2 border">Pegawai</th>
                                <th class="px-4 py-2 border">Pelaksanaan</th>
                                <th class="px-4 py-2 border">Dibuat</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($keuangans as $index => $item)
                                <tr>
                                    <td class="px-4 py-2 border">
                                        {{ $keuangans->firstItem() + $index }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ $item->no_sppd }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ \Carbon\Carbon::parse($item->tanggal_sppd)->format('d-m-Y') }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ $item->kepegawaian->nama ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ $item->pelaksanaan->nama_kegiatan ?? '-' }} <br>
                                        <span class="text-sm text-gray-500">
                                            {{ $item->pelaksanaan->lokasi_kegiatan ?? '' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ $item->created_at->format('d-m-Y H:i') }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        <button
                                            wire:click="cetakPdf({{ $item->id }})"
                                            class="text-blue-600 hover:underline">
                                            Cetak PDF
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-2 border text-center text-gray-500">
                                        Data keuangan belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $keuangans->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
