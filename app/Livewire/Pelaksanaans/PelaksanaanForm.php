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

    $pelaksanaan = Pelaksanaan::with('rencana')
        ->findOrFail($pelaksanaan_id);

    $this->pelaksanaan_id = $pelaksanaan->id;
    $this->rencana_id = $pelaksanaan->rencana_id;
    $this->rencana = $pelaksanaan->rencana;
    $this->tanggal_upload = $this->rencana->tanggal_kegiatan;

    // ⭐ ambil semua bukti untuk rencana + pegawai
    $data = Pelaksanaan::where('rencana_id', $this->rencana_id)
        ->when(auth()->user()->kepegawaian, function ($q) {
            $q->where('kepegawaian_id', auth()->user()->kepegawaian->id);
        })
        ->get();

    $this->lampirans = $data->map(function ($item) {
        return [
            'id' => $item->id, // ⭐ penting untuk update & delete
            'file' => null,
            'file_existing' => $item->file_pdf,
            'pelaksanaan_jenis_id' => $item->pelaksanaan_jenis_id,
            'nominal' => $item->nominal,
            'keterangan' => $item->keterangan,
        ];
    })->toArray();
}
    }

   protected function rules()
{
    $rules = [
        'rencana_id' => 'required|exists:rencanas,id',
    ];

    foreach ($this->lampirans as $index => $lampiran) {

        $rules["lampirans.$index.pelaksanaan_jenis_id"] = 'required|exists:pelaksanaan_jenis,id';
        $rules["lampirans.$index.nominal"] = 'nullable|numeric|min:0';
        $rules["lampirans.$index.keterangan"] = 'nullable|string|max:255';

        // ⭐ FILE OPTIONAL SAAT EDIT
        if (!isset($lampiran['file_existing'])) {
            $rules["lampirans.$index.file"] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
        } else {
            $rules["lampirans.$index.file"] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
        }
    }

    return $rules;
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
    if (isset($this->lampirans[$index]['id'])) {
        Pelaksanaan::find($this->lampirans[$index]['id'])?->delete();
    }

    unset($this->lampirans[$index]);
    $this->lampirans = array_values($this->lampirans);
}

    public function submit()
{
    $this->validate();

    $user = auth()->user();

    // 🛡️ ADMIN BOLEH LEWAT
    if (! $user->hasRole('admin') && ! $user->kepegawaian) {
        abort(403, 'User belum terhubung ke data pegawai');
    }

    foreach ($this->lampirans as $lampiran) {

    // ⭐ HANDLE FILE
    if (!empty($lampiran['file'])) {

        $file = $lampiran['file'];
        $extension = strtolower($file->getClientOriginalExtension());

        $fileType = in_array($extension, ['jpg','jpeg','png']) ? 'image' : 'pdf';
        $filePath = $file->store('pelaksanaan', 'public');

    } else {

        $filePath = $lampiran['file_existing'] ?? null;
        $fileType = 'pdf';
    }

    $nominal = $lampiran['pelaksanaan_jenis_id'] == $this->laporanJenisId
        ? 0
        : ($lampiran['nominal'] ?? 0);

    // ⭐ UPDATE ATAU CREATE
    if (isset($lampiran['id'])) {

        Pelaksanaan::find($lampiran['id'])->update([
            'pelaksanaan_jenis_id' => $lampiran['pelaksanaan_jenis_id'],
            'nominal' => $nominal,
            'file_pdf' => $filePath,
            'file_type' => $fileType,
            'keterangan' => $lampiran['keterangan'],
        ]);

    } else {

        Pelaksanaan::create([
            'rencana_id' => $this->rencana_id,
            'kepegawaian_id' => auth()->user()->hasRole('admin')
                ? null
                : auth()->user()->kepegawaian->id,
            'pelaksanaan_jenis_id' => $lampiran['pelaksanaan_jenis_id'],
            'nominal' => $nominal,
            'file_pdf' => $filePath,
            'file_type' => $fileType,
            'keterangan' => $lampiran['keterangan'],
            'tanggal_upload' => $this->tanggal_upload,
        ]);
    }
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
