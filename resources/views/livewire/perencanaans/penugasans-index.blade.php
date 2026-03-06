<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Penugasan') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex items-center justify-between mb-4">

                {{-- Tombol tambah penugasan (opsional) --}}
                    <div>
                        <a href="{{ route('penugasans.create') }}"
                            class="inline-block px-4 py-2 rounded">Tambah Tugas </a>
                    </div>

                    {{-- Search bar --}}
                    <div>
                        <input type="text" wire:model.live="search"
                            placeholder="Cari Penugasan..."
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
                                <th class="px-4 py-2 border">Pegawai</th>
                                <th class="px-4 py-2 border">Nama Tugas</th>
                                <th class="px-4 py-2 border">Tanggal Mulai/th>
                                <th class="px-4 py-2 border">Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penugasans as $penugasan)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $penugasan->id }}</td>
                                    <td class="px-4 py-2 border">{{ $penugasan->pegawai }}</td>
                                    <td class="px-4 py-2 border">{{ $penugasan->nama_tugas }}</td>
                                    <td class="px-4 py-2 border">{{ $penugasan->tanggal_mulai }}</td>
                                    <td class="px-4 py-2 border">{{ $penugasan->tanggal_selesai }}</td>
                                    <td class="px-4 py-2 border">
                                        <a href="{{ route(name: 'penugasans.edit', parameters: $penugasan->id) }}"
                                            class="mr-2 text-blue-600">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 border text-center">
                                        Tidak ada Tugas .
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $penugasans->links() }}
                </div>

            </div>
        </div>
    </div>
</div>