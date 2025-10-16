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

          <!-- NOME DO CLIENTE -->
          <div class="col-lg-4">
            <label class="form-label">NOME</label>
            <input type="text" name="nome" class="form-control"
                   placeholder="Ex: TJRN"
                   value="{{ old('nome', $ts->nome ?? '') }}">
          </div>

          <!-- CPE -->
          <div class="col-lg-4">
            <label class="form-label">CPE</label>
            <input type="text" name="cpe" class="form-control"
                   placeholder="Gerencia do cliente"
                   value="{{ old('cpe', $ts->cpe ?? '') }}">
          </div>

          <!-- Tipo de Contrato -->
          <div class="col-lg-4">
            <label class="form-label">PE</label>
            <input type="text" name="pe" class="form-control"
                   placeholder="Ex: Acesso do PE"
                   value="{{ old('pe', $ts->pe ?? '') }}">
          </div>

          <!-- Descrição -->
          <div class="col-12">
            <label class="form-label">DESIGNADOR</label>
            <input type="text" name="designador" class="form-control"
                   placeholder="designador"
                   value="{{ old('designador', $ts->designador ?? '') }}">
          </div>

          <!-- === ENDEREÇO === -->
          <div class="col-lg-6">
            <label class="form-label">VLANS</label>
            <input type="text" name="vlans" class="form-control"
                   placeholder="Ex: 1022 e 1023"
                   value="{{ old('vlans', $ts->vlans ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">IP PUBLICO</label>
            <input type="text" name="publico" class="form-control"
                   placeholder="Ex: 187.33."
                   value="{{ old('publico', $ts->publico ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">PARCEIRO</label>
            <input type="text" name="parceiro" class="form-control"
                   placeholder="Ex: Proxxima"
                   value="{{ old('parceiro', $ts->parceiro ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">PORTA</label>
            <input type="text" name="porta" class="form-control"
                   placeholder="Ex: XGE0/0/5"
                   value="{{ old('porta', $ts->porta ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">PRTG</label>
            <input type="text" name="prtg" class="form-control"
                   placeholder="link"
                   value="{{ old('prtg', $ts->prtg ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">AVENIDA</label>
            <input type="text" name="avenida" class="form-control"
                   placeholder="João Machado"
                   value="{{ old('avenida', $ts->avenida ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">BAIRRO</label>
            <input type="text" name="bairro" class="form-control"
                   placeholder="Ex: Bancarios"
                   value="{{ old('bairro', $ts->bairro ?? '') }}">
          </div>

          <div class="col-lg-6">
            <label class="form-label">COMPLEMENTO</label>
            <input type="text" name="complemento" class="form-control"
                   placeholder="Ex: complemento"
                   value="{{ old('complemento', $ts->complemento ?? '') }}">
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

          <div class="col-lg-6">
            <label class="form-label">Cidade</label>
            <input type="text" name="cidade" class="form-control"
                   placeholder="Ex: Fortaleza"
                   value="{{ old('cidade', $ts->cidade ?? '') }}">
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
