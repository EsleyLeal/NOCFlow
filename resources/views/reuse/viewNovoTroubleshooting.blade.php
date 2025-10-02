<div class="container-xxl">

  {{-- Se NÃO for edição, mostra collapse --}}
  @if(!isset($ts))
    <div id="formNovoTroubleshooting" class="collapse mt-3">
  @endif

    <div class="p-4 rounded-3" style="background:#0f161d;border:1px solid #0f0;">
      <h2 class="neon mb-4">
        {{ isset($ts) ? 'Editar Troubleshooting' : 'Novo Troubleshooting' }}
      </h2>

      <form method="POST" action="{{ isset($ts) ? route('troubleshooting.update', $ts->id) : route('troubleshooting.store') }}">
        @csrf
        @if(isset($ts))
          @method('PUT')
        @endif

        <div class="row g-3">

          <!-- Código do Chamado -->
          <div class="col-lg-4">
            <label class="form-label">Código do Chamado</label>
            <input type="text" name="ticket_code" class="form-control"
                   placeholder="Ex: CHM12345"
                   value="{{ old('ticket_code', $ts->ticket_code ?? '') }}">
          </div>

          <!-- Nome do Cliente -->
          <div class="col-lg-4">
            <label class="form-label">Nome do Cliente</label>
            <input type="text" name="client_name" class="form-control"
                   placeholder="Ex: Escola ABC"
                   value="{{ old('client_name', $ts->client_name ?? '') }}">
          </div>

          <!-- Tipo de Contrato -->
          <div class="col-lg-4">
            <label class="form-label">Tipo de Contrato</label>
            <select name="troubleshoot_type" class="form-select">
              <option value="">Selecione</option>
              <option value="VPN PONTO A PONTO" {{ (isset($ts) && $ts->troubleshoot_type === 'VPN PONTO A PONTO') ? 'selected' : '' }}>VPN PONTO A PONTO</option>
              <option value="DADOS IP DEDICADO" {{ (isset($ts) && $ts->troubleshoot_type === 'DADOS IP DEDICADO') ? 'selected' : '' }}>DADOS IP DEDICADO</option>
              <option value="PME 30 MBPS - SEMI DEDICADO" {{ (isset($ts) && $ts->troubleshoot_type === 'PME 30 MBPS - SEMI DEDICADO') ? 'selected' : '' }}>PME SEMI DEDICADO</option>
            </select>
          </div>

          <!-- Descrição -->
          <div class="col-12">
            <label class="form-label">Tipo de Problema</label>
            <input type="text" name="description" class="form-control"
                   placeholder="Breve descrição do problema"
                   value="{{ old('description', $ts->description ?? '') }}">
          </div>

          <!-- === ENDEREÇO === -->
          <div class="col-lg-6">
            <label class="form-label">Endereço</label>
            <input type="text" name="endereco" class="form-control"
                   placeholder="Ex: Rua das Flores, 123"
                   value="{{ old('endereco', $ts->endereco ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">Bairro</label>
            <input type="text" name="bairro" class="form-control"
                   placeholder="Ex: Centro"
                   value="{{ old('bairro', $ts->bairro ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">Complemento</label>
            <input type="text" name="complemento" class="form-control"
                   placeholder="Ex: Bloco A, Sala 12"
                   value="{{ old('complemento', $ts->complemento ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">Cidade</label>
            <input type="text" name="cidade" class="form-control"
                   placeholder="Ex: Fortaleza"
                   value="{{ old('cidade', $ts->cidade ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">Grupo</label>
            <select name="grupo" class="form-select">
              <option value="">Selecione</option>
              <option value="Governo Matriz" {{ (isset($ts) && $ts->grupo === 'Governo Matriz') ? 'selected' : '' }}>Governo Matriz</option>
              <option value="corporativo" {{ (isset($ts) && $ts->grupo === 'corporativo') ? 'selected' : '' }}>Corporativo</option>
            </select>
          </div>

          <div class="col-lg-6">
            <label class="form-label">UF</label>
            <select name="uf" class="form-select">
              <option value="">Selecione</option>
              @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                <option value="{{ $uf }}" {{ (isset($ts) && $ts->uf === $uf) ? 'selected' : '' }}>{{ $uf }}</option>
              @endforeach
            </select>
          </div>
          <!-- ============================== -->

          <!-- Campos Dinâmicos -->
          <div class="col-12">
            <label class="form-label">Detalhes do Circuito</label>
            <div id="dynamic-fields-{{ isset($ts) ? $ts->id : 'new' }}" class="sortable-list">

              {{-- Repopula se for edição --}}
              @if(isset($ts) && $ts->details)
                @foreach(json_decode($ts->details, true) as $key => $entries)
                  @foreach($entries as $entry)
                    <div class="mt-2 card p-3" draggable="true">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label m-0">{{ strtoupper($key) }}</label>
                        <span class="drag-handle" style="cursor: grab;">☰</span>
                      </div>
                      <div class="row g-2">
                        {{-- Valor --}}
                        <div class="col-md-3">
                          <input type="text" name="{{ strtolower($key) }}[]" class="form-control"
                                 value="{{ $entry['value'] ?? '' }}" placeholder="Digite {{ $key }}">
                        </div>

                        {{-- Fabricante --}}
                        @if(!in_array(strtoupper($key), ['VLANS','PORTA','PARCEIRO','PRTG']))
                          <div class="col-md-3">
                            <select name="{{ strtolower($key) }}_vendor[]" class="form-select">
                              <option value="">Fabricante</option>
                              @foreach(['Huawei','Cisco','Winbox','Juniper','Extreme','Nokia','Fiberhome'] as $fab)
                                <option value="{{ $fab }}" {{ ($entry['vendor'] ?? '') === $fab ? 'selected' : '' }}>
                                  {{ $fab }}
                                </option>
                              @endforeach
                            </select>
                          </div>
                        @endif

                        {{-- Observações --}}
                        @if(strtoupper($key) !== 'PRTG')
                          <div class="col-md-4">
                            <input type="text" name="{{ strtolower($key) }}_notes[]" class="form-control"
                                   value="{{ $entry['notes'] ?? '' }}" placeholder="Observações">
                          </div>
                        @endif

                        {{-- Caso PRTG --}}
                        @if(strtoupper($key) === 'PRTG')
                          <div class="col-md-8">
                            <input type="url" name="prtg[]" class="form-control"
                                   value="{{ $entry['value'] ?? '' }}" placeholder="https://link-do-prtg">
                          </div>
                          <div class="col-md-2">
                            <a href="{{ $entry['value'] ?? '#' }}" target="_blank" class="btn btn-primary w-100">Abrir</a>
                          </div>
                        @endif
                      </div>
                      <button type="button" class="btn btn-sm btn-danger mt-2" onclick="this.parentElement.remove()">Remover</button>
                    </div>
                  @endforeach
                @endforeach
              @endif

            </div>

            <!-- Botões para adicionar novos -->
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('PE','dynamic-fields-{{ isset($ts) ? $ts->id : 'new' }}')">+ PE:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('CPE','dynamic-fields-{{ isset($ts) ? $ts->id : 'new' }}')">+ CPE:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('ONU','dynamic-fields-{{ isset($ts) ? $ts->id : 'new' }}')">+ ONU:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('VLANS','dynamic-fields-{{ isset($ts) ? $ts->id : 'new' }}')">+ VLANs:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('GER','dynamic-fields-{{ isset($ts) ? $ts->id : 'new' }}')">+ GER:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('SW','dynamic-fields-{{ isset($ts) ? $ts->id : 'new' }}')">+ SW:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('PORTA','dynamic-fields-{{ isset($ts) ? $ts->id : 'new' }}')">+ Porta:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('PARCEIRO','dynamic-fields-{{ isset($ts) ? $ts->id : 'new' }}')">+ Parceiro:</button>
            <button type="button" class="btn btn-sm btn-outline-info mt-2" onclick="addField('PRTG','dynamic-fields-{{ isset($ts) ? $ts->id : 'new' }}',true)">+ PRTG:</button>
          </div>

          <!-- Passos -->
          <div class="col-12">
            <label class="form-label">O que foi feito para resolução do Troubleshooting</label>
            <textarea name="steps" class="form-control" rows="6" placeholder="Digite cada passo em uma linha separada...">{{ old('steps', $ts->steps ?? '') }}</textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          @if(!isset($ts))
            <button type="button" class="btn btn-dark"
                    data-bs-toggle="collapse" data-bs-target="#formNovoTroubleshooting">
              Cancelar
            </button>
          @else
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          @endif

          <button type="submit" class="btn btn-success">
            {{ isset($ts) ? 'Salvar Alterações' : 'Adicionar Troubleshoot' }}
          </button>
        </div>
      </form>
    </div>

  @if(!isset($ts))
    </div>
  @endif
</div>


<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".sortable-list").forEach(el => {
    new Sortable(el, {
      animation: 150,
      handle: ".drag-handle",
      ghostClass: "sortable-ghost"
    });
  });
});

// função global
function addField(type, containerId, isLink = false) {
  const container = document.getElementById(containerId);
  if (!container) return;

  const div = document.createElement('div');
  div.classList.add('mt-2', 'card', 'p-3');
  div.setAttribute('draggable', 'true');

  let inputField = `
    <div class="row g-2">
      <div class="col-md-3">
        <input type="text" name="${type.toLowerCase()}[]" class="form-control" placeholder="Digite ${type}">
      </div>
  `;

  if (type !== 'VLANS' && type !== 'PORTA' && type !== 'PARCEIRO' && !isLink) {
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

  if (!isLink) {
    inputField += `
      <div class="col-md-4">
        <input type="text" name="${type.toLowerCase()}_notes[]" class="form-control" placeholder="Observações">
      </div>
    `;
  }

  inputField += `</div>`;

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
  .sortable-ghost { opacity: 0.6; background: #0f0 !important; }
  .drag-handle { font-size: 18px; color: #0f0; }
</style>
