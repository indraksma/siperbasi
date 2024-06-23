<button type="button" class="btn btn-warning btn-sm mb-1" wire:click="$emit('edit', {{ $data->id }})"
    data-toggle="modal" data-target="#bbModal">Edit</button>
<button type="button" wire:click="$emit('deleteId', {{ $data->id }})" data-toggle="modal" data-target="#deleteModal"
    class="btn btn-danger btn-sm mb-1">Hapus</button>
