<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Keuangan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                {{-- Search --}}
                <div class="flex justify-end mb-4">
                    <input
                        type="text"
                        wire:model.debounce.500ms="search"
                        placeholder="Cari kegiatan / lokasi / tanggal..."
                        class="border rounded px-3 py-2 w-72"
                    >
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border">
                        <thead class="bg-gray-100 text-sm">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border text-left">Kegiatan</th>
                                <th class="px-4 py-2 border text-left">Tempat</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="text-sm">
                            @php $no = $pelaksanaans->firstItem(); @endphp

                            @forelse ($pelaksanaans as $pelaksanaan)
                                <tr>
                                    <td class="px-4 py-2 border text-center">
                                        {{ $no++ }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ $pelaksanaan->rencana->nama_kegiatan ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ $pelaksanaan->rencana->lokasi_kegiatan ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2 border text-center">
                                        {{ optional($pelaksanaan->rencana?->tanggal_kegiatan)
                                            ? \Carbon\Carbon::parse($pelaksanaan->rencana->tanggal_kegiatan)->format('d M Y')
                                            : '-' }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-2 border text-center">
                                        @if ($pelaksanaan->keuangans->count())
                                            <span class="px-3 py-1 bg-green-600 text-white rounded text-xs font-semibold">
                                                Sudah Diajukan
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-400 text-white rounded text-xs font-semibold">
                                                Belum Diajukan
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-4 py-2 border text-center">
                                        @if ($pelaksanaan->keuangans->count())
                                            <a
                                                href="{{ route('keuangans.show', $pelaksanaan->keuangans->first()->id) }}"
                                                class="text-blue-600 hover:underline"
                                            >
                                                Lihat Keuangan
                                            </a>
                                        @else
                                            <a
                                                href="{{ route('keuangans.create', ['pelaksanaan' => $pelaksanaan->id]) }}"
                                                class="inline-block px-3 py-1 bg-blue-600 text-white rounded text-xs"
                                            >
                                                Ajukan Keuangan
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-400 py-6">
                                        Data pelaksanaan belum tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $pelaksanaans->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
