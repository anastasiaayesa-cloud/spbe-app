<?php

namespace App\Livewire\Perencanaans;

use Livewire\Component;
use App\Models\Perencanaan;

class PerencanaanForm extends Component
{
    public $perencanaan_id, $komponen, $uraian_komponen, $sub_komponen, $uraian_sub_komponen, $nama_aktivitas, $rencana_mulai, $rencana_selesai, $realisasi_mulai, $realisasi_selesai, $keterangan, $terlaksana_id;

    public function mount($perencanaan_id = null)
    {
        // kalau parameter ada (edit mode)
        if ($perencanaan_id) {
            $this->perencanaan_id = $perencanaan_id;

            $perencanaan = Perencanaan::findOrFail($perencanaan_id);
            $this->komponen = $perencanaan->komponen;
            $this->uraian_komponen = $perencanaan->uraian_komponen;
            $this->sub_komponen = $perencanaan->sub_komponen;
            $this->uraian_sub_komponen = $perencanaan->uraian_sub_komponen;
            $this->nama_aktivitas = $perencanaan->nama_aktivitas;
            $this->rencana_mulai = $perencanaan->rencana_mulai;
            $this->rencana_selesai = $perencanaan->rencana_selesai;
            $this->keterangan = $perencanaan->keterangan;
        }
    }

    public function rules()
    {
        $rules = [
            'komponen' => 'required|string|max:255',
            'uraian_komponen' => 'nullable|string',
            'sub_komponen' => 'required|string|max:255',
            'uraian_sub_komponen' => 'nullable|string',
            'nama_aktivitas' => 'required|string|max:255',
            'rencana_mulai' => 'required|date',
            'rencana_selesai' => 'required|date',
            'keterangan' => 'nullable|string',
        ];

        return $rules;
    }

    public function submit()
    {
        $this->validate();

        // setelah lulus validasi, lakukan sintaks dibawah
        if ($this->perencanaan_id) {
            $perencanaan = Perencanaan::findOrFail($this->perencanaan_id);
            $perencanaan->update([
                'komponen' => $this->komponen,
                'uraian_komponen' => $this->uraian_komponen,
                'sub_komponen' => $this->sub_komponen,
                'uraian_sub_komponen' => $this->uraian_sub_komponen,
                'nama_aktivitas' => $this->nama_aktivitas,
                'rencana_mulai' => $this->rencana_mulai,
                'rencana_selesai' => $this->rencana_selesai,
                'keterangan' => $this->keterangan,
            ]);

            session()->flash('success', 'Perencanaan berhasil diedit.');
            return redirect()->route('perencanaans.index');
        } else {
            $perencanaan = Perencanaan::create([
                'komponen' => $this->komponen,
                'uraian_komponen' => $this->uraian_komponen,
                'sub_komponen' => $this->sub_komponen,
                'uraian_sub_komponen' => $this->uraian_sub_komponen,
                'nama_aktivitas' => $this->nama_aktivitas,
                'rencana_mulai' => $this->rencana_mulai,
                'rencana_selesai' => $this->rencana_selesai,
                'keterangan' => $this->keterangan,
            ]);

            session()->flash('success', 'Perencanaan baru berhasil ditambahkan.');
            return redirect()->route('perencanaans.create');
        }
    }

    public function render()
    {
        return view('livewire.perencanaans.perencanaan-form')
            ->layout('layouts.app');
    }
}
