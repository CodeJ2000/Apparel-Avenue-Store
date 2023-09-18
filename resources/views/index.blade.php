<x-Base-Layout>
       <!-- Hero section -->
       <section id="hero">
        <h4>Elevate Your Style, Embrace Your Uniqueness.</h4>
        <h2>Jomar Shop Wear</h2>
        <h1>Elevate your styles</h1>
        <p>Experience Fashion That Goes Beyond Trends. Express Yourself.</p>
      </section>
      <!-- End Hero section -->
      <!-- Feature section -->
      <section id="feature" class="section-p1">
        <div class="fe-box">
          <img src="{{ asset('images/features/f1.png') }}" alt="" />
          <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
          <img src="{{ asset('images/features/f2.png') }}" alt="" />
          <h6>Online Order</h6>
        </div>
        <div class="fe-box">
          <img src="{{ asset('images/features/f3.png') }}" alt="" />
          <h6>Save Money</h6>
        </div>
        <div class="fe-box">
          <img src="{{ asset('images/features/f4.png') }}" alt="" />
          <h6>Promotions</h6>
        </div>
        <div class="fe-box">
          <img src="{{ asset('images/features/f5.png') }}" alt="" />
          <h6>Happy Sell</h6>
        </div>
        <div class="fe-box">
          <img src="{{ asset('images/features/f6.png') }}" alt="" />
          <h6>F24/7 Support</h6>
        </div>
      </section>
      <!--End Feature section -->
      <!-- Project1 section -->
      <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
          @if (count($featuredProducts) === 0)
            <div class="col-md-12">
              <p class="h3 text-muted text-center justify-content-center">No featured products avaiable!</p>
            </div>
          @else
              @foreach ($featuredProducts as $featuredProduct)
              <x-partials.productCard
              name="{{ $featuredProduct->name }}"
              image="{{ $featuredProduct->images->first()->image_url }}"
              category="{{ $featuredProduct->category->name }}"
              price="{{ $featuredProduct->price }}"
              description="{{ $featuredProduct->description }}"
              url="{{ route('single.product', $featuredProduct) }}"
              />
              @endforeach
          @endif
        </div>
      </section>
      <!--End Project1 section -->
      <!-- Banner section -->
      <section id="banner" class="section-m1">
        <h4>Repair Services</h4>
        <h2>Up to <span>70% off</span> - All t-shirts & Accessories</h2>
        <button class="normal">Explore More</button>
      </section>
      <!--End Banner section -->
      <!-- Product2 section -->
      <section id="product1" class="section-p1">
        <h2>New Arrivals</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
          @if (count($newArrivalProducts) === 0)
          <div class="col-md-12">
            <p class="h3 text-muted text-center justify-content-center">No new products arival!</p>
          </div>
        @else
            @foreach ($newArrivalProducts as $newArrivalProduct)
              <x-partials.product-card
                name="{{ $newArrivalProduct->name }}"
                image="{{ $newArrivalProduct->images->first()->image_url }}"
                category="{{ $newArrivalProduct->category->name }}"
                price="{{ $newArrivalProduct->price }}"
                description="{{ $newArrivalProduct->description }}"
                url="{{ route('single.product', $newArrivalProduct) }}"
              />
            @endforeach
        @endif
        </div>
      </section>
      <!-- End product2 section -->
      <!-- banner2 section -->
      <section id="sm-banner" class="section-p1">
        <div class="banner-box">
          <h4>crazy deals</h4>
          <h2>buy 1 get free</h2>
          <span>The best classic dress is on sale at cara</span>
          <button class="white">Learn More</button>
        </div>
        <div class="banner-box banner-box2">
          <h4>spring/summer</h4>
          <h2>upcomming season</h2>
          <span>The best classic dress is on sale at cara</span>
          <button class="white">Collection</button>
        </div>
      </section>
      <!--End banner2 section -->
      <!-- Banner3 section -->
      <section id="banner3">
        <div class="banner-box">
          <h2>SEASONAL SALE</h2>
          <h3>Winter Collection -50% OFF</h3>
        </div>
        <div class="banner-box banner2">
          <h2>SEASONAL SALE</h2>
          <h3>Winter Collection -50% OFF</h3>
        </div>
        <div class="banner-box banner3">
          <h2>SEASONAL SALE</h2>
          <h3>Winter Collection -50% OFF</h3>
        </div>
      </section>
      <!--End Banner3 section -->
      <!-- Newsletter section -->
      <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
          <h4>Sign up and order now to get latest and high quality products</h4>
          <p>
            Order now in our latest shop and
            <span>special offers.</span>
          </p>
        </div>
      </section>
</x-Base-Layout>