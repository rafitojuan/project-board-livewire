<div>
    <div class="row">
        @foreach ($columns as $column)
            <div class="col-lg-4">
                <div class="card rounded-4">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#updateColumnModal"
                                    wire:click="openEditColumnModal({{ $column }})">Edit</a>
                                <a class="dropdown-item" href="#"
                                    wire:click="deleteTasklistColumn({{ $column->id }})">Delete</a>
                            </div>
                        </div>

                        <h4 class="card-title mb-4">{{ $column->name }}</h4>
                        <div class="task-list" data-column-id="{{ $column->id }}" x-data="{ dropzone: null }"
                            x-init="dropzone = new Sortable($el, {
                                group: 'tasklists',
                                animation: 150,
                                onEnd: function(evt) {
                                    let columnId = evt.to.dataset.columnId;
                                    let tasklistOrder = Array.from(evt.to.children).map(el => el.dataset.tasklistId);
                                    $wire.updateTasklistOrder(columnId, tasklistOrder);
                                }
                            })">
                            @forelse ($column->tasklists as $tasklist)
                                <div class="card task-box mb-3 rounded-4" data-tasklist-id="{{ $tasklist->id }}"
                                    style="cursor: pointer">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#updateModal"
                                                    wire:click="openEditTasklistModal({{ $tasklist }})">Edit</a>
                                                <a class="dropdown-item" href="#"
                                                    wire:click="deleteTasklist({{ $tasklist->id }})">Delete</a>
                                            </div>
                                        </div>
                                        <div class="float-end ml-2">
                                            <span class="badge rounded-pill font-size-12"
                                                style="background-color: {{ isset($tasklist->status->color) ? $tasklist->status->color : 'tomato' }}; opacity: 65%">{{ $tasklist->status->name ?? 'No Status' }}</span>
                                        </div>
                                        <div>
                                            <h5 class="font-size-15"><a
                                                    href="{{ route('tasklist.detail', ['encryptedId' => Crypt::encryptString($tasklist->id)]) }}"
                                                    class="text-dark">{{ Str::limit($tasklist->name, 60) . (strlen($tasklist->name) > 60 ? '...' : '') }}</a>
                                            </h5>
                                            <p class="text-muted">
                                                {{ $tasklist->created_at ? $tasklist->created_at->format('d M, Y') : 'N/A' }}
                                            </p>
                                        </div>

                                        <ul class="ps-3 mb-4 text-muted">
                                            <li class="py-1">{{ $tasklist->company }}</li>
                                            <li class="py-1">{{ $tasklist->location }}</li>
                                        </ul>

                                        <div class="avatar-group float-start task-assigne">
                                            <!-- Avatar -->
                                        </div>
                                        <div class="text-end">
                                            <h5 class="font-size-15 mb-1">Rp {{ number_format($tasklist->value, 2) }}
                                            </h5>
                                            <p class="mb-0 text-muted">Project Value</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Tidak ada task saat ini.</p>
                            @endforelse
                        </div>

                        @if ($loop->index == 0)
                            <div class="text-center d-grid">
                                <a href="javascript: void(0);"
                                    class="btn btn-primary waves-effect waves-light addtask-btn"
                                    wire:click="openAddTasklistModal({{ $column->id }})">
                                    <i class="mdi mdi-plus me-1"></i> Add New
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <!-- Update Tasklist Modal -->
    <div class="modal fade updateModal" tabindex="-1" id="updateModal" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Update Tasklist
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='updateTasklist'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama"
                                wire:model='newTasklistName' required>
                        </div>
                        <div class="mb-3">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="company" placeholder="Masukkan company"
                                wire:model='newTasklistCompany' required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <textarea name="location" id="location" class="form-control" placeholder="Masukkan lokasi" wire:model='location'
                                rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Start Date</label>
                            <input type="date" class="form-control" wire:model='newTasklistStartDate'
                                value="" id="">
                        </div>
                        <div class="mb-3">
                            <label for="value">Value</label>
                            <div class="input-group">
                                <div class="input-group-text">Rp</div>
                                <input type="number" class="form-control" id="value"
                                    placeholder="Masukkan nilai" wire:model='newTasklistValue' required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Tasklist Modal -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add Tasklist
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='addTasklist'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama"
                                wire:model='newTasklistName' required>
                        </div>
                        <div class="mb-3">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="company" placeholder="Masukkan company"
                                wire:model='newTasklistCompany' required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <textarea name="location" id="location" class="form-control" placeholder="Masukkan lokasi" wire:model='location'
                                rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Start Date</label>
                            <input type="date" class="form-control" wire:model='newTasklistStartDate'
                                value="{{ now()->format('Y-m-d\TH:i') }}" id="">
                        </div>
                        <div class="mb-3">
                            <label for="value">Value</label>
                            <div class="input-group">
                                <div class="input-group-text">Rp</div>
                                <input type="number" class="form-control" id="value"
                                    placeholder="Masukkan nilai" wire:model='newTasklistValue' required>
                            </div>
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
    </div>


    <!-- Update Tasklist Column Modal -->
    <div class="modal fade updateColumnModal" tabindex="-1" id="updateColumnModal" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Update Tasklist Column
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='updateTasklistColumn'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama"
                                wire:model='tasklistColumnName' required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
