<div class="max-w-4xl mx-auto py-6 space-y-6">

    {{-- HEADER --}}
    <h2 class="text-2xl font-semibold">
        Pengajuan Keuangan Perjalanan Dinas
    </h2>

    {{-- INFO KEGIATAN --}}
    @if ($pelaksanaan)
        <div class="bg-gray-50 border rounded-lg p-6 grid grid-cols-2 gap-6 text-sm">

            <div>
                <div class="text-gray-500">Nama Kegiatan</div>
                <div class="font-semibold">
                    {{ $pelaksanaan->rencana->nama_kegiatan }}
                </div>
            </div>

            <div>
                <div class="text-gray-500">Tanggal Kegiatan</div>
                <div class="font-semibold">
                    {{ \Carbon\Carbon::parse(
                        $pelaksanaan->rencana->tanggal_kegiatan
                    )->translatedFormat('d F Y') }}
                </div>
            </div>

            <div>
                <div class="text-gray-500">Nominal Pengeluaran</div>
                <div class="font-semibold text-green-700">
                    Rp {{ number_format($pelaksanaan->nominal, 0, ',', '.') }}
                </div>
            </div>

            <div>
                <div class="text-gray-500">Tanggal Upload Bukti</div>
                <div class="font-semibold">
                    {{ \Carbon\Carbon::parse(
                        $pelaksanaan->tanggal_upload
                    )->translatedFormat('d F Y') }}
                </div>
            </div>

            <div class="col-span-2">
                <div class="text-gray-500 mb-1">Bukti Pengeluaran</div>
                <a href="{{ asset('storage/' . $pelaksanaan->file_pdf) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 text-blue-600 hover:underline">
                    📄 Lihat Bukti Pengeluaran
                </a>
            </div>

        </div>
    @endif

    {{-- ACTION SUBMIT --}}
    <form wire:submit.prevent="submit"
          class="bg-white border rounded-lg p-6 flex justify-end">

        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Ajukan Keuangan
        </button>
    </form>

    {{-- ACTION --}}
    <div class="flex justify-end gap-3">
        <a href="{{ route('keuangans.index') }}"
           class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
            Kembali
        </a>
    </div>

</div>
