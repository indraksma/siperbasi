<?php

namespace App\Http\Livewire\Admin;

use App\Models\Penetapan;
use App\Models\Penyitaan as ModelsPenyitaan;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Penyitaan extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $delete_id;
    public Collection $inputs;

    public function mount()
    {
        $this->fill([
            'inputs' => collect([['nama_barang' => '', 'file_photo' => '']]),
        ]);
    }

    public function render()
    {
        $sita = ModelsPenyitaan::latest()->paginate(10);
        return view('livewire.admin.penyitaan', [
            'sita' => $sita,
        ]);
    }

    public function resetInputFields()
    {
        $this->reset(['delete_id']);
    }

    public function deleteId($id)
    {
        $this->delete_id = $id;
    }

    public function destroy()
    {
        ModelsPenyitaan::destroy($this->delete_id);

        $this->alert('success', 'Data berhasil dihapus.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
        $this->resetInputFields();
    }
}
