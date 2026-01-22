<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Rencana;
use App\Models\Pelaksanaan;
use App\Models\PelaksanaanJenis;

class PelaksanaanForm extends Component
{
    use WithFileUploads;

    public $pelaksanaan_id;
    public $rencana_id;
    public $tanggal_upload;
    public $laporanJenisId;


    // INFO RENCANA
    public $rencana;

    // DROPDOWN
    public $pelaksanaanJenisList = [];

    // MULTI LAMPIRAN
    public $lampirans = [];

    public function mount($pelaksanaan_id = null)
    {

        $this->pelaksanaanJenisList = PelaksanaanJenis::orderBy('nama')->get();

        // ambil ID jenis laporan
        $this->laporanJenisId = PelaksanaanJenis::where('nama', 'Laporan Kegiatan')->value('id');

        $this->pelaksanaanJenisList = PelaksanaanJenis::orderBy('nama')->get();

        // Ambil rencana dari query string
        $this->rencana_id = request()->query('rencana_id');

        if ($this->rencana_id) {
            $this->rencana = Rencana::findOrFail($this->rencana_id);
            $this->tanggal_upload = $this->rencana->tanggal_kegiatan;
        }

        // Default 1 lampiran
        $this->lampirans = [[
            'file' => null,
            'pelaksanaan_jenis_id' => '',
            'nominal' => null,
            'keterangan' => '',
        ]];

        // MODE EDIT
        if ($pelaksanaan_id) {
            $pelaksanaan = Pelaksanaan::findOrFail($pelaksanaan_id);

            $this->pelaksanaan_id = $pelaksanaan->id;
            $this->rencana_id = $pelaksanaan->rencana_id;
            $this->rencana = $pelaksanaan->rencana;
            $this->tanggal_upload = $this->rencana->tanggal_kegiatan;
        }
    }

    protected function rules()
    {
        return [
            'rencana_id' => 'required|exists:rencanas,id',
            'lampirans.*.file' => 'required|file|mimes:pdf',
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

        // 🔥 LOGIKA REVISI
        $nominal = $lampiran['pelaksanaan_jenis_id'] == $this->laporanJenisId
            ? 0
            : ($lampiran['nominal'] ?? 0);

        Pelaksanaan::create([
            'rencana_id' => $this->rencana_id,
            'pelaksanaan_jenis_id' => $lampiran['pelaksanaan_jenis_id'],
            'nominal' => $nominal,
            'file_pdf' => $pdfPath,
            'keterangan' => $lampiran['keterangan'],
            'tanggal_upload' => $this->tanggal_upload,
        ]);
    }

    session()->flash('success', 'Bukti pelaksanaan berhasil disimpan.');
    return redirect()->route('pelaksanaans.index');
}

    public function render()
    {
        return view('livewire.pelaksanaans.pelaksanaan-form')
            ->layout('layouts.app');
    }
}
