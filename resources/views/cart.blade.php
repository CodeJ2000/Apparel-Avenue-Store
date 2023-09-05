<x-Base-Layout>
    <section id="page-header" class="about-header">
        <h2>#Let's_Checkout</h2>
        <p>Save more with coupons & up to 70% off!</p>
      </section>
      <section id="cart" class="section-p1">
        <table width="100%" id="cart-table">
          <thead>
            <tr>
              <td>Action</td>
              <td>Image</td>
              <td>Product</td>
              <td>Price</td>
              <td>Quantity</td>
              <td>Subtotal</td>
            </tr>
          </thead>
          <tbody id="tbody">
            @if (count($products->cartItems) === 0)
                <tr class="col-md-12">
                  <p class="text-center text-muted">No products to display!</p>
                </tr>
            @else 
                @foreach ($products->cartItems as $product)
                    <tr>
                      <td>
                        <a href="#" class="btn btn-danger"><i class="far fa-times-circle fa-1x"></i></a>
                        <a href="#" data-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary edit-button"><i class="fa-regular fa-pen-to-square fa-1x"></i></a>
                      </td>
                      <td><img src="../{{ $product->product->images->first()->image_url }}" alt="" /></td>
                      <td>{{ $product->product->name }}</td>
                      <td>{{ $product->product->price }}</td>
                      <td>{{ $product->quantity }}</td>
                      <td>{{ $product->total_price }}</td>
                    </tr>
                @endforeach
            @endif
          </tbody>
        </table>
      </section>
      <section id="cart-add" class="section-p1">
        <div id="coupon">
          <h3>Apply Coupon</h3>
          <div>
            <input type="text" placeholder="Enter Your Coupon" />
            <button class="normal">Apply</button>
          </div>
        </div>
        <div id="subtotal">
          <h3>Cart Totals</h3>
          <table>
            <tr>
              <td>Cart Subtotal</td>
              <td>{{ $products->calculatePrice->subTotal }}</td>
            </tr>
            <tr>
              <td>VAT-12%</td>
              <td>{{ $products->calculatePrice->totalWithTaxDeduction->calculatedTax }}</td>
            </tr>
            <tr>
              <td><strong>Total Amount</strong></td>
              <td><strong>{{ $products->calculatePrice->totalWithTaxDeduction->totalAmount }}</strong></td>
            </tr>
          </table>
          <button class="normal">Proceed to checkout</button>
        </div>
      </section>
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5 " id="exampleModalLabel"></h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <section id="prodetails" class="section-p1">
                <div class="single-pro-image">
                  <img src="" width="100%" id="MainImg" alt="" />
                  <div class="small-img-group">
                    <div class="small-img-col">
                      <img
                        src=""
                        width="100%"
                        class="small-img"
                        alt=""
                      />
                    </div>
                    <div class="small-img-col">
                      <img
                        src=""
                        width="100%"
                        class="small-img"
                        alt=""
                      />
                    </div>
                    <div class="small-img-col">
                      <img
                        src=""
                        width="100%"
                        class="small-img"
                        alt=""
                      />
                    </div>
                    <div class="small-img-col">
                      <img
                        src=""
                        width="100%"
                        class="small-img"
                        alt=""
                      />
                    </div>
                  </div>
                </div>
                <div class="single-pro-details">
                  <h6 id="category-name"></h6>
                  <h2 id="product-name">dsadsada</h2>
                  <form id="updateToCartForm" action="" method="POST">
                    @csrf
                    <input type="hidden" id="product-id" name="product_id" value="">
                    <select name="size_id" id="size">
                      <option selected="true" disabled >Select Size</option>
                      
                    </select>
                    <p>Stocks: <span id="stocks"></span></p>
                  <input type="number" value="1" min="1" name="quantity" id="quantity" max="" />
                  <button type="submit" class="normal" id="add-btn">Update Cart</button>  
                  </form>
                  
                </div>
              </section>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      @push('scripts')
      <script src="{{ asset('js/images-selection.js') }}"></script>
      <script src="{{ asset('admin/assets/js/jquery-ajax/dataTable.js') }}"></script>
        <script>
         
            $(document).ready(function(){
            
              // edit button for editing the product in the cart
              $('#cart-table').on('click', '.edit-button', function(e){
                e.preventDefault();  
                cartItemId = $(this).data('id'); //store cart item id
                console.log(cartItemId)
                let url = "{{ route('customer.cart.item.show', ':cartItem') }}"; //route  for showing single item

                //get the cart item data
                $.get(url.replace(':cartItem', cartItemId), function(cartItem){
                  console.log(cartItem) // console the cartitem data for debugging
                  
                  let product = cartItem.product; //store the product data from cartitem
                  let images = cartItem.product.images; //store images from cartitem product
                  let category = cartItem.product.category.name; //store the category name of the product
                  let sizeId = cartItem.size.id; //store the size id of the product in the cart                  

                  //dynamically put the cartitem data in the respected tags
                  $('#product-id').val(product.id);
                  $('#product-name').text(product.name);
                  $('#category-name').text(category);
                  $('#MainImg').attr('src', '../' + images[0].image_url)
                  
                  //loop the small image tags add images file in to the src
                  $('.small-img').each(function(index){
                    $(this).attr('src', '../' + images[index].image_url);
                  });

                  //get the size data
                  $.get("{{ route('get.sizes.json') }}", function(sizes){
                    sizes.forEach(function(size){
                      
                      //store the option tag with size value and text
                      let option = $('<option>',{
                        value: size.id,
                        text: size.name
                        });
                        $('#size').append(option); //append the option into the select tag
                        
                        if(size.id === sizeId){
                          option.attr('selected', 'selected');
                        }
                       
                    });//end of size loop

                    //loop product size and pass the stocks value in the stocks html tag
                    product.sizes.forEach(function(size){
                      if(size.id === sizeId){
                        $('#stocks').text(size.pivot.stocks);
                        $('#quantity').attr('max', size.pivot.stocks).val(cartItem.quantity);
                      
                      }
                    }); //end product sze loop

                    // size option on change
                   $('#size').on('change', function(){
                      let selectedSize = $(this).val();

                      //loop product size and check if empty stocks then pass the stocks value to stocks html tag, disabled the add to cart button
                      product.sizes.forEach(function(size){
                        if(selectedSize == size.id){
                          let stocksPerSize = size.pivot.stocks;
                          $('#stocks').text(size.pivot.stocks);
                          $('#quantity').attr('max', size.pivot.stocks);
                          if (stocksPerSize == "" || stocksPerSize == 0){
                            $('#add-btn').text('Out of stocks').prop('disabled', true);
                            $('#add-btn').addClass('bg-secondary');
                          } else {
                            $('#add-btn').text('Update Cart').prop('disabled', false);
                            $('#add-btn').removeClass('bg-secondary');
                          }
                        }
                      }); //end product size loop
                    }); //end size option on change
                  });// end of get size data
                }); //end of of get cart item data
                // Call the add function with necessary parameters
                add("", "#updateToCartForm", "{{ route('customer.product.add_cart') }}", 'Update to Cart',"")
              }); //end click edit button
            }); //end document ready
        </script>
      @endpush
</x-Base-Layout>