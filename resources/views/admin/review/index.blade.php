@extends('layouts.app')
@section('title', 'Manage Product Reviews')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Manage Product Reviews</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Product Reviews</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product Reviews</h3>
                </div>
                <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 200px !important; max-width: 200px !important;">Product</th>
                            <th style="width: 200px !important; max-width: 200px !important;">Customer</th>
                            <th style="width: 60px !important; max-width: 60px !important;">Rating</th>
                            <th style="width: 200px !important; max-width: 200px !important;">Comment</th>
                            <th>Images</th>
                            <th style="width: 160px !important; max-width: 160px !important;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;"
         aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                </div>

                <form class="tablelist-form" action="" method="POST" id="deleteForm">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-body p-4">
                        <p id="deleteMessage">Are you sure you want to delete this review?</p>
                    </div>
                    <div class="modal-footer" style="display: block;">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal"><i
                                        class="bi bi-x-lg align-baseline me-1"></i> Close
                            </button>
                            <button type="submit" class="btn btn-danger" id="deleteBtn">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- modal-content -->
        </div>
        <!-- modal-dialog -->
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/cdn/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/cdn/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('reviews.index') }}",
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false
                },
                    {
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'rating',
                        name: 'rating'
                    },
                    {
                        data: 'comment',
                        name: 'comment',
                    },
                    {
                        data: 'images',
                        name: 'images'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('body').on('click', '.approvedBtn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('reviews.approve', ':id') }}".replace(':id', id),
                    method: "GET",
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            notify('success', response.message);
                            table.ajax.reload();
                        }
                    },
                    complete: function () {
                        $('#loader').hide();
                    }
                });
            });

            // Delete asset
            $('body').on('click', '.delete-item-btn', function() {
                let id = $(this).data('id');
                let type = $(this).data('type');
                let deleteUrl = "{{ route('reviews.destroy', ':id') }}".replace(':id', id);
                $('#deleteForm').attr('action', deleteUrl);
                $('#deleteModal').modal('show');
            });

            // Handle form submission
            $('#deleteForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        $('#deleteBtn').prop('disabled', true);
                        $('#deleteBtn').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
                        );
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        table.ajax.reload();
                        notify('success', response.message);
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            notify('error', value);
                        });
                    },
                    complete: function() {
                        $('#deleteBtn').prop('disabled', false);
                        $('#deleteBtn').html('Delete');
                    }
                });
            });
        });
    </script>
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/cdn/datatables/dataTables.bootstrap5.min.css') }}">
@endsection