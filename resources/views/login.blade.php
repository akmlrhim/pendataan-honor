<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html, charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BPS Tapin - Login</title>

  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

  <link rel="icon" href="{{ asset('img/logo_bps.png') }}" type="image/png">
  <link rel="shortcut icon" href="{{ asset('img/logo_bps.ico') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

  <style>
    body {
      font-family: "Inter", sans-serif;
    }
  </style>
</head>

<body class="bg-light">
  <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="row w-100 justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
        <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
          <div class="row no-gutters">

            {{-- left  --}}
            <div class="col-md-6 d-none d-md-block bg-light">
              <div class="h-100 d-flex align-items-center justify-content-center p-4">
                <img src="{{ asset('img/computer-security-with-login-password-padlock-removebg-preview.png') }}"
                  loading="lazy" alt="Ilustrasi Login" class="img-fluid" style="max-height: 100%; object-fit: cover;" />
              </div>
            </div>

            {{-- right  --}}
            <div class="col-md-6 bg-white">
              <div class="card-body p-5">
                <div class="text-center mb-4">
                  <h3 class="mb-1 font-weight-bold text-primary">Login</h3>
                  <p class="text-muted text-sm">Silakan masuk untuk melanjutkan</p>
                </div>

                <x-alert />

                <form method="POST" action="{{ route('login') }}" id="login-form">
                  @csrf

                  <div class="form-group mb-3">
                    <label for="email" class="form-label font-weight-bold text-sm">Email</label>
                    <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                      id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email anda"
                      autofocus autocomplete="off">
                    @error('email')
                      <x-input-validation>{{ $message }}</x-input-validation>
                    @enderror
                  </div>

                  <div class="form-group mb-4">
                    <label for="password" class="form-label font-weight-bold text-sm">Password</label>
                    <div class="input-group">
                      <input type="password"
                        class="form-control form-control-sm @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Masukkan password" autocomplete="off">

                      <div class="input-group-append">
                        <button class="btn btn-sm btn-outline-secondary toggle-password" type="button">
                          <span class="icon-eye-off d-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round" class="lucide lucide-eye">
                              <path d="M2.062 12.348a1 1 0 0 1 0-.696
                           10.75 10.75 0 0 1 19.876 0
                           1 1 0 0 1 0 .696
                           10.75 10.75 0 0 1-19.876 0" />
                              <circle cx="12" cy="12" r="3" />
                            </svg>
                          </span>

                          <span class="icon-eye">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
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
                      <x-input-validation>{{ $message }}</x-input-validation>
                    @enderror
                  </div>

                  <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                  <button type="submit" class="btn btn-primary w-100 shadow-sm">
                    Login
                  </button>
                </form>
              </div>
            </div>

          </div>
        </div>
        <div class="text-center mt-3">
          <p class="text-muted text-sm">&copy; {{ date('Y') }} SIKOMBAT</p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const toggleBtn = document.querySelector(".toggle-password");
      const passwordInput = document.getElementById("password");
      const eye = toggleBtn.querySelector(".icon-eye-off");
      const eyeOff = toggleBtn.querySelector(".icon-eye");

      toggleBtn.addEventListener("click", function() {
        const isPassword = passwordInput.getAttribute("type") === "password";
        passwordInput.setAttribute("type", isPassword ? "text" : "password");

        eye.classList.toggle("d-none", !isPassword);
        eyeOff.classList.toggle("d-none", isPassword);
      });

      if (!window.grecaptcha) return;

      grecaptcha.ready(function() {
        grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
          action: 'login'
        }).then(function(token) {
          document.getElementById('g-recaptcha-response').value = token;
        });

        document.getElementById('login-form').addEventListener('submit', function(e) {
          e.preventDefault();
          grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
            action: 'login'
          }).then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
            e.target.submit();
          });
        });
      });
    });
  </script>
</body>

</html>
