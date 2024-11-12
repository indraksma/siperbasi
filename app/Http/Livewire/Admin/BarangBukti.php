<?php

namespace App\Http\Livewire\Admin;

use App\Models\BarangBukti as ModelsBarangBukti;
use App\Models\Penyitaan;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BarangBukti extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['edit' => 'edit', 'deleteId' => 'deleteId', 'tambahData' => 'tambahData', 'eksekusi' => 'eksekusi', 'detailEksekusi' => 'detailEksekusi'];
    public $bb_id, $delete_id, $nama_barang, $file_photo, $foto, $no_penyitaan, $no_sita, $not_found, $no_putusan, $status_putusan, $keterangan, $keterangan_eksekusi, $tanggal_eksekusi, $file_eksekusi, $eksekusi, $foto_eksekusi, $deletefotobb, $deletefotoeks;
    public $no_register, $ket_sidang, $tanggal_register, $kondisi, $satuan, $ekonomis_tinggi;
    public $startDate, $endDate;
    public $tambah = FALSE;
    public $status = FALSE;
    public $iteration = 0;

    public function mount()
    {
        $this->tanggal_eksekusi = date('Y-m-d');
    }

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
        $bb = ModelsBarangBukti::where('id', $this->delete_id)->first();
        if ($bb->foto != NULL) {
            Storage::disk('public')->delete('bb/' . $bb->foto);
        }

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
        $this->keterangan = $bb->keterangan;
        $this->foto = $bb->foto;
        $this->satuan = $bb->satuan;
        $this->ket_sidang = $bb->ket_sidang;
        // $this->no_register = $bb->no_register;
        // $this->tanggal_register = $bb->tanggal_register;
        $this->kondisi = $bb->kondisi;
        $this->ekonomis_tinggi = $bb->ekonomis_tinggi;
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
        $this->reset(['bb_id', 'delete_id', 'no_penyitaan', 'no_sita', 'nama_barang', 'file_photo', 'not_found', 'no_putusan', 'status_putusan', 'foto', 'keterangan', 'keterangan_eksekusi', 'file_eksekusi', 'tanggal_eksekusi', 'eksekusi', 'foto_eksekusi', 'deletefotobb', 'deletefotoeks']);
        $this->reset(['tanggal_register', 'no_register', 'kondisi', 'ket_sidang', 'satuan', 'ekonomis_tinggi']);
        $this->reset(['startDate', 'endDate']);
        $this->deletefotobb = FALSE;
        $this->deletefotoeks = FALSE;
        $this->tanggal_eksekusi = date('Y-m-d');
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
            if ($this->deletefotobb) {
                $bb->update([
                    'nama_barang' => $this->nama_barang,
                    'keterangan' => $this->keterangan,
                    'foto' => NULL,
                    'status' => $this->status_putusan,
                    'satuan' => $this->satuan,
                    'kondisi' => $this->kondisi,
                    'ekonomis_tinggi' => $this->ekonomis_tinggi,
                    // 'no_register' => $this->no_register,
                    // 'tanggal_register' => $this->tanggal_register,
                    'ket_sidang' => $this->ket_sidang,
                ]);
            } else {
                $bb->update([
                    'nama_barang' => $this->nama_barang,
                    'keterangan' => $this->keterangan,
                    'foto' => $uploadedfilename,
                    'status' => $this->status_putusan,
                    'satuan' => $this->satuan,
                    'kondisi' => $this->kondisi,
                    'ekonomis_tinggi' => $this->ekonomis_tinggi,
                    // 'no_register' => $this->no_register,
                    // 'tanggal_register' => $this->tanggal_register,
                    'ket_sidang' => $this->ket_sidang,
                ]);
            }

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
                'keterangan' => $this->keterangan,
                'satuan' => $this->satuan,
                'kondisi' => $this->kondisi,
                'ekonomis_tinggi' => $this->ekonomis_tinggi,
                // 'no_register' => $this->no_register,
                // 'tanggal_register' => $this->tanggal_register,
                'ket_sidang' => $this->ket_sidang,
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

    public function eksekusi($id)
    {
        $this->bb_id = $id;
    }

    public function editEksekusi($id)
    {
        $this->bb_id = $id;
        $eksekusi = ModelsBarangBukti::where('id', $id)->first();
        $this->tanggal_eksekusi = $eksekusi->tanggal_eksekusi;
        $this->keterangan_eksekusi = $eksekusi->ket_eksekusi;
        if ($eksekusi->foto_eksekusi != NULL) {
            $this->foto_eksekusi = $eksekusi->foto_eksekusi;
        }
    }

    public function detailEksekusi($id)
    {
        $this->eksekusi = ModelsBarangBukti::where('id', $id)->first();
    }

    public function storeEksekusi()
    {
        $bb = ModelsBarangBukti::where('id', $this->bb_id)->first();
        if (isset($this->file_eksekusi)) {
            $this->validate(['file_eksekusi' => 'required|image|max:2048']);
            $filename = 'exc_' . date('YmdHis');
            $uploadedfilename = $filename . '.' . $this->file_eksekusi->getClientOriginalExtension();
            $this->file_eksekusi->storeAs('public/eksekusi', $uploadedfilename);
        } else {
            $uploadedfilename = $bb->foto_eksekusi;
        }
        if ($this->deletefotoeks) {
            $bb->update([
                'tanggal_eksekusi' => $this->tanggal_eksekusi,
                'ket_eksekusi' => $this->keterangan_eksekusi,
                'foto_eksekusi' => NULL,
            ]);
        } else {
            $bb->update([
                'tanggal_eksekusi' => $this->tanggal_eksekusi,
                'ket_eksekusi' => $this->keterangan_eksekusi,
                'foto_eksekusi' => $uploadedfilename,
            ]);
        }

        $this->alert('success', 'Data berhasil ditambahkan.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);

        $this->dispatchBrowserEvent('closeModalEksekusi');

        $this->resetInputFields();
        $this->emit('refreshBbTable');
    }

    public function hapusFotoBB()
    {
        $this->reset('foto');
        $this->deletefotobb = TRUE;
    }
    public function hapusFotoEks()
    {
        $this->reset('foto_eksekusi');
        $this->deletefotoeks = TRUE;
    }
}
