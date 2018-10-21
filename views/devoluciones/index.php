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
          <table class="folio_products_table">
            <thead class="folio_products_table--header">
              <i class="folio_products_table--header-italic">
                Lista de productos del folio*
              </i>
              <tr>
                <th></th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Linea</th>
                <th>Precio</th>
              </tr>
            </thead>
            <tbody class="folio_products_table--body" id="folio_products_list">
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
              <tbody class="folio_search_table--body" id="product_index">
              </tbody>
            </table>
          </div>
          <div class="folio_search-container">
            <input id="product_search-input" class="folio-input-control form-control">
            <button id="btn_search_product" class="btn btn-primary">Buscar</button>
          </div>
        </div>
      </div>
      <div class="folio_button-control">
        <div>
          <button id="addProductBtn" class="">>></button>
          <button id="removeProductBtn" class=""><<</button>
        </div>
      </div>
      <div class="folio_calculated_fields-container">
        <div>
          Valor de productos cambiados
          <input
            placeholder="$$$"
            id="changed_products_value"
            class="form-control">
        </div>
        <div>
          Valor de productos a devolver
          <input
            placeholder="$$$"
            id="returned_products_value"
            class="form-control">
        </div>
        <div>
          Valor restante a pagar
          <input
            placeholder="$$$"
            id="missing_payment"
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
    let products = [];
    let displayRow = [];
    let elementClicked;
    let productClicked;
    let folio_selected;
    let last_id_inventario;
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

    $.ajax({
      type: "POST",
      url: "../../devoluciones/index.php",
      data: {folio_products_list: true},
      dataType: "json",
      success: function(res){
        products = res;
        res.map(row => {
          addProductElement(row);
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

    $("#btn_search_product").click(function(){
      let search = $("#product_search-input").val();
      if(search) {
        clearProductElements();
        displayRow = products.find(obj => obj.codigo == search);
        if(displayRow) {
          addProductElement(displayRow);
        }
      } else {
        clearProductElements();
        products.map(row => {
          addProductElement(row);
        });
      }
    });

    $("#folio_index").click(function(e){
      changeSelectedElement(elementClicked, e.target.parentElement);
      elementClicked = e.target.parentElement;
    });

    $("#product_index").click(function(e){
      changeSelectedProduct(productClicked, e.target.parentElement);
      productClicked = e.target.parentElement;
    });

    $("#addProductBtn").click(function(e){
      if(productClicked && folio_selected){
        last_id_inventario++;
        selectedProductInfo = products.find(obj => obj.idProducto == productClicked.id);
        addFolioProductElement(last_id_inventario, selectedProductInfo.idProducto);
        $("#folio_products_list").find("#"+last_id_inventario).addClass("bg-green");
        var precio = parseInt(selectedProductInfo.precio);
        var tot_precio = parseInt($("#changed_products_value").val()) || 0;
        $("#changed_products_value").val(precio + tot_precio);
        calculateMissingPayment();
      }
    });

    $("#addFolioBtn").click(function(e){
      if(elementClicked){
        folio_selected = true;
        clearFolioProductElements();
        // agregar informacion del folio
        selectedRowInfo = data.find(obj => obj.idFolio == elementClicked.id);
        var monto_pagado = 0;
        var num_prods = 0;
        var deuda = 0;

        if(selectedRowInfo.transaccion){
          monto_pagado = selectedRowInfo.transaccion.reduce(function(a, b){ return a + parseInt(b.monto); }, 0);
        }

        if(selectedRowInfo.inventario){
          num_prods = selectedRowInfo.inventario.reduce((a,b) => {return a + parseInt(b.tipo)},0) * -1;
        }

        if(selectedRowInfo.cobranza) {
          deuda = selectedRowInfo.cobranza.reduce((a,b) => {return a + parseInt(b.monto)},0);
        }

        $("#info_codigo").text(selectedRowInfo.codigo);
        $("#info_nombre").text(selectedRowInfo.persona.nombre);
        $("#info_almacen").text(selectedRowInfo.almacen.name);
        $("#info_num_productos").text(num_prods);
        $("#info_monto_total").text(deuda);
        $("#info_monto_debido").text(deuda - monto_pagado);

        // Agregar lista de productos del folio
        if(selectedRowInfo.inventario){
          selectedRowInfo.inventario.map(( obj ) => {
            last_id_inventario = obj.idInventario;
            addFolioProductElement(obj.idInventario, obj.idProducto)
          });
        }
      }
    });

    $("#folio_products_list").click(function(e){
      var prices = $( "#folio_products_list input:checked" ).map(function() {return $(this).parent().parent().find(".folioProd-precio").text()});
      var total = prices.toArray().reduce((a,b) => { return parseInt(a) + parseInt(b)});
      $("#returned_products_value").val(total);
      calculateMissingPayment();
    });

    function calculateMissingPayment(){
      var returned = $("#returned_products_value").val();
      var changed = $("#changed_products_value").val();
      if(returned && changed){
        var missing = changed - returned;
        if(missing < 0){
          missing = 0;
        }
        $("#missing_payment").val(missing);
      }
    }

    function clearFolioElements(){
      return $("#folio_index").html("");
    }

    function clearProductElements() {
      return $("#product_index").html("");
    }

    function clearFolioProductElements(){
      return $("#folio_products_list").html("");
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

    function addProductElement(row) {
      let str = "<tr id="+row['idProducto']+">"
        str += "<th>"+row['codigo']+"</th>"
        str += "<th>"+row['nombre']+"</th>"
        str += "<th>"+row['idLinea']+"</th>"
        str += "<th>"+row['precio']+"</th>"
        str += "</tr>"
      $("#product_index").append(str);
    }

    function addFolioProductElement(inventarioId, productoId){
      var prod = products.find(obj => obj.idProducto == productoId);

      let str = "<tr id="+inventarioId+">"
        str += "<th class='folio_prod_input'><input class='folio_prod_chck' id='"+inventarioId+"' type='checkbox'></th>"
        str += "<th>"+prod['codigo']+"</th>"
        str += "<th>"+prod['nombre']+"</th>"
        str += "<th>"+prod['idLinea']+"</th>"
        str += "<th class='folioProd-precio'>"+prod['precio']+"</th>"
        str += "</tr>"
      $("#folio_products_list").prepend(str);
    }

    function changeSelectedElement(oldrow, newrow){
      if(oldrow){
        $(oldrow).removeClass('isSelected');
      }
      $(newrow).addClass('isSelected');
    }

    function changeSelectedProduct(oldrow, newrow) {
      if(oldrow){
        $(oldrow).removeClass('isSelected');
      }
      $(newrow).addClass('isSelected');
    }

    function folio_prod_chck_click(id){
    }
  });
</script>
