<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Detail Keuangan
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- ================= INFO KEGIATAN ================= --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">Informasi Kegiatan</h3>

            <table class="w-full text-sm">
                <tr>
                    <td class="w-48 font-semibold">Nama Kegiatan</td>
                    <td>: {{ $keuangan->pelaksanaan->rencana->nama_kegiatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Lokasi</td>
                    <td>: {{ $keuangan->pelaksanaan->rencana->lokasi_kegiatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Tanggal</td>
                    <td>:
                        {{ \Carbon\Carbon::parse(
                            $keuangan->pelaksanaan->tanggal_kegiatan
                        )->format('d M Y') }}
                    </td>
                </tr>
                <tr>
    <td class="font-semibold">Status</td>
    <td>:
    <div class="inline-flex items-center gap-2">
        @role('super-admin')
            <button
                type="button"
                wire:click="toggleStatus"
                wire:loading.attr="disabled"
                class="px-2 py-1 rounded text-xs font-semibold
                    {{ $keuangan->status === 'lunas'
                        ? 'bg-green-600 text-white'
                        : 'bg-red-600 text-white' }}"
            >
                {{ ucfirst($keuangan->status) }}
            </button>
        @else
            <span class="px-2 py-1 rounded text-xs font-semibold
                {{ $keuangan->status === 'lunas'
                    ? 'bg-green-600 text-white'
                    : 'bg-red-600 text-white' }}">
                {{ ucfirst($keuangan->status) }}
            </span>
        @endrole

        @if ($keuangan->lunas_at)
            <span class="text-xs text-gray-500">
                ({{ $keuangan->lunas_at->format('d M Y H:i') }} WIB)
            </span>
        @endif
    </div>
</td>

</tr>

            </table>
        </div>

        {{-- ================= RINCIAN KEUANGAN PER PEGAWAI ================= --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">
                Rincian Keuangan & Bukti per Pegawai
            </h3>

            @foreach ($keuangan->pelaksanaan->rencana->kepegawaians as $pegawai)

    @php
    $buktis = $buktiPengeluaran
        ->where('kepegawaian_id', $pegawai->id);
@endphp

    <div class="border rounded-lg p-4 mb-5 bg-gray-50">
        <div class="flex justify-between items-center mb-3">
    <h4 class="font-semibold text-md">
        {{ $pegawai->nama }}
    </h4>

    <div class="flex items-center gap-3">
        <span class="text-sm font-semibold">
            Total:
            Rp {{ number_format($buktis->sum('nominal'), 0, ',', '.') }}
        </span>

        @if ($buktis->isNotEmpty())
            <a
                href="{{ route('keuangan.cetak', [
                    'keuangan' => $keuangan->id,
                    'pegawai' => $pegawai->id
                ]) }}"
                target="_blank"
                class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700"
            >
                Cetak PDF
            </a>
        @endif
    </div>
</div>

        @if ($buktis->isEmpty())
            <div class="text-sm italic text-gray-500">
                Belum ada bukti pengeluaran.
            </div>
        @else
            <div class="space-y-3">
                @foreach ($buktis as $bukti)
                    <div class="grid grid-cols-3 gap-4 text-sm bg-white border rounded p-3">

                        <div>
                            <div class="text-gray-500">Uraian</div>
                            <div class="font-semibold">
                                {{ $bukti->pelaksanaanJenis->nama ?? '-' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-gray-500">Nominal</div>
                            <div class="font-semibold text-green-700">
                                Rp {{ number_format($bukti->nominal, 0, ',', '.') }}
                            </div>
                        </div>

                        <div>
                            <div class="text-gray-500">File Bukti</div>
                            @if ($bukti->file_pdf)
                                <a href="{{ Storage::url($bukti->file_pdf) }}"
                                   target="_blank"
                                   class="text-blue-600 underline">
                                    Lihat Bukti
                                </a>
                            @else
                                <span class="italic text-gray-400">
                                    Tidak ada file
                                </span>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endforeach

        </div>

        {{-- ================= TOTAL GLOBAL ================= --}}
        <div class="bg-white shadow rounded p-6">
            <div class="flex justify-between font-semibold text-lg">
                <span>Total Keseluruhan</span>
                <span>
                    Rp {{ number_format($keuangan->total_nominal, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- ================= AKSI ================= --}}
        <div class="flex justify-between">
            <a
                href="{{ route('keuangans.index') }}"
                class="px-4 py-2 bg-gray-300 rounded"
            >
                ← Kembali
            </a>
        </div>

    </div>
</div>
