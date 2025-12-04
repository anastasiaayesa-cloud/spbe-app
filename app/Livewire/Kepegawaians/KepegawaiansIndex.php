<?php

namespace App\Livewire\Kepegawaians;

use App\Models\Kepegawaian;
use Livewire\Component;
use Livewire\WithPagination;

class KepegawaiansIndex extends Component
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
        $kepegawaians = Kepegawaian::query()
            ->select('kepegawaians.*')
            // ->when($this->search, function ($query) { //searching di search kolom
            //     $query->where('items.nama', 'like', '%' . $this->search . '%')
            //         ->orWhere('item_kategoris.nama', 'like', "%{$this->search}%");
            // })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.kepegawaians.kepegawaians-index', compact('kepegawaians'))
            ->layout('layouts.app');
    }
}
