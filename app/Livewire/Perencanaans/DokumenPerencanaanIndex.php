<?php

namespace App\Livewire\Perencanaans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DokumenPerencanaan;

class DokumenPerencanaanIndex extends Component
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
        $dokumenperencanaans = DokumenPerencanaan::query()
            ->select('dokumen_perencanaans.*')
            ->when($this->search, function ($query) { //searching di search kolom
                $query->where('dokumen_perencanaans.nama', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(5);

        return view('livewire.perencanaans.dokumen-perencanaan-index', compact('dokumenperencanaans'))
            ->layout('layouts.app');
    }
}
