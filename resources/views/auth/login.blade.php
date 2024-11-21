@extends('layouts.base')

@section('title', 'Login')

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="login-box">
            <div class="login-logo">
                <b>Admin</b>Panel
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Увійдіть, щоб почати роботу</p>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="input-group mt-3">
                            <input type="password" name="password" class="form-control" placeholder="Пароль" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="row mt-3">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name="remember">
                                    <label for="remember">Запам’ятати мене</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Увійти</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
