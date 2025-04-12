@extends('layouts.app')
@section('title', 'System Settings')
@section('content')
    {{--  Start breadcrumb  --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Manage System Settings</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage System Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{--  End breadcrumb  --}}
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">System Settings</h5>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <form action="{{ route('settings.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="col-sm-2 col-form-label" for="site_name"">Site Name</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="types[]" value="site_name">
                                    <input type="text" name="site_name" id="site_name" class="form-control"
                                        value="{{ old('site_name', app_setting('site_name')) }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="col-sm-2 col-form-label" for="site_icon"">Site Icon</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="types[]" value="site_icon">
                                    <input type="file" name="site_icon" id="site_icon" class="form-control"
                                        value="{{ old('site_icon') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="col-sm-2 col-form-label" for="light_logo"">Light Logo</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="types[]" value="light_logo">
                                    <input type="file" name="light_logo" id="light_logo" class="form-control"
                                        value="{{ old('light_logo') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="col-sm-2 col-form-label" for="dark_logo"">Dark Logo</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="types[]" value="dark_logo">
                                    <input type="file" name="dark_logo" id="dark_logo" class="form-control"
                                        value="{{ old('dark_logo') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="col-sm-2 col-form-label" for="email_header_logo"">Email Header Logo</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="types[]" value="email_header_logo">
                                    <input type="file" name="email_header_logo" id="email_header_logo"
                                        class="form-control" value="{{ old('email_header_logo') }}">
                                </div>
                            </div>


                            <div class="col-md-12 my-3">
                                <h4>Footer Settings</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="col-sm-2 col-form-label" for="footer_logo"">Footer Logo</label>
                                        <input type="hidden" name="types[]" value="footer_logo">
                                        <input type="file" name="footer_logo" id="footer_logo" class="form-control"
                                            value="{{ old('footer_logo') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="col-sm-2 col-form-label" for="contact_email">Email</label>
                                        <input type="hidden" name="types[]" value="contact_email">
                                        <input type="email" name="contact_email" id="contact_email"
                                            class="form-control"
                                            value="{{ old('contact_email', app_setting('contact_email')) }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="col-sm-2 col-form-label" for="contact_address">Address</label>
                                        <input type="hidden" name="types[]" value="contact_address">
                                        <input type="text" name="contact_address" id="contact_address"
                                            class="form-control"
                                            value="{{ old('contact_address', app_setting('contact_address')) }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="col-sm-2 col-form-label" for="contact_phone">Phone</label>
                                        <input type="hidden" name="types[]" value="contact_phone">
                                        <input type="text" name="contact_phone" id="contact_phone"
                                            class="form-control"
                                            value="{{ old('contact_phone', app_setting('contact_phone')) }}">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="col-sm-2 col-form-label" for="copy_right">Copy Right Text</label>

                                        <input type="hidden" name="types[]" value="copy_right">
                                        <input type="text" name="copy_right" id="copy_right" class="form-control"
                                            value="{{ old('copy_right', app_setting('copy_right')) }}">

                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="col-sm-2 col-form-label" for="about_description"">About
                                            Description</label>
                                        <input type="hidden" name="types[]" value="about_description">
                                        <textarea name="about_description" id="about_description" class="form-control" row="6">{{ old('about_description', app_setting('about_description')) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 my-3">
                                <h4>Social Links</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="col-sm-2 col-form-label" for="facebook_link">Facebook Link</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="types[]" value="facebook_link">
                                            <input type="text" name="facebook_link" id="facebook_link"
                                                class="form-control"
                                                value="{{ old('facebook_link', app_setting('facebook_link')) }}"
                                                placeholder="https://www.facebook.com/xyz">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="col-sm-2 col-form-label" for="threads_link">Threads Link</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="types[]" value="threads_link">
                                            <input type="text" name="threads_link" id="threads_link"
                                                class="form-control"
                                                value="{{ old('threads_link', app_setting('threads_link')) }}"
                                                placeholder="https://www.twitter.com/xyz">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="col-sm-2 col-form-label" for="instagram_link">Instagram Link</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="types[]" value="instagram_link">
                                            <input type="text" name="instagram_link" id="instagram_link"
                                                class="form-control"
                                                value="{{ old('instagram_link', app_setting('instagram_link')) }}"
                                                placeholder="https://www.instagram.com/xyz">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="col-sm-2 col-form-label" for="tiktok_link">Tiktok Link</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="types[]" value="tiktok_link">
                                            <input type="text" name="tiktok_link" id="tiktok_link"
                                                class="form-control"
                                                value="{{ old('tiktok_link', app_setting('tiktok_link')) }}"
                                                placeholder="https://www.youtube.com/xyz">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-css')
    <style>
        hr {
            margin: 0.6rem 0 !important;
            color: inherit;
            border: 0;
            border-top: var(--tb-border-width) solid;
            opacity: .25;
        }
    </style>
@endsection
