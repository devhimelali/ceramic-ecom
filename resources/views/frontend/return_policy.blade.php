@extends('frontend.layouts.app')
@section('title', 'Privacy Policy')
@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend') }}/assets/images/backgrounds/page-header-bg-1-1.png');">
        </div><!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title">Return Policy</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="text-white icon-home"></i> <a href="/">Home</a></li>
                <li><span class="text-white">Return Policy</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->
    <div class="container py-5">
        <h1 class="text-center">Return Policy</h1>
        <p class="text-center">Melbourne Building Products Pty Ltd <br> ABN: 75 682 871 003</p>
        <p class="text-center"><a href="http://www.melbournebuildingproducts.com.au/"
                target="_blank">www.melbournebuildingproducts.com.au</a></p>

        <h1>1. Introduction</h1>
        <p>Items purchased in-store or online must be returned within 7 days in the event of a fault.
        </p>
        <p>A proof of purchase is required for all returns.
        </p>
        <ul>
            <li>Customers may be asked to provide photos or videos of the fault to assist with the return process.
            </li>
            <li>
                If your order included free shipping the actual delivery cost will be deducted from your refund, along with
                any return shipping fees if we arrange the return.
            </li>
            <li>
                No refunds will be issued for change of mind.
            </li>
        </ul>

        <h1 class="section-title">2. Return Guidelines:</h1>
        <p><strong>Original Packaging:</strong> The product must be returned in its original packaging, which should be in
            good condition. If
            the item requires assembly, please disassemble it and place it back in the original packaging.
        </p>
        <p><strong>Checking Features:</strong> If you need to inspect a colour or feature, please do so without assembling
            the item.
        </p>
        <h1 class="section-title">3. How to Return Your Item</h1>
        <ul>
            <li>Request a Return Authorisation
                Contact us at <a href="mailto:melbournebuildingproducts@gmail.com">melbournebuildingproducts@gmail.com</a>
                within 10 days of receiving your item. Please include clear photos of the product in its original packaging.
            </li>
            <li>
                Receive Your RA Number
                Once your request is approved, we’ll issue a Return Authorisation (RA) number along with instructions for
                returning your item. This helps ensure smooth tracking and processing.
            </li>
            <li>Fast Refund Processing
                After we receive and inspect the returned item, your refund will be processed—typically within 7 business
                days.
            </li>
        </ul>

        <h1 class="section-title">4. Important Note:</h1>
        <p>Due to health and hygiene reasons, mattresses, rugs, and bed sheets can only be returned if they remain unopened
            and in their original sealed packaging.</p>
    </div>
@endsection
