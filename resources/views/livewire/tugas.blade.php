<div>
    <div class="row">
        @if ($tugasUser->isEmpty())
            <div class="d-flex justify-content-center align-items-center" style="height: 65vh;">
                <div class="text-center">
                    <i class="fas fa-tasks fa-3x mb-3"></i>
                    <p class="h5">Belum ada tugas.</p>
                </div>
            </div>
        @else
            <div class="col-md-3">
                <div class="card rounded-4 shadow-sm">
                    <div class="card-body">
                        @foreach ($tugasUser as $tugas)
                            @if ($tugas->nama_projek_aktif)
                                <h4 class="card-title">{{ $loop->iteration }}. {{ $tugas->nama_projek_aktif }}</h4>
                                @if ($tugas->kegiatan_list)
                                    @foreach (json_decode($tugas->kegiatan_list) as $kegiatan)
                                        @if ($kegiatan->subtasks)
                                            <div class="card-text mt-1">
                                                <span class="fw-bold">- {{ $kegiatan->nama_kegiatan }} :</span>
                                                @if ($kegiatan->subtasks)
                                                    <ul>
                                                        @foreach ($kegiatan->subtasks as $tugas)
                                                            @if ($tugas->rap != null && Auth::user()->role_id <= 2)
                                                                <li>
                                                                    {{ $tugas->nama_tugas }}
                                                                    <span class="ms-2" style="cursor: pointer"
                                                                        x-data="{ isOpen: false, lastClicked: null }"
                                                                        @click="
                                                                            if (lastClicked === {{ $tugas->id_tugas }}) {
                                                                                isOpen = false;
                                                                                lastClicked = null;
                                                                                $refs.detailTugas.classList.remove('fade-left');
                                                                                $refs.detailTugas.style.display = 'none';
                                                                            } else {
                                                                                $dispatch('close-others');
                                                                                isOpen = true;
                                                                                lastClicked = {{ $tugas->id_tugas }};
                                                                                $refs.detailTugas.classList.add('fade-left');
                                                                                $refs.detailTugas.style.display = 'block';
                                                                                $wire.showTugasUser({{ $tugas->id_tugas }})
                                                                            }
                                                                        ">
                                                                        <i class="fas"
                                                                            :class="{
                                                                                'fa-eye': !isOpen,
                                                                                'fa-eye-slash': isOpen
                                                                            }"
                                                                            @close-others.window="if (!$el.isSameNode($event.target)) { isOpen = false; lastClicked = null; }">
                                                                        </i>
                                                                    </span>
                                                                </li>
                                                            @endif
                                                            @if ($tugas->nama_tugas && $tugas->pelaksana_id == Auth::user()->id)
                                                                <li>
                                                                    {{ $tugas->nama_tugas }}
                                                                    <span class="ms-2" style="cursor: pointer"
                                                                        x-data="{ isOpen: false, lastClicked: null }"
                                                                        @click="
                                                                                if (lastClicked === {{ $tugas->id_tugas }}) {
                                                                                    isOpen = false;
                                                                                    lastClicked = null;
                                                                                    $refs.detailTugas.classList.remove('fade-left');
                                                                                    $refs.detailTugas.style.display = 'none';
                                                                                } else {
                                                                                    $dispatch('close-others');
                                                                                    isOpen = true;
                                                                                    lastClicked = {{ $tugas->id_tugas }};
                                                                                    $refs.detailTugas.classList.add('fade-left');
                                                                                    $refs.detailTugas.style.display = 'block';
                                                                                    $wire.showTugasUser({{ $tugas->id_tugas }})
                                                                                }
                                                                            ">
                                                                        <i class="fas"
                                                                            :class="{
                                                                                'fa-eye': !isOpen,
                                                                                'fa-eye-slash': isOpen
                                                                            }"
                                                                            @close-others.window="if (!$el.isSameNode($event.target)) { isOpen = false; lastClicked = null; }">
                                                                        </i>
                                                                    </span>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                                {{-- <hr class="my-2 border-2 border-secondary"> --}}
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="row">
                        <div class="col-4">
                            <div class="card rounded-4 mini-stats-wid shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Potential</p>
                                            <h4 class="mb-0">{{ $userData->jlh_tasklists_potential_user }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-bulb font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card rounded-4 mini-stats-wid shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">In Progress</p>
                                            <h4 class="mb-0">{{ $userData->jlh_tasklists_onprogress_user }}</h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bxs-hourglass font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card rounded-4 mini-stats-wid shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Completed</p>
                                            <h4 class="mb-0">{{ $userData->jlh_tasklists_completed_user }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-list-check font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card rounded-4 shadow-sm" x-ref="detailTugas" id="detail-tugas" style="display: none;">
                    <style>
                        .fade-left {
                            animation: fadeLeft 0.5s ease-in-out;
                        }

                        @keyframes fadeLeft {
                            from {
                                opacity: 0;
                                transform: translateX(20px);
                            }

                            to {
                                opacity: 1;
                                transform: translateX(0);
                            }
                        }
                    </style>
                    <div class="card-body">
                        <h4 class="card-title">Detail Pekerjaan</h4>
                        <p class="card-text">
                        <form wire:submit.prevent="updateTugas">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" wire:model='namaTugas'
                                    class="form-control rounded-3 @error('namaTugas') is-invalid @enderror"
                                    id="name">
                                @error('namaTugas')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="pelaksana" class="form-label">Pelaksana</label>
                                <select wire:model='namaPelaksana'
                                    class="form-select rounded-3 @error('namaPelaksana') is-invalid @enderror"
                                    id="pelaksana">
                                    <option value="" disabled>Pilih Pelaksana</option>
                                    @foreach ($pelaksanaList as $pelaksana)
                                        <option value="{{ $pelaksana->id }}">{{ $pelaksana->name }}</option>
                                    @endforeach
                                </select>
                                @error('namaPelaksana')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                        <input type="date" wire:model='mulaiTugas'
                                            class="form-control rounded-3 @error('mulaiTugas') is-invalid @enderror"
                                            id="tanggal_mulai">
                                        @error('mulaiTugas')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                        <input type="date" wire:model='akhirTugas'
                                            class="form-control rounded-3 @error('akhirTugas') is-invalid @enderror"
                                            id="tanggal_akhir">
                                        @error('akhirTugas')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="biaya" class="form-label">Biaya</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" wire:model='biayaTugas'
                                        class="form-control @error('biayaTugas') is-invalid @enderror" id="biaya">
                                </div>
                                @error('biayaTugas')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="statusa" class="form-label">Status</label>
                                <select id="statusa"
                                    class="form-select rounded-3 @error('statusTugas') is-invalid @enderror"
                                    wire:model='statusTugas'>
                                    <option disabled>Pilih Status</option>
                                    @foreach ($statusList as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('statusTugas')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" wire:model='keteranganTugas'
                                    class="form-control rounded-3 @error('keteranganTugas') is-invalid @enderror" cols="10" rows="3"></textarea>
                                @error('keteranganTugas')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="url">URL <span class="text-sm">(Lampiran)</span></label>
                                <input type="url" wire:model='urlTugas'
                                    class="form-control rounded-3 @error('urlTugas') is-invalid @enderror"
                                    id="url"
                                    placeholder="{{ empty($urlTugas) ? 'Tidak ada lampiran' : 'https://example.com' }}">
                                @error('urlTugas')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="text-end mb-3">
                                <button class="btn btn-primary btn-sm rounded-4">Simpan</button>
                            </div>
                        </form>
                        </p>
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>
