<!DOCTYPE html>
<html lang="ru" class="light-style layout-menu-fixed">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>VOID Admin — @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/images/favicon.ico') }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="{{ asset('assets/admin/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('admin.partials.dashboard.menu')
        <div class="layout-page">
            @include('admin.partials.dashboard.navbar')
            <div class="content-wrapper">
                <div class="container-fluid flex-grow-1 pt-3">
                    <div class="row">
                        <div class="col-lg-12 mb-2">
                            <div class="card card-content pt-4 pb-4">
                                @include('admin.partials.dashboard.validation')
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<script src="{{ asset('assets/admin/js/manifest.js') }}"></script>
<script src="{{ asset('assets/admin/js/vendor.js') }}"></script>
<script src="{{ asset('assets/admin/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
