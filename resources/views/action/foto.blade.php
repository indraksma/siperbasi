@if ($data->foto)
    <img src="{{ url('storage/bb/' . $data->foto) }}" class="img-fluid my-2" style="max-width: 150px;">
@else
    -
@endif
