<div class="container-xxl">
  <div id="formNovoTroubleshooting" class="collapse mt-3">
    <div class="p-4 rounded-3" style="background:#0f161d;border:1px solid #0f0;">
      <h2 class="neon mb-4">Novo Troubleshooting</h2>

      <form method="POST" action="{{ route('troubleshooting.store') }}">
        @csrf
        <div class="row g-3">
          <div class="col-lg-6">
            <label class="form-label">Título do Problema</label>
            <input type="text" name="title" class="form-control" placeholder="Ex: interface down, routing loop" id="ts-title">
          </div>

          <div class="col-lg-6">
            <label class="form-label">Descrição</label>
            <input type="text" name="description" class="form-control" placeholder="Breve descrição do problema">
          </div>

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
