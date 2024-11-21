@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Час роботи</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active">Час роботи</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <a href="{{ route('time-sheets.create') }}" class="btn btn-block btn-primary">Додати</a>
                    </div>

                    <form action="{{ route('time-sheets.index') }}" method="GET">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control" placeholder="Пошук"
                                   style="border-top-right-radius: 0; border-bottom-right-radius: 0"
                                   value="{{ request()->query('search') }}">
                            <button type="submit" class="btn btn-primary"
                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                @if($timeSheets->isEmpty())
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
                                            <th>Доктор</th>
                                            <th>Клініка</th>
                                            <th>День тижня</th>
                                            <th>Час початку</th>
                                            <th>Час закінчення</th>
                                            <th colspan="3">Дія</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($timeSheets as $timeSheet)
                                            <tr>
                                                <td>{{ $timeSheet->id }}</td>
                                                <td>
                                                    {{ $timeSheet->daySheet->doctor->user->first_name }}
                                                    {{ $timeSheet->daySheet->doctor->user->last_name }}
                                                </td>
                                                <td>{{ $timeSheet->daySheet->clinic->name }}</td>
                                                <td>{{ $timeSheet->daySheet->day_of_week }}</td>
                                                <td>{{ $timeSheet->start_time }}</td>
                                                <td>{{ $timeSheet->end_time }}</td>
                                                <td><a href="{{ route('time-sheets.show', $timeSheet->id) }}"><i
                                                            class="far fa-eye"></i></a></td>
                                                <td><a href="{{ route('time-sheets.edit', $timeSheet->id) }}"
                                                       class="text-success"><i class="fas fa-pencil-alt"></i></a></td>
                                                <td>
                                                    <button class="border-0 bg-transparent"
                                                            onclick="openDeleteModal({{ $timeSheet->id }}, '/time-sheets')">
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
                            {{ $timeSheets->appends(['search' => request()->query('search')])->links() }}
                        </div>
                    </div>

                    <x-modal id="deleteModal" title="Підтвердження видалення" formId="deleteForm" action="">
                        Ви впевнені, що бажаєте видалити цей час роботи?
                    </x-modal>
                @endif
            </div>
        </section>
    </div>
@endsection
