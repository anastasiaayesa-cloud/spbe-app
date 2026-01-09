@php
    use Carbon\Carbon;
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

                {{-- HEADER --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="text-lg font-semibold">
                        Daftar Kegiatan
                    </div>

                    <div>
                        <input type="text"
                            wire:model.live="search"
                            placeholder="Cari kegiatan..."
                            class="border rounded px-3 py-2 w-64 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                {{-- FLASH --}}
                @if (session('success'))
                    <div class="mb-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="w-full border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-3 py-2 text-left">
                                    Tanggal Kegiatan
                                </th>
                                <th class="border px-3 py-2 text-left">
                                    Nama Kegiatan
                                </th>
                                <th class="border px-3 py-2 text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($rencanas as $rencana)
                                <tr>
                                    {{-- TANGGAL --}}
                                    <td class="border px-3 py-2">
                                        {{ Carbon::parse($rencana->tanggal_kegiatan)
                                            ->translatedFormat('d F Y') }}
                                    </td>

                                    {{-- NAMA --}}
                                    <td class="border px-3 py-2">
                                        {{ $rencana->nama_kegiatan }}
                                    </td>

                                    <td class="px-4 py-2 border text-center">
    @if ($rencana->pelaksanaans->count() > 0)
        @php
            $pelaksanaan = $rencana->pelaksanaans->first();
        @endphp

        <a href="{{ route('pelaksanaans.show.by-rencana', $rencana->id) }}"
           class="text-blue-600 underline mr-2">
            Lihat
        </a>

        <a href="{{ route('pelaksanaans.edit', $pelaksanaan->id) }}"
           class="text-yellow-600">
            Edit
        </a>
    @else
        <a href="{{ route('pelaksanaans.create', ['rencana_id' => $rencana->id]) }}">
    Upload Bukti
</a>
    @endif
</td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="text-center py-4 text-gray-500">
                                        Tidak ada data rencana
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="mt-4">
                    {{ $rencanas->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
