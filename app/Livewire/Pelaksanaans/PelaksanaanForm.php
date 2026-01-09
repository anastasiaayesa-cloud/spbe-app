<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Rencana;
use App\Models\Pelaksanaan;
use App\Models\PelaksanaanJenis;
use Illuminate\Support\Facades\Storage;

class PelaksanaanForm extends Component
{
    use WithFileUploads;

    public $pelaksanaan_id;
    public $rencana_id;
    public $tanggal_upload;

    // INFO RENCANA
public $rencana;

    // DROPDOWN
    public $pelaksanaanJenisList = [];

    // MULTI LAMPIRAN
    public $lampirans = [];

    // public $nominal;

    public function mount($pelaksanaan_id = null, $rencana_id = null)
{
    $this->pelaksanaanJenisList = PelaksanaanJenis::orderBy('nama')->get();

    // CREATE
    if ($rencana_id) {
        $this->rencana_id = $rencana_id;
        $this->rencana = Rencana::findOrFail($rencana_id);
        
        $this->setTanggalDariRencana();
        $this->rencana_id = request('rencana_id');

        $this->lampirans = [[
    'file' => null,
    'pelaksanaan_jenis_id' => '',
    'nominal' => null,
    'keterangan' => '',
]];
    }


    // EDIT
    if ($pelaksanaan_id) {
        $pelaksanaan = Pelaksanaan::findOrFail($pelaksanaan_id);

        $this->pelaksanaan_id = $pelaksanaan->id;
        $this->rencana_id = $pelaksanaan->rencana_id;
        
        $this->rencana = Rencana::findOrFail($pelaksanaan->rencana_id);
        $this->setTanggalDariRencana();
    }
}

private function setTanggalDariRencana()
{
    if ($this->rencana) {
        $this->tanggal_upload = $this->rencana->tanggal_kegiatan;
    }
}

    protected function rules()
    {
        return [
            'rencana_id' => 'required|exists:rencanas,id',
            'lampirans.*.file' => 'required|mimes:pdf',
            'lampirans.*.pelaksanaan_jenis_id' => 'required|exists:pelaksanaan_jenis,id',
            'lampirans.*.nominal' => 'nullable|numeric|min:0',
            'lampirans.*.keterangan' => 'nullable|string|max:255',
        ];
    }

    public function addLampiran()
    {
        $this->lampirans[] = [
            'file' => null,
            'pelaksanaan_jenis_id' => '',
            'nominal' => null,
            'keterangan' => '',
        ];
    }

    public function removeLampiran($index)
    {
        unset($this->lampirans[$index]);
        $this->lampirans = array_values($this->lampirans);
    }

    public function submit()
    {
        $this->validate();

       foreach ($this->lampirans as $lampiran) {

    $pdfPath = $lampiran['file']->store('pelaksanaan', 'public');

    Pelaksanaan::create([
        'rencana_id' => $this->rencana_id,
        'pelaksanaan_jenis_id' => $lampiran['pelaksanaan_jenis_id'],
        'nominal' => $lampiran['nominal'] ?? null,
        'file_pdf' => $pdfPath,
        'keterangan' => $lampiran['keterangan'] ?? null,
        'tanggal_upload' => $this->tanggal_upload,
    ]);
}



        session()->flash('success', 'Bukti berhasil disimpan.');
        return redirect()->route('pelaksanaans.index');
    }

    public function render()
    {
        return view('livewire.pelaksanaans.pelaksanaan-form')
            ->layout('layouts.app');
    }
}
