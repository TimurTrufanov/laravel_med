@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Розклад роботи</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active">Розклад роботи</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <a href="{{ route('day-sheets.create') }}" class="btn btn-block btn-primary">Додати</a>
                    </div>

                    <form action="{{ route('day-sheets.index') }}" method="GET">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control" placeholder="Пошук за лікарем або клінікою"
                                   style="border-top-right-radius: 0; border-bottom-right-radius: 0"
                                   value="{{ request()->query('search') }}">
                            <button type="submit" class="btn btn-primary"
                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                @if($daySheets->isEmpty())
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
                                            <th>Лікар</th>
                                            <th>Клініка</th>
                                            <th>День тижня</th>
                                            <th colspan="3">Дія</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($daySheets as $daySheet)
                                            <tr>
                                                <td>{{ $daySheet->id }}</td>
                                                <td>{{ $daySheet->doctor->user->first_name }} {{ $daySheet->doctor->user->last_name }}</td>
                                                <td>{{ $daySheet->clinic->name }}</td>
                                                <td>{{ $daySheet->day_of_week }}</td>
                                                <td><a href="{{ route('day-sheets.show', $daySheet->id) }}"><i
                                                            class="far fa-eye"></i></a></td>
                                                <td><a href="{{ route('day-sheets.edit', $daySheet->id) }}"
                                                       class="text-success"><i class="fas fa-pencil-alt"></i></a></td>
                                                <td>
                                                    <button class="border-0 bg-transparent"
                                                            onclick="openDeleteModal({{ $daySheet->id }}, '/day-sheets')">
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
                            {{ $daySheets->appends(['search' => request()->query('search')])->links() }}
                        </div>
                    </div>

                    <x-modal id="deleteModal" title="Підтвердження видалення" formId="deleteForm" action="">
                        Ви впевнені, що бажаєте видалити цей розклад?
                    </x-modal>
                @endif
            </div>
        </section>
    </div>
@endsection
