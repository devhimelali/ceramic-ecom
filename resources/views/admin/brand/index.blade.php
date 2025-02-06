@extends('layouts.app')
@section('title', 'Brands')
@section('content')
    {{--  Start breadcrumb  --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Brands</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Brands</li>
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
                    <div class="ms-auto">
                        <a href="#" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-plus-circle align-baseline me-1"></i> Add Brand
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive mt-3 mb-1">
                        <table id="dataTable" class="table align-middle ">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th style="width: 140px">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--end card-->
        </div><!--end col-->
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">Create Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('brands.store') }}" class="dynamic-form" method="POST" id="addForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-xl-7">
                                <div class="my-3">
                                    <div>
                                        <label for="name" class="form-label">Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Enter Category Name">
                                    </div>
                                </div>
                                <div class="my-3 d-none slugWrapper">
                                    <div>
                                        <label for="slug" class="form-label">Slug <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="slug" name="slug" class="form-control"
                                            placeholder="Enter category slug" value="{{ old('slug') }}">
                                    </div>
                                </div>
                                <div class="my-3">
                                    <div>
                                        <label for="status" class="form-label">Status<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" name="status" id="brandStatus">
                                            <option selected value="">Select Status</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->value }}">{{ $status->description() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="my-3">
                                    <div>
                                        <label for="description" class="form-label">Description<span
                                                class="text-danger">*</span></label>
                                        <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-xxl-5 pt-4">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-center">
                                        <div class="image-container" id="imagePreview">
                                            <img src="{{ asset('assets/placeholder-image.webp') }}" class="previewImg"
                                                alt="Image Preview">
                                            <button type="button" class="remove-btn" id="removeImage"
                                                style="display:none;">&times;</button>
                                        </div>
                                        <input type="file" name="image" id="imageUpload" class="d-none"
                                            accept="image/*">
                                        <label for="imageUpload" class="upload-label d-block mt-3">Choose a Category
                                            Image</label>
                                    </div>
                                </div>
                            </div> --}}



                            <div class="col-xxl-5 pt-4">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-center">
                                        <div class="custom-upload-box">
                                            <img src="{{ asset('assets/placeholder-image-2.png') }}" class="preview-img"
                                                alt="Image Preview">
                                            <button type="button" class="remove-btn removeImage"
                                                style="display:none;">&times;</button>
                                        </div>
                                        <input type="file" name="image" class="d-none hidden-input" accept="image/*">

                                        <button type="button" class="btn btn-dark mt-1 px-4"
                                            onclick="setupImagePreview('.hidden-input', '.preview-img')"><i
                                                class="bx bx-cloud-upload fs-3"></i> Choose a
                                            Category</button>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary btn-load submit-btn">
                                        <span class="submit-text">Submit</span>
                                        <span class="d-flex align-items-center d-none loader">
                                            <span class="flex-grow-1 me-2">
                                                Submitting...
                                            </span>
                                            <span class="spinner-grow flex-shrink-0" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editModalContent">
                    <!-- The AJAX response (edit form) will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/cdn/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/cdn/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('brands.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $("#addForm").on("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let submitButton = $(".submit-btn");
                let submitText = $(".submit-text");
                let loader = $(".loader");

                submitText.addClass("d-none");
                loader.removeClass("d-none");
                submitButton.prop("disabled", true);

                $.ajax({
                    url: "{{ route('brands.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            notify(response.status, response.message);
                            $("#addForm")[0].reset();
                            $(".previewImg").attr("src",
                                "{{ asset('assets/placeholder-image.webp') }}");

                            if ($.fn.DataTable.isDataTable("#dataTable")) {
                                $("#dataTable").DataTable().ajax.reload();
                            }

                            submitText.removeClass("d-none");
                            loader.addClass("d-none");
                            submitButton.prop("disabled", false);
                            $('#addModal').modal('hide');
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $(".text-danger").remove();
                        if (errors) {
                            $.each(errors, function(key, value) {
                                let inputField = $('[name="' + key + '"]');
                                inputField.after('<small class="text-danger">' + value[
                                    0] + '</small>');
                                notify('error', value[0]);
                            });
                        }
                    },
                    complete: function() {
                        submitText.removeClass("d-none");
                        loader.addClass("d-none");
                        submitButton.prop("disabled", false);
                    }
                });
            });
        });

        function editCategory(slug) {
            $.ajax({
                url: "{{ route('brands.edit', 'slug') }}".replace('slug',
                    slug),
                type: "GET",
                success: function(response) {
                    $("#editModalContent").html(response); // Load the response (view) into modal
                    $("#editModal").modal("show"); // Show the modal
                },
                error: function(xhr) {
                    notify('error', "Failed to load the brand edit form.");
                }
            });
        }

        function confirmDelete(slug, deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to undo this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteCategory(slug, deleteUrl);
                }
            });
        }

        function deleteCategory(slug, deleteUrl) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Deleted!', 'The category has been deleted.', 'success');
                        $('#dataTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Error!', 'There was a problem deleting the category.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'There was a problem with the request.', 'error');
                }
            });
        }
    </script>

    <script>
        function setupImagePreview(inputSelector, previewSelector) {
            // inputSelector means which input field to listen to
            // previewSelector means which image to change
            $(inputSelector).click();
            $(inputSelector).change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(previewSelector).attr("src", e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    </script>
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/cdn/datatables/dataTables.bootstrap5.min.css') }}">
    <style>
        .custom-upload-box {
            width: 200px;
            height: 200px;
            border: 2px dashed #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin: auto;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .custom-upload-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .custom-upload-box:hover {
            border-color: #aaa;
        }

        .hidden-input {
            display: none;
        }

        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 14px;
            display: none;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
