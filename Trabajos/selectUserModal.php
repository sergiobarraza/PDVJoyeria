<!-- Modal -->
<div class="modal fade" id="selectUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div style="min-width: 999px;" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="selectUserModalLabel">Buscador de clientes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="row">
            <div class="col-md-7 inline">
              <input type="text" id="client_search_input" class="form-control" placeholder="Buscar..."/>
            </div>
            <div class="col-md-4 inline">
              <select id="client_search_select" name="clientSearchType" class="form-control">
                <option selected value="nombre">Nombre</option>
                <option value="apellido">Apellidos</option>
                <option value="email">Email</option>
                <option value="tel">Telefono</option>
                <option value="rfc">RFC</option>
              </select>
            </div>
            <div class="col-md-1">
              <button type="button" class="btn btn-default" style="width: 100%;">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
          <div style="padding-top: 25px;">
            <div class="container" style="border: 1px solid rgb(206, 212, 218);padding: 0;">
              <table style="width: 100%;">
                <thead>
                  <tr style="font-size: 18px;height: 50px;">
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>TEL</th>
                    <th>Email</th>
                    <th>RFC</th>
                  </tr>
                </thead>
                <tbody id="client_index-tbody">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="client_search_submit" type="button" class="btn btn-primary">Seleccionar Cliente</button>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  .inline {
    display: inline-block;
  }

  #client_index-tbody {
    height: 100px;
    overflow-y: scroll;
  }

  #client_index-tbody tr {
  }

  #client_index-tbody tr:hover {
    background-color: #ccc;
  }

  .isSelected {
    background-color: #bec4cd;
  }
</style>
