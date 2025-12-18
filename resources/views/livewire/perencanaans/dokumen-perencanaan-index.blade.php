@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Dokumen Perencanaan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex items-center justify-between mb-4">

                    {{-- Tombol tambah perencanaan (opsional) --}}
                    <div>
                        <a href="{{ route('dokumen-perencanaan.create') }}"
                            class="inline-block px-4 py-2 rounded">Upload Dokumen</a>
                    </div>

                    {{-- Search bar --}}
                    <div>
                        <input type="text" wire:model.live="search"
                            placeholder="Cari Dokumen..."
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
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">File</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dokumenperencanaans as $dokumenperencanaan)
                                <tr>
                                <td class="px-4 py-2 border">{{ $dokumenperencanaan->id }}</td>
                                    <td class="px-4 py-2 border">{{ $dokumenperencanaan->nama }}</td>
                                    {{-- <td class="px-4 py-2 border">{{ $dokumenperencanaan->file_pdf }}</td> --}}
                                    <td class="px-4 py-2 border"> 
                                        @if ($dokumenperencanaan->file_pdf)
                                            <a href="{{ Storage::url($dokumenperencanaan->file_pdf) }}" 
                                            class="text-blue-600 underline" target="_blank">
                                            Download File
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">{{ $dokumenperencanaan->tanggal }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 border text-center">
                                        Tidak ada Dokumen .
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $dokumenperencanaans->links() }}
                </div>

            </div>
        </div>
    </div>
</div>