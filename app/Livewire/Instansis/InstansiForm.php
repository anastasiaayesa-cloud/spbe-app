<?php

namespace App\Livewire\Instansis;

use Livewire\Component;
use App\Models\Instansi;


class InstansiForm extends Component
{
 public $instansi_id, $nama_instansi, $alamat_instansi, $telp_instansi;

 public function mount($instansi_id = null)
    {
        // kalau parameter ada (edit mode)
        if ($instansi_id) {
            $this->instansi_id = $instansi_id;

            $instansi = Instansi::findOrFail($instansi_id);
            $this->nama_instansi = $instansi->nama_instansi;
            $this->alamat_instansi = $instansi->alamat_instansi;
            $this->telp_instansi = $instansi->telp_instansi;
            
    }
}

     public function rules()
    {
        $rules = [
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'telp_instansi' => 'required|string|max:255',

        ];

        return $rules;
    }
    
        public function submit()
    {
        $this->validate();

        // setelah lulus validasi, lakukan sintaks dibawah
        if ($this->instansi_id) {
            $instansi = Instansi::findOrFail($this->instansi_id);
            $instansi->update([
                'nama_instansi' => $this->nama_instansi,
                'alamat_instansi' => $this->alamat_instansi,
                'telp_instansi' => $this->telp_instansi,
              
            ]);

            session()->flash('success', 'Instansi berhasil diedit.');
            return redirect()->route('instansis.index');
        } else {
            $instansi = Instansi::create([
                'nama_instansi' => $this->nama_instansi,
                'alamat_instansi' => $this->alamat_instansi,
                'telp_instansi' => $this->telp_instansi,
                
            ]);

            session()->flash('success', 'instansi baru berhasil ditambahkan.');
            return redirect()->route('instansis.create');
        }
    }

    public function render()
    {
        return view('livewire.instansis.instansi-form')->layout('layouts.app');
    }
}
