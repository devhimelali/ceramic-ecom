@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Product</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Edit Product</h4>
                    <a href="{{ route('products.index') }}" class="btn btn-danger ms-auto"><i
                            class="bi bi-arrow-left me-1"></i> Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" id="editForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Basic Fields --}}
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $product->name }}">
                                </div>
                                <div class="row">
                                    <div class="my-3 col-lg-3">
                                        <label for="category" class="form-label">Category <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control select2" required id="category" name="category">
                                            <option value="" disabled>Select Category</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $cat->id == optional($product->category->parent)->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- sub category --}}
                                    <div class="my-3 col-lg-3">
                                        <label for="sub_category" class="form-label">Sub Category</label>
                                        <select class="form-control select2" id="sub_category" name="sub_category">
                                            <option value="" selected disabled>Loading...</option>
                                            {{-- Will be replaced via JS --}}
                                        </select>
                                    </div>


                                    <div class="col-lg-3 my-3">
                                        <label for="brand" class="form-label">Brand</label>
                                        <select class="form-control select2" id="brand" name="brand">
                                            <option value="" disabled>Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 my-3">
                                        <label for="label" class="form-label">Product Label</label>
                                        <select class="form-control select2" id="label" name="label">
                                            <option value="" disabled
                                                {{ is_null($product->label) ? 'selected' : '' }}>Select Brand</option>
                                            @foreach ($labels as $label)
                                                <option value="{{ $label->value }}"
                                                    {{ $product->label === $label ? 'selected' : '' }}>
                                                    {{ $label->description() }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-lg-4 my-3">
                                        <label for="regular_price" class="form-label">Regular Price <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required id="regular_price"
                                            name="regular_price" value="{{ $product->regular_price }}">
                                    </div>
                                    <div class="col-lg-4 my-3">
                                        <label for="sale_price" class="form-label">Sale Price</label>
                                        <input type="text" class="form-control" id="sale_price" name="sale_price"
                                            value="{{ $product->sale_price }}">
                                    </div>
                                    <div class="col-lg-4 my-3">
                                        <label for="status" class="form-label">Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control select2" id="productStatus" name="status" required>
                                            <option value="" disabled>Select Status</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->value }}"
                                                    {{ $product->status === $status ? 'selected' : '' }}>
                                                    {{ $status->description() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="text-center">
                                        <div class="custom-upload-box">
                                            <img src="{{ $product->images ? asset($product->images->where('imageable_id', $product->id)->where('imageable_type', 'App\Models\Product')->first()?->path) : asset('assets/placeholder-image-2.png') }}"
                                                class="preview-img" alt="Image Preview">
                                            <button type="button" class="remove-btn removeImage"
                                                style="display:none;">&times;
                                            </button>
                                        </div>
                                        <input type="file" name="image" class="d-none hidden-input"
                                            accept="image/*">

                                        <button type="button" class="px-4 mt-1 btn btn-dark"
                                            onclick="setupImagePreview('.hidden-input', '.preview-img')"><i
                                                class="bx bx-cloud-upload fs-3"></i>Thumbnail Image
                                        </button>
                                    </div>
                                </div>
                            </div>




                            <div class="col-lg-12 mb-3">
                                <label for="short_description" class="form-label">Short Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" name="short_description" rows="4">{{ $product->short_description }}</textarea>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control ckeditor-classic" id="description" name="description" rows="4">{{ $product->description }}</textarea>
                            </div>
                        </div>

                        {{-- Attributes + Variations --}}
                        <div class="vertical-navs-step mt-3">
                            <div class="row gy-5">
                                <div class="col-lg-3">
                                    <div class="nav flex-column custom-nav nav-pills" role="tablist">
                                        <button class="nav-link active" id="variation-tab" data-bs-toggle="pill"
                                            data-bs-target="#attributes-tab" type="button" role="tab">Step 1 -
                                            Attributes</button>
                                        <button class="nav-link" id="attribute-tab" data-bs-toggle="pill"
                                            data-bs-target="#variations-tab" type="button" role="tab">Step 2 -
                                            Variations</button>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="px-lg-4 tab-content">
                                        {{-- Attributes Tab --}}
                                        <div class="tab-pane fade show active" id="attributes-tab" role="tabpanel">
                                            <div id="attributesWrapper">
                                                @foreach ($product->attributes as $index => $attribute)
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <input type="hidden"
                                                                name="attributes[{{ $index }}][id]"
                                                                value="{{ $attribute->id }}">
                                                            <input name="attributes[{{ $index }}][name]"
                                                                type="text" class="form-control"
                                                                value="{{ $attribute->name }}"
                                                                placeholder="Attribute Name" required>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input name="attributes[{{ $index }}][values]"
                                                                type="text" class="form-control"
                                                                value="{{ $attribute->values->pluck('value')->implode(', ') }}"
                                                                placeholder="Comma separated values" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            @if ($index === 0)
                                                                <button type="button" class="btn btn-success"
                                                                    onclick="addAttribute()">+</button>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-danger remove-attr">x</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>

                                        {{-- Variations Tab --}}
                                        <div class="tab-pane fade" id="variations-tab" role="tabpanel">
                                            <p class="text-muted">Define price, image, and info for each variation.</p>
                                            <div id="variationContainer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <button type="submit" id="updateProductBtn"
                                class="btn btn-success ms-auto d-none d-none">Update
                                Product</button>
                            <button type="button" id="step2Btn" class="btn btn-success ms-auto nexttab d-none"
                                data-nexttab="attribute-tab">
                                Step 2 <i class="ri-arrow-right-line ms-2"></i>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>
    <script>
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

        $(document).ready(function() {
            function toggleButtons(activeTabId) {
                if (activeTabId === 'attributes-tab') {
                    $('#step2Btn').removeClass('d-none');
                    $('#updateProductBtn').addClass('d-none');
                } else if (activeTabId === 'variations-tab') {
                    $('#step2Btn').addClass('d-none');
                    $('#updateProductBtn').removeClass('d-none');
                }
            }

            // Initial check on page load
            toggleButtons($('.tab-pane.active').attr('id'));

            // On tab shown event
            $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function(e) {
                var activeTabId = $(e.target).data('bs-target').substring(1);
                toggleButtons(activeTabId);
            });
        });
    </script>

    <script>
        $('#description').summernote({
            placeholder: 'Write your description here',
            tabsize: 2,
            height: 280,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['table', ['table']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        const productId = {{ $product->id }};
        const variationFiles = {};

        $(document).ready(function() {
            $('.select2').select2();
            renderVariations();
            let attrIndex = $('#attributesWrapper .row').length;

            let selectedCategoryId = "{{ optional($product->category->parent)->id }}";
            let selectedSubCategoryId = "{{ $product->category->id }}";
            // Initial load for editing
            loadSubcategories(selectedCategoryId, selectedSubCategoryId);

            window.addAttribute = function() {
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
            };

            $(document).on('click', '.remove-attr', function() {
                $(this).closest('.row').remove();
            });

            $('[data-nexttab="attribute-tab"]').on('click', function() {
                $('#attribute-tab').click();
            });

            $('#attribute-tab').on('click', function() {
                let hasEmpty = false;
                $('#attributesWrapper .row').each(function() {
                    const name = $(this).find('input[name*="[name]"]').val().trim();
                    const values = $(this).find('input[name*="[values]"]').val().trim();
                    if (!name || !values) {
                        hasEmpty = true;
                        return false;
                    }
                });

                if (hasEmpty) {
                    notify('error', 'Please fill all the required fields.');
                    return;
                }

                storeAttributes();
                renderVariations();
            });

            function storeAttributes() {
                const attributes = [];
                $('#attributesWrapper .row').each(function() {
                    const name = $(this).find('input[name*="[name]"]').val().trim();
                    const values = $(this).find('input[name*="[values]"]').val().split(',').map(v => v
                        .trim()).filter(Boolean);
                    if (name && values.length) {
                        attributes.push({
                            name,
                            values
                        });
                    }
                });
                localStorage.setItem('product_attributes', JSON.stringify(attributes));
            }

            function generateCombinations(arrays, prefix = []) {
                if (!arrays.length) return [prefix];
                const [first, ...rest] = arrays;
                return first.flatMap(value => generateCombinations(rest, [...prefix, value]));
            }

            function renderVariations() {
                const container = $('#variationContainer');
                container.html('');
                const attributes = JSON.parse(localStorage.getItem('product_attributes') || '[]');
                if (!attributes.length) return;

                const attrNames = attributes.map(attr => attr.name);
                const combinations = generateCombinations(attributes.map(attr => attr.values));
                const comboStrings = combinations.map(combo =>
                    combo.map((val, i) => `${attrNames[i]}: ${val}`).join(' / ')
                );

                $.ajax({
                    url: "{{ route('get.variations') }}",
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        product_id: productId,
                        combinations: comboStrings
                    },
                    beforeSend: function() {
                        $('#variationContainer').html(
                            '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                        );
                    },
                    success: function(response) {
                        combinations.forEach((combo, index) => {
                            const attrDisplay =
                                `${capitalize(attrNames[0])}: ${capitalize(combo[0])}`;
                            const safeAttrDisplay = attrDisplay.replace(/"/g, '&quot;');
                            const variation = response[attrDisplay] || {};
                            const regular_price = variation.regular_price || '';
                            const sale_price = variation.sale_price || '';
                            const imageObjs = variation.images || [];
                            const variation_id = variation.id || '';
                            const imagePreviewHTML = imageObjs.map(img => `
                                    <div class="position-relative me-2 mb-2">
                                        <img src="${img.path.startsWith('http') ? img.path : '/' + img.path}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 1px solid #e0e0e0;">
                                        <button type="button" class="position-absolute top-0 end-0 m-1 remove-image-existing" data-id="${img.id}" style="
                                            width: 24px; height: 24px; background-color: #ff4d4f; color: white;
                                            border: none; border-radius: 50%; display: flex; align-items: center;
                                            justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2); cursor: pointer;">
                                            <i class="ph ph-x" style="font-size: 14px;"></i>
                                        </button>
                                    </div>`).join('');

                            const html = `
                                <div class="card p-3 mb-3">
                                    <h5>Variation: ${index + 1}</h5>
                                    <input type="hidden" name="variations[${index}][attributes]" value="${safeAttrDisplay}">
                                    <input type="hidden" name="variations[${index}][variation_id]" value="${variation_id}">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label>Variation</label>
                                            <input type="text" value="${attrDisplay}" disabled class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Regular Price</label>
                                            <input name="variations[${index}][regular_price]" type="number" step="0.01" class="form-control" value="${regular_price}">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Sales Price</label>
                                            <input name="variations[${index}][sale_price]" type="number" step="0.01" class="form-control" value="${sale_price}">
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
                                                    <div id="imagePreview-${index}" class="d-flex flex-wrap mt-2 gap-2">
                                                        ${imagePreviewHTML}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                            container.append(html);
                        });
                    },
                    error: function(xhr, status, error) {
                        notify('error', 'Something went wrong. Please check the inputs.');
                    },
                    complete: function() {
                        $('#variationContainer .text-center').empty();
                    }

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

            function capitalize(str) {
                return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
            }

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

            // Remove new images
            $(document).on('click', '.remove-image', function() {
                const index = $(this).data('index');
                const previewId = $(this).data('preview-id');

                variationFiles[index] = variationFiles[index].filter(item => item.id !== previewId);
                $(`[data-preview-id="${previewId}"]`).remove();
            });

            // Remove existing image
            $(document).on('click', '.remove-image-existing', function() {
                const imageId = $(this).data('id');
                const container = $(this).closest('.position-relative');

                if (confirm('Are you sure you want to delete this image?')) {
                    $.ajax({
                        url: '{{ route('delete.product.image') }}',
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: imageId
                        },
                        success: function() {
                            container.remove();
                        },
                        error: function() {
                            notify('error', 'Failed to delete image');
                        }
                    });
                }
            });

            // Form submit
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);

                Object.keys(variationFiles).forEach(index => {
                    variationFiles[index].forEach(({
                        file
                    }) => {
                        formData.append(`variations[${index}][images][]`, file);
                    });
                });

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true).text('Updating...');
                        $('.validation-error').remove();
                    },
                    success: function(response) {
                        notify('success', "Product updated successfully");
                        setTimeout(() => {
                            window.location.href = '{{ route('products.index') }}';
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('button[type="submit"]').prop('disabled', false).text(
                            'Update Product');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                let errorMessage =
                                    `<span class="validation-error" style="color:red; font-size:13px;">${errors[field][0]}</span>`;
                                $(`[name="${field}"]`).after(errorMessage);
                                notify('error', errorMessage);
                            }
                        } else {
                            notify('error', 'Something went wrong. Please check the inputs.');
                        }
                    },
                    complete: function() {
                        $('button[type="submit"]').prop('disabled', false).text(
                            'Update Product');
                    }
                });
            });


            // Change event for normal selection
            $('#category').on('change', function() {
                loadSubcategories($(this).val());
            });
        });

        function loadSubcategories(categoryId, selectedId = null) {
            if (categoryId) {
                let url = "{{ route('get.subcategories', ':id') }}".replace(':id', categoryId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        $('#sub_category').html('<option selected disabled>⏳ Loading...</option>');
                    },
                    success: function(data) {
                        $('#sub_category').empty().append(
                            '<option value="" disabled>Select Sub Category</option>');
                        $.each(data, function(key, subcategory) {
                            let selected = subcategory.id == selectedId ? 'selected' : '';
                            $('#sub_category').append(
                                `<option value="${subcategory.id}" ${selected}>${subcategory.name}</option>`
                            );
                        });
                    }
                });
            }
        }
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

        .note-modal .note-form-label small {
            display: none !important;
        }

        .note-modal-footer{
            margin-bottom: 15px;
        }
    </style>
@endsection
