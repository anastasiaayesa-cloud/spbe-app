<?php

namespace App\Livewire\Persuratans;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Persuratan;

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
        $persuratans = Persuratan::query()
            ->select('persuratans.*')
            // ->when($this->search, function ($query) { //searching di search kolom
            //     $query->where('items.nama', 'like', '%' . $this->search . '%')
            //         ->orWhere('item_kategoris.nama', 'like', "%{$this->search}%");
            // })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.persuratans.persuratans-index', compact('persuratans'))
            ->layout('layouts.app');
    }
}
