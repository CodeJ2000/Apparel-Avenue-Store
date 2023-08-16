<!DOCTYPE html>
<html lang="en">
<head>
    {{-- head --}}
    <x-partials._head/>
    @stack('styles')
    {{-- /head --}}
</head>
<body>
    {{-- navbar --}}
    <x-partials._nav/>
    {{-- /navbar --}}

    {{-- body --}}
    {{ $slot }}
    {{-- /body --}}

    {{-- footer --}}
    <x-partials._footer/>
    @stack('scripts')
    {{-- /footer     --}}
</body>
</html>