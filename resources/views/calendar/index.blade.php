@extends('layouts.main')

@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Календарь расписаний</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Главная</a></li>
                            <li class="breadcrumb-item active">Календарь расписаний</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="clinicFilter">Выберите клинику:</label>
                <select id="clinicFilter" class="form-control">
                    <option value="">Все клиники</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="doctorFilter">Выберите врача:</label>
                <select id="doctorFilter" class="form-control">
                    <option value="">Все врачи</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const clinicFilter = document.getElementById('clinicFilter');
            const doctorFilter = document.getElementById('doctorFilter');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: function (fetchInfo, successCallback, failureCallback) {
                    const clinicId = clinicFilter.value;
                    const doctorId = doctorFilter.value;

                    const params = new URLSearchParams({ clinic_id: clinicId, doctor_id: doctorId }).toString();
                    fetch(`/api/schedule?${params}`)
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => failureCallback(error));
                },
                dateClick: function (info) {
                    const url = `/day-sheets/create?date=${info.dateStr}`;
                    window.location.href = url; // Редирект на страницу создания
                },
                eventClick: function (info) {
                    alert(`Событие: ${info.event.title}`);
                }
            });

            calendar.render();

            // Перезагрузка событий при изменении фильтров
            clinicFilter.addEventListener('change', () => calendar.refetchEvents());
            doctorFilter.addEventListener('change', () => calendar.refetchEvents());
        });
    </script>
@endsection
