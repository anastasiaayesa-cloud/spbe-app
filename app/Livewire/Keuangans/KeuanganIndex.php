<?php

namespace App\Livewire\Keuangans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pelaksanaan;
use App\Models\Rencana;

class KeuanganIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
{
    $rencanas = Rencana::with([
            'pelaksanaans.keuangans'
        ])
        ->when($this->search, function ($query) {
            $query->where('nama_kegiatan', 'like', '%' . $this->search . '%')
                  ->orWhere('lokasi_kegiatan', 'like', '%' . $this->search . '%')
                  ->orWhere('tanggal_kegiatan', 'like', '%' . $this->search . '%');
        })
        ->orderBy('tanggal_kegiatan', 'desc')
        ->paginate(10);

    return view('livewire.keuangans.keuangan-index', compact('rencanas'))
        ->layout('layouts.app');
}
}
