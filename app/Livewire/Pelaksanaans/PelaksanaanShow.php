<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use App\Models\Pelaksanaan;
use App\Models\Rencana;


class PelaksanaanShow extends Component
{
    public $rencana;
    public $pelaksanaans;

    public function mount(Rencana $rencana)
    {
        $this->rencana = $rencana;

        $this->pelaksanaans = Pelaksanaan::with('pelaksanaanJenis')
            ->where('rencana_id', $rencana->id)
            ->get();
    }

    public function render()
    {
        return view('livewire.pelaksanaans.pelaksanaan-show')
            ->layout('layouts.app');
    }
}
