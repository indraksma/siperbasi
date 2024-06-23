<?php

namespace App\Http\Livewire\Admin;

use App\Models\BarangBukti;
use App\Models\Penyitaan;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AddPenyitaan extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $no_penyitaan, $tersangka, $penyidik, $pengadilan, $penuntut, $tanggal_penyitaan, $nama_barang, $file_photo;
    public $iteration = 0;
    public $inputs = [];
    public $i = 0;

    public function mount()
    {
        $this->tanggal_penyitaan = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.add-penyitaan', [
            'iteration' => $this->iteration,
        ]);
    }

    public function addInput($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function removeInput($i)
    {
        $this->i = $this->i - 1;
        unset($this->inputs[$i]);
    }

    public function resetInputFields()
    {
        $this->reset(['no_penyitaan', 'tanggal_penyitaan', 'tersangka', 'penyidik', 'penuntut', 'pengadilan', 'penyitaan_id', 'nama_barang', 'file_photo']);
    }

    public function store()
    {
        foreach ($this->nama_barang as $key => $value) {
            if (isset($this->file_photo[$key])) {
                $this->validate(['file_photo.' . $key => 'required|image|max:2048']);
                $filename = 'bb' . $key . '_' . date('YmdHis');
                $uploadedfilename[$key] = $filename . '.' . $this->file_photo[$key]->getClientOriginalExtension();
                $this->file_photo[$key]->storeAs('public/bb', $uploadedfilename[$key]);
            } else {
                $uploadedfilename[$key] = NULL;
            }
        }

        // dd($uploadedfilename);

        DB::beginTransaction();

        try {
            $sita = Penyitaan::create([
                'tanggal_penyitaan' => $this->tanggal_penyitaan,
                'no_penyitaan' => $this->no_penyitaan,
                'pengadilan' => $this->pengadilan,
                'penyidik' => $this->penyidik,
                'penuntut' => $this->penuntut,
                'tersangka' => $this->tersangka,
            ]);

            foreach ($this->nama_barang as $key => $input) {
                BarangBukti::create([
                    'penyitaan_id' => $sita->id,
                    'nama_barang' => $input,
                    'foto' => $uploadedfilename[$key],
                    'status' => 0,
                ]);
            }

            DB::commit();
            $this->alert('success', 'Data Berhasil Ditambahkan!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
            $this->iteration = $this->iteration + 1;
            return redirect()->route('admin.penyitaan');
        } catch (Exception $e) {
            DB::rollBack();
            $this->alert('error', 'Data Gagal Ditambahkan!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }
}
