<?php

namespace App\Livewire\Keuangans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Keuangan;
use App\Services\KeuanganPdfService;

class KeuanganIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function cetakPdf($id)
    {
        $keuangan = Keuangan::with([
            'rencana.pegawai',
            'pelaksanaan'
        ])->findOrFail($id);

        return response()->streamDownload(
            fn () => print(
                KeuanganPdfService::generate($keuangan)->output()
            ),
            'Keuangan-' . $id . '.pdf'
        );
    }

    public function render()
    {
        $keuangans = Keuangan::with([
                'rencana.pegawai',
                'pelaksanaan'
            ])
            ->when($this->search, function ($query) {
                $query->where('no_sppd', 'like', '%' . $this->search . '%')
                      ->orWhere('tanggal_sppd', 'like', '%' . $this->search . '%')

                      // 🔥 search lewat rencana -> pegawai
                      ->orWhereHas('rencana.pegawai', function ($q) {
                          $q->where('nama', 'like', '%' . $this->search . '%');
                      })

                      // 🔥 search pelaksanaan
                      ->orWhereHas('pelaksanaan', function ($q) {
                          $q->where('nama_kegiatan', 'like', '%' . $this->search . '%')
                            ->orWhere('lokasi_kegiatan', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderByDesc('id')
            ->paginate(5);

        return view('livewire.keuangans.keuangan-index', compact('keuangans'))
            ->layout('layouts.app');
    }
}
