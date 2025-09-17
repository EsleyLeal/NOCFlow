<div class="container-xxl">
  <div id="formNovoTroubleshooting" class="collapse mt-3">
    <div class="p-4 rounded-3" style="background:#0f161d;border:1px solid #0f0;">
      <h2 class="neon mb-4">Novo Troubleshooting</h2>

      <form method="POST" action="{{ route('troubleshooting.store') }}">
        @csrf
        <div class="row g-3">

          <!-- Código do Chamado -->
          <div class="col-lg-4">
            <label class="form-label">Código do Chamado</label>
            <input type="text" name="ticket_code" class="form-control" placeholder="Ex: CHM12345">
          </div>

          <!-- Nome do Cliente -->
          <div class="col-lg-4">
            <label class="form-label">Nome do Cliente</label>
            <input type="text" name="client_name" class="form-control" placeholder="Ex: Escola ABC">
          </div>

          <!-- Tipo de Troubleshooting -->
          <div class="col-lg-4">
            <label class="form-label">Tipo de Troubleshooting</label>
            <select name="troubleshoot_type" class="form-select">
              <option value="">Selecione</option>
              <option value="ip">Dados IP</option>
              <option value="lan">LAN to LAN</option>
              <option value="bgp">BGP</option>
              <option value="vpn-l2">VPN L2</option>
              <option value="vpn-l3">VPN L3</option>
              <option value="escola">Escola</option>
              <option value="massivo">Massivo</option>
            </select>
          </div>

          <!-- Descrição -->
          <div class="col-12">
            <label class="form-label">Relato</label>
            <input type="text" name="description" class="form-control" placeholder="Breve descrição do problema">
          </div>

          <!-- === NOVOS CAMPOS DE ENDEREÇO === -->
          <div class="col-lg-6">
            <label class="form-label">Endereço</label>
            <input type="text" name="endereco" class="form-control" placeholder="Ex: Rua das Flores, 123">
          </div>

          <div class="col-lg-6">
            <label class="form-label">Bairro</label>
            <input type="text" name="bairro" class="form-control" placeholder="Ex: Centro">
          </div>

          <div class="col-lg-6">
            <label class="form-label">Complemento</label>
            <input type="text" name="complemento" class="form-control" placeholder="Ex: Bloco A, Sala 12">
          </div>

          <div class="col-lg-6">
            <label class="form-label">Cidade</label>
            <input type="text" name="cidade" class="form-control" placeholder="Ex: Fortaleza">
          </div>

          <div class="col-lg-6">
            <label class="form-label">Grupo</label>
            <select name="grupo" class="form-select">
              <option value="">Selecione</option>
              <option value="Governo Matriz">Governo Matriz</option>
              <option value="corporativo">Corporativo</option>
            </select>
          </div>

          <div class="col-lg-6">
            <label class="form-label">UF</label>
            <select name="uf" class="form-select">
              <option value="">Selecione</option>
              <option value="AC">AC</option>
              <option value="AL">AL</option>
              <option value="AP">AP</option>
              <option value="AM">AM</option>
              <option value="BA">BA</option>
              <option value="CE">CE</option>
              <option value="DF">DF</option>
              <option value="ES">ES</option>
              <option value="GO">GO</option>
              <option value="MA">MA</option>
              <option value="MT">MT</option>
              <option value="MS">MS</option>
              <option value="MG">MG</option>
              <option value="PA">PA</option>
              <option value="PB">PB</option>
              <option value="PR">PR</option>
              <option value="PE">PE</option>
              <option value="PI">PI</option>
              <option value="RJ">RJ</option>
              <option value="RN">RN</option>
              <option value="RS">RS</option>
              <option value="RO">RO</option>
              <option value="RR">RR</option>
              <option value="SC">SC</option>
              <option value="SP">SP</option>
              <option value="SE">SE</option>
              <option value="TO">TO</option>
            </select>
          </div>
          <!-- ============================== -->

          <!-- Campos Dinâmicos -->
          <div class="col-12">
            <label class="form-label">Detalhes do Circuito</label>
            <div id="dynamic-fields" class="sortable-list"></div>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('PE')">+ PE:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('CPE')">+ CPE:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('ONU')">+ ONU:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('VLANS')">+ VLANs:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('GER')">+ GER:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('SW')">+ SW:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('PORTA')">+ Porta:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('PARCEIRO')">+ Parceiro:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('PRTG', true)">+ PRTG:</button>
          </div>

          <!-- Passos -->
          <div class="col-12">
            <label class="form-label">Passos para a solução</label>
            <textarea name="steps" class="form-control" rows="6" placeholder="Digite cada passo em uma linha separada..."></textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <button type="button" class="btn btn-dark"
                  data-bs-toggle="collapse" data-bs-target="#formNovoTroubleshooting">
            Cancelar
          </button>
          <button type="submit" class="btn btn-success">
            Adicionar Troubleshoot
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- SortableJS para drag-and-drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
  // Ativa drag-and-drop nos cards
  new Sortable(document.getElementById('dynamic-fields'), {
    animation: 150,
    handle: '.drag-handle',
    ghostClass: 'sortable-ghost'
  });

  // Campos Dinâmicos
  // Campos Dinâmicos
