<?php

namespace App\Livewire\Keuangans;

use Livewire\Component;
use App\Models\Pelaksanaan;
use App\Models\Keuangan;
use Illuminate\Support\Facades\Auth;

class KeuanganForm extends Component
{
    public $pelaksanaan;

    public function mount($pelaksanaan)
    {
        $query = Pelaksanaan::with('rencana');

        // Jika bukan super-admin, filter berdasarkan kepegawaian_id milik user
        if (!Auth::user()->hasRole('super-admin')) {
            // Pastikan user punya data kepegawaian agar tidak error null
            if (!Auth::user()->kepegawaian) {
                abort(403, 'Profil kepegawaian tidak ditemukan.');
            }
            $query->where('kepegawaian_id', Auth::user()->kepegawaian->id);
        }

        $this->pelaksanaan = $query->where('id', $pelaksanaan)->firstOrFail();
    }

    public function submit()
    {
        // Izinkan pegawai atau super-admin
        if (!Auth::user()->hasAnyRole(['pegawai', 'super-admin'])) {
            abort(403);
        }

        Keuangan::firstOrCreate(
            ['pelaksanaan_id' => $this->pelaksanaan->id],
            [
                'status' => 'belum_lunas',
                'tanggal_proses' => now(),
            ]
        );

        session()->flash('success', 'Keuangan berhasil disimpan');

        return redirect()->route('keuangans.index');
    }

    public function render()
    {
        return view('livewire.keuangans.keuangan-form')
            ->layout('layouts.app');
    }
}