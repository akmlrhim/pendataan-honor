<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html, charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BPS Kab.Tapin - {{ $title }}</title>

  <link rel="icon" href="{{ asset('img/logo_bps.png') }}" type="image/png">
  <link rel="shortcut icon" href="{{ asset('img/logo_bps.ico') }}" type="image/x-icon">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/font.css') }}">

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

  @stack('css-libs')

</head>

<body class="sidebar-mini layout-footer-fixed layout-fixed layout-navbar-fixed">
  <div class="wrapper">

    @include('layouts.navbar')
    @include('layouts.sidebar')

    <div class="content-wrapper">
      @include('layouts.breadcrumb')

      <section class="content">
        <div class="container-fluid">
          @yield('content')
        </div>
      </section>
    </div>

    @include('layouts.control-sidebar')
  </div>


  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/adminlte.min.js') }}"></script>

  @yield('scripts')
</body>

</html>
