<?php

namespace App\Http\Livewire\Admin;

use App\Models\BarangBukti as ModelsBarangBukti;
use App\Models\Penyitaan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BarangBukti extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['edit' => 'edit', 'deleteId' => 'deleteId', 'tambahData' => 'tambahData'];
    public $bb_id, $delete_id, $nama_barang, $file_photo, $foto, $no_penyitaan, $no_sita, $not_found, $no_putusan, $status_putusan;
    public $tambah = FALSE;
    public $status = FALSE;
    public $iteration = 0;

    public function render()
    {
        $barbuk = ModelsBarangBukti::latest()->paginate(15);
        return view('livewire.admin.barang-bukti', [
            'barangbukti' => $barbuk,
            'iteration' => $this->iteration,
        ]);
    }

    public function destroy()
    {
        ModelsBarangBukti::destroy($this->delete_id);
        $this->alert('success', 'Data berhasil dihapus.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
        $this->resetInputFields();
        $this->emit('refreshBbTable');
    }

    public function tambahData()
    {
        $this->tambah = TRUE;
    }

    public function updatedNoPenyitaan($value)
    {
        $this->reset('not_found');
        $this->no_penyitaan = $value;
    }

    public function cekSita()
    {
        $no_penyitaan = $this->no_penyitaan;
        $cek = Penyitaan::where('no_penyitaan', $no_penyitaan)->first();
        if ($cek) {
            $this->not_found = FALSE;
            if ($cek->putusan) {
                $this->no_putusan = $cek->putusan->no_putusan;
                $this->status = TRUE;
            } else {
                $this->no_putusan = "-";
            }
        } else {
            $this->not_found = TRUE;
        }
    }
    public function edit($id)
    {
        $bb = ModelsBarangBukti::where('id', $id)->first();
        $this->nama_barang = $bb->nama_barang;
        $this->foto = $bb->foto;
        $this->bb_id = $id;
        if ($bb->putusan_id != NULL) {
            $this->status = TRUE;
            $this->no_putusan = $bb->putusan->no_putusan;
            $this->status_putusan = $bb->status;
        } else {
            $this->no_putusan = NULL;
            $this->status_putusan = 0;
        }
    }

    public function deleteId($id)
    {
        $this->delete_id = $id;
    }

    public function resetInputFields()
    {
        $this->tambah = FALSE;
        $this->status = FALSE;
        $this->reset(['bb_id', 'delete_id', 'no_penyitaan', 'no_sita', 'nama_barang', 'file_photo', 'not_found', 'no_putusan', 'status_putusan', 'foto']);
    }

    public function store()
    {
        if ($this->bb_id) {
            $bb = ModelsBarangBukti::where('id', $this->bb_id)->first();
            if (isset($this->file_photo)) {
                $this->validate(['file_photo' => 'required|image|max:2048']);
                $filename = 'bb_' . date('YmdHis');
                $uploadedfilename = $filename . '.' . $this->file_photo->getClientOriginalExtension();
                $this->file_photo->storeAs('public/bb', $uploadedfilename);
            } else {
                $uploadedfilename = $bb->foto;
            }
            $bb->update([
                'nama_barang' => $this->nama_barang,
                'foto' => $uploadedfilename,
                'status' => $this->status_putusan,
            ]);

            $this->alert('success', 'Data berhasil diubah.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            if (isset($this->file_photo)) {
                $this->validate(['file_photo' => 'required|image|max:2048']);
                $filename = 'bb_' . date('YmdHis');
                $uploadedfilename = $filename . '.' . $this->file_photo->getClientOriginalExtension();
                $this->file_photo->storeAs('public/bb', $uploadedfilename);
            } else {
                $uploadedfilename = NULL;
            }
            $penyitaan = Penyitaan::where('no_penyitaan', $this->no_penyitaan)->first();
            if ($penyitaan->putusan) {
                $putusan_id = $penyitaan->putusan->id;
                $status = $this->status_putusan;
            } else {
                $putusan_id = NULL;
                $status = 0;
            }
            $barbuk = ModelsBarangBukti::create([
                'penyitaan_id' => $penyitaan->id,
                'putusan_id' => $putusan_id,
                'nama_barang' => $this->nama_barang,
                'foto' => $uploadedfilename,
                'status' => $status,
            ]);

            $this->alert('success', 'Data berhasil ditambahkan.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
        $this->dispatchBrowserEvent('closeModal');

        $this->resetInputFields();
        $this->emit('refreshBbTable');
    }
}
