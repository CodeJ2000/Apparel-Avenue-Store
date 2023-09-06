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
                        <a href="#" data-id="{{ $product->id }}" class="btn btn-danger delete-button"><i class="far fa-times-circle fa-1x"></i></a>
                        <a href="#" data-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#edit-product-modal" class="btn btn-primary edit-button"><i class="fa-regular fa-pen-to-square fa-1x"></i></a>
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
              <td>{{ $products->calculatePrice->totalWithTaxAdded->calculatedTax }}</td>
            </tr>
            <tr>
              <td><strong>Total Amount</strong></td>
              <td><strong>{{ $products->calculatePrice->totalWithTaxAdded->totalAmount }}</strong></td>
            </tr>
          </table>
          <button class="normal">Proceed to checkout</button>
        </div>
      </section>
      <div class="modal fade" id="edit-product-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
      <script src="{{ asset('js/cart.js') }}"></script>
      <script>
         
            $(document).ready(function(){

              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              // edit button for editing the product in the cart
              $('#cart-table').on('click', '.edit-button', function(e){
                e.preventDefault();  
                cartItemId = $(this).data('id'); //store cart item id
                let cartItemShowUrl = "{{ route('customer.cart.item.show', ':cartItem') }}"; //route  for showing single item
                const addUrl = "{{ route('customer.product.add_cart') }}"; //route for update the product in the cart
                const sizeUrl = "{{ route('get.sizes.json') }}"; // route for getting the size data

                //update the cart item
                updateCartItem(cartItemShowUrl, addUrl, sizeUrl);
              }); //end click edit button

              deleteData('#cart-table', "{{ route('customer.cart.item.destroy', ':id') }}")
            }); //end document ready
        </script>
      @endpush
</x-Base-Layout>