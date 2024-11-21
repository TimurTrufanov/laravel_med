@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Послуги</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Головна</a></li>
                            <li class="breadcrumb-item active">Послуги</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <a href="{{ route('services.create') }}" class="btn btn-block btn-primary">Додати</a>
                    </div>

                    <form action="{{ route('services.index') }}" method="GET">
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
                @if($services->isEmpty())
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
                                            <th>Ціна</th>
                                            <th colspan="3">Дія</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($services as $service)
                                            <tr>
                                                <td>{{ $service->id }}</td>
                                                <td>{{ $service->name }}</td>
                                                <td class="text-truncate" style="max-width: 300px;">
                                                    {{ $service->description }}
                                                </td>
                                                <td>{{ $service->price }}</td>
                                                <td><a href="{{ route('services.show', $service->id) }}"><i
                                                            class="far fa-eye"></i></a></td>
                                                <td><a href="{{ route('services.edit', $service->id) }}"
                                                       class="text-success"><i class="fas fa-pencil-alt"></i></a></td>
                                                <td>
                                                    <button class="border-0 bg-transparent"
                                                            onclick="openDeleteModal({{ $service->id }}, '/services')">
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
                            {{ $services->appends(['search' => request()->query('search')])->links() }}
                        </div>
                    </div>

                    <x-modal id="deleteModal" title="Підтвердження видалення" formId="deleteForm" action="">
                        Ви впевнені, що бажаєте видалити цю послугу?
                    </x-modal>
                @endif
            </div>
        </section>
    </div>
@endsection
