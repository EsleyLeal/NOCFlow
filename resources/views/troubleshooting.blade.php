<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Guia de Troubleshooting</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,800" rel="stylesheet" />

  <style>
    :root{
      --bg:#0b1120; --panel:#0f172a; --muted:#94a3b8; --line:#1f2937;
      --neon:#39ff14; --neon-weak:#34d399;
    }
    html,body{height:100%}
    body.compact{
      background:linear-gradient(180deg,#0a0f1f 0%, #0b1120 40%, #0a1022 100%);
      color:#e5e7eb; font-family:"Instrument Sans", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      letter-spacing:.01em;
    }
    .neon{ color:var(--neon); text-shadow:0 0 6px rgba(57,255,20,.35) }
    .muted{ color:var(--muted) }

    /* métricas */
    .metric{
      background:var(--panel); border:1px solid var(--line); border-radius:.75rem;
      padding:1.1rem; text-align:center;
    }
    .metric .value{ font:800 2rem/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; color:#cfe0ff }
    .metric .label{ color:var(--muted); font-weight:600; letter-spacing:.02em }

    /* botão "novo" */
    .btn-neon{
      display:inline-flex; align-items:center; gap:.5rem; font-weight:700;
      border:1px solid #16a34a; background:var(--neon); color:#041408;
      padding:.55rem .9rem; border-radius:.6rem; text-decoration:none;
    }

    /* acordeão */
    .accordion-dark .accordion-item{
      background:var(--panel); border:1px solid var(--line); border-radius:.75rem; overflow:hidden;
    }
    .accordion-dark .accordion-item + .accordion-item{ margin-top:.7rem }
    .accordion-dark .accordion-button{
      background:transparent; color:#e5e7eb; padding:1rem 1.1rem;
      box-shadow:none; gap:.75rem;
    }
    .accordion-dark .accordion-button:not(.collapsed){ color:#e5e7eb; background:#0a1226 }
    .accordion-dark .accordion-body{ background:#0a1226; border-top:1px solid #172033 }
    .badge-chip{
      display:inline-flex; align-items:center; gap:.35rem; padding:.18rem .5rem;
      border-radius:999px; border:1px solid #22314a; background:#0b152a; font-size:.7rem; font-weight:800;
      text-transform:uppercase; letter-spacing:.05em; color:#c7d2fe;
    }
    .kbd-copy{
      width:100%; display:flex; align-items:center; justify-content:center; gap:.5rem;
      border:1px solid #22314a; background:#0a1226; color:#cfe0ff; border-radius:.5rem; padding:.55rem .7rem;
      font-weight:700;
    }

    /* === ESTILOS DO HEADER (compartilhados) === */
.mono{ font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace }
.neon{ color:#39ff14; text-shadow:0 0 6px rgba(57,255,20,.35) } /* se já tiver, pode manter o seu */
.nav-dark{ background:#111827 }
.nav-btn{
  display:inline-flex; align-items:center; gap:.45rem;
  padding:.35rem .65rem; border:1px solid #16a34a; border-radius:.4rem;
  background:#39ff14; color:#041408; font-weight:600;
  text-decoration:none;
}
.nav-link-muted{
  display:inline-flex; align-items:center; gap:.45rem;
  color:#e5e7eb; text-decoration:none; font-weight:500;
  padding:.35rem .45rem; border-radius:.35rem;
}
.nav-link-muted:hover{ background:#0f172a }
.divider{ border-top:1px solid #111827 }

  </style>
</head>
<body class="compact">

    

  @include('reuse.header')
  @include('reuse.viewNovoTroubleshooting')

  <!-- HERO -->
  <section class="container-xxl py-4">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
      <div>
        <h1 class="neon mb-1" style="font:800 2rem/1.1 ui-monospace, Menlo, Consolas">Guia de Troubleshooting</h1>
        <p class="muted mb-0">Soluções para problemas comuns em redes</p>
      </div>
      <a class="btn-neon"
   data-bs-toggle="collapse"
   href="#formNovoTroubleshooting"
   role="button"
   aria-expanded="false"
   aria-controls="formNovoTroubleshooting">
  <svg width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
  Novo Troubleshoot
</a>

    </div>
  </section>

  <!-- MÉTRICAS -->
  <section class="container-xxl pb-2">
  <div class="row g-3">
    <div class="col-md-4">
      <div class="metric">
        <div class="value neon">{{ $stats['total'] ?? 0 }}</div>
        <div class="label">Total de Guias</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="metric">
        <div class="value neon">{{ $stats['personalizados'] ?? 0 }}</div>
        <div class="label">Personalizados</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="metric">
        <div class="value neon">{{ $stats['padrao'] ?? 0 }}</div>
        <div class="label">Padrão</div>
      </div>
    </div>
  </div>
</section>


  <!-- ACORDEÃO (dinâmico) -->
<main class="container-xxl pb-5">
  <div class="accordion accordion-dark" id="accTroubles">

    @forelse($items as $ts)
      @php
        // gera IDs únicos para o acordeão
        $hid = "h-ts-{$ts->id}";
        $cid = "c-ts-{$ts->id}";

        // quebra os passos em linhas (ignora vazias)
        $steps = preg_split("/\r\n|\n|\r/", (string)($ts->steps ?? ''));
        $steps = array_values(array_filter(array_map('trim', $steps), fn($s) => $s !== ''));
      @endphp

      <div class="accordion-item">
        <h2 class="accordion-header" id="{{ $hid }}">
          <button class="accordion-button collapsed" type="button"
                  data-bs-toggle="collapse" data-bs-target="#{{ $cid }}"
                  aria-expanded="false" aria-controls="{{ $cid }}">
            <span class="badge-chip">TS</span>
            <div>
              <div class="fw-bold" style="font-family:ui-monospace,Menlo,Consolas">
                {{ $ts->title }}
              </div>
              @if($ts->description)
                <small class="muted">{{ $ts->description }}</small>
              @endif
            </div>
          </button>
        </h2>

        <div id="{{ $cid }}" class="accordion-collapse collapse" aria-labelledby="{{ $hid }}" data-bs-parent="#accTroubles">
          <div class="accordion-body">
            @if(count($steps))
              <ol class="mb-3 text-white">
                @foreach($steps as $s)
                  <li>{{ $s }}</li>
                @endforeach
              </ol>
            @else
              <div class="muted">Sem passos cadastrados.</div>
            @endif

            {{-- botão para copiar todos os passos como texto (opcional) --}}
            @if(count($steps))
              <button class="kbd-copy mt-2"
                      data-copy="{{ implode("\n", $steps) }}">
                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M16.5 6.5v11a4.5 4.5 0 1 1-9 0v-10a3 3 0 1 1 6 0v9a1.5 1.5 0 1 1-3 0V7h2v9a.5.5 0 1 0 1 0v-9a3.5 3.5 0 1 0-7 0v10a5.5 5.5 0 1 0 11 0v-11z"/></svg>
                Copiar passos
              </button>
            @endif
          </div>
        </div>
      </div>
    @empty
      <div class="text-center muted py-5">Nenhum troubleshooting cadastrado.</div>
    @endforelse

  </div>
</main>

  <script>
    // botão "copiar"
    document.querySelectorAll('.kbd-copy').forEach(btn=>{
      btn.addEventListener('click', async ()=>{
        try{
          await navigator.clipboard.writeText(btn.getAttribute('data-copy')||'');
          const html = btn.innerHTML;
          btn.innerHTML = '<span style="display:flex;gap:.45rem;align-items:center"><svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/></svg>Copiado!</span>';
          setTimeout(()=>btn.innerHTML = html, 1200);
        }catch(e){ alert('Não foi possível copiar.'); }
      });
    });
  </script>
</body>
</html>
