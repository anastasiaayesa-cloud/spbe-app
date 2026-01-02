@php
    use Illuminate\Support\Facades\Storage;
@endphp


<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Bukti Laporan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex items-center justify-between mb-4">

                    {{-- Tombol tambah perencaan (opsional) --}}
                    <div>
                        <a href="{{ route('pelaksanaans.create') }}"
                            class="inline-block px-4 py-2 rounded">Upload Bukti Pelaksanaan</a>
                    </div>

                    {{-- Search bar --}}
                    <div>
                        <input type="text" wire:model.live="search"
                            placeholder="Cari kegiatan..."
                            class="border rounded px-3 py-2 w-64 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                @if (session('success'))
                    <div class="mb-4 text-green-700">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 text-red-700">{{ session('error') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Nama Kegiatan</th>
                                <th class="px-4 py-2 border">Jenis Bukti</th>
                                <th class="px-4 py-2 border">File</th>
                                <th class="px-4 py-2 border">Tanggal upload</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pelaksanaans as $pelaksanaan)
                            <tr>
                                <td class="px-4 py-2 border">{{ $pelaksanaan->id }}</td>
                                {{-- Nama Kegiatan --}}
                                <td class="px-4 py-2 border">
                                    {{ $pelaksanaan->perencanaan?->perencanaanNama?->nama ?? '-' }}
                                </td>

                                <td class="px-4 py-2 border">{{ $pelaksanaan->jenis->nama }}</td>
                                    {{-- <td class="px-4 py-2 border">{{ $persuratan->file_pdf }}</td> --}}
                                    <td class="px-4 py-2 border">
                                    @if ($pelaksanaan->file_pdf)
                                        <a href="{{ Storage::url($pelaksanaan->file_pdf) }}"
                                        class="text-blue-600 underline"
                                        target="_blank">
                                            Download File
                                        </a>
                                    @endif
                                </td>
                                 <td class="px-4 py-2 border">{{ $pelaksanaan->tanggal_upload }}</td>

                                <td class="px-4 py-2 border">
                                    <a href="{{ route('pelaksanaans.edit', $pelaksanaan->id) }}"
                                    class="text-blue-600 mr-2">
                                        Edit
                                    </a>
                                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 border text-center">
                                        Tidak ada Surat .
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $pelaksanaans->links() }}
                </div>

            </div>
        </div>
    </div>
</div>