<x-Base-Layout>
    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
          <img src="../{{ $product->images[0]->image_url }}" width="100%" id="MainImg" alt="" />
          <div class="small-img-group">
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
            <div class="small-img-col">
              <img
                src="{{ asset('images/products/f4.jpg') }}"
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
              <select name="sizes" id="sizes">
                <option selected="true" disabled="disabled">Select Size</option>
                
              </select>
              <p>Stocks: <span id="stocks">{{ $product->stocks }}</span></p>
            <input type="number" value="1" id="qty" max="" />
            <button class="normal {{ $product->stocks === 0 ? 'bg-secondary' : '' }}" {{ $product->stocks === 0 ?  'disabled' : ''}} id="cart-btn">{{ $product->stocks === 0 ? 'Out of Stock' : 'Add to Cart' }}</button>
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
      <script>
        $(document).ready(function(){
          const selectSizes = $('#sizes');
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
          selectSizes.on('change', function(){
            productId = "{{ $product->id }}";
            const selectedSize = $(this).val();
            $('cart-btn').text('Add to Cart');  
            $.ajax({
                url: "{{ route('stocks.get', ['product' => ':product', 'size' => ':size']) }}"
                    .replace(':product', productId)
                    .replace(':size', selectedSize),
                type: 'GET',
                success: function(response){
                  console.log(response);
                  $('#stocks').text(response);
                  $('#qty').attr('max', response);
                  $('#cart-btn').text('Add to Cart');
                  $('#cart-btn').removeClass('bg-secondary');

                  if(response === 0){
                    $('#cart-btn').text('Out of stocks').prop('disabled', true);
                    $('#cart-btn').addClass('bg-secondary');
                  } 
                  
                },
                error: function(xhr){
                  console.log('error stocks');
                }
              });
          });

          $('#cart-btn').submit(function(e){
            e.preventDefault();
            console.log('clicked');
          });
        });
        
      </script>
      @endpush
</x-Base-Layout>