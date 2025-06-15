@extends('layouts.app')
@section('title', 'Reviews Details')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Reviews Details</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reviews Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Product Name:</h5>
                            <a href="{{ route('products.edit', $review->product->id) }}" target="_blank"
                               class="text-decoration-none">
                                <p>{{ $review->product->name }}</p>
                            </a>
                            <h5>Rating:</h5>
                            <p style="font-size: 1.5rem; margin: 0;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Customer Name:</h5>
                            <p>{{ $review->name }}</p>
                            {{-- Status --}}
                            <h5>Status:</h5>
                            <p>
                                @if($review->is_approved == 1)
                                    <span class="badge bg-success">Approved</span>
                                @elseif($review->is_approved == 0)
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Comment:</h5>
                            <p>{{ $review->comment }}</p>
                        </div>
                    </div>
                    @if($review->images)
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Images:</h5>
                                <div id="gallery-images" class="gallery-container">
                                    @php
                                        $images = $review->images->where('image_type', 'review-image');
                                    @endphp
                                    @foreach($images as $image)
                                        <a href="{{ asset($image->path) }}" data-lg-size="1280-720" class="lg-thumb">
                                            <img src="{{ asset($image->path) }}" alt="Review Image"
                                                 style="width: 100%; height: auto; max-width: 200px; margin-right: 10px; border-radius: 10px; border: 1px solid #ddd; padding: 5px; box-shadow: 0 0 10px rgba(0,0,0,.2); object-fit: cover; object-position: center;  max-height: 200px; overflow: hidden; margin-bottom: 10px;">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($review->videos)
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <h5>Videos:</h5>
                                <div id="video-gallery-{{$review->id}}"
                                     class="video-gallery-container d-flex gap-2 flex-wrap"
                                     style="min-width: 300px;">
                                    @php
                                        $thumbnails = $review->images->where('image_type', 'video-thumbnail')->values();
                                    @endphp

                                    @foreach ($review->videos as $key => $video)
                                        @php
                                            $thumbPath = isset($thumbnails[$key]) ? asset('storage/' .$thumbnails[$key]->path) : null;
                                            $videoPath = asset($video->url);
                                        @endphp

                                        <a href="{{$videoPath}}" class="glightbox" data-type="video"
                                           data-gallery="review-videos-{{$review->id}}"
                                           style="position: relative; display: inline-block;">
                                            @if ($thumbPath)
                                                <img src="{{$thumbPath}}"
                                                     style="width: 180px; height: 120px; object-fit: cover; object-position: center; margin-right: 10px; border-radius: 6px; border: 1px solid #ddd; padding: 5px; box-shadow: 0 0 10px rgba(0,0,0,.2);"
                                                     alt="Video Thumbnail">
                                                <span class="position-absolute top-50 start-50 translate-middle"
                                                      style="pointer-events: none;">
                                                    <i class="bi bi-play-circle-fill text-white" style="font-size: 2rem;"></i>
                                                </span>
                                            @else
                                                <div class="bg-dark d-flex align-items-center justify-content-center"
                                                     style="width: 100px; height: 60px;">
                                                    <i class="bi bi-play-circle-fill text-white"
                                                       style="font-size: 2rem;"></i>
                                                </div>
                                            @endif
                                            </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/video/lg-video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            GLightbox({selector: '.glightbox'});
        });
        lightGallery(document.getElementById('gallery-images'), {
            animateThumb: false,
            zoomFromOrigin: false,
            allowMediaOverlap: true,
            toggleThumb: true,
        });

        // on click open video on popup and play video 
        lightGallery(document.getElementById('gallery-videos'), {
            selector: 'a',
            videojs: true,
            plugins: [lgVideo],
            videoMaxWidth: '100%',
            videoMaxHeight: '100%',
            autoplayFirstVideo: true,
            download: false,
            zoomFromOrigin: false,
            allowMediaOverlap: true,
            toggleThumb: true,
        });

    </script>

@endsection

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css"/>
    <style>
        #gallery-videos a {
            position: relative;
            display: inline-block;
        }

        #gallery-videos i {
            position: absolute;
            font-size: 45px;
            color: white;
            z-index: 99;
            border: 3px solid red;
            left: calc(50% - 44px);
            top: calc(50% - 42px);
            width: 80px;
            text-align: center;
            border-radius: 10px;
        }
    </style>
@endsection