<?php

namespace App\Livewire\Kepegawaians;

use App\Models\Instansi;
use App\Models\Kepegawaian;
use App\Models\Pangkat;
use App\Models\Bank;
use App\Models\Pendidikan;

use Livewire\Component;
use Symfony\Contracts\Service\Attribute\Required;

class KepegawaianForm extends Component
{
    public $kepegawaian_id, $nama, $nip, $jabatan, $pangkat_id, $tempat_lahir, $tgl_lahir, $jenis_kelamin, $agama, $instansi_id, $pendidikan_id, $hp, $email, $npwp, $bank_id, $no_rek, $pangkatList = [], $instansiList = [], $bankList = [], $pendidikanList = [];

    public function mount($kepegawaian_id = null)
    {
        $this->pangkatList = Pangkat::orderBy('nama')->get();
        $this->instansiList = Instansi::orderBy('nama_instansi')->get();
        $this->bankList = Bank::orderBy('nama')->get();
        $this->pendidikanList = Pendidikan::orderBy('nama_pendidikan')->get();

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
            $this->instansi_id = $kepegawaian->instansi_id;
            $this->hp = $kepegawaian->hp;
            $this->email  = $kepegawaian->email;
            $this->npwp = $kepegawaian->npwp;
            $this->bank_id = $kepegawaian->bank_id;
            $this->no_rek = $kepegawaian->no_rek;
            $this->pendidikan_id = $kepegawaian->pendidikan_id;
        } else {
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
            'instansi_id' => 'required|exists:instansis,id',
            'hp' => 'required|string|max:255',
            'email' => 'nullable|email',
            'npwp' => 'nullable|string',
            'bank_id' => 'nullable|string',
            'no_rek' => 'nullable|string',
            'pendidikan_id' => 'required|exists:pendidikans,id',
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
                'instansi_id' => $this->instansi_id,
                'hp' => $this->hp,
                'email' => $this->email,
                'npwp' => $this->npwp,
                'bank_id' => $this->bank_id,
                'no_rek' => $this->no_rek,
                'pendidikan_id' => $this->pendidikan_id,
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
                'instansi_id' => $this->instansi_id,
                'hp' => $this->hp,
                'email' => $this->email,
                'npwp' => $this->npwp,
                'bank_id' => $this->bank_id,
                'no_rek' => $this->no_rek,
                'pendidikan_id' => $this->pendidikan_id,
            ]);

            // dd($kepegawaian);

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
