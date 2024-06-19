@section('title', 'Penetapan Penyitaan')
@push('footscripts')
    <script>
        document.addEventListener('closeModal', (event) => {
            $('#sitaModal').modal('hide');
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
                        <h1 class="m-0">Putusan Penyitaan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
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
                                        <th>Tersangka</th>
                                        <th>Barang Sitaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($sita->isNotEmpty())
                                        @foreach ($sita as $data)
                                            <tr>
                                                <td>{{ $data->no_penyitaan }}</td>
                                                <td>{{ $data->tanggal_penyitaan }}</td>
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
                                                    <button type="button" class="btn btn-warning btn-sm mb-1"
                                                        wire:click="edit({{ $data->id }})" data-toggle="modal"
                                                        data-target="#sitaModal">Edit</button>
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
