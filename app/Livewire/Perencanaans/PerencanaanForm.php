<?php

namespace App\Livewire\Perencanaans;

use Livewire\Component;
use App\Models\Perencanaan;
use App\Models\DokumenPerencanaan;

class PerencanaanForm extends Component
{
    // public $perencanaan_id, $komponen, $uraian_komponen, $sub_komponen, $uraian_sub_komponen, $nama_aktivitas, $rencana_mulai, $rencana_selesai, $realisasi_mulai, $realisasi_selesai, $keterangan, $terlaksana_id;
    public $perencanaan_id, $dokumenperencanaanList = [], $dokumen_perencanaan_id, $kode, $nama, $detail, $volume, $harga_satuan, $jumlah_biaya;

    public function mount($perencanaan_id = null)
    {
        $this->dokumenperencanaanList = DokumenPerencanaan::orderBy('nama')->get();
        // kalau parameter ada (edit mode)
        if ($perencanaan_id) {
            $this->perencanaan_id = $perencanaan_id;

            $perencanaan = Perencanaan::findOrFail($perencanaan_id);
            $this->dokumen_perencanaan_id = $perencanaan->dokumen_perencanaan_id;
            $this->kode = $perencanaan->kode;
            $this->nama = $perencanaan->nama;
            $this->volume = $perencanaan->volume;
            $this->jumlah_biaya = $perencanaan->jumlah_biaya;
        }
    }

    public function rules()
    {
        $rules = [
            'dokumen_perencanaan_id' => 'required|exists:dokumen_perencanaans,id',
            'kode' => 'nullable|string|max:255',
            'nama' => 'nullable|string|max:255',
            'volume' => 'nullable|string|max:255',
            'jumlah_biaya' => 'nullable|integer|min:0',
        ];

        return $rules;
    }

    public function submit()
    {
        $this->validate();

        // setelah lulus validasi, lakukan sintaks dibawah
        if ($this->perencanaan_id) {
            $perencanaan = Perencanaan::findOrFail($this->perencanaan_id);
            $perencanaan->update([
                'dokumen_perencanaan_id' => $this->dokumen_perencanaan_id,
                'kode' => $this->kode,
                'nama' => $this->nama,
                'volume' => $this->volume,
                'jumlah_biaya' => $this->jumlah_biaya,
            ]);

            session()->flash('success', 'Perencanaan berhasil diedit.');
            return redirect()->route('perencanaans.index');
        } else {
            $perencanaan = Perencanaan::create([
                'dokumen_perencanaan_id' => $this->dokumen_perencanaan_id,
                'kode' => $this->kode,
                'nama' => $this->nama,
                'volume' => $this->volume,
                'jumlah_biaya' => $this->jumlah_biaya,
            ]);

            session()->flash('success', 'Perencanaan baru berhasil ditambahkan.');
            return redirect()->route('perencanaans.create');
        }
    }

    public function cancel()
{
    return redirect()->route('perencanaans.index');
}

    public function render()
    {
        return view('livewire.perencanaans.perencanaan-form')
            ->layout('layouts.app');
    }
}
