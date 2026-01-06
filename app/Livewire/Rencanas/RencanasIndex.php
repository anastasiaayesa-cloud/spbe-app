<?php

namespace App\Livewire\Rencanas;

use App\Models\Rencana;
use Livewire\WithPagination;
use Livewire\Component;

class RencanasIndex extends Component
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
       $rencanas = Rencana::with('kepegawaians')
    ->when($this->search, function ($query) {
        $query->where('nama_kegiatan', 'like', '%' . $this->search . '%')
              ->orWhereHas('kepegawaians', function ($q) {
                  $q->where('nama', 'like', '%' . $this->search . '%');
              });
    })
    ->orderBy('id', 'desc')
    ->paginate(5);

        return view('livewire.rencanas.rencanas-index', compact('rencanas'))
            ->layout('layouts.app');
    }
}
