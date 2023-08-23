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
          <select>
            <option selected="true" disabled="disabled">Select Size</option>
            <option value="">XL</option>
            <option value="">XXL</option>
            <option value="">Small</option>
            <option value="">Large</option>
          </select>
          <input type="number" value="1" />
          <button class="normal">Add to Cart</button>
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
      <script>
        const mainImage = document.getElementById("MainImg");
        const smallImg = document.getElementsByClassName("small-img");
  
        smallImg[0].onclick = function () {
          mainImage.src = smallImg[0].src;
        };
  
        smallImg[1].onclick = function () {
          mainImage.src = smallImg[1].src;
        };
  
        smallImg[2].onclick = function () {
          mainImage.src = smallImg[2].src;
        };
  
        smallImg[3].onclick = function () {
          mainImage.src = smallImg[3].src;
        };
      </script>
      @endpush
</x-Base-Layout>