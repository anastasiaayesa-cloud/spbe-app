<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use App\Models\Rencana;
use Illuminate\Support\Facades\Auth;

class PelaksanaanShow extends Component
{
    public $rencana;

   public function mount(Rencana $rencana)
{
    $user = Auth::user();

    if ($user->hasAnyRole(['admin','super-admin'])) {

        $this->rencana = $rencana->load([
            'kepegawaians',
            'pelaksanaans.pelaksanaanJenis'
        ]);

        return;
    }

    $kepegawaian = $user->kepegawaian;

    if (!$kepegawaian) {
        abort(403,'Akun ini belum terhubung dengan kepegawaian');
    }

    $this->rencana = $rencana->load([
        'kepegawaians',
        'pelaksanaans' => fn($q) =>
            $q->where('kepegawaian_id',$kepegawaian->id),
        'pelaksanaans.pelaksanaanJenis'
    ]);
}
    public function render()
    {
        return view('livewire.pelaksanaans.pelaksanaan-show')
            ->layout('layouts.app');
    }
}
