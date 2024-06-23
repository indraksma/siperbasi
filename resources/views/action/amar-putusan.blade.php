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
