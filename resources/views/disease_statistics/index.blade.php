@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Статистика захворювань</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active">Статистика захворювань</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content pb-4">
            <div class="container-fluid">
                <form method="GET" action="{{ route('disease_statistics.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="clinic_id">Клініка</label>
                            <select class="form-control @error('clinic_id') is-invalid @enderror" name="clinic_id" id="clinic_id">
                                <option value="">Всі клініки</option>
                                @foreach($clinics as $clinic)
                                    <option value="{{ $clinic->id }}" {{ request('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                        {{ $clinic->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('clinic_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="diagnosis_id">Діагноз</label>
                            <select class="form-control @error('diagnosis_id') is-invalid @enderror" name="diagnosis_id" id="diagnosis_id">
                                <option value="">Всі діагнози</option>
                                @foreach($diagnoses as $diagnosis)
                                    <option value="{{ $diagnosis->id }}" {{ request('diagnosis_id') == $diagnosis->id ? 'selected' : '' }}>
                                        {{ $diagnosis->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('diagnosis_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="start_date">Дата початку</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{ request('start_date') }}">
                            @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="end_date">Дата завершення</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ request('end_date') }}">
                            @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Згенерувати звіт</button>
                </form>

                @if(request()->has(['start_date', 'end_date']))
                    @if($records && $records->isNotEmpty())
                        <div class="row mt-4">
                            <div class="col-12">
                                <h3>Клініка: {{ $clinics->find(request('clinic_id'))->name ?? 'Всі клініки' }}</h3>
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
                                                <th>Діагноз</th>
                                                <th>Кількість</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($diagnosisCounts as $diagnosis => $group)
                                                <tr>
                                                    <td>{{ $diagnosis }}</td>
                                                    <td>{{ $group->count() }}</td>
                                                </tr>
                                            @endforeach
                                            @if ($customDiagnosesCount > 0)
                                                <tr>
                                                    <td>Користувацький діагноз</td>
                                                    <td>{{ $customDiagnosesCount }}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <form action="{{ route('disease_statistics.pdf') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="clinic_id" value="{{ request('clinic_id') }}">
                                    <input type="hidden" name="diagnosis_id" value="{{ request('diagnosis_id') }}">
                                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                                    <button type="submit" class="btn btn-success">Завантажити PDF</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mt-4">
                            Немає даних за вибраний період для цієї клініки.
                        </div>
                    @endif
                @endif
            </div>
        </section>
    </div>
@endsection
