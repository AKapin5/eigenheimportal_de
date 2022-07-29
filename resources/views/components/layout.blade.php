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
        <script src="{{ asset('js/custom.min.js') }}" defer></script>
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
    </body>
</html>
