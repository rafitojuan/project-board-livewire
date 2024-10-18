<div>
    <div class="row">
        <div class="col-3">
            <div class="card rounded-4 shadow-lg">
                <div class="card-header rounded-top-4" style="background-color: white; border-bottom: 1px solid #dee2e6;">
                    <nav aria-label="breadcrumb" style="margin-bottom: -0.9rem; margin-left: -0.4rem;">
                        <ol class="breadcrumb" style="font-size: 0.8rem;">
                            <li class="breadcrumb-item"><a href="{{ route('kanban.index') }}"
                                    style="color:#007bff;">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('kanban.index') }}"
                                    style="color:#007bff;">Project</a></li>
                            <li class="breadcrumb-item active" aria-current="page">#{{ $tasklist->id }}</li>
                        </ol>
                    </nav>
                    <h4 class="card-title fs-4 ms-2">{{ $tasklist->name }}</h4>
                    <p class="card-text ms-2 mt-3 mb-3">
                        {{ \Carbon\Carbon::parse($tasklist->started_at)->format('d F Y') }} <span
                            class="fw-bold mx-2">-</span>
                        {{ $tasklist->end_at ? \Carbon\Carbon::parse($tasklist->end_at)->format('d F Y') : 'N/A' }}
                    </p>
                </div>
                <div class="card-body">
                    <table class="table align-middle table-borderless" style="margin-top: -1rem;">
                        <tr>
                            <th scope="col" style="width: 40%;">Tentang Projek</th>
                            <th scope="col"></th>
                        </tr>
                        <tr>
                            <td style="width: 3%">Company</td>
                            <td><strong>{{ $tasklist->company }}</strong></td>
                        </tr>
                        <tr>
                            <td>Location</td>
                            <td><strong>{{ $tasklist->location }}</strong></td>
                        </tr>
                        <tr>
                            <td>Value</td>
                            <td><strong>Rp{{ number_format($tasklist->value, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><strong>{{ $tasklist->status->name ?? 'No Status' }}</strong></td>
                        </tr>
                        @if ($tasklist->url)
                            <tr>
                                <td>Url <small class="text-sm">(Lampiran)</small></td>
                                <td><a
                                        href="{{ $tasklist->url ?? '-' }}">{{ Str::limit($tasklist->url ?? '-', 25, '...') }}</a>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Kegiatan</h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addColumnModal">Add Column</button>
                    </div>
                    <div class="row">
                        @foreach ($tasklistColumns as $column)
                            <div class="col-lg-4">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#updateTasklistColumnModal"
                                                    wire:click="openEditTasklistColumnModal({{ $column }})">Edit</a>
                                                <a class="dropdown-item" href="#"
                                                    wire:click="deleteTasklistColumn({{ $column->id }})">Delete</a>
                                            </div>
                                        </div>

                                        <h4 class="card-title mb-4">{{ $column->name }}</h4>
                                        <div class="task-list" data-column-id="{{ $column->id }}"
                                            x-data="{ dropzone: null }" x-init="dropzone = new Sortable($el, {
                                                group: 'task',
                                                animation: 150,
                                                onEnd: function(evt) {
                                                    let columnId = evt.to.dataset.columnId;
                                                    let taskOrder = Array.from(evt.to.children).map(el => el.dataset.taskId);
                                                    $wire.updateTaskOrder(columnId, taskOrder);
                                                }
                                            })">
                                            @forelse ($column->tasks as $task)
                                                <div class="card task-box mb-3 rounded-4 shadow-lg"
                                                    data-task-id="{{ $task->id }}"
                                                    style="cursor: move; height: 13rem;">
                                                    <div class="card-body">
                                                        <div class="dropdown float-end">
                                                            <a href="#" class="dropdown-toggle arrow-none"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal" data-bs-target="#updateModal"
                                                                    wire:click="openEditTaskModal({{ $task }})">Edit</a>
                                                                <a class="dropdown-item" href="#"
                                                                    wire:click="deleteTask({{ $task->id }})">Delete</a>
                                                            </div>
                                                        </div>
                                                        <div class="float-end ml-2">
                                                            <span class="badge rounded-pill font-size-12"
                                                                style="background-color: {{ isset($task->status->color) ? $task->status->color : 'tomato' }}; opacity: 65%">
                                                                {{ $task->status->name ?? 'No Status' }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <h5 class="font-size-15" style="cursor: pointer"
                                                                data-bs-toggle="modal" data-bs-target="#subTaskModal"
                                                                wire:click="openSubTaskModal({{ $task }})">
                                                                {{ Str::limit($task->name, 60) . (strlen($task->name) > 60 ? '...' : '') }}
                                                            </h5>
                                                            <small class="text-muted mb-2">
                                                                {{ \Carbon\Carbon::parse($task->started_at)->format('d M Y') }}<span
                                                                    class="mx-1">-</span>{{ $task->end_at ? \Carbon\Carbon::parse($task->end_at)->format('d M Y') : 'N/A' }}
                                                            </small>
                                                        </div>

                                                        <div class="position-absolute bottom-0 start-0 end-0 p-3">
                                                            @if ($task->url)
                                                                <a href="{{ $task->url }}" target="_blank"
                                                                    class="float-start d-flex align-items-center text-decoration-none">
                                                                    <i class="bi bi-link-45deg fs-4 me-1"></i>
                                                                    <span>lampiran</span>
                                                                </a>
                                                            @endif
                                                            <div class="text-end">
                                                                <h5 class="font-size-15 mb-1">Rp100000
                                                                </h5>
                                                                <p class="mb-0 text-muted">Project Value</p>
                                                            </div>
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
                                                    wire:click="openTaskModal({{ $column->id }})">
                                                    <i class="mdi mdi-plus me-1"></i> Add New
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Kegiatan Modal -->
    <div class="modal fade addTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add Kegiatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='addTask'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('taskName') is-invalid @enderror"
                                id="name" placeholder="Masukkan nama" wire:model='taskName' required>
                            @error('taskName')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date"
                                    class="form-control @error('taskStartDate') is-invalid @enderror"
                                    wire:model='taskStartDate' value="{{ now()->format('Y-m-d') }}" id="start_date">
                                @error('taskStartDate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('taskEndDate') is-invalid @enderror"
                                    wire:model='taskEndDate' id="end_date">
                                @error('taskEndDate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com"" wire:model='taskUrl'>
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

    {{-- Update Modal --}}
    <div class="modal fade updateTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" id="updateModal"
        tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Update Kegiatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click='closeTaskModal'
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='updateTask'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('taskName') is-invalid @enderror"
                                id="name" placeholder="Masukkan nama" wire:model='taskName' required>
                            @error('taskName')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date"
                                    class="form-control @error('taskStartDate') is-invalid @enderror"
                                    wire:model='taskStartDate' id="start_date">
                                @error('taskStartDate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control @error('taskEndDate') is-invalid @enderror"
                                    wire:model='taskEndDate' id="end_date">
                                @error('taskEndDate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com"" wire:model='taskUrl'>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='closeTaskModal'
                        data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Column Modal --}}
    <div class="modal fade addColumnModal" id="addColumnModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add Tasklist Column
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='addTasklistColumn'>
                        <input type="hidden" value="{{ $tasklist->id }}" wire:model='columnId'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('taskName') is-invalid @enderror"
                                id="name" placeholder="Masukkan nama" wire:model='tasklistColumnName' required>
                            @error('tasklistColumnName')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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

    {{-- Update Column Modal --}}
    <div class="modal fade updateTasklistColumnModal" id="updateTasklistColumnModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Update Kegiatan Column
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='updateTasklistColumn'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('taskName') is-invalid @enderror"
                                id="name" placeholder="Masukkan nama" wire:model='tasklistColumnName' required>
                            @error('tasklistColumnName')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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


    {{-- Subtask Modal --}}
    <div class="modal fade" id="subTaskModal" data-bs-backdrop="static" wire:ignore.self aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">
                        Detail Pekerjaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-end mb-3">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addSubtaskModal">+ Add Detail Pekerjaan</button>
                    </div>
                    <div>
                        @if ($kode)
                            <livewire:subtasks-table kode="{{ $kode }}" />
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click='closeSubtaskModal({{ $kode }})' data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="addSubtaskModal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add Detail Pekerjaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit='addSubtask'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subtaskName') is-invalid @enderror"
                                id="name" placeholder="Masukkan nama" wire:model='subtaskName' required>
                            @error('subtaskName')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Pelaksana <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subtaskJob') is-invalid @enderror"
                                id="name" placeholder="Masukkan pelaksana" wire:model='subtaskJob' required>
                            @error('subtaskJob')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="form-label">Tanggal Mulai</label>
                                    <input type="date"
                                        class="form-control @error('subTaskStarted') is-invalid @enderror"
                                        id="name" placeholder="Masukkan tanngal mulai"
                                        wire:model='subTaskStarted'>
                                    @error('subTaskStarted')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="name" class="form-label">Tanggal Akhir</label>
                                    <input type="date"
                                        class="form-control @error('subTaskEnd') is-invalid @enderror" id="name"
                                        placeholder="Masukkan tanngal akhir" wire:model='subTaskEnd'>
                                    @error('subTaskEnd')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Biaya</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" placeholder="Masukkan nominal"
                                    x-data="{ subtaskValue: '' }"
                                    x-on:keydown="if(subtaskValue.length >= 10 && !['Backspace', 'Delete', 'Space'].includes($event.key)) $event.preventDefault()"
                                    wire:model="subtaskValue" x-model="subtaskValue" maxlength="10">
                            </div>
                            @error('subtaskValue')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com"" wire:model='subtaskUrl'>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#subTaskModal">
                        Back
                    </button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End --}}

    {{-- Modal Detail Pekerjaan --}}
    <div class="modal fade" id="editSubtaskModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Update Detail Pekerjaan
                    </h5>
                </div>
                <div class="modal-body">
                    <form wire:submit='updateSubtask'>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subtaskName') is-invalid @enderror"
                                id="name" placeholder="Masukkan nama" wire:model='subtaskName' required>
                            @error('subtaskName')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Pelaksana <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subtaskName') is-invalid @enderror"
                                id="name" placeholder="Masukkan pelaksana" wire:model='subtaskJob' required>
                            @error('subtaskJob')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="form-label">Tanggal Mulai</label> <small
                                        class="text-danger">*</small>
                                    <input type="date"
                                        class="form-control @error('subTaskStarted') is-invalid @enderror"
                                        id="name" placeholder="Masukkan tanngal mulai"
                                        wire:model='subTaskStarted'>
                                    @error('subTaskStarted')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="name" class="form-label">Tanggal Akhir</label>
                                    <input type="date"
                                        class="form-control @error('subTaskEnd') is-invalid @enderror" id="name"
                                        placeholder="Masukkan tanngal akhir" wire:model='subTaskEnd'>
                                    @error('subTaskEnd')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Biaya</label> <small
                                class="text-danger">*</small>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number"
                                    class="form-control @error('subtaskValue') is-invalid @enderror" id="name"
                                    placeholder="Masukkan nominal" wire:model='subtaskValue' x-model="subtaskValue"
                                    x-on:keydown="if(subtaskValue.length >= 10 && !['Backspace', 'Delete', 'Space'].includes($event.key)) $event.preventDefault()">
                            </div>
                            @error('subtaskValue')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" wire:model='subTaskKeterangan' class="form-control" cols="10" rows="3"></textarea>
                            @error('subTaskKeterangan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label me-2">Status : </label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="0"
                                    wire:model='subtaskCompleted' />
                                <label class="form-check-label" for="">new</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="3"
                                    wire:model='subtaskCompleted' />
                                <label class="form-check-label" for="">progress</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="1"
                                    wire:model='subtaskCompleted' />
                                <label class="form-check-label" for="">finished</label>
                            </div>
                            @error('subtaskCompleted')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com"" wire:model='subtaskUrl'>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeSubtaskAddModal"
                        data-bs-toggle="modal" data-bs-target="#subTaskModal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
