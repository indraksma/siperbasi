@section('title', 'Perkara')
@push('footscripts')
    <script>
        document.addEventListener('closeModal', (event) => {
            $('#perkaraModal').modal('hide');
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
                        <h1 class="m-0">Perkara</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Perkara</li>
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
                                <button type="button" class="btn btn-info mb-2" data-toggle="modal"
                                    data-target="#perkaraModal">Tambah</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No Perkara</th>
                                        <th>Tanggal Terima</th>
                                        <th>Tanggal Putusan</th>
                                        <th>Nama Tersangka</th>
                                        <th>Barang Bukti</th>
                                        <th>Amar Putusan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($perkara->isNotEmpty())
                                        @foreach ($perkara as $data)
                                            <tr>
                                                <td>{{ $data->no_perkara }}</td>
                                                <td>{{ $data->tanggal_terima }}</td>
                                                <td>
                                                    {{ $data->tanggal_putusan != null ? $data->tanggal_putusan : '-' }}
                                                </td>
                                                <td>{{ $data->nama_tersangka }}</td>
                                                <td>
                                                    <button type="button" data-toggle="modal" data-target="#modalBB"
                                                        wire:click="barbuk({{ $data->id }})"
                                                        class="btn btn-sm btn-primary">Detail</button>
                                                </td>
                                                <td>
                                                    {{ $data->amar_putusan != null ? $data->amar_putusan : '-' }}
                                                </td>
                                                <td>
                                                    <span class="badge badge-warning">Proses Pengadilan</span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm mb-1"
                                                        wire:click="edit({{ $data->id }})" data-toggle="modal"
                                                        data-target="#perkaraModal">Edit</button>
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
                        @if ($perkara->isNotEmpty())
                            <div class="mt-2">
                                {{ $perkara->links() }}
                            </div>
                        @endif
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
    </div>
    <!-- Modal Perkara -->
    <div wire:ignore.self class="modal fade" id="perkaraModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="perkaraModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="perkaraModalLabel">Data Perkara</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data" wire:submit.prevent="store()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nomorPerkara">Nomor Perkara</label>
                            <input type="text" wire:model.lazy="no_perkara" class="form-control" id="nomorPerkara"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="tanggalDiterima">Tanggal Diterima</label>
                            <input type="date" wire:model="tanggal_terima" class="form-control" id="tanggalDiterima"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="tanggalPutusan">Tanggal Putusan</label>
                            <input type="date" wire:model="tanggal_putusan" class="form-control" id="tanggalPutusan">
                        </div>
                        <div class="form-group">
                            <label for="amarPutusan">Amar Putusan</label>
                            <input type="text" wire:model.lazy="amar_putusan" class="form-control" id="amarPutusan">
                        </div>
                        <div class="form-group">
                            <label for="namaTersangka">Nama Tersangka</label>
                            <textarea wire:model.lazy="nama_tersangka" class="form-control" id="namaTersangka" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="barangBukti">Barang Bukti</label>
                            <textarea wire:model.lazy="barang_bukti" class="form-control" id="barangBukti" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="upload{{ $iteration }}">Foto Barang Bukti <small>(JPG/JPEG/PNG.
                                    Max:2MB)</small></label>
                            @if ($file_photo)
                                <br />
                                <img src="{{ $file_photo->temporaryUrl() }}" class="img-fluid my-2"
                                    style="max-width: 200px;">
                            @elseif($photo)
                                <br />
                                <img src="{{ asset('storage/bb/' . $photo) }}" class="img-fluid my-2"
                                    style="max-width: 200px;">
                            @endif
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" wire:model="file_photo" class="custom-file-input"
                                        id="upload{{ $iteration }}">
                                    <label class="custom-file-label" for="upload{{ $iteration }}">Choose
                                        file</label>
                                </div>
                            </div>
                            @error('file_photo')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="resetInputFields()"
                            data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Detail Perkara -->
    <div wire:ignore.self class="modal fade" id="modalBB" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="modalBBLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBBLabel">Barang Bukti</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($detailBB)
                        <table class="table table-bordered">
                            <tr>
                                <td>Barang Bukti :</td>
                                <td>{{ $barang_bukti }}</td>
                            </tr>
                            <tr>
                                <td>Foto Barang Bukti :</td>
                                <td>
                                    @if ($photo)
                                        <img src="{{ url('storage/bb/' . $photo) }}" class="img-fluid my-2"
                                            style="max-width: 200px;">
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    @endif
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
