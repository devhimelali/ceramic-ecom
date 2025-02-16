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
        <div class="col-sm-2">
            <div class="card border-bottom border-3 card-animate border-primary">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{$totalProducts}}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Products</p>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card border-bottom border-3 card-animate border-secondary">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{$totalBrands}}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Brands</p>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card border-bottom border-3 card-animate border-info">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{$totalCategories}}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Categories</p>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card border-bottom border-3 card-animate border-success">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{$totalQueries}}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Product Inquires</p>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card border-bottom border-3 card-animate border-warning">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{$totalPendingQueries}}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Pending Inquires</p>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card border-bottom border-3 card-animate border-danger">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{$totalUnreadContact}}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Unread Messages</p>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card border-bottom border-3 card-animate border-warning">
                <div class="card-body text-center">
                    <h4 class="mb-4"><span class="counter-value" data-target="21438">{{$totalPendingReplay}}</span></h4>
                    <p class="text-muted fw-medium text-uppercase mb-0">Total Pending Replied</p>
                </div>
            </div>
        </div>
    </div>
@endsection
