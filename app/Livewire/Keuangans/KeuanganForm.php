<?php

namespace App\Livewire\Keuangans;

use Livewire\Component;
use App\Models\Pelaksanaan;
use App\Models\Keuangan;
use App\Models\DetailKeuangan;

namespace App\Livewire\Keuangans;

use Livewire\Component;
use App\Models\Pelaksanaan;
use App\Models\Keuangan;

class KeuanganForm extends Component
{
    public $pelaksanaan;

    public function mount($pelaksanaan)
    {
        $this->pelaksanaan = Pelaksanaan::with('rencana')
            ->where('id', $pelaksanaan)
            ->where('kepegawaian_id', auth()->user()->kepegawaian->id)
            ->firstOrFail();
    }

    public function submit()
{
    if (! auth()->user()->hasRole('pegawai')) {
        abort(403);
    }

    Keuangan::firstOrCreate(
        ['pelaksanaan_id' => $this->pelaksanaan->id],
        [
            'status' => 'belum_lunas', // ✅ SESUAI ENUM
            'tanggal_proses' => now(),
        ]
    );

    session()->flash('success', 'Keuangan berhasil disimpan');
}



    public function render()
    {
        return view('livewire.keuangans.keuangan-form')
            ->layout('layouts.app');
    }
}

