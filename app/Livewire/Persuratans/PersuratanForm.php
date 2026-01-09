<?php

namespace App\Livewire\Persuratans;

use App\Models\Kepegawaian;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Persuratan;
use Illuminate\Support\Facades\Storage;
use App\Models\PersuratanKategori;
use App\Models\Rencana;


class PersuratanForm extends Component
{
    use WithFileUploads;
    public $persuratan_id, $nama_surat, $file_pdf,$rencana_id, $existing_pdf, $tanggal_upload, $persuratanKategoriList = [], $persuratan_kategori_id, $kepada, $perihal, $jenis_anggaran;
    // public $persuratan_id, $nama_surat, $file_pdf, $existing_pdf, $tanggal_upload, $persuratanKategoriList = [], $persuratan_kategori_id;

    public $pegawaiAllowed = [];   // pegawai dari rencana

    public $pegawaiSearch = '';
    public $pegawaiResults = [];
    public $pegawaiSelected = []; // array of pegawai_id
    public $showPegawaiDropdown = false;

    public function mount($persuratan_id = null, $rencana_id = null)
{
    $this->persuratanKategoriList = PersuratanKategori::orderBy('nama_kategori')->get();

    // ==== RENCANA ====
    $this->rencana_id = $rencana_id ?? request('rencana_id');

    if ($this->rencana_id) {
        $rencana = Rencana::with('kepegawaians')->findOrFail($this->rencana_id);
        $this->pegawaiAllowed = $rencana->kepegawaians;
    }

    if ($this->rencana_id) {
    $rencana = Rencana::with('kepegawaians')->findOrFail($this->rencana_id);

    $this->pegawaiAllowed = $rencana->kepegawaians;

    // 🔥 AUTO ISI TANGGAL DARI RENCANA
    $this->tanggal_upload = $rencana->tanggal_kegiatan;
}

    // ==== EDIT MODE ====
    if ($persuratan_id) {
        $this->persuratan_id = $persuratan_id;

        $persuratan = Persuratan::with('kepegawaians')->findOrFail($persuratan_id);

        $this->nama_surat = $persuratan->nama_surat;
        $this->tanggal_upload = $persuratan->tanggal_upload;
        $this->persuratan_kategori_id = $persuratan->persuratan_kategori_id;
        $this->perihal = $persuratan->perihal;
        $this->jenis_anggaran = $persuratan->jenis_anggaran;

        $this->pegawaiSelected = $persuratan->kepegawaians->pluck('id')->toArray();
    }
}

    public function updatedPegawaiSearch()
{
    if (!$this->pegawaiSearch) {
        $this->pegawaiResults = [];
        return;
    }

    $this->pegawaiResults = collect($this->pegawaiAllowed)
        ->filter(fn ($p) =>
            str_contains(strtolower($p->nama), strtolower($this->pegawaiSearch))
        )
        ->whereNotIn('id', $this->pegawaiSelected)
        ->values()
        ->toArray();

    $this->showPegawaiDropdown = true;
}
public function openDropdown()
{
    $this->showPegawaiDropdown = true;

    $this->pegawaiResults = collect($this->pegawaiAllowed)
        ->whereNotIn('id', $this->pegawaiSelected)
        ->take(10)
        ->values()
        ->toArray();
}
    public function addPegawai($pegawaiId)
{
    if (!in_array($pegawaiId, $this->pegawaiSelected)) {
        $this->pegawaiSelected[] = $pegawaiId;
    }

    $this->pegawaiSearch = '';
    $this->pegawaiResults = [];
}

public function removePegawai($pegawaiId)
{
    $this->pegawaiSelected = array_values(
        array_diff($this->pegawaiSelected, [$pegawaiId])
    );
}

    public function getPegawaiSelectedDataProperty()
{
    return collect($this->pegawaiAllowed)
        ->whereIn('id', $this->pegawaiSelected);
}
   
    // public function showAllPegawai()
    // {
    //     $this->showPegawaiDropdown = true;

    //     $this->pegawaiResults = Kepegawaian::query()
    //         ->whereNotIn('id', $this->pegawaiSelected)
    //         ->orderBy('nama')
    //         ->limit(20)
    //         ->get()
    //         ->toArray();
    // }

    public function closeDropdown()
    {
        $this->showPegawaiDropdown = false;
    }

    public function rules()
    {
        $rules = [
            'nama_surat' => 'required|string|max:255',
            'file_pdf' => 'required|mimes:pdf',
            'tanggal_upload' => 'required|date',
            // 'kepada' => 'required|string',
            'perihal' => 'required|string',
            'jenis_anggaran' => 'nullable|in:BPMP,Luar BPMP',
        ];

        return $rules;
    }

    public function submit()
{
    $this->validate();

    // ==== UPLOAD FILE ====
    if ($this->file_pdf) {
        $pdfPath = $this->file_pdf->store('persuratan', 'public');
    }

    // ==== EDIT MODE ====
    if ($this->persuratan_id) {
        $persuratan = Persuratan::findOrFail($this->persuratan_id);

        // hapus file lama
        if ($persuratan->file_pdf && Storage::disk('public')->exists($persuratan->file_pdf)) {
            Storage::disk('public')->delete($persuratan->file_pdf);
        }

        $persuratan->update([
            'nama_surat'      => $this->nama_surat,
            'file_pdf'        => $pdfPath,
            'tanggal_upload'  => $this->tanggal_upload,
            'perihal'         => $this->perihal,
            'jenis_anggaran'  => $this->jenis_anggaran,
            'rencana_id'      => $this->rencana_id, // 🔥 PENTING
        ]);

        // sync penerima
        $persuratan->kepegawaians()->sync($this->pegawaiSelected);

        session()->flash('success', 'Persuratan berhasil diperbarui.');
        return redirect()->route('persuratans.index');
    }

    // ==== CREATE MODE ====
    $persuratan = Persuratan::create([
        'nama_surat'      => $this->nama_surat,
        'file_pdf'        => $pdfPath,
        'tanggal_upload'  => $this->tanggal_upload,
        'perihal'         => $this->perihal,
        'jenis_anggaran'  => $this->jenis_anggaran,
        'rencana_id'      => $this->rencana_id, // 🔥 KUNCI STATUS
    ]);

    // simpan penerima
    $persuratan->kepegawaians()->sync($this->pegawaiSelected);

    session()->flash('success', 'Persuratan berhasil diupload.');
    return redirect()->route('persuratans.index');
}

    public function delete()
    {

        $persuratan = Persuratan::findOrFail($this->persuratan_id);

        if ($persuratan->file_pdf && storage_path('app/public/' . $persuratan->file_pdf)) {
            Storage::delete('public/' . $persuratan->file_pdf);
        }

        Persuratan::where('id', $this->persuratan_id)->delete();

        session()->flash('success', 'Persuratan berhasil dihapus.');
        return redirect()->route('persuratans.index');
    }

    public function render()
    {
        return view('livewire.persuratans.persuratan-form')
            ->layout('layouts.app');
    }
}
