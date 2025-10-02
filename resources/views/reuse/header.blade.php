
<header class="nav-dark">
    
  <div class="container-xxl py-2">
    <div class="row align-items-center">

      <!-- Coluna esquerda: Logo -->
      <div class="col-auto">
        <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none">
          <svg width="26" height="26" viewBox="0 0 24 24" class="neon">
            <path fill="currentColor" d="M3 4h18v2H3zM3 9h10v2H3zM3 14h7v2H3zM3 19h18v2H3z"/>
          </svg>
          <span class="mono fw-bold fs-3 neon">NOC-N2 Terminal</span>
        </a>
      </div>

      <!-- Coluna centro: Menu -->
      <div class="col d-flex justify-content-center">
        @php $isTroubles = request()->routeIs('troubleshooting'); @endphp
        <nav class="d-flex align-items-center gap-2">
          <a href="{{ route('comandos') }}"
             class="{{ $isTroubles ? 'nav-link-muted mono' : 'nav-btn mono' }}">
            Comandos
          </a>
          <a href="{{ route('troubleshooting') }}"
             class="{{ $isTroubles ? 'nav-btn mono' : 'nav-link-muted mono' }}">
            Troubleshooting
          </a>
        </nav>
      </div>

      <!-- Coluna direita: Usuário + Logout -->
      <div class="col-auto">
        @if(Auth::check())
          <div class="d-flex align-items-center gap-2">
            <span class="neon-soft">
              Olá, <strong class="neon">{{ Auth::user()->nome }}</strong>
            </span>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="nav-btn d-flex align-items-center gap-1">
                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor"
                  d="M16 13v-2H7V8l-5 4l5 4v-3zM20 3H12v2h8v14h-8v2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/></svg>
                Sair
              </button>
            </form>
          </div>
        @endif
      </div>

    </div>
  </div>
  <div class="divider"></div>
</header>
