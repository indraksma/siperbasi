@if ($data->status == 1)
    <span class="badge badge-primary">Dikembalikan kepada yang
        berhak</span>
@elseif($data->status == 2)
    <span class="badge badge-danger">Dimusnahkan</span>
@elseif($data->status == 3)
    <span class="badge badge-success">Dirampas untuk negara
        (Lelang)
    </span>
@else
    -
@endif
@if ($data->tanggal_eksekusi != null)
    <button type="button" class="btn btn-sm btn-info mt-1" data-toggle="modal" data-target="#detailEksekusi"
        wire:click="$emit('detailEksekusi',{{ $data->id }})"><i class="fas fa-eye"></i>
        Eksekusi</button>
@endif
