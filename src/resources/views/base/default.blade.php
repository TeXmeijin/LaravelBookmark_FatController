<!DOCTYPE html>
<html lang="ja">
@include('base.layout.head')

<body>
<main class="all-main">
    @include('base.layout.header')
    @yield('content')
    @include('base.layout.footer')
</main>
</body>

</html>
