@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex align-items-center">
                        <h1 class="m-0 mr-2">Розклад на {{ $daySheet->day_of_week }}</h1>
                        <a href="{{ route('day-sheets.edit', $daySheet->id) }}" class="text-success mr-2"><i
                                class="fas fa-pencil-alt"></i></a>
                        <button class="border-0 bg-transparent"
                                onclick="openDeleteModal({{ $daySheet->id }}, '/day-sheets')">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('day-sheets.index') }}">Розклади</a></li>
                            <li class="breadcrumb-item active">Розклад на {{ $daySheet->day_of_week }}</li>
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
                                        <td>{{ $daySheet->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Лікар</td>
                                        <td>{{ $daySheet->doctor->user->first_name }} {{ $daySheet->doctor->user->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Клініка</td>
                                        <td>{{ $daySheet->clinic->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>День тижня</td>
                                        <td>{{ $daySheet->day_of_week }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <x-modal id="deleteModal" title="Підтвердження видалення" formId="deleteForm" action="">
                    Ви впевнені, що бажаєте видалити цей розклад?
                </x-modal>
            </div>
        </section>
    </div>
@endsection
