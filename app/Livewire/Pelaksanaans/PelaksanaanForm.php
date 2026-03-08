<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use Livewire\WithFileUploads;
// use App\Models\Rencana;
// use App\Models\Pelaksanaan;
// use App\Models\PelaksanaanJenis;
use App\Services\Pelaksanaan\PelaksanaanService;

class PelaksanaanForm extends Component
{
    use WithFileUploads;

    protected $service;

    public $pelaksanaan_id;
    public $rencana_id;
    public $tanggal_upload;
    public $laporanJenisId;

    public $rencana;
    public $pelaksanaanJenisList = [];
    public $lampirans = [];

    public function boot(PelaksanaanService $service)
    {
        $this->service = $service;
    }

    public function mount($pelaksanaan_id = null)
    {
        $this->pelaksanaanJenisList = $this->service->getPelaksanaanJenis();
        $this->laporanJenisId = $this->service->getLaporanJenisId();

        $this->rencana_id = request()->query('rencana_id');

        if ($this->rencana_id) {
            $this->rencana = $this->service->getRencana($this->rencana_id);
            $this->tanggal_upload = $this->rencana->tanggal_kegiatan;
        }

        $this->lampirans = $this->service->defaultLampiran();
    }

    public function addLampiran()
    {
        $this->lampirans[] = $this->service->defaultLampiranItem();
    }

    public function removeLampiran($index)
    {
        $this->service->removeLampiran($this->lampirans[$index] ?? null);

        unset($this->lampirans[$index]);
        $this->lampirans = array_values($this->lampirans);
    }

    public function submit()
    {
        $this->validate();

        $this->service->savePelaksanaan(
            $this->rencana_id,
            $this->lampirans,
            $this->tanggal_upload,
            $this->laporanJenisId
        );

        session()->flash('success', 'Bukti pelaksanaan berhasil disimpan.');

        return redirect()->route('pelaksanaans.index');
    }

    public function render()
    {
        return view('livewire.pelaksanaans.pelaksanaan-form')
            ->layout('layouts.app');
    }
}