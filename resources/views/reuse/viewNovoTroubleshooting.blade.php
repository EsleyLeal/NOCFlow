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

<ul class="nav nav-tabs mb-4" id="tsTabs" role="tablist">
  <li class="nav-item">
    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-inicial" type="button">Dados Iniciais</button>
  </li>
  <li class="nav-item">
    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-endereco" type="button">Endereço</button>
  </li>
  <li class="nav-item">
    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-mais" type="button">Mais Informações</button>
  </li>
</ul>

<div class="tab-content">

  <!-- DADOS INICIAIS -->
  <div class="tab-pane fade show active" id="tab-inicial">
    <div class="row g-3">

      <div class="col-lg-4">
        <label class="form-label">Contrato</label>
        <input type="text" name="contrato" class="form-control" placeholder="Ex: 236589"
          value="{{ old('contrato', $ts->contrato ?? '') }}">
      </div>

      <div class="col-lg-4">
        <label class="form-label">Nome</label>
        <input type="text" name="nome" class="form-control" placeholder="Ex: TJRN"
          value="{{ old('nome', $ts->nome ?? '') }}">
      </div>

      <div class="col-lg-4">
  <label class="form-label">CPE</label>
  <input type="text" name="cpe" class="form-control" placeholder="Gerência do cliente"
    value="{{ old('cpe', $ts->IP ?? '') }}">
</div>


      <div class="col-lg-4">
        <label class="form-label">PE</label>
        <input type="text" name="pe" class="form-control" placeholder="Ex: Acesso do PE"
          value="{{ old('pe', $ts->pe ?? '') }}">
      </div>

      <div class="col-lg-4">
        <label class="form-label">VLANS</label>
        <input type="text" name="vlans" class="form-control" placeholder="Ex: 1022, 1023"
          value="{{ old('vlans', $ts->vlans ?? '') }}">
      </div>


      <div class="col-12 mt-3">
    <div class="form-check form-switch">
        <input class="form-check-input"
               type="checkbox"
               data-toggle-field="wrapperDesignador"
               {{ old('designador', $ts->designador ?? null) ? 'checked' : '' }}>
        <label class="form-check-label">DESIGNADOR</label>
    </div>

    <div id="wrapperDesignador"
         class="mt-2 {{ old('designador', $ts->designador ?? null) ? '' : 'd-none' }}">
        <input type="text" name="designador"
               class="form-control"
               placeholder="Ex: Designador"
               value="{{ old('designador', $ts->designador ?? '') }}">
    </div>
