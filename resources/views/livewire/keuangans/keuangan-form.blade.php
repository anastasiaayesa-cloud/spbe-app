<div class="max-w-4xl mx-auto py-6">

    {{-- HEADER --}}
    <h2 class="text-2xl font-semibold mb-6">
        Form Keuangan Perjalanan Dinas
    </h2>

    <form wire:submit.prevent="submit" class="space-y-6">

        {{-- SELECT KEGIATAN --}}
        {{-- <div class="bg-white shadow rounded-lg p-6">
            <label class="block text-sm font-medium mb-2">
                Nama Kegiatan
            </label>

            <select
                wire:model.live="pelaksanaan_id"
                class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
            >
                <option value="">-- Pilih Kegiatan --</option>
                @foreach ($pelaksanaanList as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->rencana->nama_kegiatan ?? '-' }}
                    </option>
                @endforeach
            </select>
        </div> --}}

        {{-- PREVIEW --}}
        @if ($pelaksanaan)
            <div class="bg-gray-50 border rounded-lg p-6 space-y-6">

                {{-- INFO KEGIATAN --}}
                <div class="grid grid-cols-2 gap-6 text-sm">
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
                </div>

                {{-- DAFTAR BUKTI --}}
                <div>
                    <h3 class="font-semibold mb-4">
                        Daftar Bukti Pengeluaran
                    </h3>

                    <div class="space-y-4">
                        @foreach ($pelaksanaanPreview as $p)
                            <div class="bg-white border rounded-lg p-4 grid grid-cols-3 gap-4 text-sm">

                                <div>
                                    <div class="text-gray-500">Jenis Bukti</div>
                                    <div class="font-semibold">
                                        {{ $p->pelaksanaanJenis->nama }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-gray-500">Nominal</div>
                                    <div class="font-semibold text-green-600">
                                        Rp {{ number_format($p->nominal, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-gray-500">File Bukti</div>
                                    @if ($p->file_pdf)
                                        <a href="{{ Storage::url($p->file_pdf) }}"
                                           target="_blank"
                                           class="text-blue-600 underline">
                                            Lihat PDF
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada file</span>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- TOTAL --}}
                <div class="flex justify-between items-center border-t pt-4">
                    <span class="text-lg font-semibold">
                        Total Pengeluaran
                    </span>
                    <span class="text-lg font-bold text-green-700">
                        Rp {{ number_format($totalNominal, 0, ',', '.') }}
                    </span>
                </div>

            </div>
        @endif

        {{-- ACTION --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('keuangans.index') }}"
               class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Batal
            </a>

            <button type="submit"
                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Simpan & Buat Kwitansi
            </button>
        </div>

    </form>
</div>
