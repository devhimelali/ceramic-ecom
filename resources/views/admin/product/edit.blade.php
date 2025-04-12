@php
    use App\Helpers\ImageUploadHelper;
@endphp
@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
    {{--  Start breadcrumb  --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Product</h4>

                <div class="page-title-right">
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{--  End breadcrumb  --}}
    <div class="mb-5 row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Update Product Details</h4>
                    <div class="ms-auto">
                        <a href="{{ route('products.index') }}" class="btn btn-danger add-btn">
                            <i class="align-baseline bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data"
                        id="addForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name" value="{{ $product->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="price" name="price"
                                        placeholder="Price" value="{{ $product->price }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-control select2" data-choice id="category" name="category"
                                        required>
                                        <option value="" selected disabled>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option {{ $category->id == $product->category_id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="brand" class="form-label">Brand</label>
                                    <select class="form-control select2" data-choice id="brand" name="brand">
                                        <option value="" selected disabled>Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option {{ $brand->id == $product->brand_id ? 'selected' : '' }}
                                                value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="short_description" name="short_description" rows="4">{{ $product->short_description }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control ckeditor-classic" id="description" name="description" rows="4">{{ $product->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control select2" id="productStatus" name="status" required>
                                        <option value="" selected disabled>Select Status</option>
                                        @foreach ($statuses as $status)
                                            <option {{ $status->value == $product->status->value ? 'selected' : '' }}
                                                value="{{ $status->value }}">{{ $status->description() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="pt-1 mt-4 mb-3 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary addVariation"> <i class="bx bx-plus"></i>
                                        Add Variation</button>
                                </div>
                            </div>
                            <div class="col-lg-12 variationContainer">
                                @foreach ($product->attributes as $key => $attribute)
                                    <div class="row" data-id="variation_{{ $key }}">
                                        <div class="col-lg-5">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Variation Name</label>
                                                <select class="form-control select2 variationName" data-choice
                                                    id="variation_name" name="variation_names[]" required>
                                                    <option value="" selected disabled>Select Variation Name</option>
                                                    @foreach ($attributes as $variation)
                                                        <option
                                                            {{ $variation->id == $attribute->pivot->attribute_id ? 'selected' : '' }}
                                                            value="{{ $variation->id }}">{{ $variation->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Variation Value</label>
                                                <select class="form-control select2" data-choice id="variation_value"
                                                    name="variation_values[]" required>
                                                    <option value="" selected disabled>Select Variation Value
                                                    </option>
                                                    @foreach ($attribute->values as $value)
                                                        <option
                                                            {{ $value->id == $attribute->pivot->attribute_value_id ? 'selected' : '' }}
                                                            value="{{ $value->id }}">{{ $value->value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="pt-1 mt-4 mb-3 ms-2">
                                                <button type="button" class="btn btn-danger removeVariation"> <i
                                                        class="bx bx-minus"></i> Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="pt-4 col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="text-center">
                                        <div class="custom-upload-box">
                                            @php
                                                $thumbnailImage = $product->images->where('type', 'thumbnail')->first();
                                            @endphp
                                            <img src="{{ $thumbnailImage ? ImageUploadHelper::getProductImageUrl($thumbnailImage->image, 'products', 'thumbnail') : asset('frontend/assets/images/product-placeholder.png') }}"
                                                class="preview-img" alt="Image Preview">

                                            <button type="button" class="remove-btn removeImage"
                                                style="display:none;">&times;</button>
                                        </div>
                                        <input type="file" name="image" class="d-none hidden-input"
                                            accept="image/*">

                                        <button type="button" class="px-4 mt-1 btn btn-dark"
                                            onclick="setupImagePreview('.hidden-input', '.preview-img')"><i
                                                class="bx bx-cloud-upload fs-3"></i>Thumbnail Image</button>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 col-md-9">
                                <div id="dropZone" class="drop-zone">
                                    Drag & Drop Images Here or Click to Select
                                    <input type="file" id="imageInput" name="images[]" class="form-control d-none"
                                        accept="image/*" multiple>
                                </div>

                                <div class="image-preview" id="imagePreview">
                                    @foreach ($product->images->where('type', 'gallery') as $image)
                                        <div class="preview-container">
                                            <img
                                                src="{{ ImageUploadHelper::getProductImageUrl($image->image, 'products', 'thumbnail') }}">
                                            <button type="button" class="deleteProductImage"
                                                data-image-id="{{ $image->id }}"
                                                data-product-id="{{ $product->id }}">×</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-4 col-lg-12">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end card-->
        </div><!--end col-->
    </div>
@endsection
@section('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .custom-upload-box {
            width: 200px;
            height: 200px;
            border: 2px dashed #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin: auto;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .custom-upload-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .custom-upload-box:hover {
            border-color: #aaa;
        }

        .hidden-input {
            display: none;
        }

        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 14px;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .drop-zone {
            border: 2px dashed #007bff;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            border-radius: 10px;
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
            height: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .image-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .preview-container {
            position: relative;
            display: inline-block;
        }

        .remove-image-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            text-align: center;
            cursor: pointer;
        }

        .deleteProductImage {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            text-align: center;
            cursor: pointer;
        }
    </style>
@endsection
@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>

    <script>
        let selectedFiles = [];

        document.getElementById("dropZone").addEventListener("click", () => {
            document.getElementById("imageInput").click();
        });

        document.getElementById("imageInput").addEventListener("change", function(event) {
            handleFiles(event.target.files);
        });

        document.getElementById("dropZone").addEventListener("dragover", function(event) {
            event.preventDefault();
            event.stopPropagation();
            this.style.backgroundColor = "#e3f2fd";
        });

        document.getElementById("dropZone").addEventListener("dragleave", function(event) {
            this.style.backgroundColor = "#f8f9fa";
        });

        document.getElementById("dropZone").addEventListener("drop", function(event) {
            event.preventDefault();
            event.stopPropagation();
            this.style.backgroundColor = "#f8f9fa";
            handleFiles(event.dataTransfer.files);
        });

        function handleFiles(files) {
            let previewContainer = document.getElementById("imagePreview");

            Array.from(files).forEach((file) => {
                if (!selectedFiles.includes(file.name)) { // Prevent duplicate images
                    selectedFiles.push(file.name);

                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let previewDiv = document.createElement("div");
                        previewDiv.classList.add("preview-container");

                        let imgElement = document.createElement("img");
                        imgElement.src = e.target.result;

                        let removeButton = document.createElement("button");
                        removeButton.innerText = "×";
                        removeButton.type = "button";
                        removeButton.classList.add("remove-image-btn");
                        removeButton.onclick = function() {
                            previewDiv.remove();
                            selectedFiles = selectedFiles.filter(name => name !== file.name);
                        };

                        previewDiv.appendChild(imgElement);
                        previewDiv.appendChild(removeButton);
                        previewContainer.appendChild(previewDiv);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        function setupImagePreview(inputSelector, previewSelector) {
            // inputSelector means which input field to listen to
            // previewSelector means which image to change
            $(inputSelector).click();
            $(inputSelector).change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(previewSelector).attr("src", e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        $('body').on('click', '.deleteProductImage', function() {
            let imageId = $(this).data('image-id');
            let productId = $(this).data('product-id');
            let $button = $(this);

            $.ajax({
                url: "{{ route('delete.product.image') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    image_id: imageId,
                    product_id: productId
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $button.closest('.preview-container').remove();
                        notify('success', response.message);
                    }
                    if (response.status == 'error') {
                        notify('error', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            notify('error', value[0]);
                        });
                    }
                }
            });
        });
    </script>
    <script>
        $('document').ready(function() {
            $('.select2').select2();
            ClassicEditor.create(document.querySelector('#description')).catch(error => {});

            $('body').on('click', '.addVariation', function() {
                var i = $('.variationContainer .row').length;
                let html = `<div class="row" data-id="variation_${i}">
                    <div class="col-lg-5">
                        <div class="mb-3">
                            <label for="name" class="form-label">Variation Name</label>
                            <select class="form-control select2 variationName" data-choice  name="variation_names[]" required>
                                <option value="" selected disabled>Select Variation Name</option>
                                @foreach ($attributes as $variation)
                                    <option value="{{ $variation->id }}">{{ $variation->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mb-3">
                            <label for="name" class="form-label">Variation Value</label>
                            <select class="form-control select2" data-choice name="variation_values[]" required>
                                <option value="" selected disabled>Select Variation Value</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pt-1 mt-4 mb-3 ms-2">
                            <button type="button" class="btn btn-danger removeVariation"> <i class="bx bx-minus"></i> Remove</button>
                        </div>
                    </div>
                </div>`;
                $('.variationContainer').append(html);
                $('.select2').select2();
            });

            $('body').on('change', '.variationName', function() {
                var variationId = $(this).val();
                var container = $(this).closest('.row');
                var variationValueSelect = container.find('[name="variation_values[]"]');
                variationValueSelect.empty().append('<option selected disabled>Loading...</option>');
                if (variationId) {
                    $.ajax({
                        url: "{{ route('get.attribute.values') }}",
                        method: 'GET',
                        data: {
                            variation_id: variationId
                        },
                        success: function(response) {
                            variationValueSelect.empty();
                            if (response.length > 0) {
                                variationValueSelect.append(
                                    `<option value="" selected disabled>Select Variation Value</option>`
                                );
                                response.forEach(function(value) {
                                    variationValueSelect.append(
                                        `<option value="${value.id}">${value.value}</option>`
                                    );
                                });
                            } else {
                                variationValueSelect.append(
                                    '<option value="" disabled>No values found</option>');
                            }
                            variationValueSelect.trigger('change');
                        },
                        error: function() {
                            alert('Error fetching variation values');
                        }
                    });
                } else {
                    variationValueSelect.empty();
                }
            });

            $('body').on('click', '.removeVariation', function() {
                $(this).closest('.row').remove();
            });



            $('body').on('click', '.removeImage', function() {
                $(this).siblings('img').attr('src', '{{ asset('assets/placeholder-image-2.png') }}');
                $(this).hide();
            });

            $('#addForm').submit(function(e) {
                e.preventDefault();
                // Create new FormData object
                let formData = new FormData(this);



                // Proceed with AJAX logic here if everything is good

                let actionUrl = $(this).attr('action');

                fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        $('#submitBtn').prop('disabled', false);
                        $('#submitBtn').html('Save');
                        if (data.status == 'success') {
                            notify(data.status, data.message);
                            let redirectUrl = "{{ route('products.index') }}";
                            setTimeout(function() {
                                window.location.href = redirectUrl;
                            }, 1000);
                        }
                    })
                    .catch(error => {
                        let errors = xhr.responseJSON.errors;
                        $('#submitBtn').prop('disabled', false);
                        $('#submitBtn').html('Save');
                        if (errors) {
                            $.each(errors, function(key, value) {
                                let inputField = $('[name="' + key + '"]');
                                inputField.addClass('is-invalid');
                                notify('error', value[0]);
                            });
                        }
                    });
            })


        });
    </script>

@endsection
