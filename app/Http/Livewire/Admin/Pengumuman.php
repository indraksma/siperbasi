<?php

namespace App\Http\Livewire\Admin;

use App\Models\Pengumuman as ModelsPengumuman;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Pengumuman extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $iteration = 0;
    public $tanggal, $deskripsi, $file_dokumen, $lelang_id, $delete_id, $dokumen;

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
    }

    public function render()
    {
        $lelang = ModelsPengumuman::latest()->paginate(10);
        return view('livewire.admin.pengumuman', [
            'iteration' => $this->iteration,
            'lelang' => $lelang,
        ]);
    }

    private function uploadDokumen($file)
    {
        $filename = 'll_' . date('YmdHis');
        $uploadedfilename = $filename . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/lelang', $uploadedfilename);
        $this->iteration = $this->iteration + 1;
        return $uploadedfilename;
    }

    public function store()
    {
        if ($this->lelang_id) {
            if ($this->file_dokumen) {
                $this->validate(['file_dokumen' => 'required|mimes:pdf|max:2048']);
                $uploadedfilename = $this->uploadDokumen($this->file_dokumen);
            } else {
                $lelang = ModelsPengumuman::where('id', $this->lelang_id)->first();
                $uploadedfilename = $lelang->file;
            }
        } else {
            $this->validate(['file_dokumen' => 'required|mimes:pdf|max:2048']);
            $uploadedfilename = $this->uploadDokumen($this->file_dokumen);
        }

        DB::beginTransaction();

        try {
            $lelang = ModelsPengumuman::updateOrCreate(['id' => $this->lelang_id], [
                'tanggal'      => $this->tanggal,
                'deskripsi'   => $this->deskripsi,
                'file'   => $uploadedfilename,
            ]);
            DB::commit();

            $this->alert('success', $this->lelang_id ? 'Data berhasil diubah!' : 'Data berhasil ditambahkan!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
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
        $this->reset(['lelang_id', 'delete_id', 'deskripsi', 'file_dokumen', 'dokumen']);
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $lelang = ModelsPengumuman::where('id', $id)->first();
        $this->lelang_id = $id;
        $this->tanggal = $lelang->tanggal;
        $this->deskripsi = $lelang->deskripsi;
        $this->dokumen = $lelang->file;
    }

    public function deleteId($id)
    {
        $this->delete_id = $id;
    }

    public function destroy()
    {
        $lelang = ModelsPengumuman::where('id', $this->delete_id)->first();

        Storage::disk('public')->delete('lelang/' . $lelang->file);

        ModelsPengumuman::destroy($this->delete_id);

        $this->alert('success', 'Data berhasil dihapus.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
        $this->resetInputFields();
    }
}
