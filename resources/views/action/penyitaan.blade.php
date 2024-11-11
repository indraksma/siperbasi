@if (!$data->putusan)
    <button type="button" class="btn btn-info btn-sm mb-1" wire:click="$emit('putusan',{{ $data->id }})"
        data-toggle="modal" data-target="#putusanModal"><i class="fas fa-plus"></i>
        Putusan</button>
@endif
<button type="button" wire:click="$emit('editPenyitaan',{{ $data->id }})" data-toggle="modal"
    data-target="#penyitaanModal" class="btn btn-warning btn-sm mb-1">Edit</button>
<button type="button" wire:click="$emit('deleteId',{{ $data->id }})" data-toggle="modal" data-target="#deleteModal"
    class="btn btn-danger btn-sm mb-1">Hapus</button>
