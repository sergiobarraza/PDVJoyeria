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
              <input type="text" id="client_search_input-name" class="form-control" placeholder="Nombre" style="width:49%;display:inline-block;"/>
              <input type="text" id="client_search_input-last" class="form-control" placeholder="Apellidos" style="width:50%;display: inline-block;"/>

              <input type="text" id="client_search_input" class="form-control hidden" placeholder="Buscar..."/>
            </div>
            <div class="col-md-4 inline">
              <select id="client_search_select" name="clientSearchType" class="form-control">
                <option selected value="nombre">Nombre y apellido</option>
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
              <table style="display: block;width: 100%;margin-left: 15px;">
                <thead id="client_index-thead">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="client_search_submit" type="button" class="btn btn-primary">Seleccionar Cliente</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $("#client_search_select").change((e)=>{
      $("#client_search_input-last").val("")
      $("#client_search_input-name").val("")
      $("#client_search_input").val("")

    if($(e.target).val() == "nombre") {
      $("#client_search_input-last").show()
      $("#client_search_input-name").show()
      $("#client_search_input").hide()

    } else {
      $("#client_search_input-last").hide()
      $("#client_search_input-name").hide()
      $("#client_search_input").show()
    }
  });

</script>

<style type="text/css">
  .inline {
    display: inline-block;
  }

  #client_index-thead {
    display: inline-block;
    width: 94%;
    height: 40px;
    padding: 10px;
    margin: 0 10px;
    border-bottom: 1px solid black;
  }

  #client_index-thead tr {
    width: 100%;
    display: block;
  }

  #client_index-thead tr th {
    display: inline-block;
    width: 19%;
    padding: 0 15px;
  }

  #client_index-tbody {
    height: 200px;
    width: 94%;
    display: inline-block;
    overflow: auto;
    padding-bottom: 15px;
  }

  #client_index-tbody tr {
    width: 100%;
    display: block;
  }

  #client_index-tbody tr:hover {
    background-color: #ccc;
  }

  #client_index-tbody tr td {
    display: inline-block;
    width: 20%;
    padding: 0 15px;
    overflow: hidden;
  }

  .isSelected {
    background-color: #bec4cd;
  }

  .hidden {
    display: none;
  }
</style>
