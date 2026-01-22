<?php

namespace App\Livewire\Keuangans;

use Livewire\Component;
use App\Models\Keuangan;

use App\Models\Pelaksanaan;

class KeuanganShow extends Component
{
    public Keuangan $keuangan;
    public $buktiPengeluaran;

    public function mount(Keuangan $keuangan)
    {
        $this->keuangan = $keuangan->load([
            'pelaksanaan.rencana',
            'detailKeuangans'
        ]);

        // 🔑 INI KUNCI UTAMANYA
        $this->buktiPengeluaran = Pelaksanaan::with('pelaksanaanJenis')
            ->where('rencana_id', $keuangan->pelaksanaan->rencana_id)
            ->get();
    }

    public function render()
    {
        return view('livewire.keuangans.keuangan-show')
            ->layout('layouts.app');
    }
}

