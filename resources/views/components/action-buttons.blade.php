<div class="btn-group">
    <!-- Tombol Edit -->
    <button class="btn btn-sm btn-primary" wire:click="edit({{ $row->id }})">
        Edit
    </button>

    <!-- Tombol Delete -->
    <button class="btn btn-sm btn-danger" wire:click="delete({{ $row->id }})">
        Delete
    </button>
</div>
