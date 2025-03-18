
@extends('layouts.template.app')

@section('title', 'Kalender Cuti')

@push('css')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet'>
<style>
    :root {
        --primary-light: #e3f2fd;
        --primary-main: #2196f3;
        --primary-dark: #1e88e5;
        --secondary-main: #012970;
        --success-light: #e8f5e9;
        --success-main: #4caf50;
        --warning-light: #fff8e1;
        --warning-main: #ffa000;
        --danger-light: #ffebee;
        --danger-main: #ef5350;
    }

    .main {
        margin-top: 60px;
        padding: 20px 30px;
        background: #f6f9ff;
        min-height: calc(100vh - 60px);
    }

    .calendar-container {
        background: #fff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
    }

    .calendar-header {
        color: var(--secondary-main);
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* FullCalendar Customization */
    .fc {
        font-family: 'Nunito', sans-serif;
    }

    .fc .fc-toolbar.fc-header-toolbar {
        margin-bottom: 2em;
    }

    .fc .fc-button-primary {
        background: var(--primary-main);
        border-color: var(--primary-main);
        font-weight: 500;
        text-transform: capitalize;
        padding: 8px 16px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .fc .fc-button-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(33, 150, 243, 0.2);
    }

    .fc .fc-daygrid-day.fc-day-today {
        background: var(--primary-light) !important;
    }

    .fc .fc-event {
        border-radius: 6px;
        padding: 3px 6px;
        font-size: 13px;
        font-weight: 500;
        border: none;
    }

    .fc .fc-event.pending {
        background: var(--warning-light);
        color: var(--warning-main);
    }

    .fc .fc-event.approved {
        background: var(--success-light);
        color: var(--success-main);
    }

    .fc .fc-event.rejected {
        background: var(--danger-light);
        color: var(--danger-main);
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background: linear-gradient(to right, var(--primary-light), #ffffff);
        padding: 20px 25px;
        border-bottom: 2px solid rgba(33, 150, 243, 0.1);
    }

    .modal-title {
        color: var(--secondary-main);
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-body p {
        margin-bottom: 15px;
        color: #444444;
    }

    .modal-body strong {
        color: var(--secondary-main);
        min-width: 120px;
        display: inline-block;
    }

    .modal-footer {
        padding: 20px 25px;
        border-top: 1px solid #e0e8f9;
    }

    .btn {
        padding: 8px 20px;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: var(--primary-main);
        border: none;
        box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
    }

    .btn-close {
        transition: transform 0.3s ease;
    }

    .btn-close:hover {
        transform: rotate(90deg);
    }
</style>
@endpush

@section('content')
<main id="main" class="main">
    <div class="calendar-container">
        <h4 class="calendar-header">Kalender Cuti</h4>
        <div id='calendar'></div>
    </div>

    <!-- Event Detail Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Cuti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Karyawan:</strong> <span id="modalKaryawan"></span></p>
                    <p><strong>Jenis Cuti:</strong> <span id="modalJenisCuti"></span></p>
                    <p><strong>Tanggal Mulai:</strong> <span id="modalStart"></span></p>
                    <p><strong>Tanggal Selesai:</strong> <span id="modalEnd"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="modalViewLink" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu'
            },
            events: @json($events),
            eventDidMount: function(info) {
                info.el.classList.add(info.event.extendedProps.status.toLowerCase());
            },
            eventClick: function(info) {
                // Update modal content
                document.getElementById('modalKaryawan').textContent = info.event.extendedProps.karyawan;
                document.getElementById('modalJenisCuti').textContent = info.event.extendedProps.jenis_cuti_label;
                document.getElementById('modalStart').textContent = info.event.extendedProps.startDate;
                document.getElementById('modalEnd').textContent = info.event.extendedProps.endDate;
                document.getElementById('modalStatus').textContent = info.event.extendedProps.status;
                
                // Update detail link
                var viewLink = document.getElementById('modalViewLink');
                if (viewLink) {
                    viewLink.href = info.event.extendedProps.detailUrl;
                }

                // Show modal
                eventModal.show();
            },
            displayEventTime: false,
            allDay: true
        });

        calendar.render();
    });
</script>
@endpush