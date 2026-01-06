<?php

namespace App\Livewire\Rencanas;

use App\Models\Kepegawaian;
use App\Models\Rencana;
use Livewire\Component;

class RencanasForm extends Component
{
    public $rencana_id, $nama_kegiatan, $tanggal_kegiatan;

    // INI UNTUK TOMBOL DROPDOWN PEGAWAI
    public $pegawaiSearch = '';
    public $pegawaiResults = [];
    public $pegawaiSelected = []; // array of pegawai_id
    public $showPegawaiDropdown = false;

    public function mount($rencana_id = null)
    {
        // INIT WAJIB (CREATE MODE) TOMBOL DROPDOWN PEGAWAI
        $this->pegawaiSelected = [];
        $this->pegawaiResults = [];
        $this->pegawaiSearch = '';

        // kalau parameter ada (edit mode)
        if ($rencana_id) {
            $this->rencana_id = $rencana_id;

            $rencana = Rencana::findOrFail($rencana_id);
            $this->nama_kegiatan = $rencana->nama_kegiatan;
            $this->tanggal_kegiatan = $rencana->tanggal_kegiatan;

            // UNTUK TOMBOL DROPDOWN PEGAWAI
            $this->pegawaiSelected = $rencana
                ->kepegawaians
                ->pluck('id')
                ->toArray();
        }
    }

    public function updatedPegawaiSearch($value)
    {
        // Jika kosong, sembunyikan dropdown
        if (trim($value) === '') {
            $this->showPegawaiDropdown = false;
            $this->pegawaiResults = [];
            return;
        }

        // Tampilkan dropdown dan filter berdasarkan input
        $this->showPegawaiDropdown = true;

        $this->pegawaiResults = Kepegawaian::query()
            ->whereNotIn('id', $this->pegawaiSelected)
            ->where('nama', 'like', '%' . $value . '%')
            ->orderBy('nama')
            ->limit(20)
            ->get()
            ->toArray();
    }

    public function addPegawai($pegawaiId)
    {
        if (!in_array($pegawaiId, $this->pegawaiSelected)) {
            $this->pegawaiSelected[] = $pegawaiId;
        }

        // Reset dan sembunyikan dropdown
        $this->pegawaiSearch = '';
        $this->pegawaiResults = [];
        $this->showPegawaiDropdown = false;
    }

    public function getPegawaiSelectedDataProperty()
    {
        return Kepegawaian::whereIn('id', $this->pegawaiSelected)->get();
    }

    public function removePegawai($pegawaiId)
    {
        $this->pegawaiSelected = array_values(
            array_diff($this->pegawaiSelected, [$pegawaiId])
        );
    }

    public function showAllPegawai()
    {
        $this->showPegawaiDropdown = true;

        $this->pegawaiResults = Kepegawaian::query()
            ->whereNotIn('id', $this->pegawaiSelected)
            ->orderBy('nama')
            ->limit(20)
            ->get()
            ->toArray();
    }

    public function closeDropdown()
    {
        $this->showPegawaiDropdown = false;
    }

    public function rules()
    {
        $rules = [
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
        ];

        return $rules;
    }

    public function submit()
    {
        $this->validate();

        if ($this->rencana_id) {
            $rencana = Rencana::findOrFail($this->rencana_id);
            $rencana->update([
                'nama_kegiatan' => $this->nama_kegiatan,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
            ]);

            $rencana->kepegawaians()->sync($this->pegawaiSelected);

            session()->flash('success', 'Rencana kegiatan berhasil diedit.');
            return redirect()->route('rencanas.index');
        } else {
            $rencana = Rencana::create([
                'nama_kegiatan' => $this->nama_kegiatan,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
            ]);

            $rencana->kepegawaians()->sync($this->pegawaiSelected);

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
