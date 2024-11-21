@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex align-items-center">
                        <h1 class="m-0 mr-2">{{ $clinic->name }}</h1>
                        <a href="{{ route('clinics.edit', $clinic->id) }}" class="text-success mr-2"><i
                                class="fas fa-pencil-alt"></i></a>
                        <button class="border-0 bg-transparent"
                                onclick="openDeleteModal({{ $clinic->id }}, '/clinics')">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('clinics.index') }}">Клініки</a></li>
                            <li class="breadcrumb-item active">{{ $clinic->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <tbody>
                                    <tr>
                                        <td>ID</td>
                                        <td>{{ $clinic->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Назва</td>
                                        <td>{{ $clinic->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Регіон</td>
                                        <td>{{ $clinic->region }}</td>
                                    </tr>
                                    <tr>
                                        <td>Місто</td>
                                        <td>{{ $clinic->city }}</td>
                                    </tr>
                                    <tr>
                                        <td>Адреса</td>
                                        <td>{{ $clinic->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Номер телефону</td>
                                        <td>{{ $clinic->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $clinic->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Спеціалізації</td>
                                        <td>{{ $clinic->specializations->pluck('name')->implode(', ') }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <x-modal id="deleteModal" title="Підтвердження видалення" formId="deleteForm" action="">
                    Ви впевнені, що бажаєте видалити цю клініку?
                </x-modal>
            </div>
        </section>
    </div>
@endsection
