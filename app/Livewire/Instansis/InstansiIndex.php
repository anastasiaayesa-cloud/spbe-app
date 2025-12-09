<?php

namespace App\Livewire\Instansis;

use App\Models\Instansi;
use Livewire\Component;
use Livewire\WithPagination;


class InstansiIndex extends Component
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
        $instansis = Instansi::query()
            ->select('instansis.*')
            ->when($this->search, function ($query) { //searching di search kolom
                $query->where('instansis.nama_instansi', 'like', '%' . $this->search . '%')
                    ->orWhere('instansis.alamat_instansi', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.instansis.instansi-index', compact('instansis'))
            ->layout('layouts.app');
    }
}
