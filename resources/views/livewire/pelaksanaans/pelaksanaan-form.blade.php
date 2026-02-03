<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Bukti') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 max-w-2xl">

                <h2 class="text-xl font-semibold mb-4">
                    {{ $pelaksanaan_id ? 'Edit Bukti' : 'Tambah Bukti' }}
                </h2>

                {{-- FLASH MESSAGE --}}
                @if (session('success'))
                    <div class="mb-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit.prevent="submit" autocomplete="off">

                    {{-- INFO KEGIATAN (DARI RENCANA) --}}
                    @if ($rencana)
                        <div class="mb-5 p-4 border rounded bg-gray-50">
                            <div class="mb-3">
                                <span class="block text-sm text-gray-500">
                                    Nama Kegiatan
                                </span>
                                <span class="font-semibold text-gray-800">
                                    {{ $rencana->nama_kegiatan }}
                                </span>
                            </div>

                            <div>
                                <span class="block text-sm text-gray-500">
                                    Tanggal Kegiatan
                                </span>
                                <span class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($rencana->tanggal_kegiatan)
                                        ->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>
                    @endif


                    {{-- HIDDEN RENCANA --}}
                    <input type="hidden" wire:model="rencana_id">

                    {{-- MULTI UPLOAD --}}
                    <div class="space-y-3 mb-5">

                        @foreach ($lampirans as $index => $lampiran)
                            <div class="flex items-center gap-2">

                                {{-- FILE --}}
                                <div class="w-1/3">
                                    <input type="file"
                                        wire:model="lampirans.{{ $index }}.file"
                                        accept="application/pdf"
                                        class="border rounded px-3 py-2 w-full text-sm">
                                    @error("lampirans.$index.file")
                                        <span class="text-red-600 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- JENIS --}}
                                <div class="w-1/4">
                                    <select
                                        wire:model="lampirans.{{ $index }}.pelaksanaan_jenis_id"
                                        class="border rounded px-3 py-2 w-full text-sm">
                                        <option value="">-- Pilih Jenis Bukti --</option>
                                        @foreach ($pelaksanaanJenisList as $jenis)
                                            <option value="{{ $jenis->id }}">
                                                {{ $jenis->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("lampirans.$index.pelaksanaan_jenis_id")
                                        <span class="text-red-600 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- NOMINAL --}}
                                <div class="w-1/3">
                                    @if ($lampiran['pelaksanaan_jenis_id'] == $laporanJenisId)
                                        <input type="text"
                                            value="0 (Laporan Kegiatan)"
                                            disabled
                                            class="border rounded px-3 py-2 w-full text-sm bg-gray-100 text-gray-600">
                                    @else
                                        <input type="number"
                                            wire:model="lampirans.{{ $index }}.nominal"
                                            placeholder="Nominal (Rp)"
                                            min="0"
                                            step="1000"
                                            class="border rounded px-3 py-2 w-full text-sm">
                                    @endif
                                </div>

                        @error('pelaksanaan_jenis_id')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>


                                {{-- BUTTON --}}
                                <div class="w-auto">
                                    @if ($index === 0)
                                        <button type="button"
                                            wire:click="addLampiran"
                                            class="px-3 py-2 border rounded text-blue-600">
                                            +
                                        </button>
                                    @else
                                        <button type="button"
                                            wire:click="removeLampiran({{ $index }})"
                                            class="px-3 py-2 border rounded text-red-600">
                                            ✕
                                        </button>
                                    @endif
                                </div>

                            </div>
                        @endforeach

                    </div>

                    
                    {{-- ACTION --}}
                    <div class="flex items-center space-x-2">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded">
                            {{ $pelaksanaan_id ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>

                        <a href="{{ route('pelaksanaans.index') }}"
                            class="px-4 py-2 border rounded">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
