@php
    use App\Helpers\ImageUploadHelper;
@endphp
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
                    <h6 class="product__item__title"><a href="#">{{ Str::limit($product->name, 15) }}</a>
                    </h6><!-- /.product-title -->
                    <div class="product__item__price">{{ env('CURRENCY_SYMBOL') }}{{ $product->price }}</div>
                    <!-- /.product-price -->
                    <a href="#" class="floens-btn product__item__link py-3">
                        <span>Add to Cart</span>
                        <i class="icon-cart"></i>
                    </a>
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
