@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Клініки</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active">Клініки</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <a href="{{ route('clinics.create') }}" class="btn btn-block btn-primary">Додати</a>
                    </div>

                    <form action="{{ route('clinics.index') }}" method="GET">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control" placeholder="Пошук по назві"
                                   style="border-top-right-radius: 0; border-bottom-right-radius: 0"
                                   value="{{ request()->query('search') }}">
                            <button type="submit" class="btn btn-primary"
                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                @if($clinics->isEmpty())
                    <div class="alert alert-warning">
                        Нічого не знайдено
                    </div>
                @else
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Назва</th>
                                            <th>Регіон</th>
                                            <th>Місто</th>
                                            <th>Адреса</th>
                                            <th>Номер телефону</th>
                                            <th>Email</th>
                                            <th>Спеціалізації</th>
                                            <th colspan="3">Дія</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($clinics as $clinic)
                                            <tr>
                                                <td>{{ $clinic->id }}</td>
                                                <td>{{ $clinic->name }}</td>
                                                <td>{{ $clinic->region }}</td>
                                                <td>{{ $clinic->city }}</td>
                                                <td>{{ $clinic->address }}</td>
                                                <td>{{ $clinic->phone_number }}</td>
                                                <td>{{ $clinic->email }}</td>
                                                <td>{{ $clinic->specializations->pluck('name')->implode(', ') }}</td>
                                                <td><a href="{{ route('clinics.show', $clinic->id) }}"><i
                                                            class="far fa-eye"></i></a></td>
                                                <td><a href="{{ route('clinics.edit', $clinic->id) }}"
                                                       class="text-success"><i class="fas fa-pencil-alt"></i></a></td>
                                                <td>
                                                    <button class="border-0 bg-transparent"
                                                            onclick="openDeleteModal({{ $clinic->id }}, '/clinics')">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            {{ $clinics->appends(['search' => request()->query('search')])->links() }}
                        </div>
                    </div>

                    <x-modal id="deleteModal" title="Підтвердження видалення" formId="deleteForm" action="">
                        Ви впевнені, що бажаєте видалити цю клініку?
                    </x-modal>
                @endif
            </div>
        </section>
    </div>
@endsection
