<?php

namespace App\Livewire\Keuangans;

use Livewire\Component;
use App\Models\Keuangan;
use App\Models\Pelaksanaan;

class KeuanganForm extends Component
{
    public $keuangan_id;

    public $no_sppd;
    public $tanggal_sppd;
    public $pelaksanaan_id;

    /**
     * MOUNT
     */
    public function mount($keuangan_id = null)
    {
        if ($keuangan_id) {
            $keuangan = Keuangan::findOrFail($keuangan_id);

            $this->keuangan_id = $keuangan->id;
            $this->no_sppd = $keuangan->no_sppd;
            $this->tanggal_sppd = $keuangan->tanggal_sppd;
            $this->pelaksanaan_id = $keuangan->pelaksanaan_id;
        }
    }

    /**
     * RULES
     */
    protected function rules()
    {
        return [
            'no_sppd' => 'required|string|max:255',
            'tanggal_sppd' => 'required|date',
            'pelaksanaan_id' => 'required|exists:pelaksanaans,id',
        ];
    }

    /**
     * AUTO ISI TANGGAL DARI PELAKSANAAN
     */
    public function updatedPelaksanaanId($value)
    {
        if ($value) {
            $pelaksanaan = Pelaksanaan::find($value);

            if ($pelaksanaan) {
                $this->tanggal_sppd = $pelaksanaan->tanggal_pelaksanaan?->format('Y-m-d');
            }
        } else {
            $this->tanggal_sppd = null;
        }
    }

    /**
     * SUBMIT
     */
    public function submit()
    {
        $this->validate();

        $data = [
            'no_sppd' => $this->no_sppd,
            'tanggal_sppd' => $this->tanggal_sppd,
            'pelaksanaan_id' => $this->pelaksanaan_id,
        ];

        Keuangan::updateOrCreate(
            ['id' => $this->keuangan_id],
            $data
        );

        session()->flash('success', 'Data keuangan berhasil disimpan');
        return redirect()->route('keuangans.index');
    }

    /**
     * RENDER
     */
    public function render()
    {
        return view('livewire.keuangans.keuangan-form', [
            'pelaksanaanList' => Pelaksanaan::with('perencanaanNama')
                ->orderBy('id')
                ->get(),
        ])->layout('layouts.app');
    }
}
