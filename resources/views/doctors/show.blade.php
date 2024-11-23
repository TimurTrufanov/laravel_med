@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex align-items-center">
                        <h1 class="m-0 mr-2">{{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</h1>
                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="text-success mr-2"><i
                                class="fas fa-pencil-alt"></i></a>
                        <button class="border-0 bg-transparent"
                                onclick="openDeleteModal({{ $doctor->id }}, '/doctors')">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('doctors.index') }}">Лікарі</a></li>
                            <li class="breadcrumb-item active">{{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <tbody>
                                    <tr>
                                        <td>ID</td>
                                        <td>{{ $doctor->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Фото</td>
                                        <td>
                                            <img src="{{ $doctor->user->photo }}" alt="Фото" width="100">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ім'я</td>
                                        <td>{{ $doctor->user->first_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Прізвище</td>
                                        <td>{{ $doctor->user->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $doctor->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Номер телефону</td>
                                        <td>{{ $doctor->user->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Адреса</td>
                                        <td>{{ $doctor->user->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Дата народження</td>
                                        <td>{{ $doctor->user->formatted_date_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <td>Стать</td>
                                        <td>{{ $doctor->user->gender }}</td>
                                    </tr>
                                    <tr>
                                        <td>Клініка</td>
                                        <td>
                                            <a href="{{ route('clinics.show', $doctor->clinic->id) }}">
                                                {{ $doctor->clinic->name}}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Посада</td>
                                        <td>{{ $doctor->position }}</td>
                                    </tr>
                                    <tr>
                                        <td>Спеціалізації</td>
                                        <td>{{ $doctor->specializations->pluck('name')->implode(', ') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Тривалість прийому (хвилин)</td>
                                        <td>{{ $doctor->appointment_duration }}</td>
                                    </tr>
                                    <tr>
                                        <td>Біографія</td>
                                        <td style="white-space: pre-wrap;">{{ $doctor->bio }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4>Графік днів</h4>
                            <a href="{{ route('day-sheets.create', ['doctor_id' => $doctor->id]) }}"
                               class="btn btn-primary">Додати день</a>
                        </div>
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>Дата</th>
                                        <th>Час початку</th>
                                        <th>Час закінчення</th>
                                        <th>Клініка</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($doctor->daySheets as $daySheet)
                                        <tr onclick="window.location.href='{{ route('day-sheets.edit', $daySheet->id) }}';"
                                            style="cursor: pointer;">
                                            <td>{{ $daySheet->formatted_date }}</td>
                                            <td>{{ $daySheet->start_time }}</td>
                                            <td>{{ $daySheet->end_time }}</td>
                                            <td>{{ $daySheet->clinic->name }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <x-modal id="deleteModal" title="Підтвердження видалення" formId="deleteForm" action="">
                    Ви впевнені, що бажаєте видалити цього лікаря?
                </x-modal>
            </div>
        </section>
    </div>
@endsection
