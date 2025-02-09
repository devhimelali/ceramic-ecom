@extends('layouts.app')
@section('title', 'Contacts')
@section('content')
    {{--  Start breadcrumb  --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Contacts</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Contacts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{--  End breadcrumb  --}}
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title mb-0">Contact List</h1>
                </div>

                <div class="card-body">
                    <div class="table-responsive mt-3 mb-1">
                        <table id="dataTable" class="table align-middle ">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Created At</th>
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

    <div id="modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHeading">Modal Heading</h5>
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
    <div id="contactReplyModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
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
                ajax: "{{ route('contacts.index') }}",
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
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.is_read == 0) {
                        $(row).addClass('table-warning');
                    } else if (data.is_replied == 0) {
                        $(row).addClass('table-danger');
                    }
                },
            });
        });

        $('body').on('click', '.viewDetails', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('contacts.show', 'id') }}".replace('id', id),
                type: "GET",
                beforeSend: function() {
                    $('#modal .modal-body').html(
                        '<div class="text-center d-flex align-items-center justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                    );
                },
                success: function(response) {
                    $("#modalHeading").html("View Contact Details");
                    $("#modal").modal("show");
                    $("#modal .modal-body").html(response);
                    $('#dataTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    notify('error', "Failed to load the contact view form.");
                }
            })
        })

        $('body').on('click', '.replyBtn', function() {
            var id = $(this).data('id');
            var url = "{{ route('contact.reply', 'id') }}".replace('id', id);
            $('#contactReplyModal form').attr('action', url);
            $('#contact_id').val(id);
            $('#contactReplyModal').modal('show');
        })

        $('#contactReplyModalForm').on('submit', function(e) {
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
                    $('#replyBtn').prop('disabled', true);
                    $('#replyBtn').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                    );
                },
                success: function(response) {
                    $('#replyBtn').prop('disabled', false);
                    $('#replyBtn').html(
                        'Send'
                    );
                    if (response.status === "success") {
                        notify(response.status, response.message);
                        $('#contactReplyModal').modal('hide');
                        $('#dataTable').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    $('#replyBtn').prop('disabled', false);
                    $('#replyBtn').html(
                        'Send'
                    );
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            let inputField = $('[name="' + key + '"]');
                            inputField.addClass('is-invalid');
                            notify('error', value[0]);
                        });
                    }
                }
            })
        })
    </script>
@endsection
