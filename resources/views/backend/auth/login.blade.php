<!DOCTYPE html>

<html class="no-js linen" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>{{ config('app.name', 'Login: Painel Administrativo') }}</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- http://davidbcalhoun.com/2010/viewport-metatag -->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    <!-- http://www.kylejlarson.com/blog/2012/iphone-5-web-design/ e http://darkforge.blogspot.fr/2010/05/customize-android-browser-scaling-with.html -->
    <meta name="viewport" content="user-scalable=0, initial-scale=1.0, target-densitydpi=115">

    <!-- Login pages styles -->
    <link rel="stylesheet" media="screen" href="{{url('backend/css/login.min.css')}}">

    <!-- modernizr -->
    <script src="{{url('backend/js/libs/modernizr.custom.js')}}"></script>

    <!-- For Modern Browsers -->
    <link rel="shortcut icon" href="{{url('backend/img/favicons/favicon.png')}}">
    <!-- For everything else -->
    <link rel="shortcut icon" href="{{url('backend/img/favicons/favicon.ico')}}">

    <!-- iOS web-app metas -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- iPhone ICON -->
    <link rel="apple-touch-icon" href="{{url('backend/img/favicons/apple-touch-icon.png')}}" sizes="57x57">
    <!-- iPad ICON -->
    <link rel="apple-touch-icon" href="{{url('backend/img/favicons/apple-touch-icon-ipad.png')}}" sizes="72x72">
    <!-- iPhone (Retina) ICON -->
    <link rel="apple-touch-icon" href="{{url('backend/img/favicons/apple-touch-icon-retina.png')}}" sizes="114x114">
    <!-- iPad (Retina) ICON -->
    <link rel="apple-touch-icon" href="{{url('backend/img/favicons/apple-touch-icon-ipad-retina.png')}}" sizes="144x144">

    <!-- iPhone SPLASHSCREEN (320x460) -->
    <link rel="apple-touch-startup-image" href="{{url('backend/img/splash/iphone.png')}}" media="(device-width: 320px)">
    <!-- iPhone (Retina) SPLASHSCREEN (640x960) -->
    <link rel="apple-touch-startup-image" href="{{url('backend/img/splash/iphone-retina.png')}}" media="(device-width: 320px) and (-webkit-device-pixel-ratio: 2)">
    <!-- iPhone 5 SPLASHSCREEN (640�1096) -->
    <link rel="apple-touch-startup-image" href="{{url('backend/img/splash/iphone5.png')}}" media="(device-height: 568px) and (-webkit-device-pixel-ratio: 2)">
    <!-- iPad (portrait) SPLASHSCREEN (748x1024) -->
    <link rel="apple-touch-startup-image" href="{{url('backend/img/splash/ipad-portrait.png')}}" media="(device-width: 768px) and (orientation: portrait)">
    <!-- iPad (landscape) SPLASHSCREEN (768x1004) -->
    <link rel="apple-touch-startup-image" href="{{url('backend/img/splash/ipad-landscape.png')}}" media="(device-width: 768px) and (orientation: landscape)">
    <!-- iPad (Retina, portrait) SPLASHSCREEN (2048x1496) -->
    <link rel="apple-touch-startup-image" href="{{url('backend/img/splash/ipad-portrait-retina.png')}}" media="(device-width: 1536px) and (orientation: portrait) and (-webkit-min-device-pixel-ratio: 2)">
    <!-- iPad (Retina, landscape) SPLASHSCREEN (1536x2008) -->
    <link rel="apple-touch-startup-image" href="{{url('backend/img/splash/ipad-landscape-retina.png')}}" media="(device-width: 1536px)  and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 2)">

    <!-- Microsoft clear type rendering -->
    <meta http-equiv="cleartype" content="on">
</head>

<body>

<div id="container">

    <hgroup id="login-title" class="large-margin-bottom">
        <h1 class="login-title-image">{{constLang('company')}}</h1>
        <h5>{{constLang('copy')}}</h5>
    </hgroup>

    <div id="form-block" class="scratch-metal">
        <form method="post" action="{{route('admin.login')}}" id="form-login" class="input-wrapper blue-gradient glossy" title="Login">
            @csrf
            <input type="hidden" name="ajax" value="1">
            <ul class="inputs black-input large">
                <!-- The autocomplete="off" attributes is the only way to prevent webkit browsers from filling the inputs with yellow -->
                <li><span class="icon-user mid-margin-right"></span><input type="text" name="login" id="login" value="" class="input-unstyled" placeholder="Login" autocomplete="off"></li>
                <li><span class="icon-lock mid-margin-right"></span><input type="password" name="password" id="pass" value="" class="input-unstyled" placeholder="Password" autocomplete="off"></li>
            </ul>

            <p class="button-height">
                <button type="submit" class="button glossy float-right">{{constLang('login')}}</button>
                <input type="checkbox" name="remember" id="remember" class="switch tiny mid-margin-right with-tooltip" title="{{constLang('login')}}">
                <label for="remind">{{constLang('reminder')}}</label>
            </p>
        </form>
    </div>

</div>
<!-- Validation -->

<script>
    var loginValidation = {!! json_encode([
        'login_required' => constLang('validation.login.required'),
        'login_min' => constLang('validation.login.min'),
        'login_max' => constLang('validation.login.max'),
        'password_required' => constLang('validation.password.required'),
        'password_min' => constLang('validation.password.min'),
        'password_max' => constLang('validation.password.max'),
        'verifying_credentials' => constLang('validation.verifying_credentials'),
        'error_server' => constLang('error.server'),
    ]) !!};
</script>

<!-- Scripts -->
<script src="{{url('backend/js/libs/jquery/jquery.min.js')}}"></script>
<script src="{{url('backend/js/login.min.js')}}"></script>
<script src="http://www.avdesign.com.br/painel/mensagens/login.js"></script>


</body>
</html>