<div class="container-xxl">
  <div class="p-4 rounded-3" style="background:#0f161d;border:1px solid #0f0;">

    <h2 class="neon mb-4">Editar Troubleshooting</h2>

    <form method="POST" action="{{ route('troubleshooting.update', $ts->id) }}">
      @csrf
      @method('PUT')

      <!-- NAV TABS -->
      <ul class="nav nav-tabs mb-4" id="editTabs">
        <li class="nav-item">
          <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#edit-inicial">
            Dados Iniciais
          </button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-endereco">
            Endereço
          </button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-mais">
            Mais Informações
          </button>
        </li>
      </ul>

      <div class="tab-content">

        <!-- ======================= -->
        <!-- DADOS INICIAIS -->
        <!-- ======================= -->
        <div class="tab-pane fade show active" id="edit-inicial">
          <div class="row g-3">

            <div class="col-lg-4">
              <label class="form-label">Contrato</label>
              <input type="text" name="contrato" class="form-control" value="{{ $ts->CONTRATO_NOVO }}">
            </div>

            <div class="col-lg-4">
              <label class="form-label">Nome</label>
              <input type="text" name="nome" class="form-control" value="{{ $ts->NOME }}">
            </div>

            <div class="col-lg-4">
              <label class="form-label">CPE (IP)</label>
              <input type="text" name="cpe" class="form-control" value="{{ $ts->IP }}">

            </div>

            <div class="col-lg-4">
              <label class="form-label">PE</label>
              <input type="text" name="pe" class="form-control" value="{{ $ts->PE_RELACIONADO }}">
            </div>

            <div class="col-lg-4">
              <label class="form-label">VLANS</label>
              <input type="text" name="vlans" class="form-control" value="{{ $ts->VLAN_GER }}">
            </div>

            <!-- DESIGNADOR -->
            <div class="col-12 mt-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"
                       {{ $ts->DESIGNADOR ? 'checked' : '' }}
                       onclick="document.getElementById('editWrapperDesignador').classList.toggle('d-none')">
                <label class="form-check-label">DESIGNADOR</label>
              </div>

              <div id="editWrapperDesignador" class="mt-2 {{ $ts->DESIGNADOR ? '' : 'd-none' }}">
                <input type="text" name="designador" class="form-control" value="{{ $ts->DESIGNADOR }}">
              </div>
            </div>

            <!-- ONU -->
            <div class="col-12 mt-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"
                       {{ $ts->ONU ? 'checked' : '' }}
                       onclick="document.getElementById('editOnu').classList.toggle('d-none')">
                <label class="form-check-label">ONU</label>
              </div>

              <div id="editOnu" class="mt-2 {{ $ts->ONU ? '' : 'd-none' }}">
                <input type="text" name="onu" class="form-control" value="{{ $ts->ONU }}">
              </div>
            </div>

            <!-- PRTG -->
            <div class="col-12 mt-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"
                       {{ $ts->LINK_PRTG ? 'checked' : '' }}
                       onclick="document.getElementById('editPrtg').classList.toggle('d-none')">
                <label class="form-check-label">PRTG (Link)</label>
              </div>

              <input type="text" name="prtg" id="editPrtg"
                     class="form-control mt-2 {{ $ts->LINK_PRTG ? '' : 'd-none' }}"
                     value="{{ $ts->LINK_PRTG }}">
            </div>

            <!-- PARCEIRO -->
            <div class="col-12 mt-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"
                       {{ ($ts->PARCEIRO || $ts->CONTATO_PARCEIRO) ? 'checked' : '' }}
                       onclick="document.getElementById('editParceiro').classList.toggle('d-none')">
                <label class="form-check-label">Parceiro</label>
              </div>

              <div id="editParceiro" class="mt-2 {{ ($ts->PARCEIRO || $ts->CONTATO_PARCEIRO) ? '' : 'd-none' }}">
                <div class="row g-2">
                  <div class="col-lg-6">
                    <input type="text" name="parceiro" class="form-control" value="{{ $ts->PARCEIRO }}">
                  </div>
                  <div class="col-lg-6">
                    <input type="text" name="contato_parceiro" class="form-control" value="{{ $ts->CONTATO_PARCEIRO }}">
                  </div>
                </div>
              </div>
            </div>

            <!-- PORTA (CIRCUITO) -->
           <div class="col-12 mt-3">
  <div class="form-check form-switch">
    <input class="form-check-input" type="checkbox"
           {{ $ts->PORTA ? 'checked' : '' }}
           onclick="document.getElementById('editPorta').classList.toggle('d-none')">
    <label class="form-check-label">Porta</label>
  </div>

  <input type="text" id="editPorta" name="porta"
         class="form-control mt-2 {{ $ts->PORTA ? '' : 'd-none' }}"
         value="{{ $ts->PORTA }}">
</div>


            <!-- SW ACESSO -->
            <div class="col-12 mt-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"
                       {{ $ts->SW_RELACIONADO ? 'checked' : '' }}
                       onclick="document.getElementById('editSw').classList.toggle('d-none')">
                <label class="form-check-label">SW de Acesso</label>
              </div>

              <input type="text" id="editSw" name="sw_acesso"
                     class="form-control mt-2 {{ $ts->SW_RELACIONADO ? '' : 'd-none' }}"
                     value="{{ $ts->SW_RELACIONADO }}">
            </div>

            <!-- IP PUBLICO / IP -->
            <div class="col-12 mt-3 mb-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"
                       {{ $ts->IP ? 'checked' : '' }}
                       onclick="document.getElementById('editPublico').classList.toggle('d-none')">
                <label class="form-check-label">IP Público</label>
              </div>

              <input type="text" id="editPublico" name="publico"
                     class="form-control mt-2 {{ $ts->IP ? '' : 'd-none' }}"
                     value="{{ $ts->IP }}">
            </div>

          </div>
        </div>

        <!-- ======================= -->
        <!-- ENDEREÇO -->
        <!-- ======================= -->
        <div class="tab-pane fade" id="edit-endereco">
          <div class="row g-3">

            <div class="col-lg-6">
              <label class="form-label">Avenida</label>
              <input type="text" name="avenida" class="form-control" value="{{ $ts->ENDERECO_NOVO }}">
            </div>

            <div class="col-lg-6">
              <label class="form-label">Bairro</label>
              <input type="text" name="bairro" class="form-control" value="{{ $ts->ENDERECO_BAIRRO }}">
            </div>

            <div class="col-lg-6">
              <label class="form-label">Complemento</label>
              <input type="text" name="complemento" class="form-control" value="{{ $ts->ENDERECO_COMPLEMENTO }}">
            </div>

            <div class="col-lg-3">
              <label class="form-label">UF</label>
              <select name="uf" class="form-select">
                @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                  <option value="{{ $uf }}" {{ $ts->ENDERECO_UF === $uf ? 'selected' : '' }}>{{ $uf }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-lg-3">
              <label class="form-label">Cidade</label>
              <input type="text" name="cidade" class="form-control" value="{{ $ts->ENDERECO_CIDADE }}">
            </div>

          </div>
        </div>

        <!-- ======================= -->
        <!-- MAIS INFORMAÇÕES -->
        <!-- ======================= -->
        <div class="tab-pane fade" id="edit-mais">
          <label class="form-label">Mais Informações</label>
          <textarea name="steps" class="form-control" rows="6">{{ $ts->STEPS }}</textarea>
        </div>

      </div>

      <!-- BOTÕES -->
      <div class="d-flex justify-content-end gap-2 mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Salvar Alterações</button>
      </div>

    </form>

  </div>
</div>
