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
            <input type="number" value="1" name="quantity" id="qty" max="" />
            <button type="submit" class="normal {{ $product->stocks === 0 ? 'bg-secondary' : '' }}" {{ $product->stocks === 0 ?  'disabled' : ''}} id="add-btn">{{ $product->stocks === 0 ? 'Out of Stock' : 'Add to Cart' }}</button>
          </form>
            
          <h4>Product Details</h4>
          <span
            >Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse modi ut
            suscipit quis rerum harum impedit maiores nam, alias, labore culpa
            cupiditate accusantium non distinctio rem mollitia quam, quidem nisi
            voluptatibus minima sit tempora sunt. Facere iste doloremque inventore
            dolorem sunt, dolor maxime. Vero repudiandae voluptas provident
            sapiente, officia delectus?</span
          >
        </div>
      </section>
      <!-- Product 1 section -->
      <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
          <div class="pro">
            <img src="{{ asset('images/products/f1.jpg') }}" alt="" />
            <div class="des">
              <span>adidas</span>
              <h5>Cartoon Astronaut T-Shirts</h5>
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
              <h4>$178</h4>
            </div>
            <a href="#"><ion-icon class="cart" name="cart-outline"></ion-icon></a>
          </div>
          <div class="pro">
            <img src="{{ asset('images/products/f1.jpg') }}" alt="" />
            <div class="des">
              <span>adidas</span>
              <h5>Cartoon Astronaut T-Shirts</h5>
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
              <h4>$178</h4>
            </div>
            <a href="#"><ion-icon class="cart" name="cart-outline"></ion-icon></a>
          </div>
          <div class="pro">
            <img src="{{ asset('images/products/f2.jpg') }}" alt="" />
            <div class="des">
              <span>adidas</span>
              <h5>Cartoon Astronaut T-Shirts</h5>
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
              <h4>$178</h4>
            </div>
            <a href="#"><ion-icon class="cart" name="cart-outline"></ion-icon></a>
          </div>
          <div class="pro">
            <img src="{{ asset('images/products/f3.jpg') }}" alt="" />
            <div class="des">
              <span>adidas</span>
              <h5>Cartoon Astronaut T-Shirts</h5>
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
              <h4>$178</h4>
            </div>
            <a href="#"><ion-icon class="cart" name="cart-outline"></ion-icon></a>
          </div>
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
              $('#add-btn').text('Select size').addClass('bg-secondary').prop('disabled', true);
            } else {
              $('#add-btn').text('Add to cart').removeClass('bg-secondary').prop('disabled', true);
            }

          // Attach an event handler to the size select dropdown
          selectSizes.on('change', function(){
            let productId = "{{ $product->id }}";
            const selectedSize = $(this).val();
            
            // Reset button text and fetch stock information
            $('add-btn').text('Add to Cart');  
            $.ajax({
                url: "{{ route('stocks.get', ['product' => ':product', 'size' => ':size']) }}"
                    .replace(':product', productId)
                    .replace(':size', selectedSize),
                type: 'GET',
                success: function(response){
                  $('#stocks').text(response);
                  $('#qty').attr('max', response);
                  $('#add-btn').removeClass('bg-secondary');
                  $('#add-btn').text('Add to Cart').prop('disabled', false);
                  
                  // Disable button if stock is zero
                  if(response === 0){
                    $('#add-btn').text('Out of stocks').prop('disabled', true);
                    $('#add-btn').addClass('bg-secondary');
                  } 
                  
                },
                error: function(xhr){
                  console.log('error stocks');
                }
              });
          });

        // Call the add function with necessary parameters
        add("", "#addToCartForm", "{{ route('customer.product.add_cart') }}", 'Add to Cart',"")

        });
        
      </script>
      @endpush
</x-Base-Layout>