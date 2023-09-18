<x-Base-Layout>
    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
          <img src="../{{ $product->images[0]->image_url }}" width="100%" id="MainImg" alt="" />
          <div class="small-img-group">
            <div class="small-img-col">
              <img
                src="../{{ $product->images[0]->image_url }}"
                width="100%"
                class="small-img"
                alt=""
              />
            </div>
            <div class="small-img-col">
              <img
                src="../{{ $product->images[1]->image_url }}"
                width="100%"
                class="small-img"
                alt=""
              />
            </div>
            <div class="small-img-col">
              <img
                src="../{{ $product->images[2]->image_url }}"
                width="100%"
                class="small-img"
                alt=""
              />
            </div>
            <div class="small-img-col">
              <img
                src="../{{ $product->images[3]->image_url }}"
                width="100%"
                class="small-img"
                alt=""
              />
            </div>
          </div>
        </div>
        <div class="single-pro-details">
          <h6>{{ $product->category->name }}</h6>
          <h4>{{ $product->name }}</h4>
          <h2>{{ $product->price }}</h2>
          <form id="addToCartForm" action="" method="POST">
            @csrf
              <input type="hidden" id="product-id" name="product_id" value="{{ $product->id }}">
              <select name="size_id" id="sizes">
                <option selected="true" disabled >Select Size</option>
                
              </select>
              <p>Stocks: <span id="stocks">{{ $product->stocks }}</span></p>
            <input type="number" value="1" min="1" name="quantity" id="qty" max="" />
            <button type="submit" class="normal {{ $product->stocks === 0 ? 'bg-secondary' : '' }}" {{ $product->stocks === 0 ?  'disabled' : ''}} id="add-cart-btn">{{ $product->stocks === 0 ? 'Out of Stock' : 'Add to Cart' }}</button>
          </form>
            
          <h4>Product Details</h4>
          <span>{{ $product->description }}</span>
        </div>
      </section>
      <!-- Product 1 section -->
      <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
          @if (count($newProducts) === 0)
          <div class="col-md-12">
            <p class="h3 text-muted text-center justify-content-center">No new products arival!</p>
          </div>
        @else
            @foreach ($newProducts as $newArrivalProduct)
              <x-partials.product-card
                name="{{ $newArrivalProduct->name }}"
                image="../{{ $newArrivalProduct->images->first()->image_url }}"
                category="{{ $newArrivalProduct->category->name }}"
                price="{{ $newArrivalProduct->price }}"
                description="{{ $newArrivalProduct->description }}"
                url="{{ route('single.product', $newArrivalProduct) }}"
              />
            @endforeach
        @endif          
        </div>
      </section>
      <!-- End of product 1 section -->
      @push('scripts')
      <script src="{{ asset('js/images-selection.js') }}"></script>
      <script src="{{ asset('admin/assets/js/jquery-ajax/dataTable.js') }}"></script>
      <script>
        $(document).ready(function(){
          // Get the select element for sizes
          const selectSizes = $('#sizes');
          $('#qty').on('input', function(){
            let sizeVal = $(this).val();
                  if(sizeVal.trim() === '' || isNaN(sizeVal)){
                    $(this).val(1)
                }
          });
          // Fetch available sizes and populate the select dropdown
          $.get("{{ route('get.sizes.json') }}", function(sizes){
            sizes.forEach(function(size){
              selectSizes.append(
                  $('<option>', {
                      value: size.id,
                      text: size.name

                  })
              );
            });
          });

          // Get the currently selected option and update the button state accordingly
          const selectedOption = $('option:selected', this);
            if(selectedOption.attr('disabled')){
              $('#add-cart-btn').text('Select size').addClass('bg-secondary').prop('disabled', true);
            } else {
              $('#add-cart-btn').text('Add to cart').removeClass('bg-secondary').prop('disabled', true);
            }

          // Attach an event handler to the size select dropdown
          selectSizes.on('change', function(){
            let productId = "{{ $product->id }}";
            const selectedSize = $(this).val();
            
            // Reset button text and fetch stock information
            $('add-cart-btn').text('Add to Cart');  
            $.ajax({
                url: "{{ route('stocks.get', ['product' => ':product', 'size' => ':size']) }}"
                    .replace(':product', productId)
                    .replace(':size', selectedSize),
                type: 'GET',
                success: function(response){
                  $('#stocks').text(response);
                  $('#qty').attr('max', response);
                  $('#add-cart-btn').removeClass('bg-secondary');
                  $('#add-cart-btn').text('Add to Cart').prop('disabled', false);
                  
                  // Disable button if stock is zero
                  if(response === 0){
                    $('#add-cart-btn').text('Out of stocks').prop('disabled', true);
                    $('#add-cart-btn').addClass('bg-secondary');
                  } 
                  
                },
                error: function(xhr){
                  console.log('error stocks');
                }
              });
          });

        // add to cart 
        add("", "", "#addToCartForm", "{{ route('customer.product.add_cart') }}", "#add-cart-btn",'Add to Cart',"")

        });
        
      </script>
      @endpush
</x-Base-Layout>