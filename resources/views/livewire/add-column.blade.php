<div>
    <h4 class="mb-3">Project Board</h4>
    <button class="btn btn-primary mb-3 text-end" wire:click="openColumnModal()">+ Add Column</button>

    <div class="modal fade modalColumn" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add Project Column
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='addColumn()'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kolom</label>
                            <input type="text" class="form-control @error('columnName') is-invalid  @enderror"
                                id="name" placeholder="Masukkan nama kolom" wire:model.blur='columnName' autofocus
                                required>
                            <small class="text-danger ">
                                @error('columnName')
                                    *{{ $message }}
                                @enderror
                            </small>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div></div>
