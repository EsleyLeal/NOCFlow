<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Guia de Troubleshooting</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


  <script src="/js/template.js"></script>
  <script src="/js/modelo.js"></script>
  <script src="/js/massivo.js"></script>


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



  <!-- Modal de Edição -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header">
          <h5 class="modal-title">Editar Troubleshooting</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="editFormContainer">
          <!-- O formulário de edição será carregado via AJAX -->
        </div>
      </div>
    </div>
  </div>

 <!-- Botão flutuante (abre lista de Massivos salvos) -->
<button
  id="btnMassivos"
  class="btn btn-danger position-fixed"
  style="bottom:170px; right:20px; z-index:2000;"
  data-bs-toggle="modal"
  data-bs-target="#massivoListModal">
  🔔 Massivos em Andamento (0)
</button>

<!-- Modal Lista de Massivos -->
<div class="modal fade" id="massivoListModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title">Massivos em Andamento</h5>
        <div class="d-flex align-items-center gap-2">
          <button id="clearMassivos" class="btn btn-danger btn-sm">🧹 Limpar todos</button>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
      </div>
      <div class="modal-body" id="massivoListCompact">
        <div class="muted">Nenhum massivo salvo.</div>
      </div>
    </div>
  </div>
</div>


<!-- Botão flutuante (abre modal de criação de Massivo) -->
<button
  id="btnMassivo"
  class="btn btn-warning position-fixed"
  style="bottom:120px; right:20px; z-index:2000;"
  data-bs-toggle="modal"
  data-bs-target="#massivoModal">
  📋 Novo Massivo
</button>




  <!-- Botão flutuante -->
  <button
    id="btnTemplates"
    class="btn btn-primary position-fixed"
    style="bottom:70px; right:20px; z-index:2000;"
    data-bs-toggle="modal"
    data-bs-target="#templatesModal">
    📧 Modelos de Email
  </button>

 <!-- Modal Massivo -->
<div class="modal fade" id="massivoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title">Gerar Lista Massiva</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <!-- Seleção da OLT -->
        <div class="mb-3">
          <label class="form-label">OLT</label>
          <select id="oltSelect" class="form-select bg-dark text-light">
            <option value="">-- Selecione --</option>
            <option>DISTRITO - EPON - FIBERHOME</option>
            <option>JPA - TAMBIA - FIBERHOME</option>
            <option>CABEDELO - EPON - FIBERHOME</option>
            <option>BESSA NORTE - FIBERHOME</option>
            <option>BESSA SUL - FIBERHOME</option>
            <option>TAMBÁU CABO BRANCO - FIBERHOME</option>
            <option>TAMBÁU MANAÍRA - FIBERHOME</option>
            <option>SEDE - FIBERHOME</option>
            <option>MME A02 - FIBERHOME</option>
            <option>MME PL - FIBERHOME</option>
            <option>CAPIM - FIBERHOME</option>
            <option>RIO TINTO - FIBERHOME</option>
            <option>CAMPINA GRADE - FIBERHOME</option>
            <option>PATOS - FIBERHOME</option>
            <option>SEDE PATOS - FIBERHOME</option>
            <option>BANCÁRIOS - HUAWEI</option>
            <option>MANGABEIRA - HUAWEI</option>
            <option>MANGABEIRA 02 - HUAWEI</option>
            <option>BOSQUE - HUAWEI</option>
            <option>DT - HUAWEI</option>
            <option>CBD - HUAWEI</option>
            <option>ALAMOANA - HUAWEI</option>
          </select>
        </div>

        <!-- Campos Fiberhome -->
        <div id="fiberhomeFields" class="mb-3" style="display:none;">
          <label class="form-label">Slot</label>
          <input type="text" id="fiberSlot" class="form-control bg-dark text-light mb-2">
          <label class="form-label">PON</label>
          <input type="text" id="fiberPon" class="form-control bg-dark text-light">
        </div>

        <!-- Campos Huawei -->
        <div id="huaweiFields" class="mb-3" style="display:none;">
          <label class="form-label">Frame</label>
          <input type="text" id="huaweiFrame" class="form-control bg-dark text-light mb-2">
          <label class="form-label">Slot</label>
          <input type="text" id="huaweiSlot" class="form-control bg-dark text-light mb-2">
          <label class="form-label">PON</label>
          <input type="text" id="huaweiPon" class="form-control bg-dark text-light">
        </div>

        <!-- Horário -->
        <div class="mb-3">
          <label class="form-label">Horário da Queda</label>
          <input type="time" id="horaQueda" class="form-control bg-dark text-light">
        </div>

        <!-- Lista -->
        <textarea id="massivoInput" class="form-control bg-dark text-light" rows="8"
          placeholder="Cole aqui a lista bruta da OLT..."></textarea>

        <button id="processMassivo" class="btn btn-success mt-3">Gerar</button>

        <h6 class="mt-4">Resultado:</h6>
        <pre id="massivoOutput" class="bg-secondary p-3 rounded text-light" style="white-space:pre-wrap;"></pre>
        <button id="copyMassivo" class="btn btn-primary mt-2">📋 Copiar</button>
        <button id="saveMassivo" class="btn btn-warning mt-2">💾 Salvar Massivo</button>

      </div>
    </div>
  </div>
