@section('title', 'Penetapan Penyitaan')
@push('footscripts')
    <script>
        document.addEventListener('closeModal', (event) => {
            $('#putusanModal').modal('hide');
        });
        document.addEventListener('closeModalEdit', (event) => {
            $('#penyitaanModal').modal('hide');
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
                        <h1 class="m-0">Penetapan Penyitaan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Penyitaan</li>
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
                            <div class="col-12 text-right">
                                <a class="btn btn-info mb-2" href="{{ route('admin.addpenyitaan') }}">Tambah</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>No Penetapan Penyitaan</th>
                                        <th>Pengadilan</th>
                                        <th>Penyidik</th>
                                        <th>Penuntut Umum</th>
                                        <th>Terdakwa</th>
                                        <th>Barang Sitaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($sita->isNotEmpty())
                                        @foreach ($sita as $data)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($data->tanggal_penyitaan)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $data->no_penyitaan }}</td>
                                                <td>{{ $data->pengadilan }}</td>
                                                <td>{{ $data->penyidik }}</td>
                                                <td>{{ $data->penuntut }}</td>
                                                <td>{{ $data->tersangka }}</td>
                                                <td>
                                                    <button type="button" data-toggle="modal" data-target="#modalBB"
                                                        wire:click="barbuk({{ $data->id }})"
                                                        class="btn btn-sm btn-primary">Detail</button>
                                                </td>
                                                <td>
                                                    @if (!$data->putusan)
                                                        <button type="button" class="btn btn-info btn-sm mb-1"
                                                            wire:click="putusan({{ $data->id }})"
                                                            data-toggle="modal" data-target="#putusanModal"><i
                                                                class="fas fa-plus"></i>
                                                            Putusan</button>
                                                    @endif
                                                    <button type="button"
                                                        wire:click="editPenyitaan({{ $data->id }})"
                                                        data-toggle="modal" data-target="#penyitaanModal"
                                                        class="btn btn-warning btn-sm mb-1">Edit</button>
                                                    <button type="button" wire:click="deleteId({{ $data->id }})"
                                                        data-toggle="modal" data-target="#deleteModal"
                                                        class="btn btn-danger btn-sm mb-1">Hapus</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center">Belum ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if ($sita->isNotEmpty())
                            <div class="mt-2">
                                {{ $sita->links() }}
                            </div>
                        @endif
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
    </div>
    <!-- Modal Detail Perkara -->
    <div wire:ignore.self class="modal fade" id="modalBB" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="modalBBLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBBLabel">Barang Bukti</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($barang_bukti)
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Keterangan</th>
                                <th>Foto</th>
                            </tr>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($barang_bukti as $bb)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $bb->nama_barang }}</td>
                                    <td>{{ $bb->keterangan }}</td>
                                    <td>
                                        @if ($bb->foto)
                                            <img src="{{ url('storage/bb/' . $bb->foto) }}" class="img-fluid my-2"
                                                style="max-width: 300px;">
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $no++;
                                @endphp
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Putusan -->
    <div wire:ignore.self class="modal fade" id="putusanModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="putusanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="putusanModalLabel">Tambah Putusan Pengadilan</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" wire:submit.prevent="storePutusan()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nomorPutusan">Nomor Putusan</label>
                            <input type="text" wire:model.lazy="no_putusan" class="form-control" id="nomorPutusan"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="tanggalPutusan">Tanggal</label>
                            <input type="date" wire:model="tanggal_putusan" class="form-control"
                                id="tanggalPutusan" required>
                        </div>
                        <div class="form-group">
                            <label for="pengadilan">Pengadilan</label>
                            <input type="text" wire:model.lazy="pengadilan" class="form-control" id="pengadilan"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="penuntut">Penuntut</label>
                            <input type="text" wire:model.lazy="penuntut" class="form-control" id="penuntut"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="namaTerpidana">Nama Terpidana</label>
                            <input type="text" wire:model.lazy="terpidana" class="form-control"
                                id="namaTerpidana" readonly>
                        </div>
                        <hr />
                        <h5>Barang Bukti</h5>
                        @if ($barang_bukti)
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Keterangan</th>
                                    <th>Foto</th>
                                    <th>Putusan</th>
                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($barang_bukti as $key => $bb)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $bb->nama_barang }}</td>
                                        <td>{{ $bb->keterangan }}</td>
                                        <td>
                                            @if ($bb->foto)
                                                <img src="{{ url('storage/bb/' . $bb->foto) }}"
                                                    class="img-fluid my-2" style="max-width: 200px;">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <select class="form-control"
                                                wire:model="status_putusan.{{ $key }}" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="1">Dikembalikan kepada yang berhak</option>
                                                <option value="2">Dirampas untuk Dimusnahkan</option>
                                                <option value="3">Dirampas untuk negara</option>
                                                <option value="4">Dirampas untuk negara c.q. Kementerian / Lembaga
                                                </option>
                                                <option value="5">Dirampas untuk negara dan Diperhitungkan untuk
                                                    Uang
                                                    Pengganti</option>
                                                <option value="8">Dipergunakan dalam Perkara Lain</option>
                                                <option value="7">Terlampir dalam berkas</option>
                                                <option value="6">Lainnya</option>
                                            </select>
                                        </td>
                                    </tr>
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            </table>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" wire:click="resetInputFields()" class="btn btn-secondary float-right"
                            data-dismiss="modal">Batal</button>
                    </div>
                </form>
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
    <!-- Modal Edit Penyitaan -->
    <div wire:ignore.self class="modal fade" id="penyitaanModal" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="penyitaanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penyitaanModalLabel">Edit Penetapan Penyitaan</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="editPenyitaanForm" wire:submit.prevent="updatePenyitaan()">
                        <div class="form-group">
                            <label for="nomorSita">Nomor Penetapan Penyitaan</label>
                            <input type="text" wire:model.lazy="no_penyitaan" class="form-control" id="nomorSita"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="tanggalSita">Tanggal</label>
                            <input type="date" wire:model="tanggal_penyitaan" class="form-control"
                                id="tanggalSita" required>
                        </div>
                        <div class="form-group">
                            <label for="pengadilan">Pengadilan</label>
                            <input type="text" wire:model.lazy="pengadilan_sita" class="form-control"
                                id="pengadilan" required>
                        </div>
                        <div class="form-group">
                            <label for="penyidik">Penyidik</label>
                            <input type="text" wire:model.lazy="penyidik" class="form-control" id="penyidik"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="penuntut">Penuntut</label>
                            <input type="text" wire:model.lazy="penuntut_sita" class="form-control"
                                id="penuntut" required>
                        </div>
                        <div class="form-group">
                            <label for="namaTersangka">Nama Terdakwa</label>
                            <input type="text" wire:model.lazy="tersangka" class="form-control"
                                id="namaTersangka" rows="2" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="editPenyitaanForm" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="resetInputFields()" class="btn btn-secondary float-right"
                        data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
