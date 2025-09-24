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

<div class="container-xxl mb-3 position-relative">
  <div class="input-group">
  <span class="input-group-text bg-dark text-light">🔍</span>
  <input type="text" id="searchBox" class="form-control"
         placeholder="Pesquisar por cliente, cidade, ticket, grupo...">
</div>




  <div id="searchResults" class="list-group position-absolute w-100 shadow"
       style="z-index:1050; max-height: 300px; overflow-y:auto; display:none;">
  </div>
</div>

 <!-- ACORDEÃO (dinâmico) -->
<main class="container-xxl pb-5">
  <div class="accordion accordion-dark" id="accTroubles">

    @forelse($items as $ts)
      @php
        $hid = "h-ts-{$ts->id}";
        $cid = "c-ts-{$ts->id}";
        $steps = preg_split("/\r\n|\n|\r/", (string)($ts->steps ?? ''));
        $steps = array_values(array_filter(array_map('trim', $steps), fn($s) => $s !== ''));
      @endphp

      <div class="accordion-item">
        <!-- Cabeçalho -->
        <h2 class="accordion-header" id="{{ $hid }}">
          <button class="accordion-button collapsed" type="button"
                  data-bs-toggle="collapse" data-bs-target="#{{ $cid }}"
                  aria-expanded="false" aria-controls="{{ $cid }}">
            <span class="badge-chip">TS</span>
           <div>
  <small class="muted">
    {{ strtoupper($ts->client_name ?? '-') }} - {{ strtoupper($ts->cidade ?? '-') }}
    | Criado por:
    @php
        // pega o nome bruto (pode vir "esley.s", "Esley Santana", etc)
        $raw = (string) ($ts->user->nome ?? '');

        // quebra no primeiro separador: ponto, espaço ou underline
        $token = preg_split('/[.\s_]+/u', trim($raw), 2)[0] ?? '';

        // capitaliza corretamente (com acentos)
        $firstName = $token !== ''
            ? mb_strtoupper(mb_substr($token, 0, 1), 'UTF-8') . mb_strtolower(mb_substr($token, 1), 'UTF-8')
            : '-';
    @endphp
    {{ $ts->user?->isAdmin() ? 'Administrador' : $firstName }}
  </small>
</div>

          </button>
        </h2>

        <div id="{{ $cid }}" class="accordion-collapse collapse" aria-labelledby="{{ $hid }}" data-bs-parent="#accTroubles">
          <div class="accordion-body">

            <!-- Botão Excluir: só mostra se admin ou dono -->
@can('delete', $ts)
  <div class="text-end mt-3 d-flex justify-content-end gap-2">
    <button class="btn btn-sm btn-success btn-copy-circuit" data-id="{{ $ts->id }}">
      Copiar Circuito
    </button>

    {{-- <button class="btn btn-sm btn-primary btn-edit-ts" data-id="{{ $ts->id }}">
      Editar
    </button> --}}

    <button class="btn btn-sm btn-danger btn-delete-ts" data-id="{{ $ts->id }}">
      Excluir
    </button>
  </div>
