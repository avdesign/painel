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

    <!-- For all browsers -->
    <link rel="stylesheet" href="{{url('assets/backend/css/reset.css')}}">
    <link rel="stylesheet" href="{{url('assets/backend/css/style.css')}}">
    <link rel="stylesheet" href="{{url('assets/backend/css/colors.css')}}">
    <link rel="stylesheet" media="print" href="{{url('assets/backend/css/print.css')}}">
    <!-- For progressively larger displays -->
    <link rel="stylesheet" media="only all and (min-width: 480px)" href="{{url('assets/backend/css/480.css')}}">
    <link rel="stylesheet" media="only all and (min-width: 768px)" href="{{url('assets/backend/css/768.css')}}">
    <link rel="stylesheet" media="only all and (min-width: 992px)" href="{{url('assets/backend/css/992.css')}}">
    <link rel="stylesheet" media="only all and (min-width: 1200px)" href="{{url('assets/backend/css/1200.css')}}">
    <!-- For Retina displays -->
    <link rel="stylesheet" media="only all and (-webkit-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5)" href="{{url('assets/backend/css/2x.css')}}">

    <!-- Additional styles -->
    <link rel="stylesheet" href="{{url('assets/backend/css/styles/form.css')}}">
    <link rel="stylesheet" href="{{url('assets/backend/css/styles/switches.css')}}">

    <!-- Login pages styles -->
    <link rel="stylesheet" media="screen" href="{{url('assets/backend/css/login.css')}}">

    <!-- modernizr -->
    <script src="{{url('assets/backend/js/libs/modernizr.custom.js')}}"></script>

    <!-- For Modern Browsers -->
    <link rel="shortcut icon" href="{{url('assets/backend/img/favicons/favicon.png')}}">
    <!-- For everything else -->
    <link rel="shortcut icon" href="{{url('assets/backend/img/favicons/favicon.ico')}}">

    <!-- iOS web-app metas -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- iPhone ICON -->
    <link rel="apple-touch-icon" href="{{url('assets/backend/img/favicons/apple-touch-icon.png')}}" sizes="57x57">
    <!-- iPad ICON -->
    <link rel="apple-touch-icon" href="{{url('assets/backend/img/favicons/apple-touch-icon-ipad.png')}}" sizes="72x72">
    <!-- iPhone (Retina) ICON -->
    <link rel="apple-touch-icon" href="{{url('assets/backend/img/favicons/apple-touch-icon-retina.png')}}" sizes="114x114">
    <!-- iPad (Retina) ICON -->
    <link rel="apple-touch-icon" href="{{url('assets/backend/img/favicons/apple-touch-icon-ipad-retina.png')}}" sizes="144x144">

    <!-- iPhone SPLASHSCREEN (320x460) -->
    <link rel="apple-touch-startup-image" href="{{url('assets/backend/img/splash/iphone.png')}}" media="(device-width: 320px)">
    <!-- iPhone (Retina) SPLASHSCREEN (640x960) -->
    <link rel="apple-touch-startup-image" href="{{url('assets/backend/img/splash/iphone-retina.png')}}" media="(device-width: 320px) and (-webkit-device-pixel-ratio: 2)">
    <!-- iPhone 5 SPLASHSCREEN (640×1096) -->
    <link rel="apple-touch-startup-image" href="{{url('assets/backend/img/splash/iphone5.png')}}" media="(device-height: 568px) and (-webkit-device-pixel-ratio: 2)">
    <!-- iPad (portrait) SPLASHSCREEN (748x1024) -->
    <link rel="apple-touch-startup-image" href="{{url('assets/backend/img/splash/ipad-portrait.png')}}" media="(device-width: 768px) and (orientation: portrait)">
    <!-- iPad (landscape) SPLASHSCREEN (768x1004) -->
    <link rel="apple-touch-startup-image" href="{{url('assets/backend/img/splash/ipad-landscape.png')}}" media="(device-width: 768px) and (orientation: landscape)">
    <!-- iPad (Retina, portrait) SPLASHSCREEN (2048x1496) -->
    <link rel="apple-touch-startup-image" href="{{url('assets/backend/img/splash/ipad-portrait-retina.png')}}" media="(device-width: 1536px) and (orientation: portrait) and (-webkit-min-device-pixel-ratio: 2)">
    <!-- iPad (Retina, landscape) SPLASHSCREEN (1536x2008) -->
    <link rel="apple-touch-startup-image" href="{{url('assets/backend/img/splash/ipad-landscape-retina.png')}}" media="(device-width: 1536px)  and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 2)">

    <!-- Microsoft clear type rendering -->
    <meta http-equiv="cleartype" content="on">
</head>

<body>

<div id="container">

        <hgroup id="login-title" class="large-margin-bottom">
            <h1 class="login-title-image">AVDesign</h1>
            <h5>&copy;</h5>
        </hgroup>

        <div id="form-wrapper">

            <div id="form-block" class="scratch-metal">
                <div id="form-viewport">

                    <form method="post" action="{{ url('painel/admin/password/reset') }}" id="form-reset-password" class="input-wrapper green-gradient glossy" title="Alterar Senha">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{$token}}">

                        <p class="message">
                            Altere a senha de forma simples e rápida para acessar sua conta.
                            <span class="block-arrow"><span></span></span>
                        </p>

                        <ul class="inputs black-input large">
                            <li><span class="icon-mail mid-margin-right"></span><input type="text" name="email" id="mail" value="" class="input-unstyled" placeholder="Seu email" autocomplete="off"></li>
                            <li><span class="icon-lock mid-margin-right"></span><input type="password" name="password" id="password" value="" class="input-unstyled" placeholder="Nova Senha" autocomplete="off"></li>
                            <li><span class="icon-lock mid-margin-right"></span><input type="password" name="password_confirmation" id="password_confirm" value="" class="input-unstyled" placeholder="Confirme a senha" autocomplete="off"></li>
                        </ul>

                        <button type="submit" class="button glossy full-width" id="send-register">Criar Senha</button>

                    </form>

                    <form method="post" action="{{route('admin.login')}}" id="form-login" class="input-wrapper blue-gradient glossy" title="Lembrei da Senha!">
                        {{ csrf_field() }}
                        <input type="hidden" name="ajax" value="1">
                        <ul class="inputs black-input large">
                            <li><span class="icon-user mid-margin-right"></span><input type="text" name="login" id="login" value="" class="input-unstyled" placeholder="Login" autocomplete="off"></li>
                            <li><span class="icon-lock mid-margin-right"></span><input type="password" name="password" id="pass" value="" class="input-unstyled" placeholder="Password" autocomplete="off"></li>
                        </ul>

                        <p class="button-height">
                            <button type="submit" class="button glossy float-right" id="login">Login</button>
                            <input type="checkbox" name="remember" id="remind" value="1" class="switch tiny mid-margin-right with-tooltip" title="Habilitar login automático">
                            <label for="remind">Lembre-me</label>
                        </p>
                    </form>



                </div>
            </div>

        </div>

    </div>

<!-- JavaScript at the bottom for fast page loading -->

<!-- Scripts -->
<script src="{{url('assets/backend/js/libs/jquery/jquery-1.10.2.min.js')}}"></script>
<script src="{{url('assets/backend/js/setup.js')}}"></script>

<!-- Template functions -->
<script src="{{url('assets/backend/js/avd.input.js')}}"></script>
<script src="{{url('assets/backend/js/avd.message.js')}}"></script>
<script src="{{url('assets/backend/js/avd.notify.js')}}"></script>
<script src="{{url('assets/backend/js/avd.tooltip.js')}}"></script>


<script src="{{url('assets/backend/scripts/reset-password.js')}}"></script>

<script src="{{url('assets/backend/js/avd.navigable.js')}}"></script>
<script src="{{url('assets/backend/js/libs/jquery.ba-hashchange.js')}}"></script>

<script src="{{url('assets/backend/scripts/libs/reset-password.js?')}}{{time()}}"></script>

<script src="http://www.avdesign.com.br/painel/mensagens/login.js?{{time()}}"></script>

</body>
</html>