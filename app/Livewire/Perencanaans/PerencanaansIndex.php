<?php

namespace App\Livewire\Perencanaans;

use App\Models\Perencanaan;
use Livewire\Component;
use Livewire\WithPagination;

class PerencanaansIndex extends Component
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
        $perencanaans = Perencanaan::query()
            ->select('perencanaans.*')
            ->when($this->search, function ($query) { //searching di search kolom
                $query->where('perencanaans.komponen', 'like', '%' . $this->search . '%')
                    ->orWhere('perencanaans.sub_komponen', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.perencanaans.perencanaans-index', compact('perencanaans'))
            ->layout('layouts.app');
    }
}
