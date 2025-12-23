<?php

namespace App\Livewire\Rencanas;

use App\Models\Rencana;
use Livewire\Component;

class RencanasForm extends Component
{
    public $rencana_id, $nama_kegiatan, $tanggal_kegiatan, $pegawai;

    public function mount($rencana_id = null)
    {
        // kalau parameter ada (edit mode)
        if ($rencana_id) {
            $this->rencana_id = $rencana_id;

            $rencana = Rencana::findOrFail($rencana_id);
            $this->nama_kegiatan = $rencana->nama_kegiatan;
            $this->tanggal_kegiatan = $rencana->tanggal_kegiatan;
            $this->pegawai = $rencana->pegawai;
        }
    }

    public function rules()
    {
        $rules = [
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'pegawai' => 'required|string',
        ];

        return $rules;
    }

    public function submit()
    {
        $this->validate();

        // setelah lulus validasi, lakukan sintaks dibawah
        if ($this->rencana_id) {
            $rencana = Rencana::findOrFail($this->rencana_id);
            $rencana->update([
                'nama_kegiatan' => $this->nama_kegiatan,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'pegawai' => $this->pegawai,
            ]);

            session()->flash('success', 'Rencana kegiatan berhasil diedit.');
            return redirect()->route('rencanas.index');
        } else {
            $rencana = Rencana::create([
                'nama_kegiatan' => $this->nama_kegiatan,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'pegawai' => $this->pegawai,
                
            ]);

            session()->flash('success', 'Rencana Kegiatan baru berhasil ditambahkan.');
            return redirect()->route('rencanas.create');
        }
    }

    public function render()
    {
        return view('livewire.rencanas.rencanas-form')
            ->layout('layouts.app');
    }
   
}
