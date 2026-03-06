<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Usulan Kegiatan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex items-center justify-between mb-4">

                {{-- Tombol tambah kepegawaian (opsional) --}}
                    <div>
                        <a href="{{ route('rencanas.create') }}"
                            class="inline-block px-4 py-2 rounded">Tambah Rencana Kegiatan </a>
                    </div>

                    {{-- Search bar --}}
                    <div>
                        <input type="text" wire:model.live="search"
                            placeholder="Cari Rencana Kegiatan..."
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
                                <th class="px-4 py-2 border">Tanggal Kegiatan</th>
                                <th class="px-4 py-2 border">Lokasi Kegiatan</th>
                                <th class="px-4 py-2 border">Pegawai yang Diusulkan</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rencanas as $rencana)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $rencana->id }}</td>
                                    <td class="px-4 py-2 border">{{ $rencana->nama_kegiatan }}</td>
                                    <td class="px-4 py-2 border">{{ $rencana->tanggal_kegiatan }}</td>
                                    <td class="px-4 py-2 border">{{ $rencana->lokasi_kegiatan }}</td>            
                                    
                                    <td class="px-4 py-2 border"> 
                                    @forelse ($rencana->kepegawaians as $pegawai)
                                            <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-sm mb-1">
                                                {{ $pegawai->nama }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400">-</span>
                                        @endforelse
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <a href="{{ route(name: 'rencanas.edit', parameters: $rencana->id) }}"
                                            class="mr-2 text-blue-600">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 border text-center">
                                        Tidak ada Rencana Kegiatan .
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $rencanas->links() }}
                </div>

            </div>
        </div>
    </div>
</div>