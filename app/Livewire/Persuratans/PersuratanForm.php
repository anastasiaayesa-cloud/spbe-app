<?php

namespace App\Livewire\Persuratans;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Persuratan;
use Illuminate\Support\Facades\Storage;
use App\Models\PersuratanKategori;


class PersuratanForm extends Component
{
    use WithFileUploads;
    public $persuratan_id, $nama_surat, $file_pdf, $existing_pdf, $tanggal_upload, $persuratanKategoriList=[], $persuratan_kategori_id;

    public function mount($persuratan_id = null)
    {
        $this->persuratanKategoriList = PersuratanKategori::orderBy('nama_kategori')->get();
        // kalau parameter ada (edit mode)
        if ($persuratan_id) {
            $this->persuratan_id = $persuratan_id;
            

            $persuratan = Persuratan::findOrFail($persuratan_id);

            
            $existing_pdf = $persuratan->file_pdf;
            $this->nama_surat = $persuratan->nama_surat;
            $this->file_pdf = $persuratan->file_pdf; // file lama
            $this->tanggal_upload = $persuratan->tanggal_upload;
            $this->persuratan_kategori_id = $persuratan->persuratan_kategori_id;
            
        }
    }

    public function rules()
    {
        $rules = [
            'nama_surat' => 'required|string|max:255',
            'file_pdf' => 'required|mimes:pdf',
            'tanggal_upload' => 'required|date',
        ];

        return $rules;
    }

    public function submit()
    {
        $this->validate();
        if ($this->file_pdf) {
            $pdfPath = $this->file_pdf->store('persuratan', 'public');
        } 
        // else {
        //     $pdfPath = $this->existing_pdf; // pakai file lama
        // }

        // setelah lulus validasi, lakukan sintaks dibawah
        if ($this->persuratan_id) {
            $persuratan = Persuratan::findOrFail($this->persuratan_id);

            if ($persuratan->file_pdf&& storage_path('app/public/' . $persuratan->file_pdf)) {
            Storage::delete('public/' . $persuratan->file_pdf);
        }
            $pdfPath = $this->file_pdf->store('persuratan', 'public');

            $persuratan->update([
                'nama_surat' => $this->nama_surat,
                'file_pdf' => $pdfPath,
                'tanggal_upload' => $this->tanggal_upload,

            ]);

            session()->flash('success', 'Persuratan berhasil diedit.');
            return redirect()->route('persuratans.index');
        } else {
            $persuratan = Persuratan::create([
                'nama_surat' => $this->nama_surat,
                'file_pdf' => $pdfPath,
                'tanggal_upload' => $this->tanggal_upload,
            ]);

            session()->flash('success', 'Persuratan baru berhasil ditambahkan.');
            return redirect()->route('persuratans.create');
        }
    }

        public function delete()
    {
        
        $persuratan = Persuratan::findOrFail($this->persuratan_id);

            if ($persuratan->file_pdf&& storage_path('app/public/' . $persuratan->file_pdf)) {
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
