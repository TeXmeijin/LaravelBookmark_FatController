<head prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/fb# website: https://ogp.me/ns/website#">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {!! SEO::generate() !!}

    <script>
        if ((navigator.userAgent.indexOf('iPhone') > 0) || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent
            .indexOf('Android') > 0) {
            document.write('<meta name="viewport" content="width=device-width, initial-scale=1">');
        } else {
            document.write('<meta name="viewport" content="width=1400">');
        }
    </script>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('page_css')
    @yield('page_javascript')
</head>