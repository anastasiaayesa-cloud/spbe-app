<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pelaksanaan;
use Illuminate\Support\Facades\Storage;
use App\Models\PelaksanaanJenis;



class PelaksanaanForm extends Component
{
    use WithFileUploads;
    public $pelaksanaan_id, $file_pdf, $existing_pdf, $tanggal_upload, $pelaksanaan_jenis_id, $pelaksanaanJenisList = [];

    public function mount($pelaksanaan_id = null)
    {
        // INI WAJIB ADA (ISI DROPDOWN)
        $this->pelaksanaanJenisList = PelaksanaanJenis::orderBy('nama')->get();

        if ($pelaksanaan_id) {
            $this->pelaksanaan_id = $pelaksanaan_id;

            $pelaksanaan = Pelaksanaan::findOrFail($pelaksanaan_id);

            $this->existing_pdf = $pelaksanaan->file_pdf;
            $this->pelaksanaan_jenis_id = $pelaksanaan->pelaksanaan_jenis_id;
            $this->tanggal_upload = $pelaksanaan->tanggal_upload;
        }
    }

    public function rules()
    {
        $rules = [
            'pelaksanaan_jenis_id' => 'required|exists:pelaksanaan_jenis,id',
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

        // setelah lulus validasi, lakukan sintaks dibawah
        if ($this->pelaksanaan_id) {
            $pelaksanaan = Pelaksanaan::findOrFail($this->pelaksanaan_id);

            if ($pelaksanaan->file_pdf && storage_path('app/public/' . $pelaksanaan->file_pdf)) {
                Storage::delete('public/' . $pelaksanaan->file_pdf);
            }
            $pdfPath = $this->file_pdf->store('pelaksanaan', 'public');

            $pelaksanaan->update([
                'pelaksanaan_jenis_id' => $this->pelaksanaan_jenis_id,
                'file_pdf' => $pdfPath,
                'tanggal_upload' => $this->tanggal_upload,


            ]);

            session()->flash('success', 'Bukti berhasil diedit.');
            return redirect()->route('pelaksanaans.index');
        } else {
            // dd($this->pelaksanaan_jenis_id);
            $pelaksanaan = Pelaksanaan::create([
                'pelaksanaan_jenis_id' => $this->pelaksanaan_jenis_id,
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
