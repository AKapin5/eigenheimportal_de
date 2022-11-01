<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @isset($pageTitle)
            <title>{{ $pageTitle }} | {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endisset
        <link rel="icon" type="image/x-icon" href="/favicon.ico" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/libs.min.js') }}" defer></script>
        <script src="{{ asset('js/custom.min.js') }}?v=1" defer></script>
        @livewireStyles
    </head>
    <body class="loaded" id="body">
        <!-- BEGIN BODY -->
        <div class="main-wrapper">
            <!-- BEGIN CONTENT -->
            <main class="content">
                {{ $slot }}
            </main>
            <!-- BEGIN HEADER -->
            @include('partials.header')
            <!-- HEADER EOF   -->
            <!-- BEGIN FOOTER -->
            @include('partials.footer')
            <!-- FOOTER EOF   -->
        </div>
        <div class="icon-load"></div>
        <!-- BODY EOF   -->
        @livewireScripts

        <!-- Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com -->
        <script type="text/javascript" src="//www.freeprivacypolicy.com/public/cookie-consent/4.0.0/cookie-consent.js" charset="UTF-8"></script>
        <script type="text/javascript" charset="UTF-8">
            document.addEventListener('DOMContentLoaded', function () {
                cookieconsent.run({"notice_banner_type":"headline","consent_type":"express","palette":"light","language":"de","page_load_consent_levels":["strictly-necessary"],"notice_banner_reject_button_hide":false,"preferences_center_close_button_hide":false,"page_refresh_confirmation_buttons":false,"website_name":"http://eigenheim.seocms.com.ua/"});
            });
        </script>
        <noscript>Cookie Consent by <a href="https://www.freeprivacypolicy.com/" rel="noopener">Free Privacy Policy Generator</a></noscript>
        <!-- End Cookie Consent by FreePrivacyPolicy.com https://www.FreePrivacyPolicy.com -->
    </body>
</html>
