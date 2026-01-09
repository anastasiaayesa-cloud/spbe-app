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
    public $persuratan_id, $nama_surat, $file_pdf, $existing_pdf, $persuratanKategoriList = [], $persuratan_kategori_id, $perihal, $jenis_anggaran;
    // public $persuratan_id, $nama_surat, $file_pdf, $existing_pdf, $tanggal_upload, $persuratanKategoriList = [], $persuratan_kategori_id;

    public $rencana_id;
    public $penerima_surat; // Field ini akan menampung nama-nama pegawai
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
        $this->rencana_id = request()->query('rencana_id');

        $this->persuratanKategoriList = PersuratanKategori::orderBy('nama_kategori')->get();

        // 2. LOGIKA OTOMATIS TARIK PEGAWAI (Jika Mode Create dan ada rencana_id)
        if (!$persuratan_id && $this->rencana_id) {
            $rencana = \App\Models\Rencana::with('kepegawaians')->find($this->rencana_id);
            
            if ($rencana && $rencana->kepegawaians->isNotEmpty()) {
                // Menggabungkan nama-nama pegawai menjadi satu string untuk input "Penerima Surat"
                $this->penerima_surat = $rencana->kepegawaians->pluck('nama')->implode(', ');
                
                // Opsional: Jika Anda juga menggunakan sistem ID untuk pegawaiSelected
                $this->pegawaiSelected = $rencana->kepegawaians->pluck('id')->toArray();
            }
        }
        // EDIT MODE
        if ($persuratan_id) {
            $this->persuratan_id = $persuratan_id;

            $persuratan = Persuratan::with('kepegawaians')->findOrFail($persuratan_id);

            $this->nama_surat = $persuratan->nama_surat;
            $this->penerima_surat = $persuratan->penerima_surat;
            $this->file_pdf = $persuratan->file_pdf;
            $this->persuratan_kategori_id = $persuratan->persuratan_kategori_id;
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
        return [
            'nama_surat'             => 'required|min:3',
            'penerima_surat'         => 'required',
            'persuratan_kategori_id' => 'required',
            'perihal'                => 'required',
            'file_pdf'               => $this->persuratan_id ? 'nullable|mimes:pdf|max:2048' : 'required|mimes:pdf|max:2048',
            'jenis_anggaran'         => 'required',
        ];
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
                // 'tanggal_upload' => $this->tanggal_upload,
                // 'kepada' => $this->kepada,
                'perihal' => $this->perihal,
                'jenis_aggaran' => $this->jenis_anggaran


            ]);
            $persuratan->kepegawaians()->sync($this->pegawaiSelected);

            session()->flash('success', 'Persuratan berhasil diedit.');
            return redirect()->route('persuratans.index');
        } else {
            $persuratan = Persuratan::create([
                'nama_surat'             => $this->nama_surat,
                'penerima_surat'         => $this->penerima_surat,
                'file_pdf'               => $pdfPath,
                'perihal'                => $this->perihal,
                'jenis_anggaran'         => $this->jenis_anggaran,
                'persuratan_kategori_id' => $this->persuratan_kategori_id,
            ]);
        
            // Simpan ke pivot pegawai (sudah ada di kode kamu)
            $persuratan->kepegawaians()->sync($this->pegawaiSelected);
        
            // TAMBAHKAN INI: Simpan ke pivot rencana
            if ($this->rencana_id) {
                $persuratan->rencanas()->attach($this->rencana_id);
            }
            
            session()->flash('success', 'Persuratan berhasil ditambahkan.');
            return redirect()->route('persuratans.index');
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
