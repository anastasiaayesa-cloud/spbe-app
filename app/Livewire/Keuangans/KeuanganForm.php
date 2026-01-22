<?php

namespace App\Livewire\Keuangans;

use Livewire\Component;
use App\Models\Keuangan;
use App\Models\Pelaksanaan;

class KeuanganForm extends Component
{
    public $pelaksanaan_id;
    public $pelaksanaan;

    public $pelaksanaanPreview;
    public $totalNominal = 0;

    public function mount($pelaksanaan)
    {
        // simpan id
        $this->pelaksanaan_id = $pelaksanaan;

        // ambil pelaksanaan utama
        $this->pelaksanaan = Pelaksanaan::with([
            'rencana.kepegawaians',
            'pelaksanaanJenis',
            'keuangans'
        ])->findOrFail($pelaksanaan);

        // ambil preview pelaksanaan lain dalam rencana yang sama
        $this->pelaksanaanPreview = Pelaksanaan::with('pelaksanaanJenis')
            ->where('rencana_id', $this->pelaksanaan->rencana_id)
            ->get();

        // hitung total
        $this->totalNominal = $this->pelaksanaanPreview->sum('nominal');
    }

    public function submit()
    {
        // cegah double pengajuan
        if ($this->pelaksanaan->keuangans()->exists()) {
            session()->flash('error', 'Keuangan sudah diajukan.');
            return;
        }

        Keuangan::create([
            'pelaksanaan_id' => $this->pelaksanaan->id,
            'rencana_id'     => $this->pelaksanaan->rencana_id,
            'total_nominal'  => $this->totalNominal,
            'status'         => 'belum_lunas',
        ]);

        session()->flash('success', 'Keuangan berhasil diajukan.');
        return redirect()->route('keuangans.index');
    }

    public function render()
    {
        return view('livewire.keuangans.keuangan-form')
            ->layout('layouts.app');
    }
}
