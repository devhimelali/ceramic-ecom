<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Image-Based Slider</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <style>
        .swiper-slide img {
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            border-radius: 15px;
        }

        .thumb-img {
            height: 60px;
            border-radius: 10px;
            opacity: 0.6;
            cursor: pointer;
        }

        .swiper-slide-thumb-active .thumb-img {
            border: 2px solid #007bff;
            opacity: 1;
        }

        .thumbs-wrapper {
            margin-top: 10px;
        }

        .person-button {
            text-align: left;
        }
    </style>
</head>

<body class="bg-light p-4">

    @php
        $images = [
            ['id' => 10, 'path' => 'https://i.pravatar.cc/500?id=1'],
            ['id' => 11, 'path' => 'https://i.pravatar.cc/500?id=2'],
            ['id' => 12, 'path' => 'https://i.pravatar.cc/500?id=3'],
            ['id' => 13, 'path' => 'https://i.pravatar.cc/500?id=4'],
            ['id' => 14, 'path' => 'https://i.pravatar.cc/500?id=5'],
            ['id' => 15, 'path' => 'https://i.pravatar.cc/500?id=6'],
            ['id' => 16, 'path' => 'https://i.pravatar.cc/500?id=6'],
            ['id' => 17, 'path' => 'https://i.pravatar.cc/500?id=7'],
        ];

        $person = [
            ['name' => 'Alice', 'img' => 1],
            ['name' => 'Bob', 'img' => 4],
            ['name' => 'Charlie', 'img' => 3],
            ['name' => 'Ethan', 'img' => 2],
            ['name' => 'Ethan', 'img' => 4],
            ['name' => 'Ethan', 'img' => 4],
        ];

        // Build map of imageId (from ?id=N) => image index
        $imageIdToIndex = [];
        foreach ($images as $index => $image) {
            $urlParts = parse_url($image['path']);
            parse_str($urlParts['query'], $queryParams);
            if (isset($queryParams['id'])) {
                $imageIdToIndex[$queryParams['id']] = $index;
            }
        }

        // Unique person name => index in image slider
        $personIndexMap = [];
        foreach ($person as $entry) {
            $name = $entry['name'];
            $imgId = $entry['img'];
            if (!isset($personIndexMap[$name]) && isset($imageIdToIndex[$imgId])) {
                $personIndexMap[$name] = $imageIdToIndex[$imgId];
            }
        }
    @endphp

    <div class="container">
        <div class="row">
            <!-- Slider Section -->
            <div class="col-md-8">
                <div class="swiper swiper-main mb-3">
                    <div class="swiper-wrapper">
                        @foreach ($images as $image)
                            <div class="swiper-slide text-center">
                                <img src="{{ $image['path'] }}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="swiper swiper-thumbs thumbs-wrapper">
                    <div class="swiper-wrapper">
                        @foreach ($images as $image)
                            <div class="swiper-slide text-center" style="width: 60px;">
                                <img src="{{ $image['path'] }}" class="thumb-img" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Person Buttons -->
            <div class="col-md-4">
                <h5>Select Person</h5>
                <div class="d-grid gap-2">
                    @foreach ($personIndexMap as $name => $slideIndex)
                        <button class="btn btn-outline-primary person-button"
                            onclick="mainSwiper.slideToLoop({{ $slideIndex }})">
                            {{ $name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        const thumbSwiper = new Swiper(".swiper-thumbs", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });

        const mainSwiper = new Swiper(".swiper-main", {
            loop: true,
            spaceBetween: 10,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            thumbs: {
                swiper: thumbSwiper,
            }
        });
    </script>

</body>

</html>
