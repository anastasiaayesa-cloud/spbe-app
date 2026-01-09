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
        $rencanas = \DB::table('rencanas')
            // Join ke tabel pivot dan persuratans untuk cek status surat
            ->leftJoin('persuratans', 'pivot_persuratans_rencanas.persuratan_id', '=', 'persuratans.id')
            ->select(
                'rencanas.id as id_rencana',
                'rencanas.nama_kegiatan',
                'rencanas.tanggal_kegiatan',
                'persuratans.id as id_surat',
                'persuratans.nama_surat',
                'persuratans.file_pdf'
            )
            ->where('rencanas.nama_kegiatan', 'like', '%' . $this->search . '%')
            ->orderBy('rencanas.id', 'desc')
            ->paginate(5);

        return view('livewire.persuratans.persuratans-index', compact('rencanas'))
            ->layout('layouts.app');
    }
}