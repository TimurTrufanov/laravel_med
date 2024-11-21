@extends('layouts.main')

@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Редагування лікаря</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('doctors.index') }}">Лікарі</a></li>
                            <li class="breadcrumb-item active">Редагування лікаря</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('doctors.update', $doctor->id) }}" method="POST" class="w-50"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>Ім'я <span style="color: red;">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       name="first_name"
                                       placeholder="Ім'я" value="{{ old('first_name', $doctor->user->first_name) }}">
                            </div>
                            @error('first_name')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Прізвище <span style="color: red;">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       name="last_name"
                                       placeholder="Прізвище" value="{{ old('last_name', $doctor->user->last_name) }}">
                            </div>
                            @error('last_name')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Email <span style="color: red;">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email"
                                       placeholder="Email" value="{{ old('email', $doctor->user->email) }}">
                            </div>
                            @error('email')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Дата народження</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                       name="date_of_birth"
                                       value="{{ old('date_of_birth', $doctor->user->date_of_birth) }}">
                            </div>
                            @error('date_of_birth')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>Стать</label>
                                <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                    <option disabled selected>Виберіть стать</option>
                                    <option
                                        value="чоловічий" {{ old('gender', $doctor->user->gender) == 'чоловічий' ? 'selected' : '' }}>
                                        Чоловіча
                                    </option>
                                    <option
                                        value="жіночий" {{ old('gender', $doctor->user->gender) == 'жіночий' ? 'selected' : '' }}>
                                        Жіноча
                                    </option>
                                </select>
                            </div>
                            @error('gender')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Адреса</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                       name="address"
                                       placeholder="Адреса" value="{{ old('address', $doctor->user->address) }}">
                            </div>
                            @error('address')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Номер телефону</label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                       name="phone_number"
                                       placeholder="Номер телефону"
                                       value="{{ old('phone_number', $doctor->user->phone_number) }}">
                            </div>
                            @error('phone_number')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="exampleInputFile">Фото</label>
                                <img src="{{ $doctor->user->photo }}" alt="Фото" width="100">
                                <div class="input-group @error('photo') is-invalid @enderror">
                                    <div class="custom-file">
                                        <input type="file" name="photo" accept="image/png, image/jpeg, image/jpg"
                                               class="custom-file-input @error('photo') is-invalid @enderror">
                                        <label class="custom-file-label">Виберіть фото</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Завантажити</span>
                                    </div>
                                </div>
                            </div>
                            @error('photo')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Клініка <span style="color: red;">*</span></label>
                                <select name="clinic_id" class="form-control @error('clinic_id') is-invalid @enderror">
                                    <option value="" disabled>Виберіть клініку</option>
                                    @foreach($clinics as $clinic)
                                        <option
                                            value="{{ $clinic->id }}" {{ old('clinic_id', $doctor->clinic_id) == $clinic->id ? 'selected' : '' }}>
                                            {{ $clinic->name }}
                                        </option>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('clinic_id')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Посада <span style="color: red;">*</span></label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror"
                                       name="position"
                                       placeholder="Посада" value="{{ old('position', $doctor->position) }}">
                            </div>
                            @error('position')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Біографія <span style="color: red;">*</span></label>
                                <textarea style="resize: none;"
                                          class="form-control @error('bio') is-invalid @enderror" name="bio"
                                          placeholder="Біографія" rows="3">{{ old('bio', $doctor->bio) }}</textarea>
                            </div>
                            @error('bio')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Тривалість прийому (хвилини)</label>
                                <input type="number"
                                       class="form-control @error('appointment_duration') is-invalid @enderror"
                                       name="appointment_duration" placeholder="Тривалість прийому"
                                       value="{{ old('appointment_duration', $doctor->appointment_duration) }}" min="5"
                                       max="60" step="5">
                            </div>
                            @error('appointment_duration')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Спеціалізації</label>
                                <select name="specializations[]"
                                        class="form-control select2 @error('specializations') is-invalid @enderror"
                                        multiple="multiple" data-placeholder="Виберіть спеціалізації">
                                    @foreach($specializations as $specialization)
                                        <option
                                            value="{{ $specialization->id }}"
                                            {{ collect(old('specializations', $selectedSpecializations))->contains($specialization->id) ? 'selected' : '' }}>
                                            {{ $specialization->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('specializations')
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