</div>



      <!-- ONU -->
      <div class="col-12 mt-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="onu"
            {{ old('onu', $ts->onu ?? null) ? 'checked' : '' }}
            onclick="document.getElementById('campoOnu').classList.toggle('d-none')">
          <label class="form-check-label" for="onu">ONU</label>
        </div>

        <div id="campoOnu"
          class="mt-2 {{ old('onu', $ts->onu ?? null) ? '' : 'd-none' }}">
          <input type="text" name="onu" class="form-control" placeholder="FHTT"
            value="{{ old('onu', $ts->onu ?? '') }}">
        </div>
      </div>


      <!-- PRTG -->
      <div class="col-12 mt-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="switchPrtg"
            {{ old('prtg', $ts->prtg ?? null) ? 'checked' : '' }}
            onclick="document.getElementById('campoPrtg').classList.toggle('d-none')">
          <label class="form-check-label" for="switchPrtg">PRTG (Link)</label>
        </div>

        <input type="text" id="campoPrtg" name="prtg"
          class="form-control mt-2 {{ old('prtg', $ts->prtg ?? null) ? '' : 'd-none' }}"
          placeholder="Cole o link do PRTG"
          value="{{ old('prtg', $ts->prtg ?? '') }}">
      </div>


      <!-- PARCEIRO -->
      <div class="col-12 mt-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="parceiro"
            {{ ($ts->parceiro ?? null) || ($ts->contato_parceiro ?? null) ? 'checked' : '' }}
            onclick="document.getElementById('campoParceiro').classList.toggle('d-none')">
          <label class="form-check-label" for="parceiro">Parceiro</label>
        </div>

        <div id="campoParceiro"
          class="mt-2 {{ ($ts->parceiro ?? null) || ($ts->contato_parceiro ?? null) ? '' : 'd-none' }}">
          <div class="row g-2">
            <div class="col-lg-6">
              <input type="text" name="parceiro" class="form-control"
                placeholder="Nome do parceiro"
                value="{{ old('parceiro', $ts->parceiro ?? '') }}">
            </div>
            <div class="col-lg-6">
              <input type="text" name="contato_parceiro" class="form-control"
                placeholder="Número para contato"
                value="{{ old('contato_parceiro', $ts->contato_parceiro ?? '') }}">
            </div>
          </div>
        </div>
      </div>


      <!-- PORTA (CORRIGIDO) -->
      <div class="col-12 mt-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="switchPorta"
            {{ old('porta', $ts->porta ?? null) ? 'checked' : '' }}
            onclick="document.getElementById('campoPorta').classList.toggle('d-none')">
          <label class="form-check-label" for="switchPorta">Porta</label>
        </div>

        <input type="text" id="campoPorta" name="porta"
          class="form-control mt-2 {{ old('porta', $ts->porta ?? null) ? '' : 'd-none' }}"
          placeholder="Ex: XGE0/0/5"
          value="{{ old('porta', $ts->porta ?? '') }}">
      </div>


      <!-- SW ACESSO (CORRIGIDO) -->
      <div class="col-12 mt-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="sw_acesso"
            {{ old('sw_acesso', $ts->sw_acesso ?? null) ? 'checked' : '' }}
            onclick="document.getElementById('campoSwAcesso').classList.toggle('d-none')">
          <label class="form-check-label" for="sw_acesso">SW de Acesso</label>
        </div>

        <input type="text" id="campoSwAcesso" name="sw_acesso"
          class="form-control mt-2 {{ old('sw_acesso', $ts->sw_acesso ?? null) ? '' : 'd-none' }}"
          placeholder="Ex: S5720-32X-EI"
          value="{{ old('sw_acesso', $ts->sw_acesso ?? '') }}">
      </div>


      <!-- IP PUBLICO (CORRIGIDO) -->
      <div class="col-12 mt-3 mb-4">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="switchPublico"
            {{ old('publico', $ts->publico ?? null) ? 'checked' : '' }}
            onclick="document.getElementById('campoPublico').classList.toggle('d-none')">
          <label class="form-check-label" for="switchPublico">IP Público</label>
        </div>

        <input type="text" id="campoPublico" name="publico"
          class="form-control mt-2 {{ old('publico', $ts->publico ?? null) ? '' : 'd-none' }}"
          placeholder="Ex: 187.33.x.x"
          value="{{ old('publico', $ts->publico ?? '') }}">
      </div>

    </div>
  </div>


  <!-- ENDEREÇO -->
  <div class="tab-pane fade" id="tab-endereco">
    <div class="row g-3">

      <div class="col-lg-6">
        <label class="form-label">Avenida</label>
        <input type="text" name="avenida" class="form-control"
          placeholder="João Machado"
          value="{{ old('avenida', $ts->avenida ?? '') }}">
      </div>

      <div class="col-lg-6">
        <label class="form-label">Bairro</label>
        <input type="text" name="bairro" class="form-control"
          placeholder="Ex: Bancários"
          value="{{ old('bairro', $ts->bairro ?? '') }}">
      </div>

      <div class="col-lg-6">
        <label class="form-label">Complemento</label>
        <input type="text" name="complemento" class="form-control"
          placeholder="Ex: complemento"
          value="{{ old('complemento', $ts->complemento ?? '') }}">
      </div>

      <div class="col-lg-3">
        <label class="form-label">UF</label>
        <select name="uf" class="form-select">
          <option value="">Selecione</option>
          @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
          <option value="{{ $uf }}" {{ (isset($ts) && $ts->uf === $uf) ? 'selected' : '' }}>{{ $uf }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-lg-3">
        <label class="form-label">Cidade</label>
        <input type="text" name="cidade" class="form-control"
          placeholder="Ex: Fortaleza"
          value="{{ old('cidade', $ts->cidade ?? '') }}">
      </div>

    </div>
  </div>


  <!-- MAIS INFORMAÇÕES -->
  <div class="tab-pane fade" id="tab-mais">
    <label class="form-label">Mais informações</label>
    <textarea name="steps" class="form-control" rows="6"
      placeholder="Digite tudo o que foi feito...">{{ old('steps', $ts->steps ?? '') }}</textarea>
  </div>


</div>

<div class="d-flex justify-content-end gap-2 mt-4">
  @if(!isset($ts))
    <button type="button" class="btn btn-dark" data-bs-toggle="collapse" data-bs-target="#formNovoTroubleshooting">Cancelar</button>
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
