<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rencana;

class PelaksanaansIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $rencanas = Rencana::with('pelaksanaans')
    // nanti tinggal tambah filter user
    ->orderBy('tanggal_kegiatan', 'desc')
    ->paginate(5);

        return view('livewire.pelaksanaans.pelaksanaans-index', compact('rencanas'))
            ->layout('layouts.app');
    }
}
