<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif

  <style>
    :root{
      --bg:#0b1120;
      --panel:#0f172a;
      --muted:#94a3b8;
      --line:#1f2937;
      --neon:#39ff14;
      --neon-weak:#34d399;
    }
    html,body{height:100%}
    body.compact{
      background:linear-gradient(180deg,#0a0f1f 0%, #0b1120 40%, #0a1022 100%);
      color:#e5e7eb;
      font-family:"Instrument Sans", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Apple Color Emoji","Segoe UI Emoji";
      letter-spacing:.01em;
    }
    .mono{ font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace }
    .neon{ color:var(--neon); text-shadow:0 0 6px rgba(57,255,20,.35) }
    .neon-soft{ color:var(--neon-weak) }
    .divider{ border-top:1px solid #111827 }
    .muted{ color:var(--muted) }

    .nav-dark{ background:#111827 }
    .nav-btn{
      display:inline-flex; align-items:center; gap:.45rem;
      padding:.35rem .65rem; border:1px solid #16a34a; border-radius:.4rem;
      background:#39ff14; color:#041408; font-weight:600;
      text-decoration: none;
    }
    .nav-link-muted{
      display:inline-flex; align-items:center; gap:.45rem;
      color:#e5e7eb; text-decoration:none; font-weight:500;
      padding:.35rem .45rem; border-radius:.35rem;
    }
    .nav-link-muted:hover{ background:#0f172a }

    .search-wrap{ position:relative }
    .search-wrap svg{ position:absolute; left:.6rem; top:50%; transform:translateY(-50%); color:#6b7280 }
    .search{
      width:100%; border-radius:.4rem; border:1px solid #253047; background:#0a1226; color:#e5e7eb;
      padding:.6rem .8rem .6rem 2.0rem; outline:none; font-size:.95rem;
      transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
      caret-color: var(--neon);
    }
    .search::placeholder{ color:#6b7280 }
    .search:focus{
      border-color:#16a34a;
      box-shadow:0 0 0 3px rgba(57,255,20,.25);
      background:#0b152a;
    }
    .search:focus::placeholder{ color:#34d399 }
    .search-wrap:focus-within svg{
      color:var(--neon);
      filter:drop-shadow(0 0 4px rgba(57,255,20,.35));
    }
    .search::selection{ background:rgba(57,255,20,.25); color:#fff; }
    .search::-moz-selection{ background:rgba(57,255,20,.25); color:#fff; }

    .list-group .list-group-item{
      background:#0f172a; border:1px solid var(--line);
      border-radius:.5rem; padding:.6rem .7rem;
    }
    .list-group .list-group-item + .list-group-item{ margin-top:.55rem }
    .list-actions{ display:flex; gap:.25rem }
    .icon-btn{
      display:inline-grid; place-items:center; width:26px; height:26px;
      border-radius:.4rem; border:1px solid #233046; color:#93a2c3; background:#0d1427;
    }
    .icon-btn:hover{ color:#cfe0ff; border-color:#2b3c5b; background:#111b33 }
    .chip{
      display:inline-flex; align-items:center; gap:.25rem;
      padding:.12rem .38rem; border-radius:999px; font-size:.66rem; font-weight:700;
      background:#0b152a; border:1px solid #22314a; color:#c7d2fe; line-height:1.1;
    }
    .chip--brand{ color:#a5b4fc }
    .chip--proto{ color:#86efac; border-color:#1f3b2a; background:#0b1a12 }
    .chip--mpls{ color:#93c5fd; border-color:#23324a; background:#0c1628 }
    .list-title{ font:700 .98rem/1.2 ui-monospace; margin:.2rem 0 .35rem }
    .kbd{
      display:flex; align-items:center; justify-content:center; gap:.5rem;
      padding:.45rem .7rem; border:1px solid #22314a; background:#0a1226;
      border-radius:.4rem; font-weight:700; color:#cfe0ff; width:100%;
    }
    .dict-dl dt{ color:var(--muted); font-size:.9rem }
    .dict-dl dd{ margin-bottom:.2rem; font-size:.92rem }
    .dict-dl dd:last-of-type{ margin-bottom:0 }

    .hero-title{ font:800 2rem/1.1 ui-monospace; }
    .hero-sub{ margin:0; font-size:1rem }
    .hero-row{ align-items:center }
    @media (min-width: 992px){
      .hero-title{ font-size:2.2rem }
    }

    .filter-bar{ background:#0f172a; border:1px solid var(--line); border-radius:.5rem; padding:.6rem .8rem }
    .filter-chip{
      display:inline-flex; align-items:center; gap:.35rem; padding:.28rem .55rem; border:1px solid #22314a;
      background:#0a1226; border-radius:999px; color:#e5e7eb; font-weight:600; font-size:.82rem; cursor:pointer;
    }
    .filter-chip.active{ border-color:#16a34a; box-shadow:0 0 0 2px rgba(57,255,20,.2) inset; color:var(--neon) }

    .star-btn{
      display:inline-grid; place-items:center; width:26px; height:26px; border-radius:.4rem;
      border:1px solid #233046; background:#0d1427; color:#93a2c3;
    }
    .star-btn.active{ color:#39ff14; border-color:#2ecc71; box-shadow:0 0 6px rgba(57,255,20,.25) }

    .site-footer a{ text-decoration:none !important; border:0 !important }

    mark.hl{
      background: rgba(57,255,20,.18);
      color:#fff;
      padding:0 .12rem;
      border-radius:.15rem;
    }
  </style>
</head>

<body class="compact">



 @include('reuse.header')

 @include('reuse.viewNovoComando')



  <section class="container-xxl py-3">
    <div class="row hero-row">
      <div class="col-lg-9 text-center text-lg-start mb-2 mb-lg-0">
        <h1 class="hero-title neon mb-2">Busca de Comandos</h1>
        <p class="hero-sub muted">Consulte comandos para equipamentos Cisco, Huawei e Datacom</p>
      </div>
      <div class="col-lg-3 d-flex justify-content-center justify-content-lg-end">
        <a class="nav-btn" data-bs-toggle="collapse" href="#formNovoComando" role="button" aria-expanded="false" aria-controls="formNovoComando">
          <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
          Novo Comando
        </a>
      </div>
    </div>
  </section>

  <section class="container-xxl">
    <form method="GET" action="{{ route('comandos') }}" class="search-wrap mx-auto" style="max-width:720px;">
      <svg width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M10 18a8 8 0 1 1 6.32-3.1l4.39 4.39l-1.41 1.41l-4.39-4.39A7.96 7.96 0 0 1 10 18m0-2a6 6 0 1 0 0-12a6 6 0 0 0 0 12"/></svg>
      <input class="search" type="text" name="q" value="{{ request('q') }}" placeholder="Buscar comandos, dispositivos, protocolos..." aria-label="Buscar comandos">
    </form>

    <div class="d-flex justify-content-center gap-4 muted mono py-2">
      <span>Total: <strong class="neon-soft">{{ $stats['total'] }}</strong> comandos</span>
      <span>Resultados: <strong class="neon-soft">{{ $stats['results'] }}</strong></span>
      <span>Favoritos: <strong class="neon-soft">{{ $stats['favorites'] }}</strong></span>
    </div>
  </section>

  <section class="container-xxl pb-2">
    <form method="GET" action="{{ route('comandos') }}" class="filter-bar d-flex flex-wrap align-items-center gap-2">
      <input type="hidden" name="q" value="{{ request('q') }}">

      @php
        $vendors = ['Cisco','Huawei','Datacom'];
        $activeVendors = (array) request('vendor', []);
      @endphp
      <div class="d-flex flex-wrap align-items-center gap-2">
        <span class="mono muted">Vendor:</span>
        @foreach($vendors as $v)
          <label class="filter-chip {{ in_array($v,$activeVendors) ? 'active' : '' }}">
            <input type="checkbox" name="vendor[]" value="{{ $v }}" class="d-none" {{ in_array($v,$activeVendors) ? 'checked' : '' }}>
            {{ $v }}
          </label>
        @endforeach
      </div>

      @php
        $protocols = ['MPLS','BGP','OSPF'];
        $activeProtocols = (array) request('protocol', []);
      @endphp
      <div class="d-flex flex-wrap align-items-center gap-2 ms-lg-3">
        <span class="mono muted">Protocolo:</span>
        @foreach($protocols as $p)
          <label class="filter-chip {{ in_array($p,$activeProtocols) ? 'active' : '' }}">
            <input type="checkbox" name="protocol[]" value="{{ $p }}" class="d-none" {{ in_array($p,$activeProtocols) ? 'checked' : '' }}>
            {{ $p }}
          </label>
        @endforeach
      </div>

      {{-- >>> AQUI: Chip "Só favoritos" --}}
      @php $onlyFav = request('favorites') == '1'; @endphp
      <div class="d-flex align-items-center gap-2 ms-lg-3">
        <label class="filter-chip {{ $onlyFav ? 'active' : '' }}">
          <input type="checkbox" name="favorites" value="1" class="d-none" {{ $onlyFav ? 'checked' : '' }}>
          MEUS FAVORITOS
        </label>
      </div>
      {{-- <<< --}}

      @php $sort = request('sort','recent'); @endphp
      <div class="ms-auto">
        <select name="sort" class="form-select form-select-sm" style="background:#0a1226;color:#e5e7eb;border-color:#22314a;">
          <option value="recent" {{ $sort=='recent'?'selected':'' }}>Mais recentes</option>
          <option value="used" {{ $sort=='used'?'selected':'' }}>Mais usados</option>
          <option value="az" {{ $sort=='az'?'selected':'' }}>A–Z</option>
          <option value="vendor" {{ $sort=='vendor'?'selected':'' }}>Vendor</option>
        </select>
      </div>

      <button class="nav-btn ms-2" type="submit">
        <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M10 18a8 8 0 1 1 6.32-3.1l4.39 4.39l-1.41 1.41l-4.39-4.39A7.96 7.96 0 0 1 10 18"/></svg>
        Filtrar
      </button>
    </form>
  </section>

  @php
    $term = trim(request('q',''));
    $hl = function($text, $term){
      $text = $text ?? '—';
      if($term === '') return e($text);
      $safe = e($text);
      return preg_replace('/(' . preg_quote($term,'/') . ')/i', '<mark class="hl">$1</mark>', $safe);
    };
  @endphp

  <main class="container-xxl pb-4">
    <section class="list-group">
      @forelse($commands as $cmd)
        <div class="list-group-item">
          <div class="d-flex justify-content-between align-items-start">
            <span class="chip chip--brand mono">{{ $cmd->vendor }}</span>
            <div class="list-actions">
              <button class="icon-btn" title="Editar">@svgEdit</button>
              <button class="icon-btn" title="Anexos">@svgPaperclip</button>

              @php $isFav = !empty($cmd->favorite) && $cmd->favorite; @endphp
              <button class="star-btn fav-btn {{ $isFav ? 'active' : '' }}"
                      data-id="{{ $cmd->id }}"
                      data-url="{{ route('comandos.favorite', $cmd) }}"
                      aria-pressed="{{ $isFav ? 'true' : 'false' }}"
                      title="{{ $isFav ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}">
                @svgStar
              </button>

              <button class="icon-btn" title="Excluir">@svgTrash</button>
            </div>
          </div>

          <h3 class="list-title neon">{!! $hl($cmd->command, $term) !!}</h3>

          <dl class="row dict-dl mb-0">
            <dt class="col-4 col-sm-3">Protocolo</dt>
            <dd class="col-8 col-sm-9">
              @if($cmd->protocol)
                <span class="chip {{ strtoupper($cmd->protocol) === 'MPLS' ? 'chip--mpls' : 'chip--proto' }}">
                  {{ $cmd->protocol }}
                </span>
              @else
                <span class="muted">—</span>
              @endif
            </dd>

            <dt class="col-4 col-sm-3">Tarefa</dt>
            <dd class="col-8 col-sm-9 text-white fw-semibold">
              {!! $hl($cmd->task, $term) !!}
            </dd>

            <dt class="col-4 col-sm-3">Descrição</dt>
            <dd class="col-8 col-sm-9 muted">
              {!! $hl($cmd->description, $term) !!}
            </dd>
          </dl>

          <div class="mt-2">
            <button class="kbd" data-copy="{{ $cmd->command }}"
                    data-used-url="{{ route('comandos.used', $cmd) }}">
              <span class="d-inline-flex align-items-center gap-2">Copiar Comando</span>
            </button>
          </div>
        </div>
      @empty
        <div class="text-center muted py-4">Nenhum comando cadastrado.</div>
      @endforelse
    </section>

    @if(method_exists($commands, 'links'))
      <div class="mt-3">
        {{ $commands->withQueryString()->links() }}
      </div>
    @endif
  </main>

  @include('reuse.footer')

  <!-- Inline SVG templates -->
  <template id="tpl-edit">
    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="m5 21l5.5-1.5L19 11l-4-4L6.5 15.5zM20.7 9.3a1 1 0 0 0 0-1.4L16.1 3.3a1 1 0 0 0-1.4 0L13 5l4 4z"/></svg>
  </template>
  <template id="tpl-clip">
    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M16.5 6.5v11a4.5 4.5 0 1 1-9 0v-10a3 3 0 1 1 6 0v9a1.5 1.5 0 1 1-3 0V7h2v9a.5.5 0 1 0 1 0v-9a3.5 3.5 0 1 0-7 0v10a5.5 5.5 0 1 0 11 0v-11z"/></svg>
  </template>
  <template id="tpl-pin">
    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M22 12h-6l2-7h-4l-1-3l-1 3H8l2 7H4l6 6v4l2-2v-2z"/></svg>
  </template>
  <template id="tpl-paperclip">
    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 17a4 4 0 0 0 6.83 2.83l6.36-6.36a5 5 0 1 0-7.07-7.07L5.64 13.88a3 3 0 1 0 4.24 4.24l6-6"/></svg>
  </template>
  <template id="tpl-trash">
    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M9 3h6l1 2h4v2H4V5h4zm1 6h2v8h-2zm4 0h2v8h-2zM6 7h12l-1 13a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2z"/></svg>
  </template>
  <template id="tpl-star">
    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="m12 17.27l6.18 3.73l-1.64-7.03L21 9.24l-7.19-.61L12 2L10.19 8.63L3 9.24l4.46 4.73L5.82 21z"/></svg>
  </template>

  <script>
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    (function hydrateIcons(){
      const map = {
        '@svgEdit': document.querySelector('#tpl-edit')?.innerHTML || '',
        '@svgClipboard': document.querySelector('#tpl-clip')?.innerHTML || '',
        '@svgPin': document.querySelector('#tpl-pin')?.innerHTML || '',
        '@svgPaperclip': document.querySelector('#tpl-paperclip')?.innerHTML || '',
        '@svgTrash': document.querySelector('#tpl-trash')?.innerHTML || '',
        '@svgStar': document.querySelector('#tpl-star')?.innerHTML || ''
      };
      document.querySelectorAll('button, a, span').forEach(el=>{
        const html = el.innerHTML.trim();
        if(map[html]) el.innerHTML = map[html];
      });
    })();

    // Delegação: FAVORITAR
    document.addEventListener('click', async (ev)=>{
      const btn = ev.target.closest('.fav-btn');
      if(!btn) return;

      ev.preventDefault();
      const url = btn.dataset.url;
      if(!url){ console.error('data-url ausente'); return; }

      try{
        const res = await fetch(url, {
          method:'POST',
          headers:{
            'X-CSRF-TOKEN': csrf,
            'Accept':'application/json',
            'X-Requested-With':'XMLHttpRequest'
          },
          credentials:'same-origin'
        });

        if(!res.ok){
          const txt = await res.text();
          console.error('Erro ao favoritar:', res.status, txt);
          alert('Não foi possível favoritar.');
          return;
        }

        const data = await res.json();
        const on = !!data.favorited;
        btn.classList.toggle('active', on);
        btn.setAttribute('aria-pressed', on ? 'true':'false');
        btn.title = on ? 'Remover dos favoritos' : 'Adicionar aos favoritos';
      }catch(e){
        console.error(e);
        alert('Falha de rede ao favoritar.');
      }
    });

    // Chips de filtro: toggle visual instantâneo
    document.querySelectorAll('.filter-chip').forEach(chip=>{
      chip.addEventListener('click', (e)=>{
        const input = chip.querySelector('input[type=checkbox]');
        if(input){
          input.checked = !input.checked;
          chip.classList.toggle('active', input.checked);
          e.preventDefault();
        }
      });
    });

    // Copiar + incrementar uso
    document.addEventListener('click', async (ev)=>{
      const btn = ev.target.closest('[data-copy]');
      if(!btn) return;

      const text = btn.getAttribute('data-copy') || '';
      const usedUrl = btn.getAttribute('data-used-url');

      try{
        await navigator.clipboard.writeText(text);
        const original = btn.innerHTML;
        btn.innerHTML = '<span style="display:flex;gap:.4rem;align-items:center"><svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/></svg>Copiado!</span>';
        setTimeout(()=> btn.innerHTML = original, 1500);
      }catch(e){
        alert('Não foi possível copiar.'); console.error(e);
      }

      if(usedUrl){
        fetch(usedUrl, {
          method:'POST',
          headers:{
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With':'XMLHttpRequest'
          },
          credentials:'same-origin'
        }).catch(()=>{});
      }
    });
  </script>
</body>
</html>
