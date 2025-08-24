<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html, charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sensus APPS</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">


  <style>
    body {
      font-family: "Plus Jakarta Sans", system-ui, sans-serif;
    }
  </style>
</head>

<body>
  <div class="container d-flex align-items-center justify-content-center min-vh-100 px-3">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">

          <div class="text-center mb-4">
            <h3 class="mb-1">Login</h3>
            <small class="text-muted">Silakan masuk untuk melanjutkan</small>
          </div>

          @if (session('error'))
            <div class="alert alert-danger text-center small">{{ session('error') }}</div>
          @endif

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" autofocus
                autocomplete="off">
              @error('email')
                <span class="invalid-feedback" role="alert">
                  {{ ucfirst($message) }}
                </span>
              @enderror
            </div>

            <!-- Password -->
            <div class="form-group mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" placeholder="Masukkan password">
              @error('password')
                <span class="invalid-feedback" role="alert">
                  {{ ucfirst($message) }}
                </span>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>


</body>

</html>
