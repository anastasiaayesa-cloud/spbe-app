<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pelaksanaan;
use Illuminate\Support\Facades\Storage;


class PelaksanaanForm extends Component
{
    use WithFileUploads;
    public $pelaksanaan_id, $jenis_bukti, $file_pdf, $existing_pdf, $tanggal_upload;

    public function mount($pelaksanaan_id = null)
    {
        // $this->persuratanKategoriList = PersuratanKategori::orderBy('nama_kategori')->get();
        // kalau parameter ada (edit mode)
        if ($pelaksanaan_id) {
            $this->pelaksanaan_id = $pelaksanaan_id;


            $pelaksanaan = Pelaksanaan::findOrFail($pelaksanaan_id);


            $this->existing_pdf = $pelaksanaan->file_pdf;
            $this->jenis_bukti = $pelaksanaan->jenis_bukti;
            $this->file_pdf = $pelaksanaan->file_pdf; // file lama
            $this->tanggal_upload = $pelaksanaan->tanggal_upload;
        }
    }

    public function rules()
    {
        $rules = [
            'jenis_bukti' => 'required|string|max:255',
            'file_pdf' => 'required|mimes:pdf',
            'tanggal_upload' => 'required|date',

        ];

        return $rules;
    }

    public function submit()
    {
        $this->validate();
        if ($this->file_pdf) {
            $pdfPath = $this->file_pdf->store('pelaksanaan', 'public');
        }
        // else {
        //     $pdfPath = $this->existing_pdf; // pakai file lama
        // }

        // setelah lulus validasi, lakukan sintaks dibawah
        if ($this->pelaksanaan_id) {
            $pelaksanaan = Pelaksanaan::findOrFail($this->pelaksanaan_id);

            if ($pelaksanaan->file_pdf && storage_path('app/public/' . $pelaksanaan->file_pdf)) {
                Storage::delete('public/' . $pelaksanaan->file_pdf);
            }
            $pdfPath = $this->file_pdf->store('pelaksanaan', 'public');

            $pelaksanaan->update([
                'jenis_bukti' => $this->jenis_bukti,
                'file_pdf' => $pdfPath,
                'tanggal_upload' => $this->tanggal_upload,


            ]);

            session()->flash('success', 'Bukti berhasil diedit.');
            return redirect()->route('pelaksanaans.index');
        } else {
            $pelaksanaan = Pelaksanaan::create([
                'jenis_bukti' => $this->jenis_bukti,
                'file_pdf' => $pdfPath,
                'tanggal_upload' => $this->tanggal_upload,
            ]);

            session()->flash('success', 'Bukti baru berhasil ditambahkan.');
            return redirect()->route('pelaksanaans.create');
        }
    }

    public function delete()
    {

        $pelaksanaan = Pelaksanaan::findOrFail($this->pelaksanaan_id);

        if ($pelaksanaan->file_pdf && storage_path('app/public/' . $pelaksanaan->file_pdf)) {
            Storage::delete('public/' . $pelaksanaan->file_pdf);
        }

        Pelaksanaan::where('id', $this->pelaksanaan_id)->delete();

        session()->flash('success', 'Pelaksanaan berhasil dihapus.');
        return redirect()->route('pelaksanaans.index');
    }

    public function render()
    {
        return view('livewire.pelaksanaans.pelaksanaan-form')
            ->layout('layouts.app');
    }
}
