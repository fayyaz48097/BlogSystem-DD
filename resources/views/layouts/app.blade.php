<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.header')

    @stack('styles')
</head>

<body>
    @include('components.navigation')

    <main class="container mt-5">
        @yield('content')

        @include('components.footer')
    </main>

    @include('components.script')
    @stack('scripts')
</body>

</html>
