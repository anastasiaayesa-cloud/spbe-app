<?php

namespace App\Livewire\Rencanas;

use App\Models\Rencana;
use Livewire\Component;
use Livewire\WithPagination;

class RencanasIndex extends Component
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
        $rencanas = Rencana::query()
            ->when($this->search, function ($query) {
                $query->where('nama_kegiatan', 'like', '%' . $this->search . '%')
                      ->orWhere('pegawai', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.rencanas.rencanas-index', compact('rencanas'))
            ->layout('layouts.app');
    }
}
