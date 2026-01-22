<?php

namespace App\Livewire\Perencanaans;

use Livewire\Component;
use App\Models\Penugasan;

class PenugasansIndex extends Component
{
    public function render()
    {
        $penugasans = Penugasan::query()
            ->select('penugasans.*')
            // ->when($this->search, function ($query) { //searching di search kolom
            //     $query->where('penugasans.pegawai','like','%'.$this->search, '%');
            // })
            ->orderBy('id', 'asc')
            ->paginate(5);
        
        return view('livewire.perencanaans.penugasans-index', compact('penugasans'))
            ->layout('layouts.app');
    }
}
