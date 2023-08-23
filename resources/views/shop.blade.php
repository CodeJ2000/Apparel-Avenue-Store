<x-Base-Layout>
    <section id="page-header">
        <h2>#stayhome</h2>
        <p>Save more with coupons & up to 70% off!</p>
      </section>
      <!-- End Hero section -->
        <!-- Project1 section -->
      <section id="product1" class="section-p1">
        <div class="pro-container">
          @if (count($products) === 0)
          <div class="col-md-12">
            <p class="text-center text-muted h3">No products available!</p>
          </div>
          @else
          @foreach ($products as $product)
          <x-partials.productCard
              name="{{ $product->name }}"
              description="{{ $product->description }}"
              price="{{ $product->price }}"
              category="{{ $product->category->name }}"
              image="{{ $product->images->first()->image_url }}"
              url="{{ route('single.product', $product) }}"
            />
          @endforeach
          @endif
        </div>
      </section>
      <!-- End product2 section -->
      <!-- Pagination section -->
      <section id="pagination" class="section-p1">
       {{ $products->links() }}
      </section>
      <!--End Pagination section -->
</x-Base-Layout>