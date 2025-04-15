@extends('layouts.app')

@section('page-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .tab-content {
            max-height: 400px;
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
    </style>
@endsection

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
                            <div class="col-lg-12 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $product->name }}">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control select2" id="category" name="category" required>
                                    <option value="" disabled>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
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
                            <div class="col-lg-4 mb-3">
                                <label for="regular_price" class="form-label">Regular Price</label>
                                <input type="text" class="form-control" id="regular_price" name="regular_price"
                                    value="{{ $product->regular_price }}">
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label for="sale_price" class="form-label">Sale Price</label>
                                <input type="text" class="form-control" id="sale_price" name="sale_price"
                                    value="{{ $product->sale_price }}">
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control select2" id="productStatus" name="status" required>
                                    <option value="" disabled>Select Status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->value }}"
                                            {{ $product->status === $status->value ? 'selected' : '' }}>
                                            {{ $status->description() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control" name="short_description" rows="4">{{ $product->short_description }}</textarea>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control ckeditor-classic" name="description" rows="4">{{ $product->description }}</textarea>
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
                                                            <input type="text" name="attributes[{{ $index }}][id]" value="{{$attribute->id}}">
                                                            <input name="attributes[{{ $index }}][name]"
                                                                type="text" class="form-control"
                                                                value="{{ $attribute->name }}"
                                                                placeholder="Attribute Name">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input name="attributes[{{ $index }}][values]"
                                                                type="text" class="form-control"
                                                                value="{{ $attribute->values->pluck('value')->implode(', ') }}"
                                                                placeholder="Comma separated values">
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
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-success ms-auto nexttab"
                                                    data-nexttab="attribute-tab">
                                                    Step 2 <i class="ri-arrow-right-line ms-2"></i>
                                                </button>
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

                        <button type="submit" class="btn btn-primary mt-4">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
    <script>
        const productId = {{ $product->id }};

        $(document).ready(function() {
            $('.select2').select2();
            ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));

            let attrIndex = $('#attributesWrapper .row').length;

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
            }

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
                    alert('Please fill out all attribute fields.');
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
                    url: '/get-variations',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        product_id: productId,
                        combinations: comboStrings
                    },
                    success: function(response) {
                        combinations.forEach((combo, index) => {
                            const attrDisplay = combo.map((val, i) => `${attrNames[i]}: ${val}`)
                                .join(' / ');
                            const safeAttrDisplay = attrDisplay.replace(/"/g, '&quot;');
                            const variation = response[attrDisplay] || {};
                            const price = variation.price || '';
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
                                    <input type="text" name="variations[${index}][attributes]" value="${safeAttrDisplay}">
                                    <input type="text" name="variations[${index}][variation_id]" value="${variation_id}">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label>Variation</label>
                                            <input type="text" value="${attrDisplay}" disabled class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Price</label>
                                            <input name="variations[${index}][price]" type="number" step="0.01" class="form-control" value="${price}">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label>Images</label>
                                            <input name="variations[${index}][images][]" type="file" class="form-control variation-image-input" data-index="${index}" multiple accept="image/*">
                                            <div id="imagePreview-${index}" class="d-flex flex-wrap mt-2 gap-2">
                                                ${imagePreviewHTML}
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                            container.append(html);
                        });
                    }
                });
            }

            $(document).on('change', '.variation-image-input', function(e) {
                const index = $(this).data('index');
                const previewContainer = $(`#imagePreview-${index}`);

                const files = Array.from(e.target.files);
                const fileInput = this;
                let dataTransfer = new DataTransfer();

                files.forEach((file, fileIndex) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = $(`
                        <div class="position-relative me-2 mb-2">
                            <img src="${e.target.result}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 1px solid #e0e0e0;">
                            <button type="button" class="position-absolute top-0 end-0 m-1 remove-image" data-file-index="${fileIndex}" style="
                                width: 24px; height: 24px; background-color: #ff4d4f; color: white;
                                border: none; border-radius: 50%; display: flex; align-items: center;
                                justify-content: center; cursor: pointer;">
                                <i class="ph ph-x" style="font-size: 14px;"></i>
                            </button>
                        </div>`);
                        previewContainer.append(
                            preview);
                    };
                    dataTransfer.items.add(file);
                    reader.readAsDataURL(file);
                });

                fileInput.files = dataTransfer.files;
                $(fileInput).data('dt', dataTransfer);
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

            // AJAX delete for existing images
            $(document).on('click', '.remove-image-existing', function() {
                const imageId = $(this).data('id');
                const container = $(this).closest('.position-relative');

                if (confirm('Are you sure you want to delete this image?')) {
                    $.ajax({
                        url: '/variation-image/delete',
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: imageId
                        },
                        success: function() {
                            container.remove();
                        },
                        error: function() {
                            alert('Failed to delete image');
                        }
                    });
                }
            });



            // AJAX Submit for the entire form
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true).text('Updating...');
                    },
                    success: function(response) {
                        // ✅ success logic (redirect or message)
                        alert('Product updated successfully!');
                        // window.location.href = "{{ route('products.index') }}";
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Something went wrong. Please check the inputs.');
                    },
                    complete: function() {
                        $('button[type="submit"]').prop('disabled', false).text(
                            'Update Product');
                    }
                });
            });

        });
    </script>
@endsection
