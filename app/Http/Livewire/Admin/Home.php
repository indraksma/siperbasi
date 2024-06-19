<?php

namespace App\Http\Livewire\Admin;

use App\Models\Pengumuman;
use App\Models\Perkara;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $perkara = Perkara::all()->count();
        $lelang = Pengumuman::all()->count();
        return view('livewire.admin.home', compact('perkara', 'lelang'));
    }
}
