@extends('frontend.layouts.app')
@section('title', 'Privacy Policy')
@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend') }}/assets/images/backgrounds/page-header-bg-1-1.png');">
        </div><!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title">Privacy Policy</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="icon-home text-white"></i> <a href="/">Home</a></li>
                <li><span class="text-white">Privacy Policy</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->
    <div class="container py-5">
        <h1 class="text-center">Privacy Policy</h1>
        <p class="text-center">Melbourne Building Products Pty Ltd <br> ABN: 75 682 871 003</p>
        <p class="text-center"><a href="http://www.melbournebuildingproducts.com.au/"
                target="_blank">www.melbournebuildingproducts.com.au</a></p>

        <h1>1. Introduction</h1>
        <p>Melbourne Building Products Pty Ltd ("we," "our," or "us") respects your privacy and is
            committed to protecting your personal information. This Privacy Policy explains how we
            collect, use, store, and protect your information in accordance with Australian privacy
            laws.</p>

        <h1 class="section-title">2. Information We Collect</h1>
        <p>When you visit our website, make an inquiry, or purchase a product, we may collect the
            following information:</p>
        <ul>
            <li><strong>Personal Information:</strong> Name, email address, phone number. </li>
            <li><strong>Product Inquiry & Purchase Information: </strong> Details of products you inquire about or
                purchase.</li>
        </ul>

        <h1 class="section-title">3. How We Use Your Information</h1>
        <p>We collect and use your personal information for the following purposes: </p>
        <ul>
            <li>To respond to your inquiries and provide customer support.</li>
            <li>To process and fulfill orders.</li>
            <li>To communicate important business updates, such as order confirmations or
                policy changes.</li>
            <li>To send promotional offers, discounts, and marketing materials related to our
                products.</li>
        </ul>

        <h1 class="section-title">4. Marketing Communications & Opt-Out</h1>
        <ul>
            <li>We may use your contact details to send information about promotions, offers, and
                business updates. </li>
            <li>If you do not wish to receive marketing communications, you may unsubscribe at
                any time by emailing us at <a
                    href="mailto:info@melbournebuildingproducts.com.au">info@melbournebuildingproducts.com.au</a> with
                "Unsubscribe" in the subject line. </li>
        </ul>

        <h1 class="section-title">5. Information Sharing & Disclosure</h1>
        <ul>
            <li>We <strong> do not</strong> sell, trade, or share your personal information with third parties. </li>
            <li>Your information may only be disclosed if required by law or requested by legal
                authorities.</li>
        </ul>

        <h1 class="section-title">6.Data Security</h1>
        <ul>
            <li>We take reasonable steps to ensure your personal information is stored securely
                and protected from unauthorized access, misuse, or disclosure. </li>
            <li>
                While we implement security measures, we cannot guarantee absolute security
                due to the nature of online communications.
            </li>
        </ul>

        <h1 class="section-title">7. Accessing & Updating Your Information</h1>
        <ul>
            <li>You may request access to or correction of your personal information by contacting
                us at <a href="mailto:info@melbournebuildingproducts.com.au">info@melbournebuildingproducts.com.au</a>.
            </li>
            <li>We will take reasonable steps to update or correct any inaccurate information upon
                request.</li>
        </ul>

        <h1 class="section-title">8. Cookies & Website Tracking</h1>
        <ul>
            <li>Our website may use cookies to enhance user experience and track website usage.</li>
            <li>You can disable cookies in your browser settings if you do not wish to allow this.</li>
        </ul>

        <h1 class="section-title">9. Changes to This Privacy Policy</h1>
        <ul>
            <li>We may update this Privacy Policy from time to time. Any changes will be posted on
                our website.</li>
            <li>Your continued use of our website constitutes acceptance of the updated Privacy
                Policy. </li>
        </ul>

        <div class="section-title">10. Contact Us</div>
        <p>For any questions regarding this Privacy Policy or your personal data, please contact us at:</p>

        <p><strong>Melbourne Building Products Pty Ltd</strong><br> <strong>Address:</strong> 1/11 Dazln Dr, Melton VIC
            3337<br><strong>Phone:</strong> <a
                href="tel:{{ $settings->where('key', 'contact_phone')->first()->value ?? 'N/A' }}">{{ $settings->where('key', 'contact_phone')->first()->value ?? 'N/A' }}</a><br><strong>Email:</strong>
            <a
                href="mailto:{{ $settings->where('key', 'contact_email')->first()->value ?? 'N/A' }}">{{ $settings->where('key', 'contact_email')->first()->value ?? 'N/A' }}</a>
        </p>
    </div>
@endsection
