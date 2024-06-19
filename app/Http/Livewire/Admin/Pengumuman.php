<?php

namespace App\Http\Livewire\Admin;

use App\Models\Pengumuman as ModelsPengumuman;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Pengumuman extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $iteration = 0;
    public $tanggal_lelang, $tanggal, $harga_limit, $uang_jaminan, $nama_barang, $keterangan, $photo, $file_photo, $lelang_id, $delete_id;

    public function render()
    {
        $lelang = ModelsPengumuman::latest()->paginate(10);
        return view('livewire.admin.pengumuman', [
            'iteration' => $this->iteration,
            'lelang' => $lelang,
        ]);
    }

    public function store()
    {

        if ($this->file_photo) {
            $this->validate(['file_photo' => 'required|image|max:2048']);

            $filename = 'll_' . date('YmdHis');
            $uploadedfilename = $filename . '.' . $this->file_photo->getClientOriginalExtension();
            $this->file_photo->storeAs('public/lelang', $uploadedfilename);
            $this->iteration = $this->iteration + 1;
        } else {
            if ($this->lelang_id) {
                $uploadedfilename = $this->photo;
            }
        }
        if ($this->lelang_id) {
            $lelang = ModelsPengumuman::where('id', $this->lelang_id)->first();
            $tanggal = $lelang->tanggal;
        } else {
            $tanggal = date('Y-m-d');
        }

        DB::beginTransaction();

        try {
            $lelang = ModelsPengumuman::updateOrCreate(['id' => $this->lelang_id], [
                'tanggal'      => $tanggal,
                'tanggal_lelang'   => $this->tanggal_lelang,
                'nama_barang'   => $this->nama_barang,
                'keterangan'   => $this->keterangan,
                'harga_limit'   => $this->harga_limit,
                'uang_jaminan'   => $this->uang_jaminan,
                'photo'   => $uploadedfilename,
                'status'   => 0,
            ]);
            DB::commit();

            $this->alert('success', $this->lelang_id ? 'Data berhasil diubah!' : 'Data berhasil ditambahkan!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $this->alert('error', 'Data gagal ditambahkan!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
        $this->resetInputFields();
        $this->dispatchBrowserEvent('closeModal');
    }

    public function resetInputFields()
    {
        $this->reset(['lelang_id', 'delete_id', 'tanggal_lelang', 'tanggal', 'nama_barang', 'keterangan', 'file_photo', 'photo', 'harga_limit', 'uang_jaminan']);
        $this->resetErrorBag();
    }

    public function photo($id)
    {
        $lelang = ModelsPengumuman::where('id', $id)->first();
        $this->lelang_id = $id;
        $this->photo = $lelang->photo;
    }

    public function edit($id)
    {
        $lelang = ModelsPengumuman::where('id', $id)->first();
        $this->lelang_id = $id;
        $this->tanggal = $lelang->tanggal;
        $this->tanggal_lelang = $lelang->tanggal_lelang;
        $this->nama_barang = $lelang->nama_barang;
        $this->keterangan = $lelang->keterangan;
        $this->uang_jaminan = $lelang->uang_jaminan;
        $this->photo = $lelang->photo;
        $this->harga_limit = $lelang->harga_limit;
    }

    public function deleteId($id)
    {
        $this->delete_id = $id;
    }

    public function destroy()
    {
        ModelsPengumuman::destroy($this->delete_id);

        $this->alert('success', 'Data berhasil dihapus.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
        $this->resetInputFields();
    }
}
