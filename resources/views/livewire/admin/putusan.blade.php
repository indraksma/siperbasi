@section('title', 'Putusan Pengadilan')
@push('footscripts')
    <script>
        document.addEventListener('closeModal', (event) => {
            $('#putusanModal').modal('hide');
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
                        <h1 class="m-0">Putusan Pengadilan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Putusan</li>
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
                        <livewire:putusan-table />
                        {{-- <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>No Putusan Pengadilan</th>
                                        <th>Pengadilan</th>
                                        <th>Penuntut Umum</th>
                                        <th>Terpidana</th>
                                        <th>Amar Putusan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($putusan->isNotEmpty())
                                        @foreach ($putusan as $data)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($data->tanggal_putusan)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $data->no_putusan }}</td>
                                                <td>{{ $data->pengadilan }}</td>
                                                <td>{{ $data->penuntut }}</td>
                                                <td>{{ $data->terpidana }}</td>
                                                <td>
                                                    <button type="button" data-toggle="modal" data-target="#modalBB"
                                                        wire:click="barbuk({{ $data->id }})"
                                                        class="btn btn-sm btn-primary">Detail</button>
                                                </td>
                                                <td>
                                                    <button type="button" wire:click="edit({{ $data->id }})"
                                                        data-toggle="modal" data-target="#putusanModal"
                                                        class="btn btn-warning btn-sm mb-1">Edit</button>
                                                    <button type="button" wire:click="deleteId({{ $data->id }})"
                                                        data-toggle="modal" data-target="#deleteModal"
                                                        class="btn btn-danger btn-sm mb-1">Hapus</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Belum ada data</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if ($putusan->isNotEmpty())
                            <div class="mt-2">
                                {{ $putusan->links() }}
                            </div>
                        @endif --}}
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
                                <th>Foto</th>
                                <th>Amar Putusan</th>
                            </tr>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($barang_bukti as $bb)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $bb->nama_barang }}</td>
                                    <td>
                                        @if ($bb->foto)
                                            <img src="{{ url('storage/bb/' . $bb->foto) }}" class="img-fluid my-2"
                                                style="max-width: 300px;">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($bb->status == 1)
                                            <span class="badge badge-primary">Dikembalikan kepada yang
                                                berhak</span>
                                        @elseif($bb->status == 2)
                                            <span class="badge badge-danger">Dirampas untuk Dimusnahkan</span>
                                        @elseif($bb->status == 3)
                                            <span class="badge badge-success">Dirampas untuk negara
                                            </span>
                                        @elseif($bb->status == 4)
                                            <span class="badge badge-success">Dirampas untuk negara c.q. Kementerian /
                                                Lembaga
                                            </span>
                                        @elseif($bb->status == 5)
                                            <span class="badge badge-success">Dirampas untuk negara dan Diperhitungkan
                                                untuk Uang Pengganti
                                            </span>
                                        @elseif($bb->status == 6)
                                            <span class="badge badge-info">Lainnya
                                            </span>
                                        @elseif($bb->status == 7)
                                            <span class="badge badge-warning">Terlampir dalam berkas
                                            </span>
                                        @elseif($bb->status == 8)
                                            <span class="badge badge-warning">Dipergunakan dalam Perkara Lain
                                            </span>
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
    <!-- Modal Edit Putusan -->
    <div wire:ignore.self class="modal fade" id="putusanModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="putusanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="putusanModalLabel">Edit Putusan Pengadilan</h5>
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
                            <input type="date" wire:model="tanggal_putusan" class="form-control" id="tanggalPutusan"
                                required>
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
                            <input type="text" wire:model.lazy="terpidana" class="form-control" id="namaTerpidana"
                                required>
                        </div>
                        <hr />
                        <h5>Barang Bukti</h5>
                        @if ($barang_bukti)
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
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
                                        <td>
                                            @if ($bb->foto)
                                                <img src="{{ url('storage/bb/' . $bb->foto) }}" class="img-fluid my-2"
                                                    style="max-width: 200px;">
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
</div>
