@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">CRM</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">CRM</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="card border-bottom border-3 card-animate border-primary">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{ $totalProducts }}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Products</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-bottom border-3 card-animate border-secondary">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{ $totalBrands }}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Brands</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-bottom border-3 card-animate border-info">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{ $totalCategories }}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Categories</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-bottom border-3 card-animate border-success">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{ $totalQueries }}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Product Inquires</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-bottom border-3 card-animate border-warning">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{ $totalPendingQueries }}</span>
                    </h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Pending Inquires</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-bottom border-3 card-animate border-danger">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{ $totalUnreadContact }}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Unread Messages</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card border-bottom border-3 card-animate border-warning">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{ $totalPendingReplay }}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Pending Replied</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 70px;">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pending Product Inquires</h4>
                </div>
                <div class="card-body">
                    <select id="filter" class="form-control">
                        <option value="1M" selected>Last 1 Month</option>
                        <option value="6M">Last 6 Months</option>
                        <option value="1Y">Last 1 Year</option>
                    </select>
                    <canvas id="queryChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pending Product Inquires</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap mb-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let ctx = document.getElementById("queryChart").getContext("2d");
            let filterDropdown = document.getElementById("filter");
            let myChart = null; // Store chart instance

            function loadChart(filter) {
                fetch("{{ route('get.chart.data') }}?filter=" + filter)
                    .then(response => response.json())
                    .then(data => {
                        let labels = data.map(item => item.day); // X-axis: Days
                        let values = data.map(item => item.total); // Y-axis: Total queries per day

                        // Destroy previous chart instance if it exists
                        if (myChart) {
                            myChart.destroy();
                        }

                        myChart = new Chart(ctx, {
                            type: "line",
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "Product Queries Per Day",
                                    data: values,
                                    backgroundColor: "rgba(52, 152, 219, 0.5)", // Light Blue
                                    borderColor: "#3498db", // Dark Blue
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.3
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: "Date"
                                        },
                                        ticks: {
                                            autoSkip: true,
                                            maxTicksLimit: 10
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: "Total Queries"
                                        },
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
            }

            // Load initial chart
            loadChart(filterDropdown.value);

            // Reload chart on filter change
            filterDropdown.addEventListener("change", function() {
                loadChart(this.value);
            });
        });



        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.dashboard') }}",
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
                        data: 'phone',
                        name: 'phone'
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
                pageLength: 5
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
            $.ajax({
                url: "{{ route('product.query', 'id') }}".replace('id', id),
                type: "GET",
                beforeSend: function() {
                    $('#modal .modal-body').html(
                        '<div class="text-center d-flex align-items-center justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                    );
                },
                success: function(response) {
                    $("#modalHeading").html("View Product Enquiry Details");
                    $("#modal").modal("show");
                    $("#modal .modal-body").html(response);
                },
                error: function(xhr) {
                    notify('error', "Failed to load the product enquiry view.");
                }
            })
        })
    </script>
@endsection
