@extends('layouts.app')

@section('page-css')
    <style>
        .upload-container {
            border: 2px dashed #e0e0e0;
            padding: 15px;
            border-radius: 10px;
            position: relative;
            margin-bottom: 20px;
        }

        .file-preview {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .file-preview img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 10px;
        }

        .remove-btn {
            background-color: #ffebee;
            border: none;
            color: red;
            font-size: 16px;
            padding: 5px 10px;
            border-radius: 50%;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #ffcdd2;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <form id="uploadForm" enctype="multipart/form-data">
            <div id="uploadFields">
                @foreach ($sliders as $key => $slider)
                    <div class="upload-container" id="uploadField-{{ $key + 1 }}">
                        <div class="mb-2">
                            <input type="text" class="form-control title" name="fields[{{ $key + 1 }}][title]"
                                value="{{ old($slider->title) }}" placeholder="Enter Title">
                        </div>
                        <div class="mb-2">
                            <textarea class="form-control description" name="fields[{{ $key + 1 }}][description]"
                                placeholder="Enter Description">{{ old('fields.' . ($key + 1) . '.description', $slider->description) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <input type="file" class="form-control d-none file-input"
                                name="fields[{{ $key + 1 }}][file]" id="fileInput-{{ $key + 1 }}">
                            <div>
                                <button type="button" class="btn btn-light border me-2 browse-btn"
                                    data-id="{{ $key + 1 }}">Browse</button>
                                <span class="file-label"
                                    id="fileLabel-{{ $key + 1 }}">{{ old('fields.' . ($key + 1) . '.file', 'No file selected') }}</span>
                            </div>
                            <button class="remove-btn ms-2" data-id="{{ $key + 1 }}">✖</button>
                        </div>
                        <div class="file-preview d-none mt-2" id="previewContainer-{{ $key + 1 }}">
                            <img id="previewImage-{{ $key + 1 }}" src="{{ asset('storage/' . $slider->file_path) }}"
                                alt="Preview">
                            <div>
                                <p class="mb-1 file-name" id="fileName-{{ $key + 1 }}">
                                    {{ $slider->file_name ?? 'No file selected' }}</p>
                                <small class="text-muted file-size"
                                    id="fileSize-{{ $key + 1 }}">{{ $slider->file_size ? round($slider->file_size / 1024, 2) . ' KB' : '' }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-primary mb-3" id="addUploadField">+ Add More</button>
            <button type="submit" class="btn btn-success mb-3">Submit</button>
        </form>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            let fieldCount = {{ count($sliders) }}; // Start from the existing number of sliders

            // Function to add an upload field
            function addUploadField() {
                fieldCount++;
                let fieldHTML = `
                    <div class="upload-container" id="uploadField-${fieldCount}">
                        <div class="mb-2">
                            <input type="text" class="form-control title" name="fields[${fieldCount}][title]" placeholder="Enter Title">
                        </div>
                        <div class="mb-2">
                            <textarea class="form-control description" name="fields[${fieldCount}][description]" placeholder="Enter Description"></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <input type="file" class="form-control d-none file-input" name="fields[${fieldCount}][file]" id="fileInput-${fieldCount}">
                            <div>
                                <button type="button" class="btn btn-light border me-2 browse-btn" data-id="${fieldCount}">Browse</button>
                                <span class="file-label" id="fileLabel-${fieldCount}">No file selected</span>
                            </div>
                            <button class="remove-btn ms-2" data-id="${fieldCount}">✖</button>
                        </div>
                        <div class="file-preview d-none mt-2" id="previewContainer-${fieldCount}">
                            <img id="previewImage-${fieldCount}" src="" alt="Preview">
                            <div>
                                <p class="mb-1 file-name" id="fileName-${fieldCount}">File Name</p>
                                <small class="text-muted file-size" id="fileSize-${fieldCount}">Size</small>
                            </div>
                        </div>
                    </div>
                `;
                $('#uploadFields').append(fieldHTML);
            }

            // Add the first field on page load
            @if (count($sliders) == 0)
                addUploadField();
            @endif

            // Add new upload field when the button is clicked
            $('#addUploadField').click(function() {
                addUploadField();
            });

            // Trigger file input when 'Browse' is clicked
            $(document).on('click', '.browse-btn', function() {
                let id = $(this).data('id');
                $(`#fileInput-${id}`).click();
            });

            // File input change event
            $(document).on('change', '.file-input', function() {
                let id = $(this).attr('id').split('-')[1];
                let file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $(`#previewImage-${id}`).attr('src', e.target.result);
                        $(`#previewContainer-${id}`).removeClass('d-none');
                        $(`#fileName-${id}`).text(file.name);
                        $(`#fileSize-${id}`).text((file.size / 1024).toFixed(2) + " KB");
                        $(`#fileLabel-${id}`).text("1 File selected");
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove upload field
            $(document).on('click', '.remove-btn', function() {
                let id = $(this).data('id');
                $(`#uploadField-${id}`).remove();
            });

            // Submit form with AJAX
            $('#uploadForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('sliders.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        alert('Form submitted successfully');
                    },
                    error: function(xhr, status, error) {
                        alert('There was an error submitting the form');
                    }
                });
            });
        });
    </script>
@endsection
