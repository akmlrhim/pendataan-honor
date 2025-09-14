<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="lucide lucide-menu-icon lucide-menu">
          <path d="M4 12h16" />
          <path d="M4 18h16" />
          <path d="M4 6h16" />
        </svg>
      </a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item d-flex align-items-center pr-3">
      <div class="text-right">
        <div id="tanggal" class="text-dark font-weight-bold text-xs"></div>
        <div id="waktu" class="text-primary font-weight-bold"></div>
      </div>
    </li>
  </ul>
</nav>

<script>
  function updateDateTime() {
    const now = new Date();

    const tanggalOptions = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    };
    document.getElementById('tanggal').textContent =
      now.toLocaleDateString('id-ID', tanggalOptions);

    const waktuOptions = {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    };
    document.getElementById('waktu').textContent =
      now.toLocaleTimeString('id-ID', waktuOptions);
  }

  setInterval(updateDateTime, 1000);
  updateDateTime();
</script>
