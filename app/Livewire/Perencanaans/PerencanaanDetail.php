<?php

namespace App\Livewire\Perencanaans;

use Livewire\Component;
use App\Models\Perencanaan;
use Illuminate\Support\Facades\DB;
use App\Models\DokumenPerencanaan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // WAJIB ADA

class PerencanaanDetail extends Component
{
    // Properti untuk Header
    public $dokumenperencanaanList = [], $dokumen_perencanaan_id, $kode, $nama, $volume, $jumlah_biaya, $perencanaanId;

    // Properti untuk Details (Array)
    public $details = [];

    public function mount($id = null)
    {
        $this->dokumenperencanaanList = DokumenPerencanaan::orderBy('nama')->get();
        // Inisialisasi baris pertama agar form tidak kosong
        if ($id) {

            $this->authorize('perencanaans-edit');
            // Mode EDIT: Ambil data lama
            $this->perencanaanId = $id;
            $perencanaan = Perencanaan::with('details')->findOrFail($id);

            $this->dokumen_perencanaan_id = $perencanaan->dokumen_perencanaan_id;
            $this->kode = $perencanaan->kode;
            $this->nama = $perencanaan->nama;
            $this->volume = $perencanaan->volume;

            // Masukkan rincian lama ke dalam array details
            foreach ($perencanaan->details as $detail) {
                $this->details[] = [
                    'uraian_rincian' => $detail->uraian_rincian,
                    'volume'         => $detail->volume,
                    'volume_satuan'  => $detail->volume_satuan,
                    'harga_satuan'   => $detail->harga_satuan,
                    'subtotal_biaya' => $detail->subtotal_biaya // Pastikan field sesuai DB
                ];
            }
        } else {
            // Mode CREATE: Inisialisasi baris kosong
            $this->authorize('perencanaans-edit');
            $this->addDetail();
        }
    }

    public function addDetail()
    {
        $this->details[] = [
            'uraian_rincian' => '',
            'volume' => 0,
            'volume_satuan' => '',
            'harga_satuan' => 0,
            'subtotal_biaya' => 0
        ];
    }

    public function removeDetail($index)
    {
        unset($this->details[$index]);
        $this->details = array_values($this->details); // Reset index array
    }

    // Fungsi otomatis saat input volume/harga berubah
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
            'details.*.uraian_rincian' => 'required',
        ]);

        DB::transaction(function () {
            $perencanaan = Perencanaan::updateOrCreate(
                ['id' => $this->perencanaanId], // Cari berdasarkan ID (null jika Create)
                [
                'dokumen_perencanaan_id' => $this->dokumen_perencanaan_id,
                'kode' => $this->kode,
                'nama' => $this->nama,
                'volume' => $this->volume,
                'jumlah_biaya' => collect($this->details)->sum('subtotal_biaya'),
            ]);

            // Jika Mode Edit, hapus detail lama lalu masukkan yang baru (Cara termudah)
            if ($this->perencanaanId) {
                $perencanaan->details()->delete();
            }

            foreach ($this->details as $item) {
                $perencanaan->details()->create([
                    'uraian_rincian' => $item['uraian_rincian'],
                    'volume'         => $item['volume'],
                    'volume_satuan'  => $item['volume_satuan'],
                    'harga_satuan'   => $item['harga_satuan'],
                    'subtotal_biaya'   => $item['subtotal_biaya'],
                ]);
            }
        });
        session()->flash('success', $this->perencanaanId ? 'Perencanaan berhasil diperbarui.' : 'Perencanaan baru berhasil ditambahkan.');
        return redirect()->route('perencanaans.index');
    }

    public function render()
    {
        return view('livewire.perencanaans.perencanaan-detail')
            ->layout('layouts.app');
    }
}
