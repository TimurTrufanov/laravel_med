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

        <div class="mb-4">
            <label for="doctorFilter">Выберите врача:</label>
            <select id="doctorFilter" class="form-control">
                <option value="">Все врачи</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</option>
                @endforeach
            </select>
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
            const doctorFilter = document.getElementById('doctorFilter');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true,
                events: function (fetchInfo, successCallback, failureCallback) {
                    const doctorId = doctorFilter.value; // Получаем ID выбранного врача
                    const url = doctorId ? `/api/day-sheets?doctor_id=${doctorId}` : '/api/day-sheets';

                    fetch(url)
                        .then(response => response.json())
                        .then(data => successCallback(data)) // Добавление событий в календарь
                        .catch(error => failureCallback(error));
                },
                dateClick: function (info) {
                    // Обработка клика по дате
                    const title = prompt('Введите расписание:');
                    if (title) {
                        fetch('/api/day-sheets', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                doctor_id: doctorFilter.value || 1, // Используем ID выбранного врача
                                clinic_id: 1, // Клиника по умолчанию
                                day_of_week: info.dateStr
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                calendar.addEvent({
                                    id: data.id,
                                    title: title,
                                    start: info.dateStr,
                                    allDay: true,
                                    backgroundColor: '#007bff', // Цвет добавленного события
                                    borderColor: '#007bff'
                                });
                            })
                            .catch(() => alert('Ошибка создания расписания'));
                    }
                },
                eventClick: function (info) {
                    if (confirm('Вы уверены, что хотите удалить это событие?')) {
                        fetch(`/api/day-sheets/${info.event.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                            .then(() => info.event.remove())
                            .catch(() => alert('Ошибка удаления'));
                    }
                }
            });

            calendar.render();

            // Обновление календаря при изменении врача в фильтре
            doctorFilter.addEventListener('change', () => {
                calendar.refetchEvents(); // Перезагружает события для отображения рабочих дней выбранного врача
            });
        });
    </script>
@endsection
