<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5>Edit Attribute Value</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive mt-3 mb-1">
            <form action="{{ route('attribute-values.update', $attributeValue->id) }}" class="dynamic-form" method="POST"
                id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div>
                        <div class="my-3">
                            <div>
                                <label for="value" class="form-label">Value<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="value" id="value"
                                    placeholder="Enter Category value" value="{{ $attributeValue->value }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light close-btn"
                                onclick="closeEditForm()"">Close</button>
                            <button type="submit" class="btn btn-success btn-load submit-btn">
                                <span class="submit-text">Submit</span>
                                <span class="d-flex align-items-center d-none loader">
                                    <span class="flex-grow-1 me-2">
                                        Submitting...
                                    </span>
                                    <span class="spinner-grow flex-shrink-0" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </form>
        </div>
    </div>
</div><!--end card-->


<script>
    $(document).ready(function() {
        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            // Show loader, hide submit button text
            $('.submit-text').addClass('d-none');
            $('.loader').removeClass('d-none');

            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    if (response.status === "success") {
                        $('.submit-text').removeClass('d-none');
                        $('.loader').addClass('d-none');
                        notify(response.status, response.message);
                        $('#addForm')[0].reset();

                        $('#dataTable').DataTable().ajax
                            .reload();
                        $('.close-btn').trigger('click');

                    }
                },
                error: function(xhr) {
                    $('.submit-text').removeClass('d-none');
                    $('.loader').addClass('d-none');

                    let errors = xhr.responseJSON.errors;
                    $(".text-danger").remove();
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
