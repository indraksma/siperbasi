@section('title', 'Tambah Data Penyitaan')
<div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Tambah Putusan Penyitaan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/admin/penyitaan') }}">Penyitaan</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
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
                    <form method="POST" enctype="multipart/form-data" wire:submit.prevent="store()">
                        <div class="card-body">
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
                                <input type="text" wire:model.lazy="pengadilan" class="form-control" id="pengadilan"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="penyidik">Penyidik</label>
                                <input type="text" wire:model.lazy="penyidik" class="form-control" id="penyidik"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="penuntut">Penuntut</label>
                                <input type="text" wire:model.lazy="penuntut" class="form-control" id="penuntut"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="namaTersangka">Nama Tersangka</label>
                                <textarea wire:model.lazy="tersangka" class="form-control" id="namaTersangka" rows="2" required></textarea>
                            </div>
                            @foreach ($inputs as $key => $input)
                                <hr />
                                <div class="form-group">
                                    <label for="input_{{ $key }}_bb">Barang Bukti {{ $key + 1 }}</label>
                                    @if ($key > 0)
                                        <button class="btn btn-sm btn-danger text-right" type="button"
                                            wire:click="removeInput({{ $key }})">Hapus BB
                                            {{ $key + 1 }}</button>
                                    @endif
                                    <textarea wire:model.lazy="inputs.{{ $key }}.nama_barang" class="form-control"
                                        id="input_{{ $key }}_bb" rows="2" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="upload_{{ $key }}_{{ $iteration }}">Foto Barang Bukti
                                        {{ $key + 1 }}
                                        (Optional)
                                        <small>(JPG/JPEG/PNG.
                                            Max:2MB)</small></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" wire:model="inputs.{{ $key }}.file_photo"
                                                id="upload_{{ $key }}_{{ $iteration }}">
                                        </div>
                                    </div>
                                    @error('inputs.{{ $key }}.file_photo')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endforeach
                            <button type="button" class="btn btn-success" wire:click="addInput()">Tambah Barang
                                Bukti</button>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary" wire:click="resetInputFields()"
                                data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
