<!DOCTYPE html>
<html>
<head>
    <title>Kalender Cuti - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet'>
    <style>
        .calendar-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .fc-event {
            cursor: pointer;
        }
        .fc-event-title {
            white-space: normal;
        }
    </style>
</head>
<body>
    @include('layouts.nav')
    
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Kalender Cuti</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Kalender</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="calendar-container">
            <div id='calendar'></div>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
 <!-- filepath: /C:/laragon/www/pengajuan-cuti/resources/views/admin/calendar.blade.php -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            events: @json($events),
            eventClick: function(info) {
                var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                document.getElementById('modalKaryawan').textContent = info.event.extendedProps.karyawan;
                document.getElementById('modalStart').textContent = info.event.extendedProps.startDate;
                document.getElementById('modalEnd').textContent = info.event.extendedProps.endDate;
                document.getElementById('modalStatus').textContent = info.event.extendedProps.status;
                document.getElementById('modalViewLink').href = info.event.extendedProps.url;
                modal.show();
            },
            eventTimeFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: false,
                hour12: false
            }
        });
        calendar.render();
    });
    </script>
</body>
</html>