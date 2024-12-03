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


    <script>
        // FUNCTION CALENDAR CUYY
        document.addEventListener('livewire:initialized', function() {
            const jadwal = @json($events);
            console.log(jadwal);
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
                selectable: {{ Auth::user()->role_id <= 2 ? 'true' : 'false' }},
                eventMouseEnter: function(info) {
                    if (!{{ Auth::user()->role_id <= 2 ? 'true' : 'false' }}) {
                        info.el.style.cursor = 'pointer';
                    }
                },
                datesSet: function(info) {
                    localStorage.setItem('calendarView', info.view.type);
                    localStorage.setItem('calendarDate', calendar.getDate().toISOString());
                }
            });

            const savedDate = localStorage.getItem('calendarDate');
            if (savedDate) {
                calendar.gotoDate(new Date(savedDate));
            }

            calendar.render();
        })
    </script>
</div>
