<?php

namespace App\Livewire\Kepegawaians;
use App\Models\Kepegawaian;

use Livewire\Component;

class KepegawaianForm extends Component
{
    public $kepegawaian_id, $nama, $nip, $jabatan, $pangkat_id, $tempat_lahir, $tgl_lahir, $jenis_kelamin, $agama, $nama_instansi, $alamat_instansi, $telp_instansi, $kode_kabupaten, $hp, $email, $npwp, $bank_id, $no_rek, $pendidikan_terakhir_id, $is_bpmp;

    public function mount($kepegawaian_id = null)
    {
        // kalau parameter ada (edit mode)
        if ($kepegawaian_id) {
            $this->kepegawaian_id = $kepegawaian_id;

            $kepegawaian = Kepegawaian::findOrFail($kepegawaian_id);
            $this->nama = $kepegawaian->nama;
            $this->nip = $kepegawaian->nip;
            $this->jabatan = $kepegawaian->jabatan;
            $this->pangkat_id = $kepegawaian->pangkat_id;
            $this->tempat_lahir = $kepegawaian->tempat_lahir;
            $this->tgl_lahir = $kepegawaian->tgl_lahir;
            $this->jenis_kelamin = $kepegawaian->jenis_kelamin;
            $this->agama = $kepegawaian->agama;
            $this->nama_instansi = $kepegawaian->nama_instansi;
            $this->alamat_instansi = $kepegawaian->alamat_instansi;
            $this->telp_instansi = $kepegawaian->telp_instansi;
            $this->kode_kabupaten = $kepegawaian->kode_kabupaten;
            $this->hp = $kepegawaian->hp;
            $this->email  = $kepegawaian->email ;
            $this->	npwp = $kepegawaian->npwp;
            $this->bank_id = $kepegawaian->bank_id;
            $this->no_rek = $kepegawaian->no_rek;
            $this->pendidikan_terakhir_id = $kepegawaian->pendidikan_terakhir_id;
            $this->	is_bpmp = $kepegawaian->is_bpmp;
        }
    }

    public function rules()
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|int',
            'jabatan' => 'nullable|string|max:255',
            'pangkat_id' => 'nullable|string',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|in:Islam,Kristen Katolik,Kristen Protestan,Hindu,Buddha,Konghucu',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'nullable|string',
            'telp_instansi' => 'required|string|max:255',
            'kode_kabupaten' => 'nullable|string',
            'hp' => 'required|string|max:255',
            'email' => 'nullable|email',
            'npwp' => 'nullable|string',
            'bank_id' => 'nullable|string',
            'no_rek' => 'nullable|string',
            'pendidikan_terakhir_id' => 'required|string|max:255',
            'is_bpmp' => 'nullable|string',
        ];

        return $rules;
    }

    public function submit()
    {
        $this->validate();

        // setelah lulus validasi, lakukan sintaks dibawah
        if ($this->kepegawaian_id) {
            $kepegawaian = Kepegawaian::findOrFail($this->kepegawaian_id);
            $kepegawaian->update([
                'nama' => $this->nama,
                'nip' => $this->nip,
                'jabatan' => $this->jabatan,
                'pangkat_id' => $this->pangkat_id,
                'tempat_lahir' => $this->tempat_lahir,
                'tgl_lahir' => $this->tgl_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'agama' => $this->agama,
                'nama_instansi' => $this->nama_instansi,
                'alamat_instansi' => $this->alamat_instansi,
                'telp_instansi' => $this->telp_instansi,
                'kode_kabupaten' => $this->kode_kabupaten,
                'hp' => $this->	hp,
                'email' => $this->email,
                'npwp' => $this->npwp,
                'bank_id' => $this->bank_id,
                'no_rek' => $this->no_rek,
                'pendidikan_terakhir_id' => $this->	pendidikan_terakhir_id,
                'is_bpmp' => $this->is_bpmp,
            ]);

            session()->flash('success', 'Kepegawaian berhasil diedit.');
            return redirect()->route('kepegawaians.index');
        } else {
            $kepegawaian = Kepegawaian::create([
                'nama' => $this->nama,
                'nip' => $this->nip,
                'jabatan' => $this->jabatan,
                'pangkat_id' => $this->pangkat_id,
                'tempat_lahir' => $this->tempat_lahir,
                'tgl_lahir' => $this->tgl_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'agama' => $this->agama,
                'nama_instansi' => $this->nama_instansi,
                'alamat_instansi' => $this->alamat_instansi,
                'telp_instansi' => $this->telp_instansi,
                'kode_kabupaten' => $this->kode_kabupaten,
                'hp' => $this->	hp,
                'email' => $this->email,
                'npwp' => $this->npwp,
                'bank_id' => $this->bank_id,
                'no_rek' => $this->no_rek,
                'pendidikan_terakhir_id' => $this->	pendidikan_terakhir_id,
                'is_bpmp' => $this->is_bpmp,
            ]);

            session()->flash('success', 'Kepegawaian baru berhasil ditambahkan.');
            return redirect()->route('kepegawaians.create');
        }
    }

    public function delete()
    {
        Kepegawaian::where('id', $this->kepegawaian_id)->delete();

        session()->flash('success', 'Kepegawaian berhasil dihapus.');
        return redirect()->route('kepegawaians.index');
    }

    public function render()
    {
        return view('livewire.kepegawaians.kepegawaian-form')
            ->layout('layouts.app');
    }
}
