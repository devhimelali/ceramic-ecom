@extends('layouts.guest')
@section('title', 'Register')
@section('content')
    <div class="col-lg-6">
        <div class="card mb-0">
            <div class="row g-0 align-items-center">
                <div class="col-xxl-12 mx-auto">
                    <div class="card mb-0 border-0 shadow-none mb-0">
                        <div class="card-body p-sm-5 m-lg-1">
                            <div class="text-center">
                                <h5 class="fs-3xl">Create your account</h5>
                                <p class="text-muted">Get your Koormal Extras account now.</p>
                            </div>
                            <div class="p-2 mt-2">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative ">
                                            <input type="text"
                                                   class="form-control  password-input {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   name="name"
                                                   id="name" placeholder="Enter name" required autofocus
                                                   autocomplete="name" value="{{old('name')}}">
                                            @if($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="position-relative ">
                                            <input type="email"
                                                   class="form-control  password-input {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                   name="email"
                                                   id="email" placeholder="Enter email" required
                                                   autofocus autocomplete="username" value="{{old('email')}}">
                                            @if($errors->has('email'))
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
                                                   class="form-control pe-5 password-input {{$errors->has('password') ? ' is-invalid' : '' }}"
                                                   placeholder="Enter password" id="password-input" name="password"
                                                   required autocomplete="new-password">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                        @if($errors->has('password'))
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
                                                   class="form-control pe-5 password-input {{$errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                                   placeholder="Enter password" id="password_confirmation" name="password_confirmation"
                                                   required autocomplete="new-password">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                        @if($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   name="terms" id="terms">
                                            <label class="form-check-label" for="auth-remember-check">I agree to the <a href="{{route('terms.show')}}" class="fw-semibold text-primary text-decoration-underline">Terms and Conditions</a> and <a href="{{route('policy.show')}}" class="fw-semibold text-primary text-decoration-underline">Privacy Policy</a></label>
                                        </div>
                                    @endif

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Sign Up</button>
                                    </div>
                                </form>

                                <div class="text-center mt-4">
                                    <p class="mb-0">Already have an account ? <a href="{{route('login')}}"
                                                                               class="fw-semibold text-secondary text-decoration-underline">
                                            Signin</a></p>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
    </div>
    <!--end col-->
@endsection





{{--<x-guest-layout>--}}
{{--    <x-authentication-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <x-authentication-card-logo />--}}
{{--        </x-slot>--}}

{{--        <x-validation-errors class="mb-4" />--}}

{{--        <form method="POST" action="{{ route('register') }}">--}}
{{--            @csrf--}}

{{--            <div>--}}
{{--                <x-label for="name" value="{{ __('Name') }}" />--}}
{{--                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-label for="email" value="{{ __('Email') }}" />--}}
{{--                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-label for="password" value="{{ __('Password') }}" />--}}
{{--                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />--}}
{{--                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())--}}
{{--                <div class="mt-4">--}}
{{--                    <x-label for="terms">--}}
{{--                        <div class="flex items-center">--}}
{{--                            <x-checkbox name="terms" id="terms" required />--}}

{{--                            <div class="ms-2">--}}
{{--                                {!! __('I agree to the :terms_of_service and :privacy_policy', [--}}
{{--                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',--}}
{{--                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',--}}
{{--                                ]) !!}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </x-label>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">--}}
{{--                    {{ __('Already registered?') }}--}}
{{--                </a>--}}

{{--                <x-button class="ms-4">--}}
{{--                    {{ __('Register') }}--}}
{{--                </x-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-authentication-card>--}}
{{--</x-guest-layout>--}}
