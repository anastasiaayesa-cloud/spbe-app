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
    @php $no = $rencanas->firstItem(); @endphp

    @forelse ($rencanas as $rencana)
        @php
    $totalPegawai = $rencana->pelaksanaans->count();

    $pegawaiSudahAjukan = $rencana->pelaksanaans
        ->filter(fn ($p) => $p->keuangans->isNotEmpty())
        ->count();
@endphp

        <tr>
            <td class="px-4 py-2 border text-center">
                {{ $no++ }}
            </td>

            <td class="px-4 py-2 border">
                {{ $rencana->nama_kegiatan ?? '-' }}
            </td>

            <td class="px-4 py-2 border">
                {{ $rencana->lokasi_kegiatan ?? '-' }}
            </td>

            <td class="px-4 py-2 border text-center">
                {{ $rencana->tanggal_kegiatan
                    ? \Carbon\Carbon::parse($rencana->tanggal_kegiatan)->format('d M Y')
                    : '-' }}
            </td>

            @php
    $pelaksanaanPegawai = $rencana->pelaksanaans
        ->where('kepegawaian_id', auth()->user()->pegawai_id)
        ->first();

    $keuangan = $rencana->pelaksanaans
        ->flatMap(fn ($p) => $p->keuangans)
        ->first();
@endphp

            {{-- STATUS --}}
            <td class="px-4 py-2 border text-center">
    @if (!$keuangan)
        <span class="px-3 py-1 bg-gray-400 text-white rounded text-xs font-semibold">
            Belum Diajukan
        </span>
    @elseif ($keuangan->status === 'lunas')
        <span class="px-3 py-1 bg-green-600 text-white rounded text-xs font-semibold">
            Lunas
        </span>
    @else
        <span class="px-3 py-1 bg-red-600 text-white rounded text-xs font-semibold">
            Belum Lunas
        </span>
    @endif
</td>

           

            {{-- AKSI --}}
           <td class="px-4 py-2 border text-center space-x-2">

    {{-- AJUKAN (hanya kalau pegawai ini belum ajukan) --}}
    @if ($pelaksanaanPegawai && $pelaksanaanPegawai->keuangans->isEmpty())
        <a
            href="{{ route('keuangans.create', ['pelaksanaan' => $pelaksanaanPegawai->id]) }}"
            class="inline-block px-3 py-1 bg-blue-600 text-white rounded text-xs"
        >
            Ajukan
        </a>
    @endif

    {{-- LIHAT (kalau sudah ada keuangan di rencana ini) --}}
    @if ($keuangan)
        <a
            href="{{ route('keuangans.show', $keuangan->id) }}"
            class="text-blue-600 hover:underline text-xs"
        >
            Lihat
        </a>
    @endif

</td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-gray-400 py-6">
                Data rencana belum tersedia
            </td>
        </tr>
    @endforelse
</tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $rencanas->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
