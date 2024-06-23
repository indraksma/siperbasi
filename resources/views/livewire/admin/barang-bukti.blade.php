@section('title', 'Barang Bukti')
@push('footscripts')
    <script>
        document.addEventListener('closeModal', (event) => {
            $('#bbModal').modal('hide');
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
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
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
                            <div class="col-12 text-right">
                                <button class="btn btn-primary mb-2" wire:click="$emit('tambahData')"
                                    data-toggle="modal" data-target="#bbModal">Tambah</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <livewire:admin.bb-table />
                        </div>
                        @if ($barangbukti->isNotEmpty())
                            <div class="mt-2">
                                {{ $barangbukti->links() }}
                            </div>
                        @endif
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
    </div><!-- Modal Tambah Barang Bukti -->
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
                                <label for="noPenyitaan">No Penetapan Penyitaan {{ $tambah }}</label>
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
                            <label for="input_0_bb">Nama Barang</label>
                            <textarea wire:model.lazy="nama_barang" class="form-control" id="input_0_bb" rows="2" required></textarea>
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
                                        <option value="1">Dikembalikan</option>
                                        <option value="2">Dimusnahkan</option>
                                        <option value="3">Dirampas untuk negara (Lelang)</option>
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
