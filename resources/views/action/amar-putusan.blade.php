@if ($data->status == 1)
    <span class="badge badge-primary">Dikembalikan kepada yang
        berhak</span>
@elseif($data->status == 2)
    <span class="badge badge-danger">Dirampas untuk Dimusnahkan</span>
@elseif($data->status == 3)
    <span class="badge badge-success">Dirampas untuk negara
    </span>
@elseif($data->status == 4)
    <span class="badge badge-success">Dirampas untuk negara c.q. Kementerian / Lembaga
    </span>
@elseif($data->status == 5)
    <span class="badge badge-success">Dirampas untuk negara dan Diperhitungkan untuk Uang Pengganti
    </span>
@elseif($data->status == 6)
    <span class="badge badge-info">Lainnya
    </span>
@elseif($data->status == 7)
    <span class="badge badge-warning">Terlampir dalam berkas
    </span>
@elseif($data->status == 8)
    <span class="badge badge-warning">Dipergunakan dalam Perkara Lain
    </span>
@else
    -
@endif
@if ($data->tanggal_eksekusi != null)
    <button type="button" class="btn btn-sm btn-info mt-1" data-toggle="modal" data-target="#detailEksekusi"
        wire:click="$emit('detailEksekusi',{{ $data->id }})"><i class="fas fa-eye"></i>
        Eksekusi</button>
@endif
