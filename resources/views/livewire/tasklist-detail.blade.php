<div>

    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <style>
        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

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
                            <th scope="col" style="width: 40%;">Tentang Projek </th>
                            <th scope="col" class="text-end">
                                @if (Auth::user()->role_id <= 2 || Auth::user()->role_id === 5)
                                    <i class="bi bi-pencil-fill me-2" id="edit-detail" style="cursor: pointer"></i>
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <td style="width: 3%">Perusahaan</td>
                            <td><strong>{{ $tasklist->company }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 3%">ID Pekerjaan</td>
                            <td><strong>{{ $tasklist->work_id }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 3%">NO Kontrak</td>
                            <td><strong>{{ $tasklist->contract_number }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 3%">Pengadaan</td>
                            <td><strong>{{ strtoupper($tasklist->pengadaan) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td><strong>{{ $tasklist->location }}</strong></td>
                        </tr>
                        <tr x-data="{
                            isEditing: false,
                            isLoading: false,
                            statusColor: '{{ $tasklist->status->color }}',
                            saveStatus() {
                                this.isLoading = true;
                                this.isEditing = false;
                        
                                $wire.saveTasklistStatus()
                                    .then(color => {
                                        this.statusColor = color;
                                        return new Promise(resolve => setTimeout(resolve, 8000));
                                    })
                                    .finally(() => {
                                        this.isLoading = false;
                                    });
                            }
                        }" @click.away="isEditing = false">
                            <td>Status</td>
                            <td>
                                <template x-if="!isEditing">
                                    <div class="d-flex align-items-center">
                                        <span class="badge text-capitalize"
                                            :style="`background-color: ${statusColor}; font-size: 0.7rem`">{{ $tasklist->status->name ?? 'No Status' }}</span>

                                        @if (Auth::user()->role_id <= 2 || Auth::user()->role_id === 5)
                                            <i class="bi bi-pencil-fill ms-2" :class="{ 'opacity-50': isLoading }"
                                                style="cursor: pointer;"
                                                @click.stop="!isLoading && (isEditing = true)"></i>
                                        @endif

                                        <i class="bi bi-arrow-repeat ms-1 spin" x-show="isLoading"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"></i>
                                    </div>
                                </template>

                                <template x-if="isEditing">
                                    <div class="d-flex">
                                        <select class="form-select" wire:model="tasklistStatus" :disabled="isLoading">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ $tasklist->status->id == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button class="btn btn-primary btn-sm ms-2 py-0 px-1" @click.stop="saveStatus()"
                                            :disabled="isLoading">
                                            Save
                                        </button>
                                    </div>
                                </template>
                            </td>
                        </tr>
                        <tr>
                            <td>Dibuat</td>
                            <td>
                                <span class="badge text-capitalize"
                                    style="background-color: {{ $tasklist->user->role->color }}; font-size: 0.7rem">
                                    {{ $tasklist->user->division->divisi }}
                                </span>
                            </td>
                        </tr>
                        @if ($tasklist->url)
                            <tr>
                                <td>Url <small class="text-sm">(Lampiran)</small></td>
                                <td><a
                                        href="{{ $tasklist->url ?? '-' }}">{{ Str::limit($tasklist->url ?? '-', 25, '...') }}</a>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>Nilai</td>
                            <td><strong>Rp{{ number_format($tasklist->value, 0) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Biaya (RAPP)</td>
                            <td><strong
                                    class="{{ $this->getTotalBiaya() > $tasklist->value ? 'text-danger' : ($this->getTotalBiaya() < $tasklist->value ? 'text-success' : 'text-dark') }}">Rp{{ number_format($this->getTotalBiaya(), 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Akumulasi</td>
                            <td><strong
                                    class="{{ $this->getTotalBiaya() > $tasklist->value ? 'text-danger' : ($this->getTotalBiaya() < $tasklist->value ? 'text-success' : 'text-dark') }}">{{ $this->getSelisihBiaya()['prefix'] }}{{ $this->getSelisihBiaya()['value'] }}
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Kegiatan</h5>
                        <button class="btn btn-primary btn-sm {{ $tasklist->role_id != 2 ? 'd-none' : '' }}"
                            data-bs-toggle="modal" data-bs-target="#addColumnModal">Add Column</button>
                    </div>
                    <div class="row">
                        @foreach ($tasklistColumns as $column)
                            <div class="col-lg-4">
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div
                                            class="dropdown float-end {{ Auth::user()->role_id > 3 ? 'd-none' : '' }}">
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
                                                    style="cursor: grab; height: 13rem;">
                                                    <div class="card-body">
                                                        <div
                                                            class="dropdown float-end {{ Auth::user()->role_id > 3 ? 'd-none' : '' }}">
                                                            <a href="#" class="dropdown-toggle arrow-none"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#updateModal"
                                                                    wire:click="openEditTaskModal({{ $task }})">Edit</a>
                                                                <a class="dropdown-item" href="#"
                                                                    wire:click="deleteTask({{ $task->id }})">Delete</a>
                                                            </div>
                                                        </div>
                                                        <div class="float-end ml-2">
                                                            <span class="badge rounded-pill font-size-12"
                                                                style="background-color: {{ isset($task->user->role->color) ? $task->user->role->color : 'tomato' }};">{{ $task->user->role->name }}</span>
                                                            <span class="badge rounded-pill font-size-12"
                                                                style="background-color: tomato; opacity: 100%">{{ $task->user->division->divisi }}</span>
                                                        </div>
                                                        <div>
                                                            <h5 class="font-size-15" style="cursor: pointer"
                                                                data-bs-toggle="modal" data-bs-target="#subTaskModal"
                                                                wire:click="openSubTaskModal({{ $task }})">
                                                                {{ Str::limit($task->name, 60) . (strlen($task->name) > 60 ? '...' : '') }}
                                                            </h5>
                                                            <small>Divisi:
                                                                {{ $task->user->division->divisi ?? '-' }}</small><br>
                                                            <small class="text-muted mb-2">
                                                                {{ \Carbon\Carbon::parse($task->started_at)->format('d M Y') }}<span
                                                                    class="mx-1">-</span>{{ $task->end_at ? \Carbon\Carbon::parse($task->end_at)->format('d M Y') : 'N/A' }}
                                                            </small>
                                                            @foreach ($detil->where('id_tasks', $task->id) as $detail)
                                                                <div class="progress mt-2" style="height: 15px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="width: {{ $detail->jlh_score }}%; background-color: {{ $detail->warna_status }}"
                                                                        aria-valuenow="{{ $detail->jlh_score }}"
                                                                        aria-valuemin="0" aria-valuemax="100">
                                                                        {{ $detail->jlh_score }}%
                                                                    </div>
                                                                </div>
                                                            @endforeach
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
                                                                <h5 class="font-size-15 mb-1">
                                                                    Rp
                                                                    {{ number_format($this->getSubtotal($task->id), 0, ',', '.') }}
                                                                </h5>
                                                                <p class="mb-0 text-muted">Biaya (RAPP)</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted">Tidak ada task saat ini.</p>
                                            @endforelse
                                        </div>

                                        @if ($loop->index == 0)
                                            <div
                                                class="text-center d-grid {{ Auth::user()->role_id === 7 ? 'd-none' : '' }}">
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
                        {{-- <div class="mb-3">
                            <label for="name" class="form-label">Nilai Kontrak</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" placeholder="Masukkan nominal"
                                    x-data="{ taskValue: '' }"
                                    x-on:keydown="if(taskValue.length >= 10 && !['Backspace', 'Delete', 'Space'].includes($event.key)) $event.preventDefault()"
                                    wire:model="taskValue" x-model="taskValue" maxlength="10">
                            </div>
                            @error('taskValue')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}
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
                        {{-- <div class="mb-3">
                            <label for="name" class="form-label">Nilai Kontrak</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" placeholder="Masukkan nominal"
                                    x-data="{ taskValue: '' }"
                                    x-on:keydown="if(taskValue.length >= 10 && !['Backspace', 'Delete', 'Space'].includes($event.key)) $event.preventDefault()"
                                    wire:model="taskValue" x-model="taskValue" maxlength="10">
                            </div>
                            @error('taskValue')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}
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
                        {{-- <input type="hidden" value="{{ $tasklist->id }}" wire:model='columnId'> --}}
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
    <div class="modal fade" id="subTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" wire:ignore.self
        aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">
                        Form Detail Pekerjaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        wire:click='closeSubtaskModal({{ $kode }})' aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="float-start">
                        <h5>{{ $uraian }}</h5>
                    </div>
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
                    <button class="btn btn-secondary" wire:click='closeSubtaskModal({{ $kode }})'
                        data-bs-dismiss="modal">
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
                            <label for="name" class="form-label">Nama Pekerjaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subtaskName') is-invalid @enderror"
                                id="name" placeholder="Masukkan nama" wire:model='subtaskName' required>
                            @error('subtaskName')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Pelaksana <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('subtaskJob') is-invalid @enderror" id="name"
                                wire:model='subtaskJob' required>
                                <option value="">Pilih Pelaksana</option>
                                @foreach ($userList as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('subtaskJob')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="rab" class="form-label">RAB</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input id="rab" type="number" class="form-control"
                                    placeholder="Masukkan nominal" x-data="{ subtaskRAB: '' }"
                                    x-on:keypress="if (!/[0-9]/.test($event.key)) $event.preventDefault()"
                                    x-on:keydown="if(subtaskRAB.length >= 13 && !['Backspace', 'Delete', 'Space'].includes($event.key)) $event.preventDefault()"
                                    wire:model="subtaskRAB" x-model="subtaskRAB" maxlength="13">
                            </div> @error('subtaskRAB')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sap" class="form-label">Administrasi SAP </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" wire:model='subtaskSAP' type="checkbox"
                                    id="sap" role="switch" />
                                <label class="form-check-label" for="sap">Tidak/Ya</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" wire:model='subTaskKeterangan' class="form-control" cols="10" rows="3"></textarea>
                            @error('subTaskKeterangan')
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
    <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
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
                            <select class="form-select @error('subtaskJob') is-invalid @enderror" id="name"
                                wire:model='subtaskJob' required>
                                <option value="">Pilih Pelaksana</option>
                                @foreach ($userList as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
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
                        <div x-data="{ subtaskRAB: @entangle('subtaskRAB').defer }" class="mb-3">
                            <label for="rab" class="form-label">RAB</label> <small class="text-danger">*</small>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number"
                                    class="form-control
                                    @error('subtaskRAB') is-invalid @enderror"
                                    id="rab" placeholder="Masukkan nominal" wire:model.defer='subtaskRAB'
                                    x-model="subtaskRAB"
                                    x-on:keydown="if(subtaskRAB.length >= 10 && !['Backspace', 'Delete', 'Space'].includes($event.key)) $event.preventDefault()"
                                    {{ $subtaskRAP && Auth::user()->role_id > 2 ? 'readonly' : '' }}>
                            </div>
                            @error('subtaskRAB')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sap" class="form-label">Administrasi SAP </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" wire:model='subtaskSAP' type="checkbox"
                                    id="sap" role="switch" />
                                <label class="form-check-label" for="sap">Tidak/Ya</label>
                            </div>
                        </div>
                        @if ($subtaskSAP && Auth::user()->role_id <= 2)
                            <div class='mb-3' x-data="{
                                subtaskRAP: {{ $subtaskRAP ?? 'null' }},
                                init() {
                                    this.subtaskRAP = {{ $subtaskRAP ?? 'null' }};
                                    $watch('subtaskRAP', value => {
                                        @this.set('subtaskRAP', value)
                                    })
                                }
                            }">
                                <label for="rap" class="form-label">RAP <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                        class="form-control @error('subtaskRAP') is-invalid @enderror"
                                        :class="{ 'is-invalid': parseInt(subtaskRAP) >= {{ $subtaskRAB }} }"
                                        id="rap" placeholder="Masukkan nominal" x-model.number="subtaskRAP"
                                        wire:model.defer='subtaskRAP'
                                        x-on:keydown="if(!['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight','ArrowUp','ArrowDown', 'Tab'].includes($event.key) && (!$event.key.match(/^\d$/) || subtaskRAP.length >= 13 || parseInt(subtaskRAP + $event.key) > {{ $subtaskRAB }})) $event.preventDefault()"
                                        min="1" :max="{{ $subtaskRAB - 1 }}"
                                        oninvalid="this.setCustomValidity('RAP tidak bisa lebih atau sama dengan RAB')"
                                        oninput="this.setCustomValidity('')"
                                        {{ Auth::user()->role_id > 2 ? 'readonly' : '' }}>
                                </div>
                                @error('subtaskRAP')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <template x-if="parseInt(subtaskRAP) >= {{ $subtaskRAB }}">
                                    <small class="text-danger">RAP tidak bisa sama dengan atau melewati RAB (RAB:
                                        {{ $subtaskRAB }})</small>
                                </template>
                            </div>
                        @endif
                        @if ($subtaskRAP && Auth::user()->role_id != 7)
                            <div x-data="{ subtaskRAPP: @entangle('subtaskRAPP').defer }" class="mb-3">
                                <label for="RAPP" class="form-label">RAPP <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                        class="form-control @error('subtaskRAPP') is-invalid @enderror"
                                        :class="{ 'is-invalid': parseInt(subtaskRAPP) >= {{ $subtaskRAP }} }"
                                        id="RAPP" placeholder="Masukkan nominal" wire:model.defer='subtaskRAPP'
                                        x-model="subtaskRAPP"
                                        x-on:keydown="if(!['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight','ArrowUp','ArrowDown', 'Tab'].includes($event.key) && (!$event.key.match(/^\d$/) || subtaskRAPP.length >= 13 || parseInt(subtaskRAPP + $event.key) > {{ $subtaskRAP }})) $event.preventDefault()"
                                        min="0" :max="{{ $subtaskRAP - 1 }}"
                                        oninvalid="this.setCustomValidity('RAPP tidak bisa lebih atau sama dengan RAP')"
                                        oninput="this.setCustomValidity('')"
                                        {{ Auth::user()->role_id > 2 ? 'readonly' : '' }}>
                                </div>
                                @error('subtaskRAPP')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <template x-if="parseInt(subtaskRAPP) >= {{ $subtaskRAP }}">
                                    <small class="text-danger">RAPP tidak bisa melebihi RAP (RAP:
                                        {{ $subtaskRAP }})</small>
                                </template>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="statusa" class="form-label">Status</label>
                            <select id="statusa" class="form-select" wire:model='subTaskStatus'>
                                <option value="" disabled>Pilih Status</option>
                                @foreach ($statusSubtask as $status)
                                    <option class="text-capitalize" value="{{ $status->id }}">{{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" wire:model='subTaskKeterangan' class="form-control" cols="10" rows="3"></textarea>
                            @error('subTaskKeterangan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="value">URL <span class="text-sm">(Lampiran)</span></label>
                            <input type="url" class="form-control" id="url"
                                placeholder="https://example.com" wire:model='subtaskUrl'>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeSubtaskAddModal"
                                data-bs-toggle="modal" data-bs-target="#subTaskModal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
