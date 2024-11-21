@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Додавання клініки</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('clinics.index') }}">Клініки</a></li>
                            <li class="breadcrumb-item active">Додавання клініки</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('clinics.store') }}" method="POST" class="w-50">
                            @csrf
                            <div class="form-group">
                                <label>Назва <span style="color: red;">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                       placeholder="Назва клініки" value="{{ old('name') }}">
                            </div>
                            @error('name')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Регіон</label>
                                <input type="text" class="form-control @error('region') is-invalid @enderror"
                                       placeholder="Регіон" name="region" value="{{ old('region') }}">
                            </div>
                            @error('region')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Місто</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                                       placeholder="Місто" value="{{ old('city') }}">
                            </div>
                            @error('city')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Адреса</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                       placeholder="Адреса" name="address" value="{{ old('address') }}">
                            </div>
                            @error('address')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Номер телефону</label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                       placeholder="Номер телефону" name="phone_number"
                                       value="{{ old('phone_number') }}">
                            </div>
                            @error('phone_number')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Email" name="email" value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Спеціалізації</label>
                                <select name="specializations[]"
                                        class="form-control select2 @error('specializations') is-invalid @enderror"
                                        multiple="multiple" data-placeholder="Виберіть спеціалізації">
                                    @foreach($specializations as $specialization)
                                        <option value="{{ $specialization->id }}"
                                            {{ collect(old('specializations'))->contains($specialization->id) ? 'selected' : '' }}>
                                            {{ $specialization->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('specializations')
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
