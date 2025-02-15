@extends('layouts.app')
@section('title', 'Slider')

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
    <div class="container my-5">
        <div id="">
            @foreach ($sliders as $key => $slider)
                <form id="uploadForm-{{ $key + 1 }}" action="{{ route('sliders.update', $slider->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="upload-container" id="uploadField-{{ $key + 1 }}">
                        <div class="text-end my-2">
                            <button class="remove-btn ms-2" type="button"
                                onclick="removeSlider('{{ route('sliders.destroy', $slider->id) }}', '#uploadForm-{{ $key + 1 }}')"
                                data-id="{{ $key + 1 }}">✖</button>
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control title" name="title" value="{{ $slider->title }}"
                                placeholder="Enter Title">
                        </div>
                        <div class="mb-2">
                            <textarea class="form-control description" name="description" placeholder="Enter Description">{{ $slider->description }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <input type="file" class="form-control d-none file-input" name="file"
                                id="fileInput-{{ $key + 1 }}">
                            <div>
                                <button type="button" class="btn btn-light border me-2 browse-btn"
                                    data-id="{{ $key + 1 }}">Browse</button>
                                <span class="file-label"
                                    id="fileLabel-{{ $key + 1 }}">{{ old('fields.' . ($key + 1) . '.file', 'No file selected') }}</span>
                            </div>
                        </div>
                        <div class="file-preview mt-2" id="previewContainer-{{ $key + 1 }}">
                            <img id="previewImage-{{ $key + 1 }}" src="{{ asset($slider->image) }}" alt="Preview">
                            <div>
                                <p class="mb-1 file-name" id="fileName-{{ $key + 1 }}">
                                    {{ $slider->file_name ?? 'No file selected' }}</p>
                                <small class="text-muted file-size"
                                    id="fileSize-{{ $key + 1 }}">{{ $slider->file_size ? round($slider->file_size / 1024, 2) . ' KB' : '' }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button"
                                onclick="updateSlider('{{ route('sliders.update', $slider->id) }}', '#uploadForm-{{ $key + 1 }}')"
                                class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            @endforeach

        </div>
        <form id="uploadForm" enctype="multipart/form-data">
            <div id="uploadFields">

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
                    <div class="text-end my-2">
                        <button class="remove-btn remove_btn ms-2" data-id="${fieldCount}">✖</button>
                    </div>
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
            $(document).on('click', '.remove_btn', function() {
                let id = $(this).data('id');
                $(`#uploadField-${id}`).remove();
            });

            // Update upload field
            $(document).on('click', '.update-btn', function() {
                let id = $(this).data('id');
                let title = $(`#uploadField-${id} .title`).val();
                let description = $(`#uploadField-${id} .description`).val();
                $(`#fileLabel-${id}`).text("Updated");
                alert(`Updated: ${title} - ${description}`);
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
                        if (response.status === 'success') {
                            notify('success', response.message);
                        } else {
                            notify('error', 'Failed to upload slider.'); // Show error message
                        }
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        alert('There was an error submitting the form');
                    }
                });
            });
        });

        function updateSlider(url, formId) {
            // Get the form element
            let form = $(formId)[0];
            let formData = new FormData(form); // Create FormData object from the form

            $.ajax({
                url: url,
                type: "POST", // Use POST for updating
                data: formData,
                processData: false, // Prevent jQuery from automatically transforming the data
                contentType: false, // Prevent jQuery from setting content-type
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    if (response.status === 'success') {
                        notify('success', response.message); // Show success message
                    } else {
                        notify('error', 'Failed to update status.'); // Show error message
                    }
                    $('#dataTable').DataTable().ajax.reload(); // Reload the data table (if necessary)
                },
                error: function() {
                    notify('error', 'Something went wrong.'); // Show generic error message
                }
            });
        }


        function removeSlider(url, formId) {
            alert('Are you sure you want to delete this slider?');
            $.ajax({
                url: url,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    if (response.status === 'success') {
                        notify('success', response.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        notify('error', 'Failed to delete slider.');
                    }
                },
                error: function() {
                    notify('error', 'Something went wrong.');
                }
            });
        }
    </script>
@endsection
