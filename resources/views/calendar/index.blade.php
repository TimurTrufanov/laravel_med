@extends('layouts.main')

@section('admin_content')
    <div class="content-wrapper py-2">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Календар розкладів</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active">Календар розкладів</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 px-4">
            <div class="col-md-6">
                <label for="clinicFilter">Виберіть клініку:</label>
                <select id="clinicFilter" class="form-control">
                    <option value="">Усі клініки</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="doctorFilter">Виберіть лікаря:</label>
                <select id="doctorFilter" class="form-control">
                    <option value="">Усі лікарі</option>
                    @foreach($doctors as $doctor)
                        <option
                            value="{{ $doctor->id }}">{{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</option>
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

            function updateUrlParams() {
                const params = new URLSearchParams(window.location.search);
                const clinicId = clinicFilter.value;
                const doctorId = doctorFilter.value;

                if (clinicId) {
                    params.set('clinic_id', clinicId);
                } else {
                    params.delete('clinic_id');
                }

                if (doctorId) {
                    params.set('doctor_id', doctorId);
                } else {
                    params.delete('doctor_id');
                }

                const newUrl = params.toString() ? `${window.location.pathname}?${params.toString()}` : window.location.pathname;

                window.history.replaceState({}, '', newUrl);
            }

            const urlParams = new URLSearchParams(window.location.search);
            const selectedClinicId = urlParams.get('clinic_id');
            const selectedDoctorId = urlParams.get('doctor_id');

            if (selectedClinicId) {
                clinicFilter.value = selectedClinicId;
            }

            if (selectedDoctorId) {
                doctorFilter.value = selectedDoctorId;
            }

            clinicFilter.addEventListener('change', () => {
                updateUrlParams();
                calendar.refetchEvents();
            });

            doctorFilter.addEventListener('change', () => {
                updateUrlParams();
                calendar.refetchEvents();
            });

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'uk',
                firstDay: 1,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Сьогодні',
                    month: 'Місяць',
                    week: 'Тиждень',
                    day: 'День'
                },
                validRange: {
                    start: new Date().toISOString().split('T')[0]
                },
                events: function (fetchInfo, successCallback, failureCallback) {
                    const clinicId = clinicFilter.value;
                    const doctorId = doctorFilter.value;

                    const params = new URLSearchParams({clinic_id: clinicId, doctor_id: doctorId}).toString();
                    fetch(`/api/calendar?${params}`)
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => failureCallback(error));
                },
                dateClick: function (info) {
                    const selectedDate = info.dateStr;
                    window.location.href = `/day-sheets/create?date=${encodeURIComponent(selectedDate)}`;
                },
                eventClick: function (info) {
                    const daySheetId = info.event.id;

                    if (daySheetId) {
                        window.location.href = `/day-sheets/${daySheetId}`;
                    }
                }
            });

            calendar.render();
        });
    </script>
@endsection
