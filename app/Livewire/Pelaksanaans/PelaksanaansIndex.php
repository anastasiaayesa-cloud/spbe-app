<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pelaksanaan;

class PelaksanaansIndex extends Component
{
    use WithPagination;

    public $search = '';

    // biar gak error di Tailwind pagination
    protected $paginationTheme = 'tailwind';

    // reset pagination ke halaman 1 tiap kali search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pelaksanaans = Pelaksanaan::query()
            ->select('pelaksanaans.*')
            // ->when($this->search, function ($query) { //searching di search kolom
            //     $query->where('items.nama', 'like', '%' . $this->search . '%')
            //         ->orWhere('item_kategoris.nama', 'like', "%{$this->search}%");
            // })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.pelaksanaans.pelaksanaans-index', [
            'pelaksanaans' => $pelaksanaans
        ])->layout('layouts.app');
    }
}
