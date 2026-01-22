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
        $pelaksanaans = Pelaksanaan::with(['rencana', 'keuangans'])
            ->when($this->search, function ($query) {
                $query->whereHas('rencana', function ($q) {
                    $q->where('nama_kegiatan', 'like', '%' . $this->search . '%')
                      ->orWhere('lokasi_kegiatan', 'like', '%' . $this->search . '%')
                      ->orWhere('tanggal_kegiatan', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy(
                Rencana::select('tanggal_kegiatan')
                    ->whereColumn('rencanas.id', 'pelaksanaans.rencana_id'),
                'desc'
            )
            ->paginate(10);

        return view('livewire.keuangans.keuangan-index', compact('pelaksanaans'))
            ->layout('layouts.app');
    }
}
