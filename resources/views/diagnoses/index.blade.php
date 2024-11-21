@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Діагнози</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active">Діагнози</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <a href="{{ route('diagnoses.create') }}" class="btn btn-block btn-primary">Додати</a>
                    </div>

                    <form action="{{ route('diagnoses.index') }}" method="GET">
                        <div class="input-group">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="search" name="search" class="form-control" placeholder="Пошук по назві"
                                       style="border-top-right-radius: 0; border-bottom-right-radius: 0"
                                       value="{{ request()->query('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary" data-mdb-ripple-init
                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                @if($diagnoses->isEmpty())
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
                                            <th>Опис</th>
                                            <th colspan="3">Дія</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($diagnoses as $diagnosis)
                                            <tr>
                                                <td>{{ $diagnosis->id }}</td>
                                                <td>{{ $diagnosis->name }}</td>
                                                <td class="text-truncate" style="max-width: 300px;">
                                                    {{ $diagnosis->description }}
                                                </td>
                                                <td><a href="{{ route('diagnoses.show', $diagnosis->id) }}"><i
                                                            class="far fa-eye"></i></a></td>
                                                <td><a href="{{ route('diagnoses.edit', $diagnosis->id) }}"
                                                       class="text-success"><i class="fas fa-pencil-alt"></i></a></td>
                                                <td>
                                                    <button class="border-0 bg-transparent"
                                                            onclick="openDeleteModal({{ $diagnosis->id }}, '/diagnoses')">
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
                            {{ $diagnoses->appends(['search' => request()->query('search')])->links() }}
                        </div>
                    </div>

                    <x-modal id="deleteModal" title="Підтвердження видалення" formId="deleteForm" action="">
                        Ви впевнені, що бажаєте видалити цей діагноз?
                    </x-modal>
                @endif
            </div>
        </section>
    </div>
@endsection
