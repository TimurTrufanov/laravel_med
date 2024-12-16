@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Завантаженість лікарів</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active">Завантаженість лікарів</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content pb-4">
            <div class="container-fluid">
                <form method="GET" action="{{ route('doctors_workload.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="clinic_id">Клініка</label>
                            <select class="form-control @error('clinic_id') is-invalid @enderror" name="clinic_id"
                                    id="clinic_id">
                                <option value="">Всі клініки</option>
                                @foreach($clinics as $clinic)
                                    <option
                                        value="{{ $clinic->id }}" {{ request('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                        {{ $clinic->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('clinic_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="specialization_id">Спеціалізація</label>
                            <select class="form-control @error('specialization_id') is-invalid @enderror"
                                    name="specialization_id" id="specialization_id">
                                <option value="">Всі спеціалізації</option>
                                @foreach($specializations as $specialization)
                                    <option
                                        value="{{ $specialization->id }}" {{ request('specialization_id') == $specialization->id ? 'selected' : '' }}>
                                        {{ $specialization->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('specialization_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="doctor_id">Лікар</label>
                            <select class="form-control @error('doctor_id') is-invalid @enderror" name="doctor_id"
                                    id="doctor_id">
                                <option value="">Всі лікарі</option>
                                @foreach($doctors as $doctor)
                                    <option
                                        value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}
                                        ({{ $doctor->user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="start_date">Дата початку</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                   name="start_date" id="start_date" value="{{ request('start_date') }}">
                            @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="end_date">Дата завершення</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                   name="end_date" id="end_date" value="{{ request('end_date') }}">
                            @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Згенерувати звіт</button>
                </form>

                @if(request()->has(['start_date', 'end_date']))
                    @if(!empty($doctorsWorkload) && $doctorsWorkload->isNotEmpty())
                        <div class="row mt-4">
                            <div class="col-12">
                                <h3>Клініка: {{ $clinicName }}</h3>
                                <h3>Спеціалізація: {{ $specializationName }}</h3>
                                <h3>Період:
                                    @if(isset($startDate) && isset($endDate) && $startDate === $endDate)
                                        {{ $startDate }}
                                    @elseif($startDate && $endDate)
                                        {{ $startDate }} - {{ $endDate }}
                                    @else
                                        весь
                                    @endif
                                </h3>
                                <div class="card">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                            <tr>
                                                <th>Лікар</th>
                                                <th>Кількість записів</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($doctorsWorkload as $doctor => $appointments)
                                                <tr>
                                                    <td>{{ $doctor }}</td>
                                                    <td>{{ $appointments->count() }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <form action="{{ route('doctors_workload.pdf') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="clinic_id" value="{{ request('clinic_id') }}">
                                    <input type="hidden" name="specialization_id"
                                           value="{{ request('specialization_id') }}">
                                    <input type="hidden" name="doctor_id" value="{{ request('doctor_id') }}">
                                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                                    <button type="submit" class="btn btn-success">Завантажити PDF</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mt-4">
                            Немає даних за вибраний період.
                        </div>
                    @endif
                @endif
            </div>
        </section>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const clinicSelect = document.getElementById('clinic_id');
                const specializationSelect = document.getElementById('specialization_id');
                const doctorSelect = document.getElementById('doctor_id');

                const preserveSelectedValue = (selectElement, selectedValue) => {
                    Array.from(selectElement.options).forEach(option => {
                        if (option.value === selectedValue) {
                            option.selected = true;
                        }
                    });
                };

                const updateSpecializationsAndDoctors = (clinicId) => {
                    fetch(`/doctors-workload/filters?clinic_id=${clinicId}`)
                        .then(response => response.json())
                        .then(data => {
                            const currentSpecialization = specializationSelect.value;
                            const currentDoctor = doctorSelect.value;

                            specializationSelect.innerHTML = '<option value="">Всі спеціалізації</option>';
                            data.specializations.forEach(specialization => {
                                specializationSelect.innerHTML += `<option value="${specialization.id}">${specialization.name}</option>`;
                            });
                            preserveSelectedValue(specializationSelect, currentSpecialization);

                            doctorSelect.innerHTML = '<option value="">Всі лікарі</option>';
                            data.doctors.forEach(doctor => {
                                doctorSelect.innerHTML += `<option value="${doctor.id}">
                        ${doctor.first_name} ${doctor.last_name} (${doctor.email})
                    </option>`;
                            });
                            preserveSelectedValue(doctorSelect, currentDoctor);
                        });
                };

                const updateDoctors = (clinicId, specializationId) => {
                    fetch(`/doctors-workload/filters?clinic_id=${clinicId}&specialization_id=${specializationId}`)
                        .then(response => response.json())
                        .then(data => {
                            const currentDoctor = doctorSelect.value;

                            doctorSelect.innerHTML = '<option value="">Всі лікарі</option>';
                            data.doctors.forEach(doctor => {
                                doctorSelect.innerHTML += `<option value="${doctor.id}">
                        ${doctor.first_name} ${doctor.last_name} (${doctor.email})
                    </option>`;
                            });
                            preserveSelectedValue(doctorSelect, currentDoctor);
                        });
                };

                clinicSelect.addEventListener('change', function () {
                    const clinicId = this.value;
                    specializationSelect.innerHTML = '<option value="">Всі спеціалізації</option>';
                    doctorSelect.innerHTML = '<option value="">Всі лікарі</option>';
                    if (clinicId) {
                        updateSpecializationsAndDoctors(clinicId);
                    } else {
                        fetch(`/doctors-workload/filters`)
                            .then(response => response.json())
                            .then(data => {
                                data.specializations.forEach(specialization => {
                                    specializationSelect.innerHTML += `<option value="${specialization.id}">${specialization.name}</option>`;
                                });

                                data.doctors.forEach(doctor => {
                                    doctorSelect.innerHTML += `<option value="${doctor.id}">
                        ${doctor.first_name} ${doctor.last_name} (${doctor.email})
                    </option>`;
                                });
                            });
                    }
                });

                specializationSelect.addEventListener('change', function () {
                    const clinicId = clinicSelect.value;
                    const specializationId = this.value;
                    if (clinicId) {
                        updateDoctors(clinicId, specializationId);
                    }
                });
            });
        </script>
    </div>
@endsection
