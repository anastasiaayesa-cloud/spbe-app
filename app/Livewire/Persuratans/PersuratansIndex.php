<?php

namespace App\Livewire\Persuratans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rencana;
use App\Models\Persuratan;
use Illuminate\Support\Facades\Storage;

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
        $surat = Persuratan::findOrFail($persuratanId);

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
        $rencanas = Rencana::with('persuratans')
            ->when($this->search, fn ($q) =>
                $q->where('nama_kegiatan', 'like', "%{$this->search}%")
            )
            ->orderBy('tanggal_kegiatan', 'desc')
            ->paginate(5);

        return view('livewire.persuratans.persuratans-index', compact('rencanas'))
            ->layout('layouts.app');
    }
}
