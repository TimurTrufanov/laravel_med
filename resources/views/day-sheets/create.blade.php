@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Додавання розкладу</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('day-sheets.index') }}">Розклад
                                    роботи</a></li>
                            <li class="breadcrumb-item active">Додавання розкладу</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('day-sheets.store') }}" method="POST" class="w-50">
                            @csrf
                            <div class="form-group">
                                <label>Лікарі <span style="color: red;">*</span></label>
                                <select id="doctor_ids" name="doctor_ids[]" multiple
                                        class="form-control select2 @error('doctor_ids') is-invalid @enderror">
                                    @foreach($doctors as $doctor)
                                        <option
                                            value="{{ $doctor->id }}" {{ collect(old('doctor_ids'))->contains($doctor->id) ? 'selected' : '' }}>
                                            {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('doctor_ids')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Клініка <span style="color: red;">*</span></label>
                                <select id="clinic_id" name="clinic_id"
                                        class="form-control @error('clinic_id') is-invalid @enderror">
                                    <option disabled selected>Виберіть клініку</option>
                                    @foreach($clinics as $clinic)
                                        <option
                                            value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                            {{ $clinic->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('clinic_id')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Дні тижня <span style="color: red;">*</span></label>
                                <select id="days_of_week" name="days_of_week[]" multiple
                                        class="form-control select2 @error('days_of_week') is-invalid @enderror">
                                    @foreach(['Понеділок', 'Вівторок', 'Середа', 'Четвер', 'Пʼятниця', 'Субота', 'Неділя'] as $day)
                                        <option
                                            value="{{ $day }}" {{ collect(old('days_of_week'))->contains($day) ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('days_of_week')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <input type="submit" class="btn btn-primary" value="Додати">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
