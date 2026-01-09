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
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Nama Kegiatan</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($rencanas as $rencana)
                                <tr>
                                    <td class="px-4 py-2 border">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ \Carbon\Carbon::parse($rencana->tanggal_kegiatan)->format('d/m/Y') }}
                                    </td>

                                    <td class="px-4 py-2 border">
                                        {{ $rencana->nama_kegiatan }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-4 py-2 border text-center">
                                        @if ($rencana->persuratans()->exists())
    <span class="px-2 py-1 text-sm bg-green-100 text-green-700 rounded">
        Sudah Upload
    </span>
@else
    <span class="px-2 py-1 text-sm bg-red-100 text-red-700 rounded">
        Belum Upload
    </span>
@endif

                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-4 py-2 border text-center">
                                        @if ($rencana->persuratans->count() > 0)
                                            @php
                                                $surat = $rencana->persuratans->first();
                                            @endphp

                                            <button
    wire:click="previewSurat({{ $surat->id }})"
    class="text-blue-600 underline mr-2">
    Lihat
</button>

                                            <a href="{{ route('persuratans.edit', $surat->id) }}"
                                               class="text-yellow-600">
                                                Edit
                                            </a>
                                        @else
                                            <a href="{{ route('persuratans.create', ['rencana_id' => $rencana->id]) }}"
                                               class="text-blue-600 font-semibold">
                                                Upload Surat
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 border text-center">
                                        Tidak ada data kegiatan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                @if ($showPreview)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white w-11/12 md:w-4/5 h-[85vh] rounded-lg shadow-lg relative">

        {{-- HEADER --}}
        <div class="flex justify-between items-center px-4 py-2 border-b">
            <h3 class="font-semibold text-lg">
                {{ $previewNama }}
            </h3>

            <button
                wire:click="closePreview"
                class="text-red-600 font-bold text-xl">
                ✕
            </button>
        </div>

        {{-- PDF VIEWER --}}
        <div class="h-full">
            <iframe
                src="{{ $previewUrl }}"
                class="w-full h-full border-none">
            </iframe>
        </div>

        {{-- FOOTER --}}
        <div class="absolute bottom-3 right-4">
            <a href="{{ $previewUrl }}"
               download
               class="px-4 py-2 bg-blue-600 text-white rounded">
                Download
            </a>
        </div>

    </div>
</div>
@endif

                </div>

                <div class="mt-4">
                    {{ $rencanas->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
