<?php

namespace App\Livewire\Kabupatens;
use App\Models\Kabupaten;
use Livewire\Component;

class KabupatensForm extends Component
{
    public $kabupaten_id, $nama;

    public function render()
    {
        return view('livewire.kabupatens.kabupatens-form');
    }
}
