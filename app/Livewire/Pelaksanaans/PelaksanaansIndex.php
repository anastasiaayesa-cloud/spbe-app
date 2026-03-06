<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Pelaksanaan\PelaksanaanIndexService;

class PelaksanaansIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    protected $service;

    public function boot(PelaksanaanIndexService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {

            $rencanas = $this->service->getAdminRencana();

        } else {

            $kepegawaian = $user->kepegawaian;

            if (!$kepegawaian) {
                abort(403, 'User belum terhubung ke data pegawai');
            }

            $rencanas = $this->service->getPegawaiRencana($kepegawaian->id);
        }

        return view('livewire.pelaksanaans.pelaksanaans-index', [
            'rencanas' => $rencanas
        ])->layout('layouts.app');
    }
}