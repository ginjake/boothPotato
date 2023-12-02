<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head prefix="og: http://ogp.me/ns#">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'potato') }}</title>
    <meta name="description" content="BOOTHの欲しいモノを簡単に共有できるサイトです。VRChat、cluster、NeosVR用のアバターや衣装にどうぞ。">
    <meta name="keywords" content="pixiv,BOOTH,VRChat,NeosVR,cluster,3Dモデル,アバター,衣装">
    <meta charset="utf-8">
    <meta property="og:title" content="booth欲しいモノ共有 potato" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:image" content="{{ asset(('images/ogp.png')) }}" />
    <meta property="og:site_name" content="potato" />
    <meta property="og:description" content="BOOTHの欲しいモノを簡単に共有できるサイトです" />
    <meta name="twitter:card" content="summary_large_image">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HEMBSXG019"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-HEMBSXG019');
    </script>

</head>
<body>
    <div id="app">
        @include("layouts/components/header")
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
