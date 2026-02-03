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

        // ADMIN → bebas
        if ($user->hasRole('admin')) {
            $this->rencana = $rencana->load([
                'kepegawaians',
                'pelaksanaans.pelaksanaanJenis'
            ]);
            return;
        }

        // USER BIASA → wajib punya kepegawaian
        if (!$user->kepegawaian) {
            abort(403, 'Akun ini belum terhubung dengan kepegawaian');
        }

        $kepegawaianLogin = $user->kepegawaian;

        $this->rencana = $rencana->load([
            'kepegawaians' => function ($q) use ($kepegawaianLogin) {
                $q->where('kepegawaians.id', $kepegawaianLogin->id);
            },
            'pelaksanaans' => function ($q) use ($kepegawaianLogin) {
                $q->where('kepegawaian_id', $kepegawaianLogin->id);
            },
            'pelaksanaans.pelaksanaanJenis'
        ]);
    }

    public function render()
    {
        return view('livewire.pelaksanaans.pelaksanaan-show')
            ->layout('layouts.app');
    }
}
