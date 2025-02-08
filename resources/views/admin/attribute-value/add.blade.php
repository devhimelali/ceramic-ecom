<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5>Add New Attribute Value</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive mt-3 mb-1">
            <form action="{{ route('attribute-values.store') }}" class="dynamic-form" method="POST" id="addForm"
                enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div>
                        <div class="my-3">
                            <div>
                                <label for="value" class="form-label">Value<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="value" id="value"
                                    placeholder="Enter Attribute Value" value="{{ old('value') }}">
                                <input type="hidden" name="attribute_id" value="{{ $attribute->id }}" id="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary btn-load submit-btn">
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
