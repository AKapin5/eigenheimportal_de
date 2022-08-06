<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth<meta name="api-token" content="{{ auth()->user()->api_token }}">@endauth

    <title>{{ $title ??  __(config('app.name')) }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/ionic/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/jQuery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/select2-bootstrap5/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/flatpickr/flatpickr.min.css') }}">
    @livewireStyles
    @powerGridStyles

    <link rel="stylesheet" href="{{ asset('admin-panel/css/app.css') }}">
</head>
<body class="layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-light">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar-full" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            @auth
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-md-inline">{{ auth()->user()->email }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-light btn-flat float-end" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-fw fa-power-off"></i>
                                    {{ __('Sign out') }}
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth
        </div>
    </nav>

    <aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">
        <div class="brand-container">
            <a href="javascript:;" class="brand-link">
                <img src="/admin-panel/libs/adminlte/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-80 shadow">
                <span class="brand-text fw-light">Eigenheim</span>
            </a>
            <a class="pushmenu mx-1" data-lte-toggle="sidebar-mini" href="javascript:;" role="button"><i class="fas fa-angle-double-left"></i></a>
        </div>
        <div class="sidebar">
            @auth
                <x-admin.menu />
            @endauth
        </div>
    </aside>

    <main class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    @isset($title)
                        <div class="col-sm-6">
                            <div class="fs-3">{{ $title }}</div>
                        </div>
                    @endisset
                    @isset($breadcrumb)
                        <div class="col-sm-6">
                            {{ $breadcrumb }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @if (session()->has('messageText'))
                    <div class="alert alert-{{ session()->get('messageType') }}">
                        {{ session()->get('messageText') }}
                    </div>
                @endif
                {{ $slot }}
            </div>
        </div>
    </main>
    <footer class="main-footer">
        <strong>{{ __('Copyright &copy;') }} 2014-{{ date('Y') }} <a href="https://adminlte.io">AdminLTE.io</a>.</strong> {{ __('All rights reserved.') }}
    </footer>

</div>
<script src="{{ asset('admin-panel/libs/jQuery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/jQuery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/flatpickr/i10n/ru.js') }}"></script>
<script src="{{ asset('admin-panel/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/select2/dist/js/i18n/ru.js') }}"></script>
<script src="{{ asset('admin-panel/libs/tinymce/js/tinymce.min.js') }}"></script>
@livewireScripts
@powerGridScripts

<script src="{{ asset('admin-panel/libs/overlayScrollbars/js/OverlayScrollbars.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/adminlte/js/adminlte.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/alpinejs/cdn.min.js') }}"></script>
<script src="{{ asset('admin-panel/js/app.js') }}"></script>
@stack('js')
</body>
</html>
