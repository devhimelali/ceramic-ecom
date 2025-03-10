@extends('frontend.layouts.app')
@section('title', 'Categories')
@section('page-style')
    <style>
        .pagination .page-item.active .page-link {
            background-color: var(--floens-base, #C7844F) !important;
            border-color: var(--floens-base, #C7844F) !important;
            color: #fff !important;
        }

        .pagination .page-link {
            color: #333;
            /* Default color */
        }
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend') }}/assets/images/backgrounds/page-header-bg-1-1.png');"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title">Our All Categories</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="text-white icon-home"></i> <a href="{{ route('frontend.home') }}">Home</a></li>
                <li><span class="text-white">Categories</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="work-page work-page--grid section-space-bottom">
        <div class="container">
            <div class="row gutter-y-30">
                @foreach ($categories as $category)
                    <div class="col-lg-3 col-md-4">
                        <div class="work-card">
                            <div class="work-card__image">
                                <img src="{{ $category->image ? asset($category->image) : asset('assets/placeholder-image-2.png') }}"
                                    alt="Modern Tiles fitting">
                            </div>
                            <div class="work-card__content-show">
                                <div class="work-card__content-inner">
                                    <h3 class="work-card__tagline">{{ $category->name }}</h3>
                                    <h3 class="work-card__title"><a
                                            href="{{ route('frontend.productsPage', ['category' => $category->slug]) }}"></a>
                                    </h3>
                                </div>
                            </div>
                            <div class="work-card__content-hover">
                                <div class="work-card__content-inner">
                                    <h3 class="work-card__tagline">{{ $category->name }}</h3>
                                    </h3>
                                </div>
                                <a href="{{ route('frontend.productsPage', ['category' => $category->slug]) }}"
                                    class="work-card__link floens-btn"><span class="icon-right-arrow"></span></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div><!-- /.row -->
            <div class="mt-5 ">
                <div class="mt-4 d-flex justify-content-center">
                    {{ $categories->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div><!-- /.container -->
    </section><!-- /.work-page section-space-bottom -->
@endsection
