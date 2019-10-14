<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>@yield('title')</title>
    <meta name="description" content="{{constLang('description_painel')}}">
    <meta name="author" content="{{constLang('author_name')}}">

    <!-- http://davidbcalhoun.com/2010/viewport-metatag -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Webfonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>


    <!-- Error pages styles -->
    <link rel="stylesheet" media="screen" href="{{url('backend/css/error.min.css')}}?v=1">


    <!-- JavaScript at bottom except for Modernizr -->
    <script src="{{url('backend/js/libs/modernizr.custom.js')}}"></script>


    <!-- For Modern Browsers -->
    <link rel="shortcut icon" href="{{url('backend/img/favicons/favicon.png')}}">
    <!-- For everything else -->
    <link rel="shortcut icon" href="{{url('backend/img/favicons/favicon.ico')}}">
    <!-- For retina screens -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{url('backend/img/favicons/apple-touch-icon-retina.png')}}">
    <!-- For iPad 1-->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{url('backend/img/favicons/apple-touch-icon-ipad.png')}}">
    <!-- For iPhone 3G, iPod Touch and Android -->
    <link rel="apple-touch-icon-precomposed" href="{{url('backend/img/favicons/apple-touch-icon.png')}}">


    <!-- Microsoft clear type rendering -->
    <meta http-equiv="cleartype" content="on">
</head>
<body class="clearfix">
<div id="container">
    <div id="form-block" class="scratch-metal">
        <h1> @yield('code')</h1>
        <h2>@yield('message')</h2>
    </div>
    <button class="button huge anthracite-gradient glossy full-width" id="button" onclick="window.history.back();">@yield('redirect')</button>

</div>

<!-- Scripts -->
<script src="{{url('backend/js/error.min.js')}}"></script>
</body>
</html>