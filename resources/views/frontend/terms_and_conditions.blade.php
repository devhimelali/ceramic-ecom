@extends('frontend.layouts.app')
@section('title', 'Terms & Conditions')
@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend') }}/assets/images/backgrounds/page-header-bg-1-1.png');">
        </div><!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title">Terms and Conditions</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="text-white icon-home"></i> <a href="/">Home</a></li>
                <li><span class="text-white">Terms and Conditions</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->
    <div class="container py-5">
        <h1 class="text-center">Website Terms and Conditions</h1>
        <p class="text-center">Melbourne Building Products Pty Ltd <br> ABN: 75 682 871 003</p>
        <p class="text-center"><a href="http://www.melbournebuildingproducts.com.au/"
                target="_blank">www.melbournebuildingproducts.com.au</a></p>

        <h2>1. Acceptance of Terms</h2>
        <p>By accessing and using this website, you agree to comply with and be bound by these
            Terms and Conditions. If you do not agree to these terms, please refrain from using the
            website. </p>

        <h2>2. Business Information</h2>
        <p>Melbourne Building Products Pty Ltd ("we," "our," or "us") operates this website for
            customers to browse building products and make inquiries. Purchases are completed
            either in-store at 1/11 Dazln Dr, Melton VIC 3337 or through direct communication, with
            payment required before shipment.</p>

        <h2>3. Product Inquiries & Purchases</h2>
        <p>Customers may inquire about products via the website or by calling our business. Once
            inquiries are received, we will discuss customer requirements, provide information, and
            issue an invoice if a purchase is confirmed. </p>
        <ul>
            <li>Products can be purchased in-store or shipped to the customer after full payment
                of the issued invoice. </li>
            <li>Prices, availability, and specifications of products are subject to change without
                notice. </li>
            <li>We reserve the right to refuse service, cancel orders, or limit quantities at our
                discretion. </li>
        </ul>

        <h2>4. Payment & Shipping</h2>
        <ul>
            <li>All invoices must be paid in full before any product is shipped. </li>
            <li>Payment methods accepted will be outlined in the invoice.</li>
            <li>Shipping costs, timelines, and responsibilities will be communicated to the
                customer before confirming the order.</li>
            <li>We are not liable for delays or damages caused by third-party shipping providers. </li>
        </ul>

        <h2>5. Warranty & Returns</h2>
        <ul>
            <li>All products sold come with general warranty terms as applicable under Australian
                Consumer Law.</li>
            <li>Any claims for defective or damaged goods must be made within a reasonable time
                after delivery or purchase. </li>
            <li>Returns, exchanges, and refunds are subject to our internal policies, which will be
                provided upon request. </li>
        </ul>

        <h2>6. Limitation of Liability</h2>
        <ul>
            <li>We strive to ensure that product descriptions, images, and details on our website
                are accurate; however, we do not guarantee that all content is error-free or up-to
                date.</li>
            <li>We are not liable for any direct, indirect, incidental, or consequential damages
                resulting from the use or inability to use our website or products.</li>
        </ul>

        <h2>7. Intellectual Property</h2>
        <ul>
            <li>All content, including logos, images, text, and graphics on this website, is the
                property of Melbourne Building Products Pty Ltd and is protected by copyright laws. </li>
            <li>Unauthorized use, reproduction, or distribution of any website content is
                prohibited. </li>
        </ul>

        <h2>8. Privacy Policy</h2>
        <ul>
            <li>We collect and store customer information for order processing and business
                communication purposes only.</li>
            <li>
                Personal information will not be shared with third parties without customer
                consent, except as required by law.
            </li>
        </ul>

        <h2>9. Governing Law</h2>
        <p>These Terms and Conditions are governed by the laws of <strong>Victoria, Australia.</strong> Any disputes
            arising from the use of this website shall be resolved in the appropriate courts of Victoria. </p>

        <h2>10. Changes to Terms</h2>
        <p>We reserve the right to update or modify these Terms and Conditions at any time. Changes
            will be effective upon posting on the website. Your continued use of the website
            constitutes acceptance of the updated terms.</p>

        <p><strong>For inquiries:</strong></p>
        <p class="mb-0">
            <strong>Melbourne Building Products Pty Ltd</strong>
        </p>
        <p class="mb-0">
            <strong>Address:</strong> 1/11 Dazln Dr, Melton VIC 3337
        </p>
        <p class="mb-0">
            <strong>Phone:</strong> <a
                href="tel:{{ $settings->where('key', 'contact_phone')->first()->value ?? 'N/A' }}">{{ $settings->where('key', 'contact_phone')->first()->value ?? 'N/A' }}</a>
        </p>
        <p class="mb-0">
            <strong>Email:</strong>
            <a
                href="mailto:{{ $settings->where('key', 'contact_email')->first()->value ?? 'N/A' }}">{{ $settings->where('key', 'contact_email')->first()->value ?? 'N/A' }}</a>
        </p>
    </div>
@endsection
