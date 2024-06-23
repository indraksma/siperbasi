<?php

namespace App\Http\Livewire\Admin;

use App\Models\BarangBukti;
use App\Models\Pengumuman;
use App\Models\Penyitaan;
use App\Models\Perkara;
use App\Models\Putusan;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $barangbukti = BarangBukti::all()->count();
        $penyitaan = Penyitaan::all()->count();
        $putusan = Putusan::all()->count();
        $lelang = Pengumuman::all()->count();
        return view('livewire.admin.home', compact('barangbukti', 'penyitaan', 'putusan', 'lelang'));
    }
}
