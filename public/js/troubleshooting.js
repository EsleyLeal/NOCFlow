
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
  .map(col => col.innerText.trim())
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

      const original = cell.innerText.trim();
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

      const original = cell.innerText.trim();
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
  if (novoValor === original) { cell.innerText = original; return; }
  if (!confirm(`Deseja salvar o detalhe "${subfield}" de "${original}" para "${novoValor}"?`)) {
    cell.innerText = original; return;
  }

  fetch(`/troubleshooting/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ detail_key: key, subfield: subfield, value: novoValor })
  })
  .then(res => { if (!res.ok) throw new Error(); cell.innerText = novoValor; })
  .catch(() => { alert("Erro ao salvar detalhe"); cell.innerText = original; });
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

