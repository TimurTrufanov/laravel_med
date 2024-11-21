@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Додавання спеціалізіції</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('main.index') }}">Головна</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="{{ route('specializations.index') }}">Спеціалізіції</a>
                            </li>
                            <li class="breadcrumb-item active">Додавання спеціалізіції</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('specializations.store') }}" method="POST" class="w-50">
                            @csrf
                            <div class="form-group">
                                <label>Назва <span style="color: red;">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                       placeholder="Назва спеціалізації" value="{{ old('name') }}">
                            </div>
                            @error('name')
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
