<!-- resources/views/reuse/header.blade.php -->
<header class="nav-dark">
  <div class="container-xxl py-2">
    <div class="d-flex justify-content-between align-items-center">

      <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none">
        <svg width="26" height="26" viewBox="0 0 24 24" class="neon"><path fill="currentColor" d="M3 4h18v2H3zM3 9h10v2H3zM3 14h7v2H3zM3 19h18v2H3z"/></svg>
        <span class="mono fw-bold fs-3 neon">NOC-N2 Terminal</span>
      </a>

      @php
  $isTroubles = request()->routeIs('troubleshooting');
@endphp

<nav class="d-flex align-items-center gap-2">
  <a href="{{ route('comandos') }}"
     class="{{ $isTroubles ? 'nav-link-muted mono' : 'nav-btn mono' }}">
    <!-- ícone --> Comandos
  </a>

  <a href="{{ route('troubleshooting') }}"
     class="{{ $isTroubles ? 'nav-btn mono' : 'nav-link-muted mono' }}">
    <!-- ícone --> Troubleshooting
  </a>
</nav>

    </div>
  </div>
  <div class="divider"></div>
</header>