</div>




  <!-- Modal de Modelos -->
  <div class="modal fade" id="templatesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header">
          <h5 class="modal-title">Modelos de E-mails</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="templateSelector" class="mb-3"></div>
          <div id="templatePreview" class="p-3 bg-secondary rounded" style="white-space:pre-wrap;"></div>
          <button id="copyTemplate" class="btn btn-success mt-3">📋 Copiar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Botão flutuante (abre o modal) -->
  <button
    id="btnNotes"
    class="btn btn-success position-fixed"
    style="bottom:20px; right:20px; z-index:2000;"
    data-bs-toggle="modal"
    data-bs-target="#notesModal">
    📝 Notas
  </button>

  <!-- Modal de Notas -->
  <div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header">
          <h5 class="modal-title">Minhas Anotações do Dia</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <textarea id="dailyNotes" class="form-control bg-dark text-light" rows="10"
                    placeholder="Digite suas anotações aqui..."></textarea>
        </div>
      </div>
    </div>
  </div>

  <!-- HERO -->
  <section class="container-xxl py-4">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
      <div>
        <h1 class="neon mb-1" style="font:800 2rem/1.1 ui-monospace, Menlo, Consolas">
          Guia de Troubleshooting
        </h1>
        <p class="muted mb-0">Soluções para problemas comuns em redes</p>
      </div>
      <a class="btn-neon"
        data-bs-toggle="collapse"
        href="#formNovoTroubleshooting"
        role="button"
        aria-expanded="false"
        aria-controls="formNovoTroubleshooting">
        <svg width="18" height="18" viewBox="0 0 24 24">
          <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/>
        </svg>
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

  <!-- PESQUISA -->
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
          <h2 class="accordion-header" id="{{ $hid }}">
            <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#{{ $cid }}"
                    aria-expanded="false" aria-controls="{{ $cid }}">
              <span class="badge-chip">TS</span>
              <div>
                <small class="muted">
                  {{ strtoupper($ts->client_name ?? '-') }} - {{ strtoupper($ts->cidade ?? '-') }}
                  | Criado por:
                  {{ $ts->user?->isAdmin() ? 'Administrador' : ucfirst(explode(' ', $ts->user->nome ?? '-')[0]) }}
                </small>
              </div>
            </button>
          </h2>

          <div id="{{ $cid }}" class="accordion-collapse collapse" aria-labelledby="{{ $hid }}" data-bs-parent="#accTroubles">
            <div class="accordion-body">

              @can('delete', $ts)
                <div class="text-end mt-3 d-flex justify-content-end gap-2">
                  <button class="btn btn-sm btn-success btn-copy-circuit" data-id="{{ $ts->id }}">
                    Copiar Circuito
                  </button>
                  <button class="btn btn-sm btn-primary btn-edit-ts" data-id="{{ $ts->id }}">
                    Editar
                  </button>
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
                    <tr><th style="width: 180px;">Código do Chamado</th><td>{{ strtoupper($ts->ticket_code ?? '-') }}</td></tr>
                    <tr><th>Cliente</th><td>{{ strtoupper($ts->client_name ?? '-') }}</td></tr>
                    <tr><th>Endereço</th><td>{{ strtoupper($ts->endereco ?? '-') }}</td></tr>
                    <tr><th>Bairro</th><td>{{ strtoupper($ts->bairro ?? '-') }}</td></tr>
                    <tr><th>Complemento</th><td>{{ strtoupper($ts->complemento ?? '-') }}</td></tr>
                    <tr><th>Cidade</th><td>{{ strtoupper($ts->cidade ?? '-') }}</td></tr>
                    <tr><th>Grupo</th><td>{{ strtoupper($ts->grupo ?? '-') }}</td></tr>
                    <tr><th>UF</th><td>{{ strtoupper($ts->uf ?? '-') }}</td></tr>
                    <tr><th>Tipo de Contrato</th><td>{{ strtoupper($ts->troubleshoot_type ?? '-') }}</td></tr>
                    <tr><th>Relato</th><td>{{ strtoupper($ts->description ?? '-') }}</td></tr>
                  </tbody>
                </table>
              </div>

              <!-- Informação de Circuito -->
              @if($ts->details && count(json_decode($ts->details, true)) > 0)
                <h6 class="neon">Informação de Circuito</h6>
                <div class="table-responsive mb-3">
                  <table class="table table-sm table-dark table-striped table-bordered align-middle">
                    <thead><tr><th>Campo</th><th>Valor</th><th>Fabricante</th><th>Observações</th></tr></thead>
                    <tbody>
                      @foreach(json_decode($ts->details, true) as $key => $entries)
                        @foreach($entries as $entry)
                          @php
                            $value  = is_array($entry) ? ($entry['value'] ?? '') : $entry;
                            $vendor = is_array($entry) ? ($entry['vendor'] ?? '') : '';
                            $notes  = is_array($entry) ? ($entry['notes'] ?? '') : '';
                          @endphp
                          @if($value || $vendor || $notes)
                            <tr>
                              <td class="fw-bold text-uppercase">{{ $key }}</td>
                              <td>{{ $value ?: '-' }}</td>
                              <td>{{ $vendor ?: '-' }}</td>
                              <td>{{ $notes ?: '-' }}</td>
                            </tr>
                          @endif
                        @endforeach
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif

              <!-- Ocorrência -->
              @if(!empty($ts->steps))
                <h6 class="neon">O que foi feito para resolução do Troubleshooting</h6>
                <div class="text-white bg-dark p-3 rounded">
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

