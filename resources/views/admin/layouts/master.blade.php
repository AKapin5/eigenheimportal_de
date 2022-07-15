<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth<meta name="api-token" content="{{ auth()->user()->api_token }}">@endauth

    <title>@yield('title', __(config('app.name')))</title>
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/dataTables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/css/fileUploader.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/css/app.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
</head>
<body class="hold-transition sidebar-mini">
<div id="app" class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        @auth
            <ul class="navbar-nav ml-auto order-1 order-md-3 navbar-no-expand">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <span class="d-none d-md-inline">{{ auth()->user()->email }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-footer">
                            <a class="btn btn-default btn-flat float-right btn-block" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-power-off"></i> {{ __('Выйти') }}
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        @endauth
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ url('/admin-panel/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>
        @auth
            <div class="sidebar">
                <x-admin.menu />
            </div>
        @endauth
    </aside>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('content_header')</h1>
                    </div>
                    <div class="col-sm-6">
                        @yield('breadcrumb')
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @if (session()->has('message'))
                    <div class="alert alert-{{ session()->get('type') }}">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-{{ date('Y') }} <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
</div>

<script src="{{ asset('admin-panel/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/flatpickr/i10n/ru.js') }}"></script>
<script src="{{ asset('admin-panel/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/adminlte/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/dataTables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/dataTables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/tinymce/js/tinymce.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admin-panel/libs/select2/dist/js/i18n/ru.js') }}"></script>
<script src="{{ asset('admin-panel/libs/bsCustomFileInput/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('admin-panel/js/redactor.js') }}"></script>
<script src="{{ asset('admin-panel/js/uploader.js') }}"></script>
<script src="{{ asset('admin-panel/js/app.js') }}"></script>
@stack('js')
</body>
</html>
