@section('title', 'Pengumuman Lelang')
@push('footscripts')
    <script>
        document.addEventListener('closeModal', (event) => {
            $('#lelangModal').modal('hide');
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
                        <h1 class="m-0">Pengumuman Lelang</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active">Pengumuman Lelang</li>
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
                                    data-target="#lelangModal">Tambah</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pengumuman</th>
                                        <th>Nama Barang</th>
                                        <th>Keterangan</th>
                                        <th>Foto</th>
                                        <th>Tanggal Lelang</th>
                                        <th>Harga Limit</th>
                                        <th>Uang Jaminan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($lelang->isNotEmpty())
                                        @foreach ($lelang as $data)
                                            <tr>
                                                <td>{{ $data->tanggal }}</td>
                                                <td>{{ $data->nama_barang }}</td>
                                                <td>{{ $data->keterangan }}</td>
                                                <td>
                                                    <button type="button" data-toggle="modal" data-target="#modalPhoto"
                                                        wire:click="photo({{ $data->id }})"
                                                        class="btn btn-sm btn-primary">Lihat</button>
                                                </td>
                                                <td>{{ $data->tanggal_lelang }}</td>
                                                <td>{{ $data->harga_limit }}</td>
                                                <td>{{ $data->uang_jaminan }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm mb-1"
                                                        wire:click="edit({{ $data->id }})" data-toggle="modal"
                                                        data-target="#lelangModal">Edit</button>
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
                        @if ($lelang->isNotEmpty())
                            <div class="mt-2">
                                {{ $lelang->links() }}
                            </div>
                        @endif
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
    </div>
    <!-- Modal Lelang -->
    <div wire:ignore.self class="modal fade" id="lelangModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="lelangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lelangModalLabel">Data Pengumuman Lelang</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data" wire:submit.prevent="store()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tanggalLelang">Tanggal Lelang</label>
                            <input type="date" wire:model="tanggal_lelang" class="form-control" id="tanggalLelang">
                        </div>
                        <div class="form-group">
                            <label for="hargaLimit">Harga Limit</label>
                            <input type="number" wire:model.lazy="harga_limit" class="form-control" id="hargaLimit">
                        </div>
                        <div class="form-group">
                            <label for="uangJaminan">Uang Jaminan</label>
                            <input type="number" wire:model.lazy="uang_jaminan" class="form-control" id="uangJaminan">
                        </div>
                        <div class="form-group">
                            <label for="namaBarang">Nama Barang</label>
                            <textarea wire:model.lazy="nama_barang" class="form-control" id="namaBarang" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea wire:model.lazy="keterangan" class="form-control" id="keterangan" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="upload{{ $iteration }}">Foto Barang<small>(JPG/JPEG/PNG.
                                    Max:2MB)</small></label>
                            @if ($file_photo)
                                <br />
                                <img src="{{ $file_photo->temporaryUrl() }}" class="img-fluid my-2"
                                    style="max-width: 200px;">
                            @elseif($photo)
                                <br />
                                <img src="{{ asset('storage/lelang/' . $photo) }}" class="img-fluid my-2"
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
    <!-- Modal Photo -->
    <div wire:ignore.self class="modal fade" id="modalPhoto" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="modalPhotoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPhotoLabel">Photo</h5>
                    <button type="button" class="close" wire:click="resetInputFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($lelang_id)
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    @if ($photo)
                                        <img src="{{ url('storage/lelang/' . $photo) }}" class="img-fluid my-2"
                                            style="max-width: 100%;">
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
