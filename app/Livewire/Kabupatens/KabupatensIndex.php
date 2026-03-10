<?php

namespace App\Livewire\Kabupatens;
use App\Models\Kabupaten;
use Livewire\Component;
use Livewire\WithPagination;

class KabupatensIndex extends Component
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
        $kabupatens = Kabupaten::query()
            ->select('kabupatens.*')
            ->orderBy('id', 'asc')
            ->paginate(5);
        return view('livewire.kabupatens.kabupatens-index',compact('kabupatens'))
            ->layout('layouts.app');
    }
}
