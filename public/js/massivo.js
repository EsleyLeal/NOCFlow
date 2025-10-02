document.addEventListener("DOMContentLoaded", () => {
  const btnProcess = document.getElementById("processMassivo");
  const btnCopy = document.getElementById("copyMassivo");
  const btnSave = document.getElementById("saveMassivo");
  const input = document.getElementById("massivoInput");
  const output = document.getElementById("massivoOutput");

  // ⬇️ tenta usar o modal; se não existir, usa a seção antiga como fallback
  const list = document.getElementById("massivoListCompact") || document.getElementById("massivoList");
  const btnMassivos = document.getElementById("btnMassivos");

  // novos campos
  const oltSelect = document.getElementById("oltSelect");
  const fiberhomeFields = document.getElementById("fiberhomeFields");
  const huaweiFields = document.getElementById("huaweiFields");
  const horaQueda = document.getElementById("horaQueda");

  if (!btnProcess) return;

  // alterna campos conforme OLT
  oltSelect.addEventListener("change", () => {
    const val = oltSelect.value;
    if (/FIBERHOME/i.test(val)) {
      fiberhomeFields.style.display = "block";
      huaweiFields.style.display = "none";
    } else if (/HUAWEI/i.test(val)) {
      fiberhomeFields.style.display = "none";
      huaweiFields.style.display = "block";
    } else {
      fiberhomeFields.style.display = "none";
      huaweiFields.style.display = "none";
    }
  });

  function limparCodigoInicial(txt) {
    return txt.replace(/^[\d./-]+\s*-?\s*/u, "").trim();
  }

  function extrairNomeDeLinha(linha) {
    if (!linha) return "";
    let l = linha.replace(/^(DYINGGASP|LINK LOSS|Offline due to fiber issues)\s*/i, "").trim();
    let cols = l.split(/\t+/).map(c => c.trim()).filter(Boolean);
    if (cols.length < 2) cols = l.split(/\s{2,}/).map(c => c.trim()).filter(Boolean);

    let candidato = "";
    const idxOnu = cols.findIndex(c => /OnuID\d+/i.test(c));
    if (idxOnu !== -1 && idxOnu + 1 < cols.length) candidato = cols[idxOnu + 1];
    if (!candidato && cols.length >= 2 && /^(DYINGGASP|LINK LOSS)$/i.test(cols[0])) candidato = cols[1];
    if (!candidato && cols.length) {
      const possivel = cols.find(c =>
        !/^(Activate|Initial|True|False|Unknown|--|OTHER_|EG\d|V\d|LINE\-VLAN|SRV\-VLAN|alarm\-policy|BAC_PPPoE|OLT\-|Frame\d|Slot\d|Port\d|Auto)$/i.test(c)
        && !/[:/]/.test(c)
      );
      candidato = possivel || cols[0];
    }
    return limparCodigoInicial(candidato).trim();
  }

  btnProcess.addEventListener("click", () => {
    const text = input.value.trim();
    if (!text) {
      output.textContent = "⚠️ Cole uma lista primeiro.";
      return;
    }

    const linhas = text.split(/\r?\n/).map(l => l.trim()).filter(Boolean);
    const nomes = linhas.map(extrairNomeDeLinha).map(n => n.replace(/\s+/g, " ").trim()).filter(n => n.length > 0);

    const olt = oltSelect ? oltSelect.value : "";
    let cabecalho = olt || "OLT não especificada";

    if (/FIBERHOME/i.test(olt)) {
      const slot = document.getElementById("fiberSlot").value || "?";
      const pon = document.getElementById("fiberPon").value || "?";
      cabecalho += ` - SLOT ${slot} - PORT ${pon}`;
    } else if (/HUAWEI/i.test(olt)) {
      const frame = document.getElementById("huaweiFrame").value || "?";
      const slot = document.getElementById("huaweiSlot").value || "?";
      const pon = document.getElementById("huaweiPon").value || "?";
      cabecalho += ` - FRAME ${frame} - SLOT ${slot} - PON ${pon}`;
    }

    if (horaQueda && horaQueda.value) {
      cabecalho += `\n\nHORARIO DE QUEDA ${horaQueda.value}`;
    }

    const saida = `${cabecalho}\n\n${nomes.join("\n")}\n\n${nomes.length} NO TOTAL`;
    output.textContent = saida;
  });

  btnCopy.addEventListener("click", async () => {
    try {
      await navigator.clipboard.writeText(output.textContent.trim());
      btnCopy.innerText = "✅ Copiado!";
      setTimeout(() => btnCopy.innerText = "📋 Copiar", 1200);
    } catch {
      alert("Não foi possível copiar.");
    }
  });

  // =========================
  // salvar / listar massivos
  // =========================
  function renderMassivos() {
    const data = JSON.parse(localStorage.getItem("massivos") || "[]");

    if (!list) return; // se não tiver container, não quebra nada

    list.innerHTML = "";
    if (data.length === 0) {
      list.innerHTML = `<div class="muted">Nenhum massivo salvo.</div>`;
      if (btnMassivos) btnMassivos.textContent = "🔔 Massivos em Andamento (0)";
      return;
    }

    const emEspera = data.filter(m => m.status === "espera").length;
    if (btnMassivos) btnMassivos.textContent = `🔔 Massivos em Andamento (${emEspera})`;

    data.forEach((m, idx) => {
      const card = document.createElement("div");
      card.className = `p-3 rounded border mb-2 ${
        m.status === "espera" ? "border-warning text-warning" : "border-success text-success"
      }`;
      card.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
          <div style="white-space:pre-wrap">${m.text}</div>
          <div>
            ${
              m.status === "espera"
                ? `<button class="btn btn-sm btn-success finalizar" data-idx="${idx}">Finalizar</button>`
                : `<span class="badge bg-success">Finalizado</span>`
            }
          </div>
        </div>
      `;
      list.appendChild(card);
    });

    document.querySelectorAll(".finalizar").forEach(btn => {
      btn.addEventListener("click", () => {
        const data = JSON.parse(localStorage.getItem("massivos") || "[]");
        const idx = parseInt(btn.dataset.idx, 10);
        if (data[idx]) {
          const primeiraLinha = data[idx].text.split("\n")[0];
          const partes = primeiraLinha.split("-").map(p => p.trim());
          const nomeLimpo = partes.length >= 2 ? `${partes[0]} ${partes[1]}` : partes[0];
          const frase = `Massivo de ${nomeLimpo} finalizado, aqueles que ainda estão fora, devem ser tratados como isolados.`;

          const card = btn.closest(".d-flex").parentElement;
          card.innerHTML = `
            <div class="mb-2">${frase}</div>
            <button class="btn btn-sm btn-primary copiar-frase">📋 Copiar frase</button>
            <button class="btn btn-sm btn-success confirmar-finalizar" data-idx="${idx}">✅ Confirmar finalização</button>
          `;

          card.querySelector(".copiar-frase").addEventListener("click", () => {
            navigator.clipboard.writeText(frase);
          });

          card.querySelector(".confirmar-finalizar").addEventListener("click", () => {
            let data = JSON.parse(localStorage.getItem("massivos") || "[]");
            const idx2 = parseInt(btn.dataset.idx, 10);
            if (data[idx2]) {
              data.splice(idx2, 1);
              localStorage.setItem("massivos", JSON.stringify(data));
            }
            renderMassivos();
          });
        }
      });
    });
  }

  if (btnSave) {
    btnSave.addEventListener("click", () => {
      const text = output.textContent.trim();
      if (!text) {
        alert("⚠️ Gere primeiro o massivo antes de salvar.");
        return;
      }
      const data = JSON.parse(localStorage.getItem("massivos") || "[]");
      data.push({ text, status: "espera", date: new Date().toISOString() });
      localStorage.setItem("massivos", JSON.stringify(data));
      renderMassivos();
      alert("✅ Massivo salvo!");
    });
  }

  renderMassivos();

  // botão temporário de limpeza (no header do modal)
  const btnClear = document.getElementById("clearMassivos");
  if (btnClear) {
    btnClear.addEventListener("click", () => {
      if (confirm("Tem certeza que deseja limpar TODOS os massivos salvos?")) {
        localStorage.removeItem("massivos");
        renderMassivos();
        alert("✅ Todos os massivos foram removidos!");
      }
    });
  }
});
