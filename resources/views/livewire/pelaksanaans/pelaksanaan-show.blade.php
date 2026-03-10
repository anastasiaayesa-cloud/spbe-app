<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Detail Bukti Pelaksanaan
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        {{-- INFO RENCANA --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <div class="mb-2">
                <span class="text-sm text-gray-500">Nama Kegiatan</span>
                <div class="font-semibold">
                    {{ $rencana->nama_kegiatan }}
                </div>
            </div>

            <div>
                <span class="text-sm text-gray-500">Tanggal Kegiatan</span>
                <div class="font-semibold">
                    {{ \Carbon\Carbon::parse($rencana->tanggal_kegiatan)
                        ->translatedFormat('d F Y') }}
                </div>
            </div>

            <div class="mb-2">
                <span class="text-sm text-gray-500">Lokasi Kegiatan</span>
                <div class="font-semibold">
                    {{ $rencana->lokasi_kegiatan }}
                </div>
            </div>

            @foreach ($rencana->kepegawaians as $pegawai)

    <div class="border rounded-lg p-4 mb-6 bg-gray-50">

        {{-- HEADER PEGAWAI --}}
        <div class="flex justify-between items-center mb-3">
            <h4 class="font-semibold text-md">
                {{ $pegawai->nama }}
            </h4>
            <span class="text-sm text-gray-500">
                NIP: {{ $pegawai->nip }}
            </span>
        </div>

        {{-- BUKTI PELAKSANAAN --}}
@forelse (
    $rencana->pelaksanaans->where('kepegawaian_id', $pegawai->id)
    as $pelaksanaan
)
            <div class="border rounded p-4 mb-3 bg-white">
                <div class="grid grid-cols-2 gap-4 text-sm">

                    <div>
                        <span class="text-gray-500">Jenis Bukti</span>
                        <div class="font-semibold">
                            {{ $pelaksanaan->pelaksanaanJenis->nama }}
                        </div>
                    </div>

                    <div>
                        <span class="text-gray-500">Nominal</span>
                        <div class="font-semibold text-green-600">
                            Rp {{ number_format($pelaksanaan->nominal, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="col-span-2">
                        <span class="text-gray-500">Keterangan</span>
                        <div>{{ $pelaksanaan->keterangan ?? '-' }}</div>
                    </div>

                    <div class="col-span-2">
                        <a href="{{ Storage::url($pelaksanaan->file_pdf) }}"
                           target="_blank"
                           class="text-blue-600 underline">
                            Lihat Bukti
                        </a>
                    </div>

                </div>
            </div>

        @empty
            <div class="text-gray-500 italic">
                Belum ada bukti pelaksanaan.
            </div>
        @endforelse

    </div>

@endforeach




        </div>

        

        <div class="mt-4">
            <a href="{{ route('pelaksanaans.index') }}"
               class="px-4 py-2 border rounded">
                Kembali
            </a>
        </div>

    </div>
</div>
