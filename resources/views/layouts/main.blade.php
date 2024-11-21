@extends('layouts.base')

@section('title', 'Admin Panel')

@section('content')
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <div class="col-12">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item ml-auto mr-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">Вийти</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    @include('includes.sidebar')

    @yield('admin_content')

    <footer class="main-footer">
        <strong>Med clinic</strong>
    </footer>
</div>
@endsection
