@extends('layouts.app')
@section('title', 'Marketing Tool')
@section('content')
    {{--  Start breadcrumb  --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Marketing Tool</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Marketing Tool</li>
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
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="card-title mb-0">Contact List</h1>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                                <a href="javascript:void(0)" class="btn btn-primary" id="sendToAll">Send To All</a>
                                <a href="javascript:void(0)" class="btn btn-secondary" id="sendToSelected">Send To
                                    Selected</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive mt-3 mb-1">
                        <table id="dataTable" class="table align-middle ">
                            <thead class="table-light">
                                <tr>
                                    <th style="max-width: 130px !important; width: 100%">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                            <label for="selectAll"class="fw-bold ms-2">Select All</label>
                                        </div>

                                    </th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th style="width: 80px">Actions</th>
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
    <div id="sendModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHeading">Send SMS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form id="sendModalForm" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control mb-2" name="message" id="message" rows="8"></textarea>
                            <span class="text-danger">{customer_name}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="sendBtn">Send</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('page-css')
    <style>
        .form-check-input[type=checkbox] {
            border-radius: .25em;
            width: 20px;
            height: 20px;
            border: 1px solid #ddd;
            margin-top: 0px;
        }
    </style>
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('marketing.index') }}",
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        $('#selectAll').on('change', function() {
            $('.job-checkbox').prop('checked', $(this).prop('checked'));
        });

        $('#sendToAll').on('click', function() {
            $('#sendModalForm').attr('action', "{{ route('send.sms.all.users') }}");
            $('#sendModal').modal('show');
        });

        $('#sendToSelected').on('click', function() {
            var ids = [];
            $('.job-checkbox:checked').each(function() {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                notify('error', 'Please select at least one user');
            } else {
                $('#sendModalForm').attr('action', "{{ route('send.sms.selected.users') }}");
                $('#sendModalForm').append('<input type="hidden" name="ids" value="' + ids.join(',') + '">');
                $('#sendModal').modal('show');
            }
        });

        $('body').on('click', '.sendSms', function() {
            var id = $(this).data('id');
            $('#sendModalForm').attr('action', "{{ route('send.sms.selected.users') }}");
            $('#sendModalForm').append('<input type="hidden" name="ids" value="' + id + '">');
            $('#sendModal').modal('show');
        });

        $('.sendSms').on('click', function() {
            console.log("click");
            // var id = $(this).data('id');
            // $('#sendModalForm').attr('action', "{{ route('send.sms.selected.users') }}");
            // $('#sendModalForm').append('<input type="hidden" name="ids" value="' + id.join(',') + '">');
            // $('#sendModal').modal('show');
        })

        $('#sendModal').on('hidden.bs.modal', function() {
            $('#sendModalForm')[0].reset();
            $('#sendModalForm .modal-body').html(`<div class="mb-3">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control mb-2" name="message" id="message" rows="8"></textarea>
                            <span class="text-danger">{customer_name}</span>
                        </div>`);
            $('#sendModalForm').attr('action', "");
        })

        $('#sendBtn').on('click', function() {
            var form = $('#sendModalForm');
            var actionUrl = form.attr('action');
            var formData = form.serialize();

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#sendBtn').prop('disabled', true);
                    $('#sendBtn').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                    );
                },
                success: function(response) {
                    if (response.status == 'success') {
                        notify(response.status, response.message);
                        $('#sendModal').modal('hide');
                        $('#dataTable').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            notify('error', value[0]);
                        });
                    }
                },
                complete: function() {
                    $('#sendBtn').prop('disabled', false);
                    $('#sendBtn').html(
                        'Send'
                    );
                }
            });
        });
    </script>
@endsection
