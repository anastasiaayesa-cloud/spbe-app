<?php

namespace App\Livewire\Perencanaans;

use Livewire\Component;
use App\Models\Perencanaan;
use App\Models\PerencanaanDetail as DetailModel;
use App\Models\DokumenPerencanaan;
use Illuminate\Support\Facades\DB;
// ... (import lainnya)

class PerencanaanDetail extends Component
{
    // 1. PASTIKAN PROPERTI INI ADA
    public $perencanaanId; 
    public $dokumen_perencanaan_id, $kode, $nama, $volume;
    public $details = [];
    public $dokumenperencanaanList = [];

    // 2. NAMA PARAMETER HARUS SAMA DENGAN DI ROUTE {perencanaanId}
    public function mount($perencanaanId = null) 
    {
        $this->dokumenperencanaanList = DokumenPerencanaan::orderBy('nama')->get();

        if ($perencanaanId) {
            // Gunakan $this-> untuk mengisi properti class
            $this->perencanaanId = $perencanaanId; 
            
            // Cari data berdasarkan parameter yang masuk
            $perencanaan = Perencanaan::with('details')->find($perencanaanId);

            if ($perencanaan) {
                $this->dokumen_perencanaan_id = $perencanaan->dokumen_perencanaan_id;
                $this->kode = $perencanaan->kode;
                $this->nama = $perencanaan->nama;
                $this->volume = $perencanaan->volume;

                $this->details = [];
                foreach ($perencanaan->details as $item) {
                    $this->details[] = [
                        'id'             => $item->id,
                        'uraian_rincian' => $item->uraian_rincian,
                        'volume'         => $item->volume,
                        'volume_satuan'  => $item->volume_satuan,
                        'harga_satuan'   => $item->harga_satuan,
                        'subtotal_biaya' => $item->subtotal_biaya,
                    ];
                }
            }
        }

        if (empty($this->details)) {
            $this->addDetail();
        }
    }

    public function addDetail()
    {
        $this->details[] = [
            'id'             => null,
            'uraian_rincian' => '',
            'volume'         => 0,
            'volume_satuan'  => '',
            'harga_satuan'   => 0,
            'subtotal_biaya' => 0
        ];
    }

    public function removeDetail($index)
    {
        unset($this->details[$index]);
        $this->details = array_values($this->details);
    }

    public function updatedDetails($value, $key)
    {
        if (str_contains($key, 'volume') || str_contains($key, 'harga_satuan')) {
            $index = explode('.', $key)[0];
            $vol = (float)($this->details[$index]['volume'] ?? 0);
            $harga = (int)($this->details[$index]['harga_satuan'] ?? 0);
            $this->details[$index]['subtotal_biaya'] = $vol * $harga;
        }
    }

    public function save()
    {
        $this->validate([
            'dokumen_perencanaan_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
        ]);

        DB::transaction(function () {
            $perencanaan = Perencanaan::updateOrCreate(
                ['id' => $this->perencanaanId],
                [
                    'dokumen_perencanaan_id' => $this->dokumen_perencanaan_id,
                    'kode' => $this->kode,
                    'nama' => $this->nama,
                    'volume' => $this->volume,
                    'jumlah_biaya' => collect($this->details)->sum('subtotal_biaya'),
                ]
            );

            // Ambil ID yang ada di input untuk proses sinkronisasi hapus
            $inputIds = collect($this->details)->pluck('id')->filter()->toArray();
            
            if ($this->perencanaanId) {
                // Hapus yang tidak ada di input (User menghapus baris)
                $perencanaan->details()->whereNotIn('id', $inputIds)->delete();
            }

            foreach ($this->details as $item) {
                $perencanaan->details()->updateOrCreate(
                    ['id' => $item['id'] ?? null],
                    [
                        'uraian_rincian' => $item['uraian_rincian'],
                        'volume' => $item['volume'],
                        'volume_satuan' => $item['volume_satuan'],
                        'harga_satuan' => $item['harga_satuan'],
                        'subtotal_biaya' => $item['subtotal_biaya'],
                    ]
                );
            }
        });

        return redirect()->route('perencanaans.index')->with('success', 'Data Berhasil Disimpan');
    }

    public function cancel()
{
    return redirect()->route('perencanaans.index');
}

    public function render()
    {
        return view('livewire.perencanaans.perencanaan-detail')
            ->layout('layouts.app');
    }
}