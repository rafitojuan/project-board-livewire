<div class="btn-group">
    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSubtaskModal"
        wire:click="edit({{ $row->id }})">
        <i class="bi bi-pencil-square"></i>
    </button>
    <button class="btn btn-sm btn-danger" wire:click="delete({{ $row->id }})">
        <i class="bi bi-trash-fill"></i>
    </button>
</div>
