<section id="header">
    <h3><strong>Apparel Ave.</strong></h3>
    <div>
      <ul id="navbar">
        <li><a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('shop') }}" class="{{ Route::is('shop') ? 'active' : '' }}">Shop</a></li>
        <li><a href="{{ route('blog') }}" class="{{ Route::is('blog') ? 'active' : '' }}">Blog</a></li>
        <li><a href="{{ route('about') }}" class="{{ Route::is('about') ? 'active' : '' }}">About</a></li>
        <li><a href="{{ route('contact') }}" class="{{ Route::is('contact') ? 'active' : ''}}">Contact</a></li>
        @guest
        <li><a href="{{ route('login.form') }}" class="{{ Route::is('login.form') ? 'active' : '' }}">Login</a></li>
        @endguest
     
        
        @auth()
        @role('customer')
          <li><a href="{{ route('customer.orders') }}" class="">Orders</a></li>
          <li id="lg-bag">
            <a href="{{ route('customer.cart') }}" class="{{ Route::is('customer.cart') ? 'active' : '' }}"><ion-icon name="bag-outline"></ion-icon></a>
          </li>
          <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
          <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
          </form>
        @endrole
        @role('admin')
          <li><a href="{{ route('admin.index') }}" class="">Admin Dashbaord</a></li>
        @endrole
        @endauth
        <a href="#" id="close"><i class="fas fa-times"></i></a>
      </ul>
    </div>
    <div id="mobile">
      <a href="{{ route('customer.cart') }}"><ion-icon name="bag-outline"></ion-icon></a>
      <i id="bar" class="fas fa-outdent"></i>
    </div>
  </section>