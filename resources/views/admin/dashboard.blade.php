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
        <div class="col-xxl col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h4><span class="counter-value" data-target="368.24">368.24</span></h4>
                    <p class="text-muted mb-4">Total Product</p>
                </div>
                <div class="progress progress-sm rounded-0" role="progressbar" aria-valuenow="76" aria-valuemin="0"
                    aria-valuemax="100">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
            </div>
        </div><!--end col-->
        <div class="col-xxl col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h4><span class="counter-value">1,454.71</span> </h4>
                    <p class="text-muted mb-4">Total Brand</p>
                </div>
                <div class="progress progress-sm rounded-0" role="progressbar" aria-valuenow="88" aria-valuemin="0"
                    aria-valuemax="100">
                    <div class="progress-bar bg-secondary" style="width: 100%"></div>
                </div>
            </div>
        </div><!--end col-->
        <div class="col-xxl col-sm-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="avatar-sm float-end">
                        <div class="avatar-title bg-danger-subtle text-danger fs-3xl rounded">
                            <i class="bi bi-broadcast"></i>
                        </div>
                    </div>
                    <h4><span class="counter-value" data-target="33.37">33.37</span>%</h4>
                    <p class="text-muted mb-4">Unread Contact</p>
                </div>
                <div class="progress progress-sm rounded-0" role="progressbar" aria-valuenow="18" aria-valuemin="0"
                    aria-valuemax="100">
                    <div class="progress-bar bg-danger" style="width: 100%"></div>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection
