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
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>Dokumen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($lelang->isNotEmpty())
                                        @foreach ($lelang as $data)
                                            <tr>
                                                <td>{{ $data->tanggal }}</td>
                                                <td>{{ $data->deskripsi }}</td>
                                                <td>
                                                    <a href="{{ url('/storage/lelang/' . $data->file) }}"
                                                        target="_blank" class="btn btn-sm btn-primary">Unduh</a>
                                                </td>
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
                                            <td colspan="4" class="text-center">Belum ada data</td>
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
                            <label for="tanggalPengumuman">Tanggal</label>
                            <input type="date" wire:model.defer="tanggal" class="form-control"
                                id="tanggalPengumuman">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea wire:model.defer="deskripsi" class="form-control" id="deskripsi" rows="6"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="upload{{ $iteration }}">Dokumen <small>(PDF. Max:2MB)</small></label>
                            @if ($dokumen)
                                <br />
                                <a href="{{ url('/storage/lelang/' . $dokumen) }}" target="_blank"
                                    class="btn btn-sm btn-primary mb-2"><i class="fas fa-download"></i> Unduh</a>
                            @endif
                            <input type="file" wire:model="file_dokumen" class="form-control"
                                id="upload{{ $iteration }}" accept=".pdf" />
                            @error('file_dokumen')
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
