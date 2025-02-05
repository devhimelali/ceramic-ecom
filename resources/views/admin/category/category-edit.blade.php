<form action="{{ route('admin.categories.update', $category->slug) }}" class="dynamic-form" method="POST" id="editForm">
    @csrf
    @method('PUT')
    <div class="row g-3">
        <div class="col-xl-6">
            <div class="my-4">
                <div>
                    <label for="name" class="form-label">Category Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ $category->name }}" placeholder="Enter Category Name">
                </div>
            </div>
            <div class="my-4">
                <div>
                    <label for="name" class="form-label">Parent Category<span class="text-danger">*</span></label>
                    <select class="form-select" name="parent_id" id="parent_id">
                        <option selected value="">Select Parent Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $category->parent_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="my-4">
                <div>
                    <label for="name" class="form-label">Active/Inactive<span class="text-danger">*</span></label>
                    <select class="form-select" name="is_active" id="is_active">
                        <option {{ $category->is_active == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $category->is_active == 0 ? 'selected' : '' }} value="0">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 pt-4">
            {{-- <div class="d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <div class="image-container" id="imagePreview">
                        <img src="{{ asset('assets/placeholder-image.webp') }}" class="previewImg" alt="Image Preview">
                        <button type="button" class="remove-btn removeImage" style="display:none;">&times;</button>
                    </div>
                    <input type="file" name="image" id="" class="d-none imageUpload" accept="image/*">
                    <label for="imageUpload" class="upload-label imageUploadlavel d-block mt-3">Choose a
                        Category
                        Image</label>
                </div>
            </div> --}}
            <label for="image" class="form-label">Category Image</label>
            <input type="file" name="upimage" id="">
        </div>
        <div class="col-lg-12">
            <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-load submit-btn">
                    <span class="submit-text">Submit</span>
                    <span class="d-flex align-items-center d-none loader">
                        <span class="flex-grow-1 me-2">Submitting...</span>
                        <span class="spinner-grow flex-shrink-0" role="status"><span
                                class="visually-hidden">Loading...</span></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            // Show loader, hide submit button text
            $('.submit-text').addClass('d-none');
            $('.loader').removeClass('d-none');

            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'), // Form action (route)
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    if (response.status === "success") {
                        alert("Category updated successfully!");
                        $('#addForm')[0].reset(); // Reset form
                        $('#editModal').modal('hide'); // Close modal
                        $('#dataTable').DataTable().ajax
                            .reload(); // Reload DataTable if needed
                    }
                },
                error: function(xhr) {
                    // Show submit button text and hide loader
                    $('.submit-text').removeClass('d-none');
                    $('.loader').addClass('d-none');

                    // Handle validation errors
                    let errors = xhr.responseJSON.errors;
                    $(".text-danger").remove(); // Remove old error messages
                    if (errors) {
                        $.each(errors, function(key, value) {
                            let inputField = $('[name="' + key + '"]');
                            inputField.after('<small class="text-danger">' + value[
                                0] + '</small>');
                        });
                    }
                }
            });
        });
    });
</script>
