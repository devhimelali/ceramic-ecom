@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    {{--  Start breadcrumb  --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Profiles</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    {{--  End breadcrumb  --}}

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile</h5>
                </div>
                <hr class="">
                <div class="card-body">
                    <div class="mx-auto text-center">
                        @if($user->profile_photo_path)
                            <img src="{{Auth::user()->profile_photo_url}}" class="rounded-circle" width="150" height="150" alt="{{$user->profile_photo_path}}">
                        @else
                            <img src="{{asset('syetemimages/user-icon.jpg')}}" class="rounded-circle" width="150" height="150" alt="">
                        @endif
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-responsive table-bordered">
                            <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-secondary">{{$role->name}}</span>
                                    @endforeach
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>Profile Information</h3>
                    <form action="{{route('user-profile-information.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3 mt-3">
                            <label for="image" class="form-label">Photo</label>
                            <img src="" alt="" id="imagePreview">
                            <input type="file" name="photo" class="form-control" id="image" accept='image/*' onchange="showImage()">
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{$user->name}}" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{$user->email}}" class="form-control">
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>Change Password</h3>
                    <form action="{{route('user-password.update')}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3 mt-3">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" class="form-control @if($errors->has('current_password')) is-invalid @endif" autocomplete="current-password">
                            @if($errors->has('current_password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('current_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" autocomplete="new-password">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-css')
    <style>
        img#imagePreview {
            width: 100%;
            max-width: 200px;
            border: 1px solid #ccc;
            box-shadow: 0px 3px 8px #ccc;
            border-radius: 5px;
            padding: 4px;
            display: none;
            margin: 6px 0;
        }
        img#imagePreview.show {
            display: block;
        }
    </style>
@endsection
@section('page-script')
    <script>
        const imageUploader = document.getElementById("image");
        const imagePreview = document.getElementById("imagePreview");

        function showImage() {
            let reader = new FileReader();
            reader.readAsDataURL(imageUploader.files[0]);
            reader.onload = function(e) {
                imagePreview.classList.add("show");
                imagePreview.src = e.target.result;
            };
        }
    </script>
@endsection
