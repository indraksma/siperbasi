<?php

namespace App\Http\Livewire\Admin;

use App\Models\Putusan as ModelsPutusan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BarangBukti;
use Exception;
use Illuminate\Support\Facades\DB;

class Putusan extends Component
{
    use LivewireAlert, WithPagination;
    public $barang_bukti, $delete_id, $no_putusan, $tanggal_putusan, $pengadilan, $penuntut, $terpidana, $status_putusan, $putusan_id;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $putusan = ModelsPutusan::latest()->paginate(10);
        return view('livewire.admin.putusan', [
            'putusan' => $putusan,
        ]);
    }

    public function barbuk($id)
    {
        $barangbukti = BarangBukti::where('putusan_id', $id)->get();
        $this->barang_bukti = $barangbukti;
    }

    public function deleteId($id)
    {
        $this->delete_id = $id;
    }

    public function destroy()
    {
        $putusan = ModelsPutusan::where('id', $this->delete_id)->first();
        DB::beginTransaction();
        try {
            $bb = BarangBukti::where('penyitaan_id', $putusan->penyitaan_id)->get();
            if ($bb->isNotEmpty()) {
                foreach ($bb as $barbuk) {
                    $barbuk->update([
                        'putusan_id' => NULL,
                        'status' => 0,
                    ]);
                }
            }
            ModelsPutusan::destroy($this->delete_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->alert('error', 'Data gagal dihapus.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }

        $this->alert('success', 'Data berhasil dihapus.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->putusan_id = $id;
        $putusan = ModelsPutusan::where('id', $id)->first();
        $this->no_putusan = $putusan->no_putusan;
        $this->tanggal_putusan = $putusan->tanggal_putusan;
        $this->pengadilan = $putusan->pengadilan;
        $this->penuntut = $putusan->penuntut;
        $this->terpidana = $putusan->terpidana;
        $barangbukti = BarangBukti::where('putusan_id', $id)->get();
        $this->barang_bukti = $barangbukti;
        foreach ($barangbukti as $key => $val) {
            $this->status_putusan[$key] = $val->status;
        }
    }

    public function resetInputFields()
    {
        $this->reset(['delete_id', 'barang_bukti', 'no_putusan', 'tanggal_putusan', 'status_putusan', 'pengadilan', 'penuntut', 'terpidana', 'putusan_id']);
    }

    public function storePutusan()
    {

        DB::beginTransaction();

        try {
            $putusan = ModelsPutusan::where('id', $this->putusan_id)->first();
            $putusan->update([
                'tanggal_putusan' => $this->tanggal_putusan,
                'no_putusan' => $this->no_putusan,
                'pengadilan' => $this->pengadilan,
                'penuntut' => $this->penuntut,
                'terpidana' => $this->terpidana,
            ]);

            $barang_bukti = BarangBukti::where('putusan_id', $this->putusan_id)->get();

            foreach ($barang_bukti as $key => $bb) {
                $bb->update(['status' => $this->status_putusan[$key]]);
            }

            DB::commit();
            $this->alert('success', 'Data Berhasil Diubah!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $this->alert('error', 'Data Gagal Diubah!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
        $this->resetInputFields();
        $this->dispatchBrowserEvent('closeModal');
    }
}
