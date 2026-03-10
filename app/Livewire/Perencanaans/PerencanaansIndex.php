<?php

namespace App\Livewire\Perencanaans;

use App\Models\Perencanaan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PerencanaanImport;

class PerencanaansIndex extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';

    // 1. Tambahkan property untuk menyimpan ID yang dibuka
    public $openedRows = [];

    // biar gak error di Tailwind pagination
    protected $paginationTheme = 'tailwind';

    public $file_excel;

    // reset pagination ke halaman 1 tiap kali search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function importExcel()
    {
        $this->validate([
            'file_excel' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new PerencanaanImport, $this->file_excel->getRealPath());

        session()->flash('message', 'Data berhasil diimport!');
    }

    // 2. Fungsi untuk toggle buka/tutup baris
    public function toggleRow($id)
    {
        if (in_array($id, $this->openedRows)) {
            $this->openedRows = array_diff($this->openedRows, [$id]);
        } else {
            $this->openedRows[] = $id;
        }
    }

    public function render()
    {
        $perencanaans = Perencanaan::query()
            // 3. Tambahkan with('details') agar tidak lambat (Eager Loading)
            ->with('details')
            ->select('perencanaans.*')
            ->when($this->search, function ($query) { //searching di search kolom
                $query->where('perencanaans.kode', 'like', '%' . $this->search . '%')
                    ->orWhere('perencanaans.dokumen_perencanaan_id', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(5);

        return view('livewire.perencanaans.perencanaans-index', compact('perencanaans'))
            ->layout('layouts.app');
    }
}
