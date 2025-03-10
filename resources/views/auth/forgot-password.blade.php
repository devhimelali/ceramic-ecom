@extends('layouts.guest')
@section('title', 'Forgot Password')
@section('content')
    <div class="col-lg-5">
        <div class="card mb-0">
            <div class="row g-0 align-items-center">
                <div class="col-xxl-12 mx-auto">
                    <div class="card mb-0 border-0 shadow-none">
                        <div class="card-body p-sm-5 m-lg-1">
                            <p class="text-center" style="font-size: 16px">Forgot your password? No problem. Just let us know
                                your email address and
                                we will email you a
                                password reset link that will allow you to choose a new one.</p>
                            <div class="p-2 mt-2">
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative ">
                                            <input type="email"
                                                class="form-control  password-input {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                name="email" id="email" placeholder="Enter email" required autofocus
                                                autocomplete="username" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Send Password Reset Link</button>
                                    </div>
                                    @session('status')
                                        <div class="mx-auto">
                                            <span class="alert alert-success" role="alert">
                                                <strong>{{ $value }}</strong>
                                            </span>
                                        </div>
                                    @endsession
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
