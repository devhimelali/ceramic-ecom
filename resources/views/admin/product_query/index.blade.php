@extends('layouts.app')
@section('title', 'Product Queries')
@section('content')
    {{--  Start breadcrumb  --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Product Queries</h4>

                <div class="page-title-right">
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product Queries</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{--  End breadcrumb  --}}
    <div class="mb-5 row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 card-title">Product Query List</h1>
                </div>

                <div class="card-body">
                    <div class="mt-3 mb-1 table-responsive">
                        <table id="dataTable" class="table align-middle ">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th style="width: 210px">Actions</th>
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
    <!-- Default Modals -->

    <div id="statusModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="heading">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form action="#" method="post" id="statusModalForm">
                    <div class="modal-body">
                        <select name="status" id="product_status" class="form-select">
                            <option value="" selected disabled>Select Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}">{{ $status->description() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="updateStatusBtn">Update Status</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHeading">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>

                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="odal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHeading">Reply Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form action="#" method="post" id="contactReplyModalForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="contact_id" id="contact_id">
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" name="reply_message" id="message" rows="8"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="replyBtn">Send</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('product.queries') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'message',
                        name: 'message'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.status.value == 'pending') {
                        $(row).addClass('table-warning');
                    } else if (data.status.value == 'cancelled') {
                        $(row).addClass('table-danger');
                    }
                },
            });
        });

        $('body').on('click', '.change-status', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');
            $('#product_status').val(status);
            $('#statusModalForm').attr('action', "{{ route('product.query.status', 'id') }}".replace('id', id));
            $('#statusModal').modal('show');
        })

        $('#statusModalForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let actionUrl = $(this).attr('action');
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                beforeSend: function() {
                    $('#updateStatusBtn').prop('disabled', true);
                    $('#updateStatusBtn').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...'
                    );
                },
                success: function(response) {
                    $('#updateStatusBtn').prop('disabled', false);
                    $('#updateStatusBtn').html(
                        'Update Status'
                    );
                    if (response.status === "success") {
                        notify(response.status, response.message);
                        $('#statusModal').modal('hide');
                        $('#dataTable').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    $('#updateStatusBtn').prop('disabled', false);
                    $('#updateStatusBtn').html(
                        'Update Status'
                    );
                    notify('error', "Failed to update status.");
                }
            })
        })

        $('body').on('click', '.viewDetails', function() {
            var id = $(this).data('id');
            $("#modalHeading").html("View Product Enquiry Details");
            // change modal size
            $("#modal").addClass("modal-lg");
            $("#modal").modal("show");
            $.ajax({
                url: "{{ route('product.query', 'id') }}".replace('id', id),
                type: "GET",
                beforeSend: function() {
                    $('#modal .modal-body').html(
                        '<div class="text-center d-flex align-items-center justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                    );
                },
                success: function(response) {
                    $("#modal .modal-body").html(response);
                },
                error: function(xhr) {
                    notify('error', "Failed to load the product enquiry view.");
                }
            })
        })
    </script>
@endsection
