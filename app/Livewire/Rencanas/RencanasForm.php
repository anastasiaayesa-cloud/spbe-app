<?php

namespace App\Livewire\Rencanas;

use App\Models\Kepegawaian;
use App\Models\Perencanaan;
use App\Models\Rencana;
use Livewire\Component;

class RencanasForm extends Component
{
    public $rencana_id;
    public $nama_kegiatan;
    public $tanggal_kegiatan;
    public $lokasi_kegiatan;

   
    // PERENCANAAN DROPDOWN

    
public $perencanaanSearch = '';
public $perencanaanResults = [];
public $perencanaanSelected = [];
public $showPerencanaanDropdown = false;

    // PEGAWAI
    public $pegawaiSearch = '';
    public $pegawaiResults = [];
    public $pegawaiSelected = [];
    public $showPegawaiDropdown = false;

   public function mount($rencana_id = null)
{
    if ($rencana_id) {
        $this->rencana_id = $rencana_id;

        $rencana = Rencana::with(['perencanaans','kepegawaians'])
            ->findOrFail($rencana_id);

        $this->nama_kegiatan = $rencana->nama_kegiatan;
        $this->tanggal_kegiatan = $rencana->tanggal_kegiatan;
        $this->lokasi_kegiatan = $rencana->lokasi_kegiatan;

        $this->perencanaanSelected = $rencana->perencanaans
            ->pluck('id')
            ->toArray();

        $this->pegawaiSelected = $rencana->kepegawaians
            ->pluck('id')
            ->toArray();
    }
}

public function closePerencanaanDropdown()
{
    $this->showPerencanaanDropdown = false;
}

public function addPerencanaan($id)
{
    if (!in_array($id, $this->perencanaanSelected)) {
        $this->perencanaanSelected[] = $id;
    }

    $this->perencanaanSearch = '';
    $this->perencanaanResults = [];
    $this->showPerencanaanDropdown = false;
}

public function removePerencanaan($id)
{
    $this->perencanaanSelected = array_values(
        array_diff($this->perencanaanSelected, [$id])
    );
}

public function getPerencanaanSelectedDataProperty()
{
    return Perencanaan::whereIn('id', $this->perencanaanSelected)->get();
}

public function showAllPerencanaan()
{
    $this->showPerencanaanDropdown = true;

    $this->perencanaanResults = Perencanaan::whereNotIn('id', $this->perencanaanSelected)
        ->orderBy('nama')
        ->limit(20)
        ->get()
        ->toArray();
}


    /* ================= PEGAWAI ================= */

    public function updatedPegawaiSearch($value)
    {
        if (trim($value) === '') {
            $this->showPegawaiDropdown = false;
            $this->pegawaiResults = [];
            return;
        }

        $this->showPegawaiDropdown = true;

        $this->pegawaiResults = Kepegawaian::whereNotIn('id', $this->pegawaiSelected)
            ->where('nama', 'like', "%{$value}%")
            ->orderBy('nama')
            ->limit(20)
            ->get()
            ->toArray();
    }

    public function showAllPegawai()
    {
        $this->showPegawaiDropdown = true;

        $this->pegawaiResults = Kepegawaian::whereNotIn('id', $this->pegawaiSelected)
            ->orderBy('nama')
            ->limit(20)
            ->get()
            ->toArray();
    }

    public function closePegawaiDropdown()
    {
        $this->showPegawaiDropdown = false;
    }

    public function addPegawai($id)
    {
        if (!in_array($id, $this->pegawaiSelected)) {
            $this->pegawaiSelected[] = $id;
        }

        $this->pegawaiSearch = '';
        $this->pegawaiResults = [];
        $this->showPegawaiDropdown = false;
    }

    public function removePegawai($id)
    {
        $this->pegawaiSelected = array_values(
            array_diff($this->pegawaiSelected, [$id])
        );
    }

    public function getPegawaiSelectedDataProperty()
    {
        return Kepegawaian::whereIn('id', $this->pegawaiSelected)->get();
    }

    /* ================= SUBMIT ================= */

    protected function rules()
    {
        return [
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'lokasi_kegiatan' => 'required|string|max:255',
            'perencanaanSelected' => 'required|array|min:1',
            'perencanaanSelected.*' => 'exists:perencanaans,id',
        ];
    }

    public function submit()
    {
        $this->validate();

        if ($this->rencana_id) {
            $rencana = Rencana::findOrFail($this->rencana_id);
            $rencana->update([
                'nama_kegiatan' => $this->nama_kegiatan,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'lokasi_kegiatan' => $this->lokasi_kegiatan,
            ]);
        } else {
            $rencana = Rencana::create([
                'nama_kegiatan' => $this->nama_kegiatan,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'lokasi_kegiatan' => $this->lokasi_kegiatan,
            ]);
        }

        // 🔥 INI INTINYA (PIVOT)
        $rencana->perencanaans()->sync($this->perencanaanSelected);
        $rencana->kepegawaians()->sync($this->pegawaiSelected);

        session()->flash('success', 'Rencana kegiatan berhasil disimpan');
        return redirect()->route('rencanas.index');
    }

    public function render()
    {
        return view('livewire.rencanas.rencanas-form')
            ->layout('layouts.app');
    }
}
