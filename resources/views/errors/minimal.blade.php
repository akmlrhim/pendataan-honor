<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title')</title>

  <link rel="stylesheet" href="{{ asset('fonts/style.css') }}" type="text/css">

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">
  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <img src="{{ asset('img/not_found.webp') }}" loading="lazy" class="img-fluid mb-2 w-50" />


        <h1 class="display-1 font-weight-bold text-danger">
          @yield('code')
        </h1>

        <p class="lead font-weight-medium mb-4">
          @yield('message')
        </p>

      </div>
    </div>
  </div>
</body>

</html>
