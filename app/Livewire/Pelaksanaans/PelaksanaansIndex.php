<?php

namespace App\Livewire\Pelaksanaans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rencana;

class PelaksanaansIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
{
    $user = auth()->user();

    // 🛡️ ADMIN → LIHAT SEMUA
    if ($user->hasRole('admin')) {

        $rencanas = Rencana::with('pelaksanaans')
            ->orderBy('tanggal_kegiatan', 'desc')
            ->paginate(5);

        return view('livewire.pelaksanaans.pelaksanaans-index', compact('rencanas'))
            ->layout('layouts.app');
    }

    // 👤 PEGAWAI → WAJIB PUNYA KEPEGAWAIAN
        $kepegawaian = $user->kepegawaian;

if (! $kepegawaian) {
    abort(403, 'User belum terhubung ke data pegawai');
}

    $kepegawaianId = $kepegawaian->id;

    $rencanas = Rencana::with(['pelaksanaans' => function ($q) use ($kepegawaianId) {
            $q->where('kepegawaian_id', $kepegawaianId);
        }])
        ->whereHas('kepegawaians', function ($q) use ($kepegawaianId) {
            $q->where('kepegawaians.id', $kepegawaianId);
        })
        ->orderBy('tanggal_kegiatan', 'desc')
        ->paginate(5);

    return view('livewire.pelaksanaans.pelaksanaans-index', compact('rencanas'))
        ->layout('layouts.app');
}

}