function addField(type, isLink = false) {
  const container = document.getElementById('dynamic-fields');
  const div = document.createElement('div');
  div.classList.add('mt-2', 'card', 'p-3');
  div.setAttribute('draggable', 'true');

  let inputField = `
    <div class="row g-2">
      <div class="col-md-3">
        <input type="text" name="${type.toLowerCase()}[]" class="form-control" placeholder="Digite ${type}">
      </div>
  `;

  // Se NÃO for VLANs e NÃO for PARCEIRO → adiciona Fabricante
  if (type !== 'VLANS' && type != 'PORTA' && type !== 'PARCEIRO' && !isLink) {
    inputField += `
      <div class="col-md-3">
        <select name="${type.toLowerCase()}_vendor[]" class="form-select">
          <option value="">Fabricante</option>
          <option value="Huawei">Huawei</option>
          <option value="Cisco">Cisco</option>
          <option value="Winbox">Winbox</option>
          <option value="Juniper">Juniper</option>
          <option value="Extreme">Extreme</option>
          <option value="Nokia">Nokia</option>
          <option value="Fiberhome">Fiberhome</option>
        </select>
      </div>
    `;
  }

  // Campo Observações (sempre aparece, exceto PRTG)
  if (!isLink) {
    inputField += `
      <div class="col-md-4">
        <input type="text" name="${type.toLowerCase()}_notes[]" class="form-control" placeholder="Observações">
      </div>
    `;
  }

  inputField += `</div>`; // fecha row

  // Caso seja PRTG (link especial)
  if (isLink) {
    inputField = `
      <div class="row g-2">
        <div class="col-md-8">
          <input type="url" name="${type.toLowerCase()}[]" class="form-control" placeholder="https://link-do-prtg">
        </div>
        <div class="col-md-2">
          <a href="#" target="_blank" class="btn btn-primary w-100 open-link">Abrir</a>
        </div>
      </div>
    `;
  }

  div.innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-2">
      <label class="form-label m-0">${type}</label>
      <span class="drag-handle" style="cursor: grab;">☰</span>
    </div>
    ${inputField}
    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="this.parentElement.remove()">Remover</button>
  `;

  container.appendChild(div);

  // Se for PRTG → ativar botão Abrir
  if (isLink) {
    const input = div.querySelector('input');
    const linkBtn = div.querySelector('.open-link');

    linkBtn.addEventListener('click', function (e) {
      e.preventDefault();
      if (input.value) {
        window.open(input.value, '_blank');
      } else {
        alert('Informe um link válido do PRTG antes de abrir.');
      }
    });
  }
}

</script>

<style>
  /* Destaque enquanto arrasta */
  .sortable-ghost {
    opacity: 0.6;
    background: #0f0 !important;
  }
  .drag-handle {
    font-size: 18px;
    color: #0f0;
  }
</style>
