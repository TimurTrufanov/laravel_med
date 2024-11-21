@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Редагування розкладу</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('day-sheets.index') }}">Розклад
                                    роботи</a></li>
                            <li class="breadcrumb-item active">Редагування розкладу</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('day-sheets.update', $daySheet->id) }}" method="POST" class="w-50">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>Лікар <span style="color: red;">*</span></label>
                                <select name="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror">
                                    <option disabled selected>Виберіть лікаря</option>
                                    @foreach($doctors as $doctor)
                                        <option
                                            value="{{ $doctor->id }}"
                                            {{ old('doctor_id', $daySheet->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('doctor_id')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Клініка <span style="color: red;">*</span></label>
                                <select name="clinic_id" class="form-control @error('clinic_id') is-invalid @enderror">
                                    <option disabled selected>Виберіть клініку</option>
                                    @foreach($clinics as $clinic)
                                        <option
                                            value="{{ $clinic->id }}"
                                            {{ old('clinic_id', $daySheet->clinic_id) == $clinic->id ? 'selected' : '' }}>
                                            {{ $clinic->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('clinic_id')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>День тижня <span style="color: red;">*</span></label>
                                <select name="day_of_week"
                                        class="form-control @error('day_of_week') is-invalid @enderror">
                                    <option disabled selected>Виберіть день тижня</option>
                                    <option
                                        value="Понеділок" {{ old('day_of_week', $daySheet->day_of_week) == 'Понеділок' ? 'selected' : '' }}>
                                        Понеділок
                                    </option>
                                    <option
                                        value="Вівторок" {{ old('day_of_week', $daySheet->day_of_week) == 'Вівторок' ? 'selected' : '' }}>
                                        Вівторок
                                    </option>
                                    <option
                                        value="Середа" {{ old('day_of_week', $daySheet->day_of_week) == 'Середа' ? 'selected' : '' }}>
                                        Середа
                                    </option>
                                    <option
                                        value="Четвер" {{ old('day_of_week', $daySheet->day_of_week) == 'Четвер' ? 'selected' : '' }}>
                                        Четвер
                                    </option>
                                    <option
                                        value="Пʼятниця" {{ old('day_of_week', $daySheet->day_of_week) == 'Пʼятниця' ? 'selected' : '' }}>
                                        Пʼятниця
                                    </option>
                                    <option
                                        value="Субота" {{ old('day_of_week', $daySheet->day_of_week) == 'Субота' ? 'selected' : '' }}>
                                        Субота
                                    </option>
                                    <option
                                        value="Неділя" {{ old('day_of_week', $daySheet->day_of_week) == 'Неділя' ? 'selected' : '' }}>
                                        Неділя
                                    </option>
                                </select>
                            </div>
                            @error('day_of_week')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <input type="submit" class="btn btn-primary" value="Оновити">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
