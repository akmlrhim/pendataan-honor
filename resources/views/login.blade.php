<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html, charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BPS Kab.Tapin - Login</title>

  <link rel="icon" href="{{ asset('img/logo_bps.png') }}" type="image/png">
  <link rel="shortcut icon" href="{{ asset('img/logo_bps.ico') }}" type="image/x-icon">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/font.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

</head>

<body>
  <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">
      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-body p-5">

          <!-- Header -->
          <div class="text-center mb-4">
            <h1 class="mb-1 font-weight-bold text-primary">Login</h1>
            <h6 class="text-muted">Silakan masuk untuk melanjutkan</h6>
          </div>

          <x-alert />

          <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            <!-- Email -->
            <div class="form-group mb-3">
              <label for="email" class="form-label font-weight-bold">Email Address</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') }}" placeholder="Masukkan email anda" autofocus
                autocomplete="off">
              @error('email')
                <span class="invalid-feedback" role="alert">
                  {{ ucfirst($message) }}
                </span>
              @enderror
            </div>

            <!-- Password -->
            <div class="form-group mb-4">
              <label for="password" class="form-label font-weight-bold">Password</label>
              <div class="input-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                  name="password" placeholder="Masukkan password" autocomplete="off">

                <div class="input-group-append">
                  <button class="btn btn-outline-secondary toggle-password" type="button">
                    <!-- 👁️ eye (default visible) -->
                    <span class="icon-eye-off d-none">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-eye">
                        <path d="M2.062 12.348a1 1 0 0 1 0-.696
                     10.75 10.75 0 0 1 19.876 0
                     1 1 0 0 1 0 .696
                     10.75 10.75 0 0 1-19.876 0" />
                        <circle cx="12" cy="12" r="3" />
                      </svg>
                    </span>

                    <!-- 🚫👁️ eye-off (hidden by default) -->
                    <span class="icon-eye">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-eye-off">
                        <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575
                     1 1 0 0 1 0 .696
                     10.747 10.747 0 0 1-1.444 2.49" />
                        <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                        <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151
                     1 1 0 0 1 0-.696
                     10.75 10.75 0 0 1 4.446-5.143" />
                        <path d="m2 2 20 20" />
                      </svg>
                    </span>
                  </button>
                </div>
              </div>
              @error('password')
                <span class="invalid-feedback d-block" role="alert">
                  {{ ucfirst($message) }}
                </span>
              @enderror
            </div>

            {{-- recapthca  --}}
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

            <!-- Button -->
            <button type="submit" class="btn btn-primary w-100 shadow-sm">
              <i class="fas fa-sign-in-alt mr-2"></i> Login
            </button>
          </form>

          {{-- <div class="text-right mt-2 text-sm text-primary">
            <a href="{{ route('register') }}">Register</a>
          </div> --}}

        </div>
      </div>

      <div class="text-center mt-3">
        <p class="text-muted">&copy; {{ date('Y') }} BPS Kab. Tapin</p>
      </div>
    </div>
  </div>

  <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const toggleBtn = document.querySelector(".toggle-password");
      const passwordInput = document.getElementById("password");
      const eye = toggleBtn.querySelector(".icon-eye-off");
      const eyeOff = toggleBtn.querySelector(".icon-eye");

      toggleBtn.addEventListener("click", function() {
        const isPassword = passwordInput.getAttribute("type") === "password";
        passwordInput.setAttribute("type", isPassword ? "text" : "password");

        // toggle ikon
        eye.classList.toggle("d-none", !isPassword);
        eyeOff.classList.toggle("d-none", isPassword);
      });

      grecaptcha.ready(function() {
        grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {
          action: 'login'
        }).then(function(token) {
          document.getElementById('g-recaptcha-response').value = token;
        });
      });
    });
  </script>
</body>

</html>
