<?php

namespace App\Http\Livewire\Admin;

use App\Models\BarangBukti;
use App\Models\Penetapan;
use App\Models\Penyitaan as ModelsPenyitaan;
use App\Models\Putusan;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Penyitaan extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $delete_id, $barang_bukti, $no_putusan, $tanggal_putusan, $pengadilan, $penuntut, $terpidana, $penyitaan_id, $status_putusan;
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
        $this->reset(['delete_id', 'barang_bukti', 'tanggal_putusan', 'no_putusan', 'pengadilan', 'penuntut', 'terpidana', 'penyitaan_id', 'status_putusan']);
    }

    public function deleteId($id)
    {
        $this->delete_id = $id;
    }

    public function destroy()
    {
        $bb = BarangBukti::where('penyitaan_id', $this->delete_id)->get();

        DB::beginTransaction();
        try {
            if ($bb->isNotEmpty()) {
                BarangBukti::where('penyitaan_id', $this->delete_id)->delete();
            }
            $putusan = Putusan::where('penyitaan_id', $this->delete_id)->get();
            if ($putusan->isNotEmpty()) {
                Putusan::where('penyitaan_id', $this->delete_id)->delete();
            }
            ModelsPenyitaan::destroy($this->delete_id);
            DB::commit();
            if ($bb->isNotEmpty()) {
                foreach ($bb as $data) {
                    if ($data->foto != NULL) {
                        Storage::disk('public')->delete('bb/' . $data->foto);
                    }
                }
            }
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

    public function barbuk($id)
    {
        $barangbukti = BarangBukti::where('penyitaan_id', $id)->get();
        $this->barang_bukti = $barangbukti;
    }

    public function putusan($id)
    {
        $barangbukti = BarangBukti::where('penyitaan_id', $id)->get();
        $penyitaan = ModelsPenyitaan::where('id', $id)->first();
        $this->barang_bukti = $barangbukti;
        $this->penyitaan_id = $id;
        $this->terpidana = $penyitaan->tersangka;
    }

    public function storePutusan()
    {

        DB::beginTransaction();

        try {
            $putusan = Putusan::create([
                'penyitaan_id' => $this->penyitaan_id,
                'tanggal_putusan' => $this->tanggal_putusan,
                'no_putusan' => $this->no_putusan,
                'pengadilan' => $this->pengadilan,
                'penuntut' => $this->penuntut,
                'terpidana' => $this->terpidana,
            ]);

            $barang_bukti = BarangBukti::where('penyitaan_id', $this->penyitaan_id)->get();

            foreach ($barang_bukti as $key => $bb) {
                $bb->update(['putusan_id' => $putusan->id, 'status' => $this->status_putusan[$key]]);
            }

            DB::commit();
            $this->alert('success', 'Data Berhasil Ditambahkan!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $this->alert('error', 'Data Gagal Ditambahkan!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
        $this->resetInputFields();
        $this->dispatchBrowserEvent('closeModal');
    }
}
