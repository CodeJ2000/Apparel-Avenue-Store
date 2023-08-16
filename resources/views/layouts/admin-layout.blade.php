<!DOCTYPE html>
<html lang="en">
<head>
    <x-partials.admin._head/>
    @stack('styles')
</head>
<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <x-partials.admin._side_nav/>
    <main class="main-content position-relative border-radius-lg ">
        <x-partials.admin._nav/>
        <div class="container-fluid py-4">
            {{ $slot }}
            <!-- footer -->
            <x-partials.admin._footer/>
          </div>
    </main>
    <x-partials.admin._scripts/>
    @stack('scripts')
</body>
</html>