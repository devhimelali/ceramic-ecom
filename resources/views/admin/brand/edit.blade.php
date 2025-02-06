<form action="{{ route('brands.update', $brand->slug) }}" class="dynamic-form" method="POST" id="editForm"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-3">
        <div class="col-xl-7">
            <div class="my-3">
                <div>
                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name"
                        placeholder="Enter Category Name" value="{{ $brand->name }}">
                </div>
            </div>
            <div class="my-3">
                <div>
                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" id="slug" name="slug" class="form-control"
                        placeholder="Enter category slug" value="{{ old('slug', $brand->slug) }}">
                </div>
            </div>
            <div class="my-3">
                <div>
                    <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                    <select class="form-select" name="status" id="brandStatus">
                        <option selected value="">Select Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}"
                                {{ $brand->status->value == $status->value ? 'selected' : '' }}>
                                {{ $status->description() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="my-3">
                <div>
                    <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ $brand->description }}</textarea>
                </div>
            </div>
        </div>



        <div class="col-xxl-5 pt-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <div class="custom-upload-box">
                        <img src="{{ $brand->image ? asset($brand->image) : asset('assets/placeholder-image-2.png') }}"
                            class="edit-preview-img" alt="Image Preview">
                        <button type="button" class="remove-btn removeImage" style="display:none;">&times;</button>
                    </div>
                    <input type="file" name="image" class="d-none edit-hidden-input" accept="image/*">

                    <button type="button" class="btn btn-dark mt-1 px-4"
                        onclick="setupImagePreview('.edit-hidden-input', '.edit-preview-img')"><i
                            class="bx bx-cloud-upload fs-3"></i> Choose a
                        Category</button>
                </div>
            </div>
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
                        notify(response.status, response.message);
                        $('#addForm')[0].reset(); // Reset form
                        $('#editModal').modal('hide'); // Close modal
                        $('#dataTable').DataTable().ajax
                            .reload();
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
