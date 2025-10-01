// Script para função Modelos

document.addEventListener("DOMContentLoaded", () => {
  const selectorEl = document.getElementById("templateSelector");
  const previewEl = document.getElementById("templatePreview");
  const copyBtn = document.getElementById("copyTemplate");

  let currentTemplate = "";

  // Gera botões de seleção de modelos a partir do templates.js
  Object.keys(templates).forEach(name => {
    const btn = document.createElement("button");
    btn.className = "btn btn-outline-light m-1";
    btn.textContent = name;
    btn.onclick = () => loadTemplate(templates[name]);
    selectorEl.appendChild(btn);
  });

  // Converte placeholders em inputs
  function loadTemplate(template) {
    currentTemplate = template;

    previewEl.innerHTML = template.replace(/\[(.+?)\]/g, (match, p1) => {
      if (p1 === "INDISPONIBILIDADE TELY") {
        return `[INDISPONIBILIDADE TELY]`;
      }
      if (p1.startsWith("PARCEIRO")) {
        return `[PARCEIRO <input type="text" class="form-control d-inline-block w-auto mx-1 my-1"
                  placeholder="${p1.replace("PARCEIRO ","")}" data-placeholder="${p1}">]`;
      }
      if (p1.startsWith("CLIENTE")) {
        return `[CLIENTE <input type="text" class="form-control d-inline-block w-auto mx-1 my-1"
                  placeholder="${p1.replace("CLIENTE ","")}" data-placeholder="${p1}">]`;
      }
      if (p1 === "SAUDACAO") {
        const hora = new Date().getHours();
        let sugestao = "bom dia";
        if (hora >= 12 && hora < 18) sugestao = "boa tarde";
        else if (hora >= 18) sugestao = "boa noite";

        return `<input type="text" class="form-control d-inline-block w-auto mx-1 my-1"
                  value="${sugestao}" data-placeholder="SAUDACAO">`;
      }

      // Default → qualquer outro placeholder (NOME, CONTATO, EMAIL, RELATO, VLAN, PROTOCOLO, DATA etc.)
      return `<input type="text" class="form-control d-inline-block w-auto mx-1 my-1"
                placeholder="${p1}" data-placeholder="${p1}">`;
    });
  }

  // Copiar texto final preenchido
  copyBtn.onclick = () => {
    let filled = currentTemplate;

    previewEl.querySelectorAll("input").forEach(input => {
      let val = input.value.trim();
      const placeholder = input.dataset.placeholder;

      if (placeholder.startsWith("PARCEIRO")) {
        val = `PARCEIRO ${val || placeholder.replace("PARCEIRO ","")}`;
        filled = filled.replace(`[${placeholder}]`, `[${val}]`);
      }
      else if (placeholder.startsWith("CLIENTE")) {
        val = `CLIENTE ${val || placeholder.replace("CLIENTE ","")}`;
        filled = filled.replace(`[${placeholder}]`, `[${val}]`);
      }
      else if (placeholder === "SAUDACAO") {
        val = val || "bom dia";
        filled = filled.replace(`[${placeholder}]`, val);
      }
      else {
        // default → insere valor simples, sem colchetes
        if (placeholder === "DATA") val = val || "00/00/2024";
        else val = val || "----";

        filled = filled.replace(`[${placeholder}]`, val);
      }
    });

    navigator.clipboard.writeText(filled);
  };
});
