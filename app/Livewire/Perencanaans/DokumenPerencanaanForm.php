<?php

namespace App\Livewire\Perencanaans;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DokumenPerencanaan;
use Illuminate\Support\Facades\Storage;

class DokumenPerencanaanForm extends Component
{
    use WithFileUploads;
    public $dokumenperencanaan_id, $nama, $file_pdf, $tanggal;

    public function mount($dokumenperencanaan_id = null)
    {
        // $this->persuratanKategoriList = PersuratanKategori::orderBy('nama_kategori')->get();
        // kalau parameter ada (edit mode)
        if ($dokumenperencanaan_id) {
            $this->dokumenperencanaan_id = $dokumenperencanaan_id;
            

            $dokumenperencanaan = DokumenPerencanaan::findOrFail($dokumenperencanaan_id);

            
            $existing_pdf = $dokumenperencanaan->file_pdf;
            $this->nama = $dokumenperencanaan->nama;
            $this->file_pdf = $dokumenperencanaan->file_pdf;
            $this->tanggal = $dokumenperencanaan->tanggal;
        }
    }

    public function rules()
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'file_pdf' => 'required|mimes:pdf',
            'tanggal' => 'required|date',
        ];

        return $rules;
    }

    public function submit()
    {
        $this->validate();
        if ($this->file_pdf) {
            $pdfPath = $this->file_pdf->store('dokumenperencanaan', 'public');
        } 
        // else {
        //     $pdfPath = $this->existing_pdf; // pakai file lama
        // }

        // setelah lulus validasi, lakukan sintaks dibawah
        if ($this->dokumenperencanaan_id) {
            $dokumenperencanaan = DokumenPerencanaan::findOrFail($this->dokumenperencanaan_id);

            if ($dokumenperencanaan->file_pdf&& storage_path('app/public/' . $dokumenperencanaan->file_pdf)) {
            Storage::delete('public/' . $dokumenperencanaan->file_pdf);
        }
            $pdfPath = $this->file_pdf->store('dokumenperencanaan', 'public');

            $dokumenperencanaan->update([
                'nama' => $this->nama,
                'file_pdf' => $pdfPath,
                'tanggal' => $this->tanggal,

            ]);

            // session()->flash('success', 'Persuratan berhasil diedit.');
            return redirect()->route('dokumen-perencanaans.index');
        } else {
            $dokumenperencanaan = DokumenPerencanaan::create([
                'nama' => $this->nama,
                'file_pdf' => $pdfPath,
                'tanggal' => $this->tanggal,
            ]);

            session()->flash('success', 'Dokumen baru berhasil ditambahkan.');
            return redirect()->route('dokumen-perencanaan.create');
        }
    }

    //     public function delete()
    // {
        
    //     $persuratan = Persuratan::findOrFail($this->persuratan_id);

    //         if ($persuratan->file_pdf&& storage_path('app/public/' . $persuratan->file_pdf)) {
    //         Storage::delete('public/' . $persuratan->file_pdf);
    //     }

    //     Persuratan::where('id', $this->persuratan_id)->delete();

    //     session()->flash('success', 'Persuratan berhasil dihapus.');
    //     return redirect()->route('persuratans.index');
    // }

    public function render()
    {
        return view('livewire.perencanaans.dokumen-perencanaan-form')
        ->layout('layouts.app');
    }
}
