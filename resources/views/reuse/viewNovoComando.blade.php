<div class="container-xxl">
  <div id="formNovoComando" class="collapse mt-3">
    <div class="p-4 rounded-3" style="background:#0f161d;border:1px solid #0f0;">
      <h2 class="neon mb-4">Adicionar Comando</h2>

      <form method="POST" action="{{ route('comandos.store') }}">
        @csrf
        <div class="row g-3">
          <div class="col-lg-6">
            <label class="form-label">Comando</label>
            <input type="text" name="command" class="form-control" placeholder="Ex: show ip bgp" id="campo-comando">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Dispositivo</label>
            <select name="device" class="form-select">
              <option value="">Selecione o dispositivo</option>
              <option>Cisco</option>
              <option>Huawei</option>
              <option>Datacom</option>
              <option>Raisecom</option>
              <option>Extreme</option>
              <option>Juniper</option>
              <option>MikroTik</option>
              <option>Switch</option>
              <option>Intelbras</option>
            </select>
          </div>

          <div class="col-lg-6">
            <label class="form-label">Protocolo</label>
            <input type="text" name="protocol" class="form-control" placeholder="Ex: BGP, OSPF, MPLS">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Tarefa</label>
            <input type="text" name="task" class="form-control" placeholder="Ex: Verificar status">
          </div>

          <div class="col-12">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Descrição detalhada do comando..."></textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <button type="button" class="btn btn-dark"
                  data-bs-toggle="collapse" data-bs-target="#formNovoComando">
            Cancelar
          </button>
          <button type="submit" class="btn btn-success">
            Adicionar Comando
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
