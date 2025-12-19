<div class="livewire-wrapper">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Perencanaan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-200 rounded">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-200 rounded">{{ session('error') }}</div>
                    @endif

                    {{--
                    ===================================================================
                    START: VISUALISASI KALENDER PERENCANAAN (GANTT-STYLE TABLE)
                    ===================================================================
                    --}}
                    
                    <h3 class="font-semibold text-lg mt-8 mb-4 text-gray-800">Kalender Perencanaan</h3>
                    
                    {{-- Keterangan Warna (Legend) --}}
                    <div class="flex flex-wrap gap-4 mb-4 text-sm">
                        <div class="flex items-center">
                            <span class="inline-block w-4 h-4 bg-red-500 border border-gray-300 mr-2"></span> Rencana Kegiatan
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-4 h-4 bg-green-500 border border-gray-300 mr-2"></span> Realisasi Kegiatan
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-4 h-4 bg-blue-500 border border-gray-300 mr-2"></span> Rencana & Realisasi
                        </div>
                    </div>
                    
                    <style>
                        /* CSS Tambahan untuk tampilan Gantt yang lebih ringkas */
                        .gantt-table-container {
                            max-width: 100%;
                            overflow-x: auto;
                            position: relative; 
                        }
                        .gantt-cell {
                            padding: 0;
                            min-width: 15px; 
                            height: 20px;
                            text-align: center;
                            vertical-align: middle;
                        }
                        .gantt-cell div {
                            width: 100%;
                            height: 100%;
                        }
                        .sticky-col {
                            position: sticky;
                            left: 0;
                            z-index: 10;
                            background-color: white;
                            min-width: 200px;
                            max-width: 200px;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            text-align: left;
                        }
                        .sticky-col.header {
                            z-index: 20;
                        }
                        .livewire-wrapper {
                            /* Pastikan pembungkus akar ini tidak memiliki styling yang mengganggu layout */
                            display: block; 
                        }
                    </style>
                    
                    <div class="gantt-table-container shadow-md sm:rounded-lg">
                        <table class="bg-white border text-xs">
                            <thead>
                                <tr>
                                    {{-- Kolom Aktivitas (Sticky) --}}
                                    <th rowspan="2" class="px-2 py-2 border sticky-col header">Aktivitas (Komponen/Sub)</th>
                                    
                                    {{-- Membuat Header Bulan (12 Bulan) --}}
                                    @php
                                        // Pastikan Carbon digunakan dan tahun diset (misalnya, tahun saat ini)
                                        $tahun = now()->year; 
                                        $current_month = now()->month;
                                    @endphp
                                    @for ($bulan = 1; $bulan <= 12; $bulan++)
                                        @php
                                            // Asumsi Carbon dikonfigurasi untuk bahasa Indonesia (translatedFormat)
                                            $nama_bulan = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F');
                                        @endphp
                                        <th colspan="4" class="px-2 py-1 border text-center {{ $bulan == $current_month ? 'bg-indigo-100' : 'bg-gray-100' }}">
                                            {{ $nama_bulan }}
                                        </th>
                                    @endfor
                                </tr>
                                <tr>
                                    {{-- Membuat Header Minggu (4 Minggu per Bulan) --}}
                                    @for ($bulan = 1; $bulan <= 12; $bulan++)
                                        @for ($minggu = 1; $minggu <= 4; $minggu++)
                                            <th class="px-1 py-1 border font-normal {{ $bulan == $current_month ? 'bg-indigo-50' : 'bg-gray-50' }}">{{ $minggu }}</th>
                                        @endfor
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($perencanaans as $perencanaan)
                                    @php
                                        // Mengonversi tanggal dari data ke objek Carbon (Wajib!)
                                        $rencana_mulai = \Carbon\Carbon::parse($perencanaan->rencana_mulai);
                                        $rencana_selesai = \Carbon\Carbon::parse($perencanaan->rencana_selesai);
                                        
                                        // Asumsi kolom realisasi_mulai dan realisasi_selesai ada (jika tidak, atur ke null)
                                        $realisasi_mulai = isset($perencanaan->realisasi_mulai) && $perencanaan->realisasi_mulai ? \Carbon\Carbon::parse($perencanaan->realisasi_mulai) : null;
                                        $realisasi_selesai = isset($perencanaan->realisasi_selesai) && $perencanaan->realisasi_selesai ? \Carbon\Carbon::parse($perencanaan->realisasi_selesai) : null;
                                    @endphp
                                    <tr>
                                        {{-- Kolom Tugas (Sticky) --}}
                                        <td class="px-2 py-1 border sticky-col text-sm" 
                                            title="{{ $perencanaan->komponen }} - {{ $perencanaan->sub_komponen }}">
                                            {{ $perencanaan->sub_komponen }}
                                        </td>
                                        
                                        {{-- Perulangan Sel Waktu (48 Kolom: 12 Bulan x 4 Minggu) --}}
                                        @for ($bulan = 1; $bulan <= 12; $bulan++)
                                            @for ($minggu = 1; $minggu <= 4; $minggu++)
                                                @php
                                                    // Tentukan rentang tanggal untuk sel mingguan saat ini
                                                    // Catatan: Ini adalah perkiraan mingguan yang disederhanakan
                                                    $tanggal_mulai_minggu = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->startOfWeek()->addWeeks($minggu - 1);
                                                    $tanggal_akhir_minggu = $tanggal_mulai_minggu->copy()->endOfWeek();

                                                    $class_warna = '';
                                                    $tooltip = '';
                                                    
                                                    // 1. Cek apakah Rencana berpotongan dengan minggu ini
                                                    $is_rencana = 
                                                        $tanggal_mulai_minggu->between($rencana_mulai, $rencana_selesai, true) || 
                                                        $tanggal_akhir_minggu->between($rencana_mulai, $rencana_selesai, true) ||
                                                        ($rencana_mulai->lte($tanggal_mulai_minggu) && $rencana_selesai->gte($tanggal_akhir_minggu));
                                                    
                                                    // 2. Cek apakah Realisasi berpotongan dengan minggu ini
                                                    $is_realisasi = false;
                                                    if ($realisasi_mulai && $realisasi_selesai) {
                                                        $is_realisasi = 
                                                            $tanggal_mulai_minggu->between($realisasi_mulai, $realisasi_selesai, true) ||
                                                            $tanggal_akhir_minggu->between($realisasi_mulai, $realisasi_selesai, true) ||
                                                            ($realisasi_mulai->lte($tanggal_mulai_minggu) && $realisasi_selesai->gte($tanggal_akhir_minggu));
                                                    }

                                                    // 3. Tentukan Warna (Logika Prioritas: Realisasi & Rencana > Realisasi Saja > Rencana Saja)
                                                    if ($is_rencana && $is_realisasi) {
                                                        $class_warna = 'bg-blue-500'; // Rencana dan Realisasi
                                                        $tooltip = 'Rencana: ' . $rencana_mulai->format('d/m') . ' - ' . $rencana_selesai->format('d/m') . ' | Realisasi: ' . $realisasi_mulai->format('d/m') . ' - ' . $realisasi_selesai->format('d/m');
                                                    } elseif ($is_realisasi) {
                                                        $class_warna = 'bg-green-500'; // Hanya Realisasi
                                                        $tooltip = 'Realisasi Kegiatan: ' . $realisasi_mulai->format('d/m') . ' - ' . $realisasi_selesai->format('d/m');
                                                    } elseif ($is_rencana) {
                                                        $class_warna = 'bg-red-500'; // Hanya Rencana
                                                        $tooltip = 'Rencana Kegiatan: ' . $rencana_mulai->format('d/m') . ' - ' . $rencana_selesai->format('d/m');
                                                    }
                                                @endphp
                                                
                                                {{-- Cetak Sel dengan Bar (Warna) --}}
                                                <td class="border gantt-cell">
                                                    @if ($class_warna)
                                                        <div class="{{ $class_warna }} hover:opacity-80" title="{{ $perencanaan->sub_komponen }} - {{ $tooltip }}"></div>
                                                    @else
                                                        &nbsp;
                                                    @endif
                                                </td>
                                            @endfor
                                        @endfor
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="49" class="px-4 py-4 border text-center">
                                            Tidak ada Perencanaans yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{--
                    ===================================================================
                    END: VISUALISASI KALENDER PERENCANAAN (GANTT-STYLE TABLE)
                    ===================================================================
                    --}}
                    <div class="flex items-center justify-between mb-4">
                        {{-- Tombol tambah perencaan (opsional) --}}
                        <div>
                        <a href="{{ route('perencanaans.create') }}"
                            class="inline-block px-4 py-2 rounded">Tambah Perencanaan </a>
                        </div>

                        {{-- Search bar (disesuaikan untuk Livewire) --}}
                        <div>
                            <input type="text" wire:model.live="search"
                                placeholder="Cari perencanaan..."
                                class="border rounded px-3 py-2 w-64 focus:ring focus:ring-blue-200">
                        </div>
                    </div>

                    {{-- Tabel Detail Data Asli (Dipindahkan ke Bawah Visualisasi) --}}
                    <h3 class="font-semibold text-lg mt-8 mb-4 text-gray-800">Tabel Detail Data</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border">#</th>
                                    <th class="px-4 py-2 border">Komponen</th>
                                    <th class="px-4 py-2 border">Sub Komponen</th>
                                    <th class="px-4 py-2 border">Rencana Mulai</th>
                                    <th class="px-4 py-2 border">Rencana Selesai</th>
                                    <th class="px-4 py-2 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($perencanaans as $perencanaan)
                                    <tr>
                                        <td class="px-4 py-2 border">{{ $perencanaan->id }}</td>
                                        <td class="px-4 py-2 border">{{ $perencanaan->komponen }}</td>
                                        <td class="px-4 py-2 border">{{ $perencanaan->sub_komponen }}</td>
                                        <td class="px-4 py-2 border">{{ $perencanaan->rencana_mulai }}</td>
                                        <td class="px-4 py-2 border">{{ $perencanaan->rencana_selesai }}</td>
                                        <td class="px-4 py-2 border">
                                            {{-- Tambahkan tombol aksi di sini --}}
                                            <a href="#" class="text-blue-600">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 border text-center">
                                            Tidak ada Perencanaans.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $perencanaans->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>