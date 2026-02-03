<?php

namespace App\Livewire\Persuratans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Persuratan;
use App\Models\Rencana;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;


class PersuratansIndex extends Component
{
    use WithPagination;

    public $search = '';

    // === PREVIEW STATE ===
    public $showPreview = false;
    public $previewUrl = null;
    public $previewNama = null;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function previewSurat($persuratanId)
    {
        $rencanas = Rencana::with('persuratans')
            ->where('nama_kegiatan', 'like', '%' . $this->search . '%')
            ->orderByDesc('id')
            ->paginate(5);

        $this->previewUrl = Storage::url($surat->file_pdf);
        $this->previewNama = $surat->nama_surat;
        $this->showPreview = true;
    }

    public function closePreview()
    {
        $this->reset(['showPreview', 'previewUrl', 'previewNama']);
    }

   public function render()
{
    $rencanas = DB::table('rencanas')
        ->leftJoin(
            'pivot_persuratans_rencanas',
            'rencanas.id',
            '=',
            'pivot_persuratans_rencanas.rencana_id'
        )
        ->leftJoin(
            'persuratans',
            'pivot_persuratans_rencanas.persuratan_id',
            '=',
            'persuratans.id'
        )
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
