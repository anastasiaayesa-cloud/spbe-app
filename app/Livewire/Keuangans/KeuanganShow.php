<?php

namespace App\Livewire\Keuangans;

use Livewire\Component;
use App\Models\Keuangan;
use App\Models\Pelaksanaan;
use Illuminate\Support\Facades\Auth;



class KeuanganShow extends Component
{
    public Keuangan $keuangan;
    public $buktiPengeluaran;

    public function mount(Keuangan $keuangan)
    {
        $this->keuangan = $keuangan->load([
            'pelaksanaan.rencana.kepegawaians',
        ]);

        $this->buktiPengeluaran = Pelaksanaan::where(
            'rencana_id',
            $keuangan->pelaksanaan->rencana_id
        )->get();

        $this->keuangan->total_nominal = $this->buktiPengeluaran->sum('nominal');
    }

    public function toggleStatus()
{
    if ($this->keuangan->status === 'lunas') {
        $this->keuangan->update([
            'status'   => 'belum_lunas',
            'lunas_at' => null,
        ]);
    } else {
        $this->keuangan->update([
            'status'   => 'lunas',
            'lunas_at' => now(), // ⬅️ otomatis waktu klik
        ]);
    }

    $this->keuangan->refresh();
}


    public function render()
    {
        return view('livewire.keuangans.keuangan-show')
            ->layout('layouts.app');
    }
}

