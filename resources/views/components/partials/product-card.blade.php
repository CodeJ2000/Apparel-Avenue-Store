<div class="pro" onclick="window.location.href='{{ $url }}'">
    <img src="{{ $image }}" alt="product image" />
    <div class="des">
      <span>{{ $category }}</span>
      <h5>{{ $name }}</h5>
      <div class="star">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
      </div>
      <h4>{{ $price }}</h4>
    </div>
    <a href="#"><ion-icon class="cart" name="cart-outline"></ion-icon></a>
</div>