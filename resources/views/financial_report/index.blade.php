@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Фінансові показники</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active">Фінансові показники</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content pb-4">
            <div class="container-fluid">
                <form method="GET" action="{{ route('financial_report.index') }}">
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
                            <label for="type">Тип</label>
                            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                <option value="">Всі</option>
                                <option value="analyses" {{ request('type') == 'analyses' ? 'selected' : '' }}>Анализы</option>
                                <option value="services" {{ request('type') == 'services' ? 'selected' : '' }}>Услуги</option>
                            </select>
                            @error('type')
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
                    @if(isset($records) && $records->isNotEmpty())
                        <div class="row mt-4">
                            <div class="col-12">
                                <h3>Клініка: {{ $clinicName }}</h3>
                                <h3>Період:
                                    @if(isset($startDate) && isset($endDate) && $startDate === $endDate)
                                        {{ $startDate->format('d.m.Y') }}
                                    @elseif($startDate && $endDate)
                                        {{ $startDate->format('d.m.Y') }} - {{ $endDate->format('d.m.Y') }}
                                    @else
                                        весь
                                    @endif
                                </h3>
                                <h3>Тип: {{ $type === 'analyses' ? 'Анализы' : ($type === 'services' ? 'Услуги' : 'Всі') }}</h3>

                                <div class="card">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                            <tr>
                                                <th>Назва</th>
                                                <th>Ціна за одиницю</th>
                                                <th>Кількість</th>
                                                <th>Загальна вартість</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($records as $item)
                                                <tr>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td>{{ number_format($item['price'], 2) }} грн</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>{{ number_format($item['total_price'], 2) }} грн</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="text-right font-weight-bold">Загальна сума:</td>
                                                <td class="font-weight-bold">{{ number_format($totalSum, 2) }} грн</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <form action="{{ route('financial_report.pdf') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="clinic_id" value="{{ request('clinic_id') }}">
                                    <input type="hidden" name="type" value="{{ request('type') }}">
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
    </div>
@endsection