// Funcao de teste anotacoes, ainda em teste
document.addEventListener("DOMContentLoaded", () => {
  const textarea = document.getElementById("dailyNotes");
  if (!textarea) return;

  // chave por data (YYYY-MM-DD)
  const today = new Date().toISOString().slice(0, 10);
  const notesKey = `notes-${today}`;

  // remove notas antigas (só mantém a do dia)
  const toRemove = [];
  for (let i = 0; i < localStorage.length; i++) {
    const k = localStorage.key(i);
    if (k && k.startsWith("notes-") && k !== notesKey) toRemove.push(k);
  }
  toRemove.forEach(k => localStorage.removeItem(k));

  // carrega a nota do dia
  const loadNotes = () => {
    textarea.value = localStorage.getItem(notesKey) || "";
  };
  loadNotes();

  // salva a cada digitação
  textarea.addEventListener("input", () => {
    localStorage.setItem(notesKey, textarea.value);
  });

  // se abrir o modal depois da meia-noite, recarrega o conteúdo
  const modalEl = document.getElementById("notesModal");
  modalEl.addEventListener("shown.bs.modal", loadNotes);

  // sincroniza se editar em outra aba
  window.addEventListener("storage", (e) => {
    if (e.key === notesKey) textarea.value = e.newValue || "";
  });
});


// teste


document.querySelectorAll('.btn-edit-ts').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;

    fetch(`/troubleshooting/${id}/edit`)
      .then(res => res.text())
      .then(html => {
        document.getElementById("editFormContainer").innerHTML = html;

        // abre o modal
        const modal = new bootstrap.Modal(document.getElementById("editModal"));
        modal.show();
      })
      .catch(() => alert("Erro ao carregar formulário de edição."));
  });
});



</script>


</body>
</html>
