@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex align-items-center">
                        <h1 class="m-0 mr-2">Час роботи</h1>
                        <a href="{{ route('time-sheets.edit', $timeSheet->id) }}" class="text-success mr-2"><i
                                class="fas fa-pencil-alt"></i></a>
                        <button class="border-0 bg-transparent"
                                onclick="openDeleteModal({{ $timeSheet->id }}, '/time-sheets')">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('time-sheets.index') }}">
                                    Час роботи
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Час роботи</li>
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
                                        <td>{{ $timeSheet->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Доктор</td>
                                        <td>
                                            {{ $timeSheet->daySheet->doctor->user->first_name }}
                                            {{ $timeSheet->daySheet->doctor->user->last_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Клініка</td>
                                        <td>
                                            {{ $timeSheet->daySheet->clinic->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>День тижня</td>
                                        <td>
                                            {{ $timeSheet->daySheet->day_of_week }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Час початку</td>
                                        <td>
                                            {{ $timeSheet->start_time }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Час закінчення</td>
                                        <td>
                                            {{ $timeSheet->end_time }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <x-modal id="deleteModal" title="Підтвердження видалення" formId="deleteForm" action="">
                    Ви впевнені, що бажаєте видалити цей час роботи?
                </x-modal>
            </div>
        </section>
    </div>
@endsection
