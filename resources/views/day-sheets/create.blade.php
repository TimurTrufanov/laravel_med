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
                                <label>Лікар <span style="color: red;">*</span></label>
                                <select name="doctor_id" class="form-control @error('doctor_id') is-invalid @enderror">
                                    <option disabled selected>Виберіть лікаря</option>
                                    @foreach($doctors as $doctor)
                                        <option
                                            value="{{ $doctor->id }}"
                                            {{ old('doctor_id', $selectedDoctorId ?? null) == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}
                                            ({{ $doctor->user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('doctor_id')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Дата <span style="color: red;">*</span></label>
                                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                       value="{{ old('date', request()->query('date')) }}">
                            </div>
                            @error('date')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Час початку <span style="color: red;">*</span></label>
                                <input type="time" name="start_time"
                                       class="form-control @error('start_time') is-invalid @enderror"
                                       value="{{ old('start_time') }}">
                            </div>
                            @error('start_time')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Час закінчення <span style="color: red;">*</span></label>
                                <input type="time" name="end_time"
                                       class="form-control @error('end_time') is-invalid @enderror"
                                       value="{{ old('end_time') }}">
                            </div>
                            @error('end_time')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <input type="submit" class="btn btn-primary" value="Додати">
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const urlParams = new URLSearchParams(window.location.search);
                const date = urlParams.get('date');

                if (date) {
                    const dateInput = document.getElementById('date');
                    if (dateInput) {
                        dateInput.value = date;
                    }
                }
            });
        </script>
    </div>
@endsection
