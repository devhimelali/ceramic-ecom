@extends('layouts.app')
@section('title', 'Brands')
@section('content')
    {{--  Start breadcrumb  --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Attributes Value For <a href="{{ route('attributes.index') }}"><span
                            class="text-primary">{{ $attribute->name }}</span></a></h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Attributes Value</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    {{--  End breadcrumb  --}}

    <div class="row mb-5">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3 mb-1">
                        <table id="dataTable" class="table align-middle ">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Value</th>
                                    <th>Status</th>
                                    <th style="width: 40px">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--end card-->
        </div><!--end col-->
        <div class="col-lg-4">
            <div id="attributeLoader" class="skeleton-placeholder" style="display: none;">
                <div class="skeleton skeleton-text"></div>
                <div class="skeleton skeleton-text"></div>
                <div class="skeleton skeleton-text"></div>
                <div class="skeleton skeleton-text"></div>
                <div class="skeleton skeleton-box"></div>
            </div>
            <div id='addAttribute'>
                @include('admin.attribute-value.add')
            </div>
            <div id='editAttribute'></div>
        </div><!--end col-->

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
                ajax: "{{ route('attribute-values.index', ['attribute_id' => Request::get('attribute_id')]) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false
                    },
                    {
                        data: 'value',
                        name: 'value'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                let addUrl = $(this).attr('action');
                $.ajax({
                    url: addUrl,
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

        function editAttribute(id) {
            $("#attributeLoader").show();
            $("#addAttribute").addClass('d-none');
            $("#editAttribute").addClass('d-none');

            $.ajax({
                url: "{{ route('attribute-values.edit', 'id') }}".replace('id', id),
                type: "GET",
                success: function(response) {
                    $("#attributeLoader").hide(); // Hide the spinner
                    $("#editAttribute").html(response); // Load the response (view) into modal
                    $("#editAttribute").removeClass('d-none');
                },
                error: function(xhr) {
                    $("#attributeLoader").hide();
                    $("#addAttribute").removeClass('d-none');
                    $("#editAttribute").html('');
                    notify('error', "Failed to load the attribute edit form.");
                }
            });
        }

        function closeEditForm() {
            setTimeout(function() {
                $("#attributeLoader").hide(); // Hide the loader after delay
                $("#addAttribute").removeClass('d-none'); // Show the add form again
            }, 500); // 500ms delay (adjust as needed)
            $("#attributeLoader").show(); // Show the loader
            $("#editAttribute").html(''); // Clear the edit form

        }

        function changeStatus(url) {
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status === 'success') {
                        notify('success', response.message);
                    } else {
                        notify('error', 'Failed to update status.');
                    }
                    $('#dataTable').DataTable().ajax.reload();
                },
                error: function() {
                    $('#dataTable').DataTable().ajax.reload();
                    notify('error', 'Something went wrong.');
                }
            });
        }


        function confirmDelete(deleteUrl) {
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
                    deleteCategory(deleteUrl);
                }
            });
        }

        function deleteCategory(deleteUrl) {
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
                    closeEditForm();
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
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 5px;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .skeleton-text {
            width: 100%;
            height: 15px;
            margin-bottom: 10px;
        }

        .skeleton-box {
            width: 100%;
            height: 150px;
            margin-bottom: 10px;
        }
    </style>
@endsection
