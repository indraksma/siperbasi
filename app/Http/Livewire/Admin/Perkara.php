<?php

namespace App\Http\Livewire\Admin;

use App\Models\Perkara as ModelsPerkara;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Perkara extends Component
{
    use WithPagination, WithFileUploads, LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $no_perkara, $tanggal_terima, $tanggal_putusan, $amar_putusan, $nama_tersangka, $barang_bukti, $file_photo, $photo, $delete_id, $perkara_id, $status, $detailBB;
    public $iteration = 0;

    public function render()
    {
        $perkara = ModelsPerkara::latest()->paginate(10);
        return view('livewire.admin.perkara', [
            'iteration' => $this->iteration,
            'perkara' => $perkara,
        ]);
    }

    public function store()
    {

        if ($this->file_photo) {
            $this->validate(['file_photo' => 'required|image|max:2048']);

            $filename = 'bb_' . date('YmdHis');
            $uploadedfilename = $filename . '.' . $this->file_photo->getClientOriginalExtension();
            $this->file_photo->storeAs('public/bb', $uploadedfilename);
            $this->iteration = $this->iteration + 1;
        } else {
            if ($this->perkara_id) {
                $uploadedfilename = $this->photo;
            }
        }

        DB::beginTransaction();

        try {
            $perkara = ModelsPerkara::updateOrCreate(['id' => $this->perkara_id], [
                'no_perkara'      => $this->no_perkara,
                'tanggal_terima'   => $this->tanggal_terima,
                'tanggal_putusan'   => $this->tanggal_putusan,
                'amar_putusan'   => $this->amar_putusan,
                'nama_tersangka'   => $this->nama_tersangka,
                'barang_bukti'   => $this->barang_bukti,
                'photo'   => $uploadedfilename,
                'status'   => 0,
                'user_id'   => Auth::user()->id,
            ]);
            DB::commit();

            $this->alert('success', $this->perkara_id ? 'Data berhasil diubah!' : 'Data berhasil ditambahkan!', [
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

    public function barbuk($id)
    {
        $perkara = ModelsPerkara::where('id', $id)->first();
        $this->barang_bukti = $perkara->barang_bukti;
        $this->photo = $perkara->photo;
        $this->detailBB = true;
    }

    public function edit($id)
    {
        $perkara = ModelsPerkara::where('id', $id)->first();
        $this->perkara_id = $id;
        $this->no_perkara = $perkara->no_perkara;
        $this->tanggal_terima = $perkara->tanggal_terima;
        $this->tanggal_putusan = $perkara->tanggal_putusan;
        $this->amar_putusan = $perkara->amar_putusan;
        $this->nama_tersangka = $perkara->nama_tersangka;
        $this->photo = $perkara->photo;
        $this->barang_bukti = $perkara->barang_bukti;
    }

    public function deleteId($id)
    {
        $this->delete_id = $id;
    }

    public function destroy()
    {
        ModelsPerkara::destroy($this->delete_id);

        $this->alert('success', 'Data berhasil dihapus.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->reset(['no_perkara', 'tanggal_terima', 'tanggal_putusan', 'amar_putusan', 'nama_tersangka', 'barang_bukti', 'file_photo', 'photo', 'delete_id', 'perkara_id', 'status', 'detailBB']);
        $this->resetErrorBag();
    }
}
