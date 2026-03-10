<?php

namespace App\Livewire\Instansis;

use Livewire\Component;
use App\Models\Instansi;
use App\Models\Kabupaten;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // WAJIB ADA


class InstansiForm extends Component
{
 public $instansi_id, $nama_instansi, $alamat_instansi, $telp_instansi, $kabupaten_id, $kabupatenList = [];

 public function mount($instansi_id = null)
    {
        $this->kabupatenList = Kabupaten::orderBy('nama')->get();

        // kalau parameter ada (edit mode)
        if ($instansi_id) {
            $this->authorize('instansi-edit');
            $this->instansi_id = $instansi_id;

            $instansi = Instansi::findOrFail($instansi_id);
            $this->nama_instansi = $instansi->nama_instansi;
            $this->alamat_instansi = $instansi->alamat_instansi;
            $this->telp_instansi = $instansi->telp_instansi;
            $this->kabupaten_id = $instansi->kabupaten_id;
        }else{
            $this->authorize('instansi-create');
        }
    }

     public function rules()
    {
        $rules = [
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'telp_instansi' => 'required|string|max:255',
            'kabupaten_id' => 'required|exists:kabupatens,id',

        ];

        return $rules;
    }
    
        public function submit()
        {
            if ($this->instansi_id) {
                $this->authorize('instansi-edit');
            } else {
                $this->authorize('instansi-create');
            }

            $this->validate();

            // setelah lulus validasi, lakukan sintaks dibawah
            if ($this->instansi_id) {
                $instansi = Instansi::findOrFail($this->instansi_id);
                $instansi->update([
                    'nama_instansi' => $this->nama_instansi,
                    'alamat_instansi' => $this->alamat_instansi,
                    'telp_instansi' => $this->telp_instansi,
                    'kabupaten_id' => $this->kabupaten_id,
                
                ]);

                session()->flash('success', 'Instansi berhasil diedit.');
                return redirect()->route('instansis.index');
            } else {
                $instansi = Instansi::create([
                    'nama_instansi' => $this->nama_instansi,
                    'alamat_instansi' => $this->alamat_instansi,
                    'telp_instansi' => $this->telp_instansi,
                    'kabupaten_id' => $this->kabupaten_id,
                    
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
