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
        </div>

        {{-- DAFTAR BUKTI --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold mb-4">Daftar Bukti</h3>

            @forelse ($pelaksanaans as $pelaksanaan)
                <div class="border rounded p-4 mb-4">

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
                                Rp {{ number_format($pelaksanaan->nominal ?? 0, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="col-span-2">
                            <span class="text-gray-500">Keterangan</span>
                            <div class="font-semibold">
                                {{ $pelaksanaan->keterangan ?? '-' }}
                            </div>
                        </div>

                        <div class="col-span-2">
                            <a href="{{ Storage::url($pelaksanaan->file_pdf) }}"
                               target="_blank"
                               class="text-blue-600 underline">
                                Lihat File PDF
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

        <div class="mt-4">
            <a href="{{ route('pelaksanaans.index') }}"
               class="px-4 py-2 border rounded">
                Kembali
            </a>
        </div>

    </div>
</div>
