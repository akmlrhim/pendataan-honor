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
  <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">
      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-body p-5">

          <!-- Header -->
          <div class="text-center mb-4">
            <h3 class="mb-1 font-weight-bold text-primary">Login</h3>
            <small class="text-muted">Silakan masuk untuk melanjutkan</small>
          </div>

          <!-- Alert error -->
          @if (session('error'))
            <div class="alert alert-danger text-center small shadow-sm rounded">
              {{ session('error') }}
            </div>
          @endif

          <!-- Form -->
          <form method="POST" action="{{ route('login') }}">
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
                    <span class="icon-eye">
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
                    <span class="icon-eye-off d-none">
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



            <!-- Button -->
            <button type="submit" class="btn btn-primary w-100 shadow-sm">
              <i class="fas fa-sign-in-alt mr-2"></i> Login
            </button>
          </form>
        </div>
      </div>

      <!-- Footer kecil -->
      <div class="text-center mt-3">
        <small class="text-muted">&copy; {{ date('Y') }} BPS Kab. Tapin</small>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const toggleBtn = document.querySelector(".toggle-password");
      const passwordInput = document.getElementById("password");
      const eye = toggleBtn.querySelector(".icon-eye");
      const eyeOff = toggleBtn.querySelector(".icon-eye-off");

      toggleBtn.addEventListener("click", function() {
        const isPassword = passwordInput.getAttribute("type") === "password";
        passwordInput.setAttribute("type", isPassword ? "text" : "password");

        // toggle ikon
        eye.classList.toggle("d-none", !isPassword);
        eyeOff.classList.toggle("d-none", isPassword);
      });
    });
  </script>


</body>

</html>
