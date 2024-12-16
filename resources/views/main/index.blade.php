@extends('layouts.main')
@section('admin_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Головна</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Головна</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>Звіт</h3>
                                <p>Статистика захворювань</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-disease"></i>
                            </div>
                            <a href="{{ route('disease_statistics.index') }}" class="small-box-footer">Подробнее <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>Звіт</h3>
                                <p>Завантаженість лікарів</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-notes-medical"></i>
                            </div>
                            <a href="{{ route('doctors_workload.index') }}" class="small-box-footer">Подробнее <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>Звіт</h3>
                                <p>Фінансові показники</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <a href="{{ route('financial_report.index') }}" class="small-box-footer">Подробнее <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
