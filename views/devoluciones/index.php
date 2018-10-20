<?php include("../../header-pdv.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="/PDVJoyeria/css/devoluciones.css" rel="stylesheet">
<div>
  <div class="container devoluciones_container">
    <div class="folio_box">
      <div class="folio_search_list">
        <h2>Folios</h2>
        <div class="folio_search_tablebox item-box">
          <table class="folio_search_table">
            <thead class="folio_search_table--header">
              <tr>
                <th class="hidden">IdFolio</th>
                <th class="hidden">idAlmacen</th>
                <th class="hidden">idPersona</th>
                <th>Codigo</th>
                <th>Estado</th>
                <th>Almacen</th>
              </tr>
            </thead>
            <tbody class="folio_search_table--body" id="folio_index">
            </tbody>
          </table>
        </div>
        <div class="folio_search-container">
          <input class="folio-input-control form-control" id="folio_search-input">
          <button type="button" class="btn btn-primary" id="btn_search_folio">Buscar</button>
        </div>
      </div>

      <div class="folio_button-control">
        <div>
          <button id="addFolioBtn" class="">>></button>
          <button id="removeFolioBtn" class=""><<</button>
        </div>
      </div>

      <div class="folio_info_list">
        <h2>Información del Folio</h2>
        <div class="folio_info_tablebox item-box">
          <table class="folio_info_table">
            <tbody>
              <tr>
                <th>Codigo: </th>
                <th id='info_codigo'> </th>
                <th>Nombre:</th>
                <th id='info_nombre'></th>
              </tr>
              <tr>
                <th>Almacen: </th>
                <th id='info_almacen'> </th>
                <th>Num de productos:</th>
                <th id='info_num_productos'> </th>
              </tr>
              <tr>
                <th>Monto total:</th>
                <th id='info_monto_total'>$ </th>
                <th>Monto debido:</th>
                <th id='info_monto_debido'>$ </th>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="folio_products_tablebox item-box">
          <table class="folio_search_table">
            <thead class="folio_products_table--header">
              <i class="folio_products_table--header-italic">
                Lista de productos del folio*
              </i>
              <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Linea</th>
                <th>Precio</th>
              </tr>
            </thead>
            <tbody class="folio_products_table--body">
               <tr>
                <th>12345678</th>
                <th>Compra a Mostrador</th>
                <th>Abarrotes</th>
                <th>18.90</th>
              </tr>
               <tr>
                <th>12345678</th>
                <th>Compra a Mostrador</th>
                <th></th>
                <th></th>
              </tr>
               <tr>
                <th>12345678</th>
                <th>Compra a Mostrador</th>
                <th></th>
                <th></th>
              </tr>
               <tr>
                <th>12345678</th>
                <th>Compra a Mostrador</th>
                <th></th>
                <th></th>
              </tr>
               <tr>
                <th>12345678</th>
                <th>Compra a Mostrador</th>
                <th></th>
                <th></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div>
      <div class="productos_devolucion">
        <div>
          <h2>Productos</h2>
          <div class="item-box">
            <table class="folio_search_table">
              <thead class="folio_search_table--header">
                <tr>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Linea</th>
                  <th>Precio</th>
                </tr>
              </thead>
              <tbody class="folio_search_table--body">
                <tr>
                  <th>12345678</th>
                  <th>Compra a Mostrador</th>
                  <th>Abarrotes</th>
                  <th>18.90</th>
                </tr>
                <tr>
                  <th>12345678</th>
                  <th>Compra a Mostrador</th>
                  <th></th>
                  <th></th>
                </tr>
                <tr>
                  <th>12345678</th>
                  <th>Compra a Mostrador</th>
                  <th></th>
                  <th></th>
                </tr>
                <tr>
                  <th>12345678</th>
                  <th>Compra a Mostrador</th>
                  <th></th>
                  <th></th>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="folio_search-container">
            <input class="folio-input-control form-control">
            <button class="btn btn-primary">Buscar</button>
          </div>
        </div>
      </div>
      <div class="folio_calculated_fields-container">
        <div>
          Valor de productos devueltos
          <input
            placeholder="$$$"
            class="form-control">
        </div>
        <div>
          Valor de productos a devolver
          <input
            placeholder="$$$"
            class="form-control">
        </div>
        <div>
          Valor restante a pagar
          <input
            placeholder="$$$"
            class="form-control">
        </div>
        <div>
          <button class="button_devolucion btn btn-primary">Aceptar devolucion</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    let data = [];
    let displayRow = [];
    let elementClicked;
    $.ajax({
      type: "POST",
      url: "../../devoluciones/index.php",
      data: {folio_index: true},
      dataType: "json",
      success: function(res){
        data = res;
        res.map(row => {
          addRowElement(row);
        });
      }
    });

    $("#btn_search_folio").click(function() {
      let search = $("#folio_search-input").val();
      if(search){
        clearFolioElements();
        displayRow = data.find(obj => obj.codigo == search);
        if(displayRow){
          addRowElement(displayRow);
        }
      } else {
        clearFolioElements();
        data.map(row => {
          addRowElement(row);
        });
      }
    });

    $("#folio_index").click(function(e){
      changeSelectedElement(elementClicked, e.target.parentElement);
      elementClicked = e.target.parentElement;
    });

    $("#addFolioBtn").click(function(e){
      if(elementClicked){
        selectedRowInfo = data.find(obj => obj.idFolio == elementClicked.id);
        $("#info_codigo").text(selectedRowInfo.codigo);
        $("#info_nombre").text(selectedRowInfo.persona.nombre);
        $("#info_almacen").text(selectedRowInfo.almacen.name);
        $("#info_num_productos").text();
        $("#info_monto_total").text();
        $("#info_monto_debido").text();
      }
    });

    function clearFolioElements(){
      return $("#folio_index").html("");
    }

    function addRowElement(row){
      let str = "<tr id="+row['idFolio']+">"
        str += "<th class='hidden'>"+row['idFolio']+"</th>"
        str += "<th class='hidden'>"+row['idAlmacen']+"</th>"
        str += "<th class='hidden'>"+row['idPersona']+"</th>"
        str += "<th>"+row['codigo']+"</th>"
        str += "<th>"+row['estado']+"</th>"
        str += "<th>"+row['almacen']['name']+"</th>"
        str += "</tr>"
      $("#folio_index").append(str);
      return str;
    }

    function changeSelectedElement(oldrow, newrow){
      if(oldrow){
        $(oldrow).removeClass('isSelected');
      }
      $(newrow).addClass('isSelected');
    }
  });
</script>
