<div>
    <div class="card col-md-12 rounded-4 shadow-sm">
        <div class="card-body">
            <h2 class="mb-4 fs-3">Jadwal Tugasku</h2>
            <div wire:ignore id='calendar'></div>
        </div>
        <div class="card-footer">
            <div>
                <ul style="list-style: none; line-height: 1;">
                    <li style="display: flex; align-items: center;">
                        <span style="color: #FFB1B1; font-size: 25px;">●</span><span style="margin-left: 10px;"> : Hari
                            Libur</span>
                    </li>
                    <li style="display: flex; align-items: center;">
                        <span style="color: #fcdf3c; font-size: 25px;">●</span><span style="margin-left: 10px;"> : Hari
                            Ini</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal Body -->
    <div class="modal fade" id="modalJadwal" wire:ignore.self tabindex="-1" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Ubah Jadwal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit="updateDetailJadwal">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Acara: <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" wire:model='namaAcara'
                                class="form-control @error('namaAcara') is-invalid @enderror">
                            @error('namaAcara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal Acara: <span
                                    class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" name="start" id="date"
                                        class="form-control @error('tanggalMulai') is-invalid @enderror"
                                        wire:model='tanggalMulai'>
                                    @error('tanggalMulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="end" id="date"
                                        class="form-control @error('tanggalSelesai') is-invalid @enderror"
                                        wire:model='tanggalSelesai'>
                                    @error('tanggalSelesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="finished" class="form-label">Tandai sebagai selesai?</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" wire:model='statusJadwal' type="checkbox" id="finished"
                                    data-on-value="6" data-off-value="1" />
                                <label class="form-check-label ms-1" for="finished">Tidak/Ya</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-danger">
                            Hapus
                        </button> --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // FUNCTION CALENDAR CUYY
    document.addEventListener('livewire:initialized', function() {
        const jadwal = @json($events);
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: localStorage.getItem('calendarView') || 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            locale: 'id',
            buttonText: {
                today: 'Hari ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari',
                list: 'List'
            },
            monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                'September', 'Oktober', 'November', 'Desember'
            ],
            monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                'Nov', 'Des'
            ],
            dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            dayNamesShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
            events: jadwal,
            editable: {{ Auth::user()->role_id <= 2 ? 'true' : 'false' }},
            eventResizableFromStart: {{ Auth::user()->role_id <= 2 ? 'true' : 'false' }},
            selectable: {{ Auth::user()->role_id <= 2 ? 'true' : 'false' }},
            eventResize: function(data) {
                console.log('Event berhasil Diubah');
                @this.call('updateJadwal', data.event.id, data.event.start, data.event.end)
                    .then(() => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Jadwal berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    })
                    .catch(() => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Gagal memperbarui jadwal',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    });
            },
            eventDrop: function(data) {
                console.log('Event berhasil Dipindahkan');
                @this.call('updateJadwal', data.event.id, data.event.start, data.event.end)
                    .then(() => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Jadwal berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    })
                    .catch(() => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Gagal memperbarui jadwal',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    });
            },
            eventClick: function(data) {
                if ({{ Auth::user()->role_id <= 2 ? 'true' : 'false' }}) {
                    @this.call('detailJadwal', data.event.id)
                        .then(() => {
                            $('#modalJadwal').modal('show');
                        });
                }
            },
            eventMouseEnter: function(info) {
                if (!{{ Auth::user()->role_id <= 2 ? 'true' : 'false' }}) {
                    info.el.style.cursor = 'pointer';
                }
            },
            datesSet: function(info) {
                localStorage.setItem('calendarView', info.view.type);
                localStorage.setItem('calendarDate', calendar.getDate().toISOString());
            },
            businessHours: [{
                daysOfWeek: [1, 2, 3, 4, 5],
                startTime: '08:00',
                endTime: '18:00',
            }]
        });

        const savedDate = localStorage.getItem('calendarDate');
        if (savedDate) {
            calendar.gotoDate(new Date(savedDate));
        }

        calendar.render();

        @this.on('refreshCalendar', function() {
            console.log('Refresh Calendar event received');
            calendar.removeAllEvents();
            calendar.addEventSource(@json($events));
        });
    })

    window.addEventListener('close-modal', event => {
        $('#modalJadwal').modal('hide');
    })
</script>
</div>