@endcan




            <!-- Cadastro do Cliente -->
            <h6 class="neon">Cadastro do Cliente</h6>
            <div class="mb-3">
              <table class="table table-sm table-dark table-bordered align-middle">
                <tbody>
                  <tr>
                    <th style="width: 180px;">Código do Chamado</th>
                    <td class="editable" data-id="{{ $ts->id }}" data-field="ticket_code">
                      {{ $ts->ticket_code ? strtoupper($ts->ticket_code) : '-' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Cliente</th>
                    <td class="editable" data-id="{{ $ts->id }}" data-field="client_name">
                      {{ $ts->client_name ? strtoupper($ts->client_name) : '-' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Endereço</th>
                    <td class="editable" data-id="{{ $ts->id }}" data-field="endereco">
                      {{ $ts->endereco ? strtoupper($ts->endereco) : '-' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Bairro</th>
                    <td class="editable" data-id="{{ $ts->id }}" data-field="bairro">
                      {{ $ts->bairro ? strtoupper($ts->bairro) : '-' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Complemento</th>
                    <td class="editable" data-id="{{ $ts->id }}" data-field="complemento">
                      {{ $ts->complemento ? strtoupper($ts->complemento) : '-' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Cidade</th>
                    <td class="editable" data-id="{{ $ts->id }}" data-field="cidade">
                      {{ $ts->cidade ? strtoupper($ts->cidade) : '-' }}
                    </td>
                  </tr>
                  <tr>
                    <th>Grupo</th>
                    <td class="editable" data-id="{{ $ts->id }}" data-field="grupo">
                      {{ $ts->grupo ? strtoupper($ts->grupo) : '-' }}
                    </td>
                  </tr>
                  <tr>
                    <th>UF</th>
                    <td class="editable" data-id="{{ $ts->id }}" data-field="uf">
                      {{ $ts->uf ? strtoupper($ts->uf) : '-' }}
                    </td>
                  </tr>
                  <tr>
  <th>Tipo de Contrato</th>
  <td class="editable" data-id="{{ $ts->id }}" data-field="troubleshoot_type">
    {{ $ts->troubleshoot_type ? strtoupper($ts->troubleshoot_type) : '-' }}
  </td>
</tr>
<tr>
  <th>Relato</th>
  <td class="editable" data-id="{{ $ts->id }}" data-field="description">
    {{ $ts->description ? strtoupper($ts->description) : '-' }}
  </td>
</tr>

                </tbody>
              </table>
            </div>

            <!-- Informação de Circuito -->
            @if($ts->details && count(json_decode($ts->details, true)) > 0)
              <h6 class="neon">Informação de Circuito</h6>
              <div class="table-responsive mb-3">
                <table class="table table-sm table-dark table-striped table-bordered align-middle">
                  <thead>
                    <tr>
                      <th style="width: 120px;">Campo</th>
                      <th>Valor</th>
                      <th style="width: 160px;">Fabricante</th>
                      <th>Observações</th>
                    </tr>
                  </thead>
                  <tbody>
  @foreach(json_decode($ts->details, true) as $key => $entries)
    @foreach($entries as $entry)
      @php
        $value  = is_array($entry) ? ($entry['value'] ?? '') : $entry;
        $vendor = is_array($entry) ? ($entry['vendor'] ?? '') : '';
        $notes  = is_array($entry) ? ($entry['notes'] ?? '') : '';
        $hasLink = fn($txt) => Str::contains($txt, ['http://', 'https://']);
      @endphp

      @if(!empty($value) || !empty($vendor) || !empty($notes))
        <tr>
          <td class="fw-bold text-uppercase">{{ strtoupper($key) }}</td>

          <!-- VALUE -->
          <td class="editable-detail"
              data-id="{{ $ts->id }}"
              data-key="{{ $key }}"
              data-subfield="value"
              data-value="{{ $value }}">
            @if($hasLink($value))
              <div class="d-flex align-items-center gap-2">
                <span class="text-truncate" style="max-width:220px;">{{ $value }}</span>
                <a href="{{ $value }}" target="_blank" class="btn btn-sm btn-primary">Abrir</a>
              </div>
            @else
              {{ $value ? strtoupper($value) : '-' }}
            @endif
          </td>

          <!-- VENDOR -->
          <td class="editable-detail"
              data-id="{{ $ts->id }}"
              data-key="{{ $key }}"
              data-subfield="vendor"
              data-value="{{ $vendor }}">
            @if($hasLink($vendor))
              <div class="d-flex align-items-center gap-2">
                <span class="text-truncate" style="max-width:220px;">{{ $vendor }}</span>
                <a href="{{ $vendor }}" target="_blank" class="btn btn-sm btn-primary">Abrir</a>
              </div>
            @else
              {{ $vendor ? strtoupper($vendor) : '-' }}
            @endif
          </td>

          <!-- NOTES -->
          <td class="editable-detail"
              data-id="{{ $ts->id }}"
              data-key="{{ $key }}"
              data-subfield="notes"
              data-value="{{ $notes }}">
            @if($hasLink($notes))
              <div class="d-flex align-items-center gap-2">
                <span class="text-truncate" style="max-width:220px;">{{ $notes }}</span>
                <a href="{{ $notes }}" target="_blank" class="btn btn-sm btn-primary">Abrir</a>
              </div>
            @else
              {{ $notes ? strtoupper($notes) : '-' }}
            @endif
          </td>
        </tr>
      @endif
    @endforeach
  @endforeach
</tbody>

                </table>
              </div>

              <!-- Botão para adicionar novo campo -->


            @endif

            <!-- Ocorrência -->
            @if(!empty($ts->steps))
              <h6 class="neon">O que foi feito para resolução do Troubleshooting</h6>
              <div class="editable-steps text-white bg-dark p-3 rounded"
                   data-id="{{ $ts->id }}">
                {!! nl2br(e(strtoupper($ts->steps))) !!}
              </div>
            @endif

          </div>
        </div>
      </div>
    @empty
      <div class="text-center muted py-5">Nenhum troubleshooting cadastrado.</div>
    @endforelse



  </div>
</main>


 @include('reuse.footer')

  <script>



document.addEventListener("DOMContentLoaded", () => {
    const searchBox = document.getElementById("searchBox");
    const resultsDiv = document.getElementById("searchResults");
    let timer = null;

    searchBox.addEventListener("input", function() {
        clearTimeout(timer);
        const q = this.value.trim();

        if (!q) {
            resultsDiv.style.display = "none";
            resultsDiv.innerHTML = "";
            return;
        }

        timer = setTimeout(() => {
            fetch(`/troubleshooting/search?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(data => {
                    resultsDiv.innerHTML = "";
                    if (data.length === 0) {
                        resultsDiv.style.display = "block";
                        resultsDiv.innerHTML = `<div class="list-group-item text-muted">Nenhum resultado</div>`;
                        return;
                    }

                    data.forEach(item => {
                        const el = document.createElement("a");
                        el.href = `#c-ts-${item.id}`;
                        el.className = "list-group-item list-group-item-action";
                        el.innerHTML = `
                            <div><strong>${item.client_name ?? '-'}</strong> (${item.ticket_code ?? '-'})</div>
                            <small>${item.cidade ?? ''} ${item.uf ?? ''} | ${item.grupo ?? ''}</small><br>
                            <small class="text-muted">${item.description ?? ''}</small>
                        `;

                        // Clique abre o acordeão e faz scroll
                        el.addEventListener("click", (e) => {
                            e.preventDefault();

                            // Fecha todos os abertos
                            document.querySelectorAll('.accordion-collapse.show')
                                .forEach(c => c.classList.remove('show'));

                            const target = document.querySelector(`#c-ts-${item.id}`);
                            if (target) {
                                target.classList.add('show');
                                target.scrollIntoView({ behavior: 'smooth', block: 'center' });

                                const headerBtn = target.closest('.accordion-item').querySelector('.accordion-button');
                                if (headerBtn && headerBtn.classList.contains('collapsed')) {
                                    headerBtn.classList.remove('collapsed');
                                }
                            }

                            resultsDiv.style.display = "none";
                            resultsDiv.innerHTML = "";
                            searchBox.value = "";
                        });

                        resultsDiv.appendChild(el);
                    });

                    resultsDiv.style.display = "block";
                })
                .catch(() => {
                    resultsDiv.innerHTML = "<div class='list-group-item text-danger'>Erro ao buscar...</div>";
                    resultsDiv.style.display = "block";
                });
        }, 400); // debounce
    });

    // esconder dropdown se clicar fora
    document.addEventListener("click", (e) => {
        if (!resultsDiv.contains(e.target) && e.target !== searchBox) {
            resultsDiv.style.display = "none";
        }
    });
});


// COPIAR CIRCUITO

// Botão Copiar Circuito
document.querySelectorAll('.btn-copy-circuit').forEach(btn => {
  btn.addEventListener('click', async () => {
    const accordionItem = btn.closest('.accordion-item');

    // procura o título h6 que contém o texto
    const h6s = accordionItem.querySelectorAll('h6.neon');
    let table = null;

    h6s.forEach(h6 => {
      if (h6.textContent.trim() === "Informação de Circuito") {
        // pega a tabela logo depois do h6
        table = h6.nextElementSibling?.querySelector("table");
      }
    });

    if (!table) {
      alert("Nenhuma informação de circuito disponível.");
      return;
    }

    // monta o texto formatado
    let texto = "";
    table.querySelectorAll('tbody tr').forEach(row => {
      const cols = row.querySelectorAll('td, th');
let linha = Array.from(cols)
  .map(col => col.dataset.value ?? col.innerText.trim())

  .filter(txt => txt && txt !== "-")   // remove vazio e "-"
  .join(" | ");
      texto += linha + "\n";
    });

    try {
      await navigator.clipboard.writeText(texto.trim());
      btn.innerText = "Copiado!";
      setTimeout(() => btn.innerText = "Copiar Circuito", 1200);
    } catch (e) {
      alert("Não foi possível copiar.");
    }
  });
});


document.addEventListener("DOMContentLoaded", () => {
  // botão "copiar"
  document.querySelectorAll('.kbd-copy').forEach(btn => {
    btn.addEventListener('click', async ()=> {
      try{
        await navigator.clipboard.writeText(btn.getAttribute('data-copy')||'');
        const html = btn.innerHTML;
        btn.innerHTML = '<span style="display:flex;gap:.45rem;align-items:center"><svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/></svg>Copiado!</span>';
        setTimeout(()=>btn.innerHTML = html, 1200);
      }catch(e){ alert('Não foi possível copiar.'); }
    });
  });

  // ==============================
  // EDIÇÃO INLINE
  // ==============================

  // --- 1. Campos fixos
  document.querySelectorAll('.editable').forEach(cell => {
    cell.addEventListener('dblclick', function () {
      if (cell.querySelector('input')) return;

      const original = cell.dataset.value ?? cell.innerText.trim();

      const field = cell.dataset.field;
      const id = cell.dataset.id;

      const input = document.createElement('input');
      input.type = 'text';
      input.value = original !== '-' ? original : '';
      input.className = 'form-control form-control-sm';

      cell.innerHTML = '';
      cell.appendChild(input);
      input.focus();

      input.addEventListener('blur', () => salvarAlteracao(cell, input.value, original, field, id));
      input.addEventListener('keydown', e => { if (e.key === 'Enter') input.blur(); });
    });
  });

  // --- 2. Detalhes adicionais
  document.querySelectorAll('.editable-detail').forEach(cell => {
    cell.addEventListener('dblclick', function () {
      if (cell.querySelector('input')) return;

      const original = cell.dataset.value ?? cell.innerText.trim();

      const id = cell.dataset.id;
      const key = cell.dataset.key;
      const subfield = cell.dataset.subfield;

      const input = document.createElement('input');
      input.type = 'text';
      input.value = original !== '-' ? original : '';
      input.className = 'form-control form-control-sm';

      cell.innerHTML = '';
      cell.appendChild(input);
      input.focus();

      input.addEventListener('blur', () => salvarDetalhe(cell, input.value, original, id, key, subfield));
      input.addEventListener('keydown', e => { if (e.key === 'Enter') input.blur(); });
    });
  });

  // --- 3. Passos (linha por linha)
  document.querySelectorAll('.editable-step').forEach(li => {
    li.addEventListener('dblclick', function () {
      if (li.querySelector('input')) return;

      const original = li.innerText.trim();
      const id = li.dataset.id;
      const index = li.dataset.index;

      const input = document.createElement('input');
      input.type = 'text';
      input.value = original;
      input.className = 'form-control form-control-sm';

      li.innerHTML = '';
      li.appendChild(input);
      input.focus();

      input.addEventListener('blur', () => salvarStep(li, input.value, original, id, index));
      input.addEventListener('keydown', e => { if (e.key === 'Enter') input.blur(); });
    });
  });

  // --- 4. Passos (textarea inteiro)
  document.querySelectorAll('.editable-steps').forEach(div => {
    div.addEventListener('dblclick', function () {
      if (div.querySelector('textarea')) return;

      const original = div.innerText.trim();
      const id = div.dataset.id;

      const textarea = document.createElement('textarea');
      textarea.className = 'form-control';
      textarea.rows = 6;
      textarea.value = original;

      div.innerHTML = '';
      div.appendChild(textarea);
      textarea.focus();

      textarea.addEventListener('blur', () => salvarSteps(div, textarea.value, original, id));
    });
  });

  // --- Botão Excluir
  document.querySelectorAll('.btn-delete-ts').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;

      if (!confirm("Tem certeza que deseja excluir este troubleshooting?")) {
        return;
      }

      fetch(`/troubleshooting/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
      })
      .then(res => {
        if (!res.ok) throw new Error();
        const item = btn.closest('.accordion-item');
        if (item) item.remove();
      })
      .catch(() => {
        alert("Erro ao excluir o troubleshooting.");
      });
    });
  });

}); // fim do DOMContentLoaded

// ==============================
// FUNÇÕES DE SALVAR
// ==============================
function salvarAlteracao(cell, novoValor, original, field, id) {
  if (novoValor === original) { cell.innerText = original; return; }
  if (!confirm(`Deseja salvar a alteração de "${original}" para "${novoValor}"?`)) {
    cell.innerText = original; return;
  }

  fetch(`/troubleshooting/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ [field]: novoValor })
  })
  .then(res => { if (!res.ok) throw new Error(); cell.innerText = novoValor; })
  .catch(() => { alert("Erro ao salvar, talvez você não seja um administrador"); cell.innerText = original; });
}

function salvarDetalhe(cell, novoValor, original, id, key, subfield) {
  if (novoValor === original) {
    cell.innerHTML = renderCellContent(original);
    return;
  }

  fetch(`/troubleshooting/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ detail_key: key, subfield: subfield, value: novoValor })
  })
  .then(res => {
    if (!res.ok) throw new Error();

    // mantém valor cru no data-value
    cell.dataset.value = novoValor;
    cell.innerHTML = renderCellContent(novoValor);
  })
  .catch(() => {
    alert("Erro ao salvar detalhe");
    cell.innerHTML = renderCellContent(original);
  });
}


function renderCellContent(value) {
  if (value && (value.startsWith('http://') || value.startsWith('https://'))) {
    return `
      <div class="d-flex align-items-center gap-2">
        <span class="link-text text-truncate" style="max-width:220px;">${value}</span>
        <a href="${value}" target="_blank" class="btn btn-sm btn-primary">Abrir</a>
      </div>
    `;
  }
  return value ? value.toUpperCase() : '-';
}



function salvarStep(li, novoValor, original, id, index) {
  if (novoValor === original) { li.innerText = original; return; }
  if (!confirm(`Deseja salvar o passo de "${original}" para "${novoValor}"?`)) {
    li.innerText = original; return;
  }

  fetch(`/troubleshooting/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ step_index: index, value: novoValor })
  })
  .then(res => { if (!res.ok) throw new Error(); li.innerText = novoValor; })
  .catch(() => { alert("Erro ao salvar passo"); li.innerText = original; });
}

function salvarSteps(div, novoValor, original, id) {
  if (novoValor === original) {
    div.innerHTML = original.replace(/\n/g, "<br>");
    return;
  }
  if (!confirm("Deseja salvar os novos passos?")) {
    div.innerHTML = original.replace(/\n/g, "<br>");
    return;
  }

  fetch(`/troubleshooting/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ steps: novoValor })
  })
  .then(res => {
    if (!res.ok) throw new Error();
    div.innerHTML = novoValor.replace(/\n/g, "<br>");
  })
  .catch(() => {
    alert("Erro ao salvar passos");
    div.innerHTML = original.replace(/\n/g, "<br>");
  });
}
</script>


</body>
</html>
