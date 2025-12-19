<?php

namespace App\Livewire\Persuratans;

use App\Models\Kepegawaian;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Persuratan;
use Illuminate\Support\Facades\Storage;
use App\Models\PersuratanKategori;

class PersuratanForm extends Component
{
    use WithFileUploads;
    public $persuratan_id, $nama_surat, $file_pdf, $existing_pdf, $tanggal_upload, $persuratanKategoriList = [], $persuratan_kategori_id, $kepada, $perihal, $jenis_anggaran;
    // public $persuratan_id, $nama_surat, $file_pdf, $existing_pdf, $tanggal_upload, $persuratanKategoriList = [], $persuratan_kategori_id;

    public $pegawaiSearch = '';
    public $pegawaiResults = [];
    public $pegawaiSelected = []; // array of pegawai_id
    public $showPegawaiDropdown = false;

    public function mount($persuratan_id = null)
    {
        // INIT WAJIB (CREATE MODE)
        $this->pegawaiSelected = [];
        $this->pegawaiResults = [];
        $this->pegawaiSearch = '';

        $this->persuratanKategoriList = PersuratanKategori::orderBy('nama_kategori')->get();

        // EDIT MODE
        if ($persuratan_id) {
            $this->persuratan_id = $persuratan_id;

            $persuratan = Persuratan::with('kepegawaians')->findOrFail($persuratan_id);

            $this->nama_surat = $persuratan->nama_surat;
            $this->file_pdf = $persuratan->file_pdf;
            $this->tanggal_upload = $persuratan->tanggal_upload;
            $this->persuratan_kategori_id = $persuratan->persuratan_kategori_id;
            $this->kepada = $persuratan->kepada;
            $this->jenis_anggaran = $persuratan->jenis_anggaran;
            $this->perihal = $persuratan->perihal;



            $this->pegawaiSelected = $persuratan
                ->kepegawaians
                ->pluck('id')
                ->toArray();
        }
    }

    public function updatedPegawaiSearch($value)
    {
        // Jika kosong, sembunyikan dropdown
        if (trim($value) === '') {
            $this->showPegawaiDropdown = false;
            $this->pegawaiResults = [];
            return;
        }

        // Tampilkan dropdown dan filter berdasarkan input
        $this->showPegawaiDropdown = true;

        $this->pegawaiResults = Kepegawaian::query()
            ->whereNotIn('id', $this->pegawaiSelected)
            ->where('nama', 'like', '%' . $value . '%')
            ->orderBy('nama')
            ->limit(20)
            ->get()
            ->toArray();
    }

    public function addPegawai($pegawaiId)
    {
        if (!in_array($pegawaiId, $this->pegawaiSelected)) {
            $this->pegawaiSelected[] = $pegawaiId;
        }

        // Reset dan sembunyikan dropdown
        $this->pegawaiSearch = '';
        $this->pegawaiResults = [];
        $this->showPegawaiDropdown = false;
    }

    public function getPegawaiSelectedDataProperty()
    {
        return Kepegawaian::whereIn('id', $this->pegawaiSelected)->get();
    }

    public function removePegawai($pegawaiId)
    {
        $this->pegawaiSelected = array_values(
            array_diff($this->pegawaiSelected, [$pegawaiId])
        );
    }

    public function showAllPegawai()
    {
        $this->showPegawaiDropdown = true;

        $this->pegawaiResults = Kepegawaian::query()
            ->whereNotIn('id', $this->pegawaiSelected)
            ->orderBy('nama')
            ->limit(20)
            ->get()
            ->toArray();
    }

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

        if ($this->file_pdf) {
            $pdfPath = $this->file_pdf->store('persuratan', 'public');
        }

        if ($this->persuratan_id) {
            $persuratan = Persuratan::findOrFail($this->persuratan_id);

            if ($persuratan->file_pdf && storage_path('app/public/' . $persuratan->file_pdf)) {
                Storage::delete('public/' . $persuratan->file_pdf);
            }
            $pdfPath = $this->file_pdf->store('persuratan', 'public');

            $persuratan->update([
                'nama_surat' => $this->nama_surat,
                'file_pdf' => $pdfPath,
                'tanggal_upload' => $this->tanggal_upload,
                // 'kepada' => $this->kepada,
                'perihal' => $this->perihal,
                'jenis_aggaran' => $this->jenis_anggaran


            ]);
            $persuratan->kepegawaians()->sync($this->pegawaiSelected);

            session()->flash('success', 'Persuratan berhasil diedit.');
            return redirect()->route('persuratans.index');
        } else {
            $persuratan = Persuratan::create([
                'nama_surat' => $this->nama_surat,
                'file_pdf' => $pdfPath,
                'tanggal_upload' => $this->tanggal_upload,
                // 'kepada' => $this->kepada,
                'perihal' => $this->perihal,
                'jenis_aggaran' => $this->jenis_anggaran
            ]);

            $persuratan->kepegawaians()->sync($this->pegawaiSelected);

            session()->flash('success', 'Persuratan baru berhasil ditambahkan.');
            return redirect()->route('persuratans.create');
        }
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
