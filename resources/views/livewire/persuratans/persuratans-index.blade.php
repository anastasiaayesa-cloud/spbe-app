@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Persuratan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex items-center justify-between mb-4">

                    {{-- Search bar --}}
                    <div>
                        <input type="text" wire:model.live="search"
                            placeholder="Cari kegiatan..."
                            class="border rounded px-3 py-2 w-64 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                <div class="overflow-x-auto">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Nama Kegiatan</th>
                            <th class="px-4 py-2 border">Tanggal Kegiatan</th>
                            {{-- Kolom Pegawai Dihapus --}}
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rencanas as $rencana)
                        <tr>
                            <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $rencana->nama_kegiatan }}</td>
                            <td class="px-4 py-2 border text-center">{{ $rencana->tanggal_kegiatan }}</td>

                            {{-- Kolom Status --}}
                            <td class="px-4 py-2 border">
                                @php
                                    // Ambil data surat berdasarkan rencana_id dari tabel pivot
                                    $daftarSurat = \App\Models\Persuratan::whereHas('rencanas', function($q) use ($rencana) {
                                        $q->where('rencanas.id', $rencana->id_rencana);
                                    })->get();
                                @endphp

                                @if($daftarSurat->isNotEmpty())
                                    <span class="text-green-600 font-bold text-xs">Terupload ({{ $daftarSurat->count() }}):</span>
                                    <ul class="list-disc ml-4">
                                        @foreach($daftarSurat as $s)
                                            <li>
                                                <a href="{{ asset('storage/'.$s->file_pdf) }}" target="_blank" class="text-blue-500 underline text-xs">
                                                    {{ $s->nama_surat }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-red-500 italic text-sm">Belum ada surat</span>
                                @endif
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="px-4 py-2 border text-center">
                                {{-- Hapus pengecekan @if(!$rencana->id_surat) agar tombol selalu ada --}}
                                <a href="{{ route('persuratans.create', ['rencana_id' => $rencana->id_rencana]) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                    Buat Surat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                    {{-- Pastikan pagination juga menggunakan $rencanas --}}
                    <div class="mt-4">
                        {{ $rencanas->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
