{{-- resources/views/products/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Create Product')
@section('content')
    {{--  Start breadcrumb  --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Crate Product</h4>

                <div class="page-title-right">
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li class="breadcrumb-item active">Create</li>
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
                    <h4>Add a New Product</h4>
                    <div class="ms-auto">
                        <a href="{{ route('products.index') }}" class="btn btn-danger add-btn">
                            <i class="align-baseline bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" id="createProductForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name">
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-4">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-control select2" data-choice id="category" name="category">
                                            <option value="" selected disabled>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-lg-4">
                                        <label for="brand" class="form-label">Brand</label>
                                        <select class="form-control select2" data-choice id="brand" name="brand">
                                            <option value="" selected disabled>Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 my-3">
                                        <label for="label" class="form-label">Product Label</label>
                                        <select class="form-control select2" id="label" name="label">
                                            <option value="" disabled>Select Brand</option>
                                            @foreach ($labels as $label)
                                                <option value="{{ $label->value }}">
                                                    {{ $label->description() }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="regular_price" class="form-label">Regular Price</label>
                                            <input type="text" class="form-control" id="regular_price"
                                                name="regular_price" placeholder="Price">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="sale_price" class="form-label">Sale Price</label>
                                            <input type="text" class="form-control" id="sale_price" name="sale_price"
                                                placeholder="Price">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control select2" id="productStatus" name="status">
                                                <option value="" selected disabled>Select Status</option>
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->value }}">{{ $status->description() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="text-center">
                                        <div class="custom-upload-box">
                                            <img src="{{ asset('assets/placeholder-image-2.png') }}" class="preview-img"
                                                alt="Image Preview">
                                            <button type="button" class="remove-btn removeImage"
                                                style="display:none;">&times;
                                            </button>
                                        </div>
                                        <input type="file" name="image" class="d-none hidden-input" accept="image/*">

                                        <button type="button" class="px-4 mt-1 btn btn-dark"
                                            onclick="setupImagePreview('.hidden-input', '.preview-img')"><i
                                                class="bx bx-cloud-upload fs-3"></i>Thumbnail Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="short_description" name="short_description" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control ckeditor-classic" id="description" name="description" rows="4"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="vertical-navs-step mt-3">
                            <div class="row gy-5">
                                <div class="col-lg-3">
                                    <div class="nav flex-column custom-nav nav-pills" role="tablist"
                                        aria-orientation="vertical">
                                        {{-- Tab 1 --}}
                                        <button class="nav-link active" id="variation-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-bill-info" type="button" role="tab"
                                            aria-controls="v-pills-bill-info" aria-selected="true">
                                            <span class="step-title me-2">
                                                <i class="ri-close-circle-fill step-icon me-2"></i> Step 1
                                            </span>
                                            Attributes
                                        </button>
                                        {{-- Tab 2 --}}
                                        <button class="nav-link" id="attribute-tab"
                                            data-bs-target="#v-pills-bill-address" type="button" role="tab"
                                            aria-controls="v-pills-bill-address" aria-selected="false">
                                            <span class="step-title me-2">
                                                <i class="ri-close-circle-fill step-icon me-2"></i> Step 2
                                            </span>
                                            Variations
                                        </button>
                                    </div>
                                    <!-- end nav -->
                                </div> <!-- end col-->
                                <div class="col-lg-9">
                                    <div class="px-lg-4">
                                        <div class="tab-content">
                                            {{-- Tab 1 --}}
                                            <div class="tab-pane fade show active" id="v-pills-bill-info" role="tabpanel"
                                                aria-labelledby="variation-tab">
                                                <div id="attributesWrapper">
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <input name="attributes[0][name]" type="text"
                                                                class="form-control" placeholder="Attribute Name">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input name="attributes[0][values]" type="text"
                                                                class="form-control"
                                                                placeholder="Comma separated values (e.g. Red, Blue)">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="addAttribute()">+
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <!-- end tab pane -->
                                            {{-- Tab 2 --}}
                                            <div class="tab-pane fade" id="v-pills-bill-address" role="tabpanel"
                                                aria-labelledby="attribute-tab">
                                                <p class="text-muted">Based on the attribute combinations, you can
                                                    define
                                                    each variation's
                                                    price, image,
                                                    and description.</p>
                                                <div id="variationContainer">
                                                    {{-- Variations will be added via JS --}}
                                                </div>
                                            </div>

                                        </div>
                                        <!-- end tab content -->
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <button type="button" id="step2Btn" class="btn btn-success btn-label right ms-auto nexttab"
                                data-nexttab="attribute-tab">
                                <i class="ri-arrow-right-line label-icon align-middle fs-lg ms-2"></i>
                                Step 2
                            </button>
                            <button type="submit" id="saveProductBtn"
                                class="btn btn-success btn-label right ms-auto d-none">
                                Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div><!--end card-->
        </div><!--end col-->
    </div>
@endsection

@section('page-script')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>

    <script>
        const variationFiles = {};
        $('#description').summernote({
            placeholder: 'Write your description here',
            tabsize: 2,
            height: 280,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        $('document').ready(function() {
            $('.select2').select2();
        });

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

        let selectedFiles = [];


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

        let attrIndex = 1;

        function addAttribute() {
            const html = `
                <div class="row mb-2">
                    <div class="col-md-5">
                        <input name="attributes[${attrIndex}][name]" type="text" class="form-control" placeholder="Attribute Name">
                    </div>
                    <div class="col-md-5">
                        <input name="attributes[${attrIndex}][values]" type="text" class="form-control" placeholder="Comma separated values">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-attr">x</button>
                    </div>
                </div>`;
            $('#attributesWrapper').append(html);
            attrIndex++;
        }

        // Remove attribute row
        $(document).on('click', '.remove-attr', function() {
            $(this).closest('.row').remove();
        });

        $('#attribute-tab, #step2Btn').on('click', function(e) {
            let hasEmpty = false;
            $('#attributesWrapper .row').each(function() {
                const nameInput = $(this).find('input[name*="[name]"]').val().trim();
                const valuesInput = $(this).find('input[name*="[values]"]').val().trim();

                if (!nameInput || !valuesInput) {
                    hasEmpty = true;
                    return false;
                }
            });

            if (hasEmpty) {
                notify('error', 'Please fill all the required fields.');
                return;
            }
            $('#step2Btn').addClass('d-none');
            $('#saveProductBtn').removeClass('d-none');

            storeAttributesInLocalStorage();
            renderVariationsFromAttributes();

            // Bootstrap tab switch
            const tab = new bootstrap.Tab($('#attribute-tab')[0]);
            tab.show();
        });

        // If next button is clicked
        $('#variation-tab').on('click', function() {
            $('#step2Btn').removeClass('d-none');
            $('#saveProductBtn').addClass('d-none');
        });

        function storeAttributesInLocalStorage() {
            const attributes = [];

            $('#attributesWrapper .row').each(function() {
                const name = $(this).find('input[name*="[name]"]').val().trim();
                const values = $(this).find('input[name*="[values]"]').val().split(',').map(v => v.trim()).filter(
                    Boolean);

                if (name && values.length) {
                    attributes.push({
                        name,
                        values
                    });
                }
            });

            localStorage.setItem('product_attributes', JSON.stringify(attributes));
        }

        function renderVariationsFromAttributes() {
            const container = $('#variationContainer');
            container.html('');

            const attributes = JSON.parse(localStorage.getItem('product_attributes') || '[]');
            if (!attributes.length) return;

            const attrNames = attributes.map(attr => attr.name);
            const combinations = generateCombinations(attributes.map(attr => attr.values));

            combinations.forEach((combo, index) => {
                const attrDisplay = combo.map((val, i) => `${attrNames[i]}: ${val}`).join(' / ');
                const safeAttrDisplay = attrDisplay.replace(/"/g, '&quot;');

                const html = `
                    <div class="card p-3 mb-3">
                        <h5>Variation: ${index + 1}</h5>
                        <input type="hidden" name="variations[${index}][attributes]" value="${safeAttrDisplay}">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label>Variation</label>
                                <input type="text" value="${attrDisplay}" disabled class="form-control">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Price</label>
                                <input name="variations[${index}][price]" type="number" step="0.01" class="form-control">
                            </div>
                            <div class="col-12 mb-2">
                                <div class="image-upload-wrapper mb-3">
                                    <label class="form-label">Images</label>
                                    <div class="custom-drop-area" data-index="${index}">
                                        <div class="upload-text">
                                            <i class="ph ph-image-square upload-icon"></i>
                                            <p>Click here to upload</p>
                                        </div>
                                        <input type="file" class="form-control variation-image-input" data-index="${index}" multiple accept="image/*" hidden>
                                         <div id="imagePreview-${index}" class="d-flex flex-wrap mt-2 gap-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                container.append(html);
            });
        }
        // ✅ FIXED: Prevent input recursion causing max stack error
        $(document).on('click', '.custom-drop-area', function(e) {
            // ⛔ Prevent opening file dialog when clicking the remove button or input itself
            if (
                $(e.target).is('input[type="file"]') ||
                $(e.target).closest('.remove-image').length ||
                $(e.target).closest('.remove-image-existing').length
            ) {
                return;
            }

            // ✅ Trigger input file picker only when clicking outside those
            $(this).find('input[type="file"]').trigger('click');
        });
        // Preview selected images
        $(document).on('change', '.variation-image-input', function(e) {
            const index = $(this).data('index');
            const files = Array.from(e.target.files);
            const previewContainer = $(`#imagePreview-${index}`);

            if (!variationFiles[index]) variationFiles[index] = [];

            files.forEach((file, i) => {
                const previewId = `preview-${index}-${Date.now()}-${i}`;
                variationFiles[index].push({
                    id: previewId,
                    file
                });

                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = $(`
                                <div class="position-relative me-2 mb-2" data-preview-id="${previewId}">
                                    <img src="${e.target.result}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 1px solid #e0e0e0;">
                                    <button type="button" class="position-absolute top-0 end-0 m-1 remove-image" data-index="${index}" data-preview-id="${previewId}" style="
                                        width: 24px; height: 24px; background-color: #ff4d4f; color: white;
                                        border: none; border-radius: 50%; display: flex; align-items: center;
                                        justify-content: center; cursor: pointer;">
                                        <i class="ph ph-x" style="font-size: 14px;"></i>
                                    </button>
                                </div>
                            `);
                    previewContainer.append(preview);
                };
                reader.readAsDataURL(file);
            });

            $(this).val('');
        });

        $(document).on('click', '.remove-image', function() {
            const fileIndex = $(this).data('file-index');
            const previewDiv = $(this).closest('.position-relative');
            const fileInput = $(this).closest('.col-12').find('.variation-image-input')[0];
            let dt = $(fileInput).data('dt') || new DataTransfer();

            dt.items.remove(fileIndex);
            fileInput.files = dt.files;
            $(fileInput).data('dt', dt);

            previewDiv.remove();
        });

        function generateCombinations(arrays, prefix = []) {
            if (!arrays.length) return [prefix];
            const [first, ...rest] = arrays;
            return first.flatMap(value => generateCombinations(rest, [...prefix, value]));
        }


        $('#createProductForm').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            let actionUrl = $(this).attr('action');

            // Clear previous errors
            $('.validation-error').remove();

            // Append variation images
            Object.keys(variationFiles).forEach(index => {
                variationFiles[index].forEach(({
                    file
                }) => {
                    formData.append(`variations[${index}][images][]`, file);
                });
            });

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('button[type="submit"]').prop('disabled', true).text('Saving...');
                },
                success: function(response) {
                    notify('success', "Product created successfully");
                    setTimeout(() => {
                        window.location.href = "{{ route('products.index') }}";
                    }, 2000);
                },
                error: function(xhr) {
                    $('button[type="submit"]').prop('disabled', false).text('Create Product');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            let errorMessages = errors[field].join(', ');
                            let input = $(`[name="${field}"]`);
                            if (input.length === 0) {
                                input = $(`[name^="${field}"]`);
                            }
                            if (input.hasClass('select2-hidden-accessible')) {
                                input.next('.select2').after(
                                    `<div class="validation-error" style="color: red; font-size: 13px;">${errorMessages}</div>`
                                );
                            } else if (input.attr('type') === 'file') {
                                input.after(
                                    `<div class="validation-error" style="color: red; font-size: 13px;">${errorMessages}</div>`
                                );
                            } else {
                                input.last().after(
                                    `<div class="validation-error" style="color: red; font-size: 13px;">${errorMessages}</div>`
                                );
                            }
                            notify('error', errorMessages);
                        }

                    } else {
                        notify('error', 'Something went wrong. Please try again.');
                    }
                },
                complete: function() {
                    $('button[type="submit"]').prop('disabled', false).text('Create Product');
                }
            });
        });
    </script>
@endsection
@section('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .tab-content {
            height: 400px;
            overflow-y: scroll;
            border: 1px dashed;
            padding: 15px;
        }

        div#variationContainer::-webkit-scrollbar {
            width: 4px;
            /* Width of the scrollbar */
        }

        div#variationContainer::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        div#variationContainer::-webkit-scrollbar-thumb {
            background: #888;
        }

        div#variationContainer::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: var(--tb-border-width) solid var(--tb-border-color-translucent);
            border-radius: 4px;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #8c8c8c;
            line-height: 1px;
            font-size: 13px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            overflow: visible;
        }

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


        .custom-drop-area {
            border: 2px dashed #d0d0d0;
            border-radius: 10px;
            padding: 30px;
            background-color: #f8f8f8;
            text-align: center;
            cursor: pointer;
            position: relative;
            transition: border-color 0.3s ease;
        }

        .custom-drop-area:hover {
            border-color: #6366f1;
        }

        .custom-drop-area .upload-icon {
            font-size: 40px;
            color: #6366f1;
        }

        .custom-drop-area p {
            margin-top: 10px;
            color: #555;
            font-weight: 500;
        }
    </style>
@endsection
