@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Редагування послуги</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('services.index') }}">Послуги</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $service->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('services.update', $service->id) }}" method="POST" class="w-50">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>Назва <span style="color: red;">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                       placeholder="Назва послуги" value="{{ old('name', $service->name) }}">
                            </div>
                            @error('name')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Опис</label>
                                <textarea style="resize: none;"
                                          class="form-control @error('description') is-invalid @enderror"
                                          name="description" placeholder="Опис послуги"
                                >{{ old('description', $service->description) }}</textarea>
                            </div>
                            @error('description')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>Ціна <span style="color: red;">*</span></label>
                                <input type="text" class="form-control @error('price') is-invalid @enderror"
                                       name="price"
                                       placeholder="Ціна" value="{{ old('price', $service->price) }}">
                            </div>
                            @error('price')
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
