@section('title', 'Barang Bukti')
@push('footscripts')
    <script>
        document.addEventListener('closeModal', (event) => {
            $('#bbModal').modal('hide');
        });
        document.addEventListener('closeModalEksekusi', (event) => {
            $('#eksekusiModal').modal('hide');
        });
    </script>
@endpush
<div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Barang Bukti</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Barang Bukti</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary mb-2" wire:click="$emit('tambahData')"
                                    data-toggle="modal" data-target="#bbModal">Tambah</button>
                                <button class="btn btn-secondary mb-2 float-right" data-toggle="modal"
                                    data-target="#exportBbModal">Export</button>
                            </div>
                        </div>
                        {{-- <div class="table-responsive"> --}}
                        <livewire:admin.bb-table />
                        {{-- </div> --}}
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
    </div>
    <!-- Modal Export Barang Bukti -->
    <div wire:ignore.self class="modal fade" id="exportBbModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exportBbModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportBbModalLabel">Export Data Barang Bukti</h5>
                    <button type="button" wire:click="resetInputFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="GET" action="{{ route('export.barbuk') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="start_date">Tanggal Awal</label>
                            <input type="date" wire:model="startDate" name="start_date" class="form-control"
                                id="start_date" required />
                        </div>
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" wire:model="endDate" name="end_date" class="form-control"
                                id="end_date" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Export</button>
                        <button type="button" wire:click="resetInputFields()" data-dismiss="modal"
                            class="btn btn-secondary float-right">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Detail Eksekusi -->
    <div wire:ignore.self class="modal fade" id="detailEksekusi" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="detailEksekusiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailEksekusiLabel">Eksekusi Barang Bukti</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($eksekusi)
                        <table class="table table-bordered">
                            <tr>
                                <th>Tanggal Eksekusi</th>
                                <th>Nama Barang</th>
                                <th>Keterangan</th>
                                <th>Foto</th>
                            </tr>
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($eksekusi->tanggal_eksekusi)->isoFormat('D MMMM Y') }}
                                </td>
                                <td>{{ $eksekusi->nama_barang }}</td>
                                <td>{{ $eksekusi->ket_eksekusi }}</td>
                                <td>
                                    @if ($eksekusi->foto_eksekusi)
                                        <img src="{{ url('storage/eksekusi/' . $eksekusi->foto_eksekusi) }}"
                                            class="img-fluid my-2" style="max-width: 300px;">
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <button class="btn btn-warning" wire:click="editEksekusi({{ $eksekusi->id }})"
                            data-toggle="modal" data-target="#eksekusiModal" data-dismiss="modal">Edit
                            Eksekusi</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Barang Bukti -->
    <div wire:ignore.self class="modal fade" id="bbModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="bbModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bbModalLabel">Data Barang Bukti</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" wire:submit.prevent="store()">
                    <div class="modal-body">
                        @if ($tambah === true)
                            <div class="form-group">
                                <label for="noPenyitaan">No Penetapan Penyitaan</label>
                                <div class="input-group">
                                    <input wire:model.lazy="no_penyitaan"
                                        class="form-control {{ $not_found === false ? 'is-valid' : ($not_found === true ? 'is-invalid' : '') }}"
                                        id="noPenyitaan" required>
                                    <div class="input-group-append">
                                        <button type="button" wire:click="cekSita()" class="btn btn-success"
                                            type="button">Cek</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="input_0_tglRegister">Tanggal Register</label>
                            <input type="date" wire:model="tanggal_register" class="form-control"
                                id="input_0_tglRegister" required />
                        </div>
                        <div class="form-group">
                            <label for="input_0_noReg">No Register</label>
                            <input type="text" wire:model.lazy="no_register" class="form-control"
                                id="input_0_noReg" required />
                        </div>
                        <div class="form-group">
                            <label for="input_0_bb">Nama Barang</label>
                            <input type="text" wire:model.lazy="nama_barang" class="form-control" id="input_0_bb"
                                required />
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" wire:model="ekonomis_tinggi"
                                id="input_0_cekEkonomis">
                            <label class="form-check-label text-bold" for="input_0_cekEkonomis">Ekonomis
                                Tinggi</label>
                        </div>
                        <div class="form-group">
                            <label for="input_0_satuan">Satuan</label>
                            <input type="text" wire:model.lazy="satuan" class="form-control" id="input_0_satuan"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="input_0_kondisi">Kondisi</label>
                            <select wire:model="kondisi" class="form-control" id="input_0_kondisi" required>
                                <option value="">-- Pilih --</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan_0_sidang">Keterangan Sidang</label>
                            <textarea wire:model.lazy="ket_sidang" class="form-control" id="keterangan_0_sidang" rows="2" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="keterangan_0_bb">Keterangan Barang</label>
                            <textarea wire:model.lazy="keterangan" class="form-control" id="keterangan_0_bb" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="upload_{{ $iteration }}">Foto Barang Bukti
                                (Optional)
                                <small>(JPG/JPEG/PNG.
                                    Max:2MB)</small></label>
                            @if ($foto)
                                <br />
                                <img src="{{ url('storage/bb/' . $foto) }}" class="img-fluid my-2"
                                    style="max-width: 200px;">
                                <br />
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="hapusFotoBB">Hapus</button>
                                <br />
                            @endif
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" wire:model="file_photo" id="upload_{{ $iteration }}">
                                </div>
                            </div>
                            @error('file_photo')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($not_found === false && $no_putusan != '-')
                                <hr />
                                <div class="form-group">
                                    <label for="noPutusan">No Putusan Pengadilan</label>
                                    <input wire:model.lazy="no_putusan" class="form-control" id="noPutusan" readonly>
                                </div>
                            @endif
                            @if ($status === true)
                                <div class="form-group">
                                    <label for="statusBB">Amar Putusan</label>
                                    <select class="form-control" wire:model="status_putusan" id="statusBB" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Dikembalikan kepada yang berhak</option>
                                        <option value="2">Dirampas untuk Dimusnahkan</option>
                                        <option value="3">Dirampas untuk negara</option>
                                        <option value="4">Dirampas untuk negara c.q. Kementerian / Lembaga
                                        </option>
                                        <option value="5">Dirampas untuk negara dan Diperhitungkan untuk Uang
                                            Pengganti</option>
                                        <option value="8">Dipergunakan dalam Perkara Lain</option>
                                        <option value="7">Terlampir dalam berkas</option>
                                        <option value="6">Lainnya</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if ($tambah === true)
                            @if ($not_found === false)
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            @endif
                            <a href="#" wire:click="resetInputFields()" data-dismiss="modal"
                                class="btn btn-secondary float-right">Batal</a>
                        @elseif($tambah === false)
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" wire:click="resetInputFields()" data-dismiss="modal"
                                class="btn btn-secondary float-right">Batal</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Eksekusi -->
    <div wire:ignore.self class="modal fade" id="eksekusiModal" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="eksekusiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eksekusiModalLabel">Eksekusi Barang Bukti</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="eksekusiForm" method="POST" wire:submit.prevent="storeEksekusi()">
                        <div class="form-group">
                            <label for="tglEksekusi">Tanggal Eksekusi</label>
                            <input type="date" wire:model.lazy="tanggal_eksekusi" class="form-control"
                                id="tglEksekusi" required />
                        </div>
                        <div class="form-group">
                            <label for="ketEksekusi">Keterangan</label>
                            <textarea wire:model.lazy="keterangan_eksekusi" class="form-control" id="ketEksekusi" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exc_{{ $iteration }}">Foto Eksekusi
                                (Optional)
                                <small>(JPG/JPEG/PNG.
                                    Max:2MB)</small></label>
                            @if ($foto_eksekusi)
                                <img src="/storage/eksekusi/{{ $foto_eksekusi }}" class="img-fluid mb-2" />
                                <br />
                                <button type="button" class="btn btn-sm btn-danger"
                                    wire:click="hapusFotoEks">Hapus</button>
                            @endif
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept=".jpg,.jpeg,.png" wire:model="file_eksekusi"
                                        id="exc_{{ $iteration }}">
                                </div>
                            </div>
                            @error('file_eksekusi')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="eksekusiForm" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="resetInputFields()" data-dismiss="modal"
                        class="btn btn-secondary float-right">Batal</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Hapus -->
    <div wire:ignore.self class="modal fade" data-backdrop="static" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="resetInputFields()" class="btn btn-dark close-btn"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" wire:click.prevent="destroy()" class="btn btn-danger close-modal"
                        data-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
