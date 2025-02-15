@php
    use App\Helpers\ImageUploadHelper;
@endphp
<style>
    /* Style the submit button */
    .custom-button {
        /* width: 100%; */
        padding: 10px;
        border: none;
        background: var(--floens-base, #C7844F);
        color: white;
        font-size: 16px;
        cursor: pointer;
    }

    .custom-button:hover {
        background: #9a6e4b;
    }

    .enquireBtn {
        width: 70%;
    }
</style>
<div class="row gutter-y-30">
    @forelse ($products as $product)
        <div class="col-xl-4 col-lg-6 col-md-6 ">
            <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                <div class="product__item__image">
                    @php
                        $images = $product->images->where('type', 'thumbnail')->first();
                    @endphp
                    <img src="{{ ImageUploadHelper::getProductImageUrl($images?->image) }}" alt="Natural Stone Tiles">
                </div><!-- /.product-image -->
                <div class="product__item__content">
                    <h6 class="product__item__title"><a
                            href="{{ route('product.details', $product->slug) }}">{{ Str::limit($product->name, 15) }}</a>
                    </h6><!-- /.product-title -->
                    <div class="product__item__price">{{ env('CURRENCY_SYMBOL') }}{{ $product->price }}</div>
                    <!-- /.product-price -->
                    {{-- <a href="#" class="floens-btn product__item__link py-3">
                        <span>Add to Cart</span>
                        <i class="icon-cart"></i>
                    </a> --}}

                    <div class="d-flex align-items-center justify-content-center">
                        <a href="javascript:void(0);"
                            class="floens-btn product__item__link me-2 custom-button p-3 enquireBtn"
                            data-id="{{ $product->id }}">Enquire</a>

                        <a href="" class="floens-btn product__item__link me-2 custom-button p-4">
                            <i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i></a>
                    </div>
                </div><!-- /.product-content -->
            </div><!-- /.product-item -->
        </div><!-- /.col-md-6 col-lg-4 -->
    @empty
        <div class="no-products-message">
            <h2 class="text-center text-danger my-auto">No products found</h2>
        </div>
    @endforelse
</div><!-- /.row -->
<div class="mt-5">
    <div class="d-flex justify-content-center mt-4" id="pagination-wrapper">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.enquireBtn').click(function() {
            var productId = $(this).data('id');
            // console.log(productId);
            $('#enquireForm').find('input[name="products[]"]').val(productId);
            $('#myModal').modal('show');
        });

        $('#enquireForm').submit(function(e) {
            e.preventDefault();
            var formData = $('#enquireForm').serialize();
            // console.log(formData);
            $.ajax({
                url: "{{ route('enquire') }}",
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.enquireSubmitBtn').prop('disabled', true);
                    $('.enquireSubmitBtn').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                    );
                },
                success: function(response) {
                    $('.enquireSubmitBtn').prop('disabled', false);
                    $('.enquireSubmitBtn').html('Submit');
                    if (response.status == 'success') {
                        notify(response.status, response.message);
                        $('#enquireForm')[0].reset();
                        $('#myModal').modal('hide');
                    }

                },
                error: function(xhr, status, error) {
                    $('.enquireSubmitBtn').prop('disabled', false);
                    $('.enquireSubmitBtn').html('Submit');
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            let inputField = $('[name="' + key + '"]');
                            inputField.addClass('is-invalid');
                            notify('error', value[0]);
                        });
                    }
                }
            });
        });
    });
</script>
