@extends('layouts.main')

@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Редагування часу роботи</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('time-sheets.index') }}">Час роботи</a></li>
                            <li class="breadcrumb-item active">Редагування часу роботи</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('time-sheets.update', $timeSheet->id) }}" method="POST" class="w-50">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label>Day Sheet <span style="color: red;">*</span></label>
                                <select name="day_sheet_id" class="form-control @error('day_sheet_id') is-invalid @enderror">
                                    <option disabled selected>Виберіть день</option>
                                    @foreach($daySheets as $daySheet)
                                        <option
                                            value="{{ $daySheet->id }}" {{ old('day_sheet_id', $timeSheet->day_sheet_id) == $daySheet->id ? 'selected' : '' }}>
                                            {{ $daySheet->doctor->user->first_name }} {{ $daySheet->doctor->user->last_name }} - {{ $daySheet->clinic->name }} ({{ $daySheet->day_of_week }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('day_sheet_id')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Час початку <span style="color: red;">*</span></label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                       name="start_time" value="{{ old('start_time', $timeSheet->start_time) }}">
                            </div>
                            @error('start_time')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Час закінчення <span style="color: red;">*</span></label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                       name="end_time" value="{{ old('end_time', $timeSheet->end_time) }}">
                            </div>
                            @error('end_time')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <input type="submit" class="btn btn-primary mb-4" value="Оновити">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
