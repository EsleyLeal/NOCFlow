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
            <option>SEDE NOVO- FIBERHOME</option>
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
            placeholder="Pesquisar por cliente, cidade, pe, porta...">
    </div>
    <div id="searchResults" class="list-group position-absolute w-100 shadow"
        style="z-index:1050; max-height: 300px; overflow-y:auto; display:none;">
    </div>
  </div>

  <!-- ACORDEÃO (dinâmico) -->
  <main class="container-xxl pb-5">
  <div class="row g-4">
    @forelse($items as $ts)
      <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <div class="card bg-dark text-light border-secondary shadow-sm h-100"
             style="border-radius:1rem; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;">

          <!-- Cabeçalho -->
          <div class="p-3">
            <div class="fw-bold mb-2" style="line-height:1.2;">
  <span style="color:#39ff14;">{{ strtoupper($ts->nome ?? '-') }}</span><br>
  <span style="color:#00bfff;">{{ strtoupper($ts->cidade ?? '-') }}</span>
  <span style="color:#66c2ff;">- {{ strtoupper($ts->avenida ?? '-') }}</span><br>
  <span style="color:#facc15;">{{ strtoupper($ts->complemento ?? '-') }}</span>
</div>

            <div class="small">
              <strong>CPE:</strong> {{ strtoupper($ts->cpe ?? '-') }}<br>
              <strong>PE:</strong> {{ strtoupper($ts->pe ?? '-') }}<br>
              <strong>PORTA:</strong> {{ strtoupper($ts->porta ?? '-') }}
            </div>
            <div class="small mt-2">
              <strong style="color:#ffcc00;">PARCEIRO:</strong> {{ strtoupper($ts->parceiro ?? '-') }}<br>
              <strong style="color:#ffcc00;">VLANS:</strong> {{ strtoupper($ts->vlans ?? '-') }}<br>
              <strong style="color:#ffcc00;">PÚBLICO:</strong> {{ strtoupper($ts->publico ?? '-') }}
            </div>
          </div>

          <!-- Rodapé -->
          <div class="p-3 border-top border-secondary d-flex justify-content-end gap-2">
            <button class="btn btn-sm btn-success btn-copy-circuit" data-id="{{ $ts->id }}">Copiar</button>
            <button class="btn btn-sm btn-primary btn-edit-ts" data-id="{{ $ts->id }}">Editar</button>
            <button class="btn btn-sm btn-danger btn-delete-ts" data-id="{{ $ts->id }}">Excluir</button>
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
    resultsDiv.innerHTML = `<div class="list-group-item text-muted">Nenhum resultado encontrado</div>`;
    return;
  }

  data.forEach(item => {
    const el = document.createElement("a");
    el.href = `#c-ts-${item.id}`;
    el.className = "list-group-item list-group-item-action bg-dark text-light border-secondary";

    el.innerHTML = `
      <div>
        <span style="color:#39ff14; font-weight:600;">
          ${(item.nome ?? '-').toUpperCase()}
        </span>
        -
        <span style="color:#00bfff; font-weight:500;">
          ${(item.cidade ?? '-').toUpperCase()}
        </span>
        -
        ${(item.avenida ?? '-').toUpperCase()}
        -
        <span style="color:#ffcc00; font-weight:500;">
          ${(item.complemento ?? '-').toUpperCase()}
        </span>
      </div>
      <div class="small mt-1">
        <span style="color:#00bfff;">CPE:</span> ${item.cpe ?? '-'} |
        <span style="color:#00bfff;">PE:</span> ${item.pe ?? '-'} |
        <span style="color:#00bfff;">PORTA:</span> ${item.porta ?? '-'} |
        <span style="color:#00bfff;">PARCEIRO:</span> ${item.parceiro ?? '-'}
      </div>
    `;

    el.addEventListener("click", (e) => {
      e.preventDefault();

      resultsDiv.style.display = "none";
      resultsDiv.innerHTML = "";
      searchBox.value = "";

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
