@extends('layouts.guest')
@section('title', 'Reset Password')
@section('content')
    <div class="col-lg-5">
        <div class="card mb-0">
            <div class="row g-0 align-items-center">
                <div class="col-xxl-12 mx-auto">
                    <div class="card mb-0 border-0 shadow-none">
                        <div class="card-body p-sm-5 m-lg-1">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative ">
                                        <input type="email"
                                            class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email" id="email" placeholder="Enter email" readonly required
                                            autofocus autocomplete="username" value="{{ old('email', $request->email) }}">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password-input">Password <span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password"
                                            class="form-control pe-5 password-input {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            placeholder="Enter password" id="password-input" name="password" required
                                            autocomplete="new-password">
                                        <button
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-addon"><i
                                                class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password_confirmation">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password"
                                            class="form-control pe-5 password-input {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                            placeholder="Enter password" id="password_confirmation"
                                            name="password_confirmation" required autocomplete="new-password">
                                        <button
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-addon"><i
                                                class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit">Rest Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
