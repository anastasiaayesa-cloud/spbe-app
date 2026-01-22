<?php

namespace App\Livewire\Persuratans;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Persuratan;
use App\Models\Rencana;
use Illuminate\Support\Facades\DB;


class PersuratansIndex extends Component
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
        $rencanas = Rencana::with('persuratans')
            ->where('nama_kegiatan', 'like', '%' . $this->search . '%')
            ->orderByDesc('id')
            ->paginate(5);

        return view('livewire.persuratans.persuratans-index', compact('rencanas'))
            ->layout('layouts.app');
    }
}
