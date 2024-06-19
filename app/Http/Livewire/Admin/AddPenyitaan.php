<?php

namespace App\Http\Livewire\Admin;

use App\Models\Penyitaan;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AddPenyitaan extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $no_penyitaan, $tersangka, $penyidik, $pengadilan, $penuntut, $tanggal_penyitaan;
    public $iteration = 0;
    public Collection $inputs;

    public function mount()
    {
        $this->fill([
            'inputs' => collect([['nama_barang' => '', 'file_photo' => '']]),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.add-penyitaan', [
            'iteration' => $this->iteration,
        ]);
    }

    public function addInput()
    {
        $this->inputs->push(['nama_barang' => '', 'file_photo' => '']);
    }

    public function removeInput($key)
    {
        $this->inputs->pull($key);
    }

    public function resetInputFields()
    {
        $this->reset(['no_penyitaan', 'tanggal_penyitaan', 'tersangka', 'penyidik', 'penuntut', 'pengadilan', 'penyitaan_id']);
    }

    public function store()
    {
    }
}
