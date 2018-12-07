<?php 
$pageSecurity = array("admin", "supervisor","venta");
require "../../config/security.php";

include("../../header-pdv.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="/PDVJoyeria/css/devoluciones.css" rel="stylesheet">
<div class="row" style="padding-bottom: 15px;">
  <div class="container devoluciones_container">
    <div class="folio_box">
      <div class="folio_search_list">
        <h2>Folios</h2>
        <div class="loader-parent" id="folio-loader-parent">
          <div class="loader"></div>
        </div>
        <div class="folio_search_tablebox item-box">
          <table class="folio_search_table">
            <thead class="folio_search_table--header">
              <tr>
                <th class="hidden">IdFolio</th>
                <th class="hidden">idAlmacen</th>
                <th class="hidden">idPersona</th>
                <th>Codigo</th>
                <th>Cliente</th>
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
          <div id="folio_already_returned" class="bg-danger hidden" style="color: white;text-align: center; padding: 5px;">
            Este folio ya ha sido devuelto anteriormente!
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="productos_devolucion">
        <div>
          <h2>Productos</h2>
          <div class="loader-parent" id="products-loader-parent">
            <div class="loader"></div>
          </div>
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
            class="form-control"
            disabled>
        </div>
        <div>
          Valor de productos a devolver
          <input
            placeholder="$$$"
            id="returned_products_value"
            class="form-control"
            disabled>
        </div>
        <div>
          Valor restante a cobrar
          <input
            placeholder="$$$"
            id="missing_payment"
            class="form-control"
            disabled>
        </div>
        <div style="padding-top: 10px;">
          <span style="display: inline-block;width: 49%;">
            <input
              placeholder="Efectivo"
              id="paidCash"
              class="form-control"
              disabled>
          </span>
          <span style="display: inline-block;width: 49%;">
            <input
              placeholder="A devolver"
              id="returnCash"
              class="form-control"
              style=""
              disabled>
          </span>
        </div>
        <div>
          <button id="btn_accept_devolution" class="button_devolucion btn btn-primary">Aceptar devolucion</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "../../footer-pdv.php"; ?>

<script>
  $(document).ready(function(){
    let data = [];
    let products = [];
    let lines = [];
    let displayRow = [];
    let elementClicked;
    let productClicked;
    let folio_selected;
    let last_id_inventario;
    $.ajax({
      type: "POST",
      url: "../../devoluciones/index.php",
      data: {folio_index: { idEstadoDeFolio: 3}},
      dataType: "json",
      success: function(res){
        $("#folio-loader-parent").hide();
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
        $("#products-loader-parent").hide();
        products = res.products;
        lines = res.lines;
        products.map(row => {
          addProductElement(row);
        });
      }
    });

    $("#btn_search_folio").click(function() {
      let search = $("#folio_search-input").val();
      if(search){
        clearFolioElements();
        displayRow = data.find(obj => obj.idFolio == search);
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
      if($(e.target).is('th')){
        changeSelectedElement(elementClicked, e.target.parentElement);
        elementClicked = e.target.parentElement;
      }
    });

    $("#product_index").click(function(e){
      if($(e.target).is('th')){
        changeSelectedProduct(productClicked, e.target.parentElement);
        productClicked = e.target.parentElement;
      }
    });

    $("#addProductBtn").click(function(e){
      if(productClicked && folio_selected){
        last_id_inventario++;
        selectedProductInfo = products.find(obj => obj.idProducto == productClicked.id);
        addFolioProductElement(last_id_inventario, selectedProductInfo.idProducto, true);
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
        $("#paidCash").prop("disabled", false);
        // agregar informacion del folio
        selectedRowInfo = data.find(obj => obj.idFolio == elementClicked.id);

        if(!!parseInt(selectedRowInfo.devuelto)){
          $("#btn_accept_devolution").addClass('disabled');
        } else if($("#btn_accept_devolution").hasClass('disabled')){
          $("#btn_accept_devolution").removeClass('disabled');
        }

        var monto_pagado = 0;
        var num_prods = 0;
        var deuda = 0;

        if(selectedRowInfo.venta[0].transaccion){
          monto_pagado = selectedRowInfo.venta.reduce(function(a, b){ return a + (b.transaccion ? parseInt(b.transaccion.monto) : 0); }, 0);;
        }

        if(selectedRowInfo.venta[0].inventario){
          lastIdInventario = 0;
          num_prods = selectedRowInfo.venta.reduce((a,b) => {
                        if(b.inventario.idInventario != lastIdInventario){
                          lastIdInventario = b.inventario.idInventario;
                          return a + parseInt(b.inventario.tipo)
                        } else {
                          return a;
                        }
                      },0);

          if(num_prods < 0){
            num_prods = num_prods * -1;
          }
        }

        let uniqueInvs = [];
        if(selectedRowInfo.venta[0].inventario){
          selectedRowInfo.venta.filter(function(item) {
            var i = uniqueInvs.findIndex(x => x.idInventario == item.idInventario);
            if(i <= -1) {
              uniqueInvs.push(item);
            }
          })

        uniqueInvs.map(obj => {
          selectedProductInfo = products.find(prod => prod.idProducto == obj.inventario.idProducto);
          deuda += selectedProductInfo.precio * (100 - obj.descuento) / 100;
        });
        deuda = deuda.toFixed(2);

        $("#info_codigo").text(selectedRowInfo.idFolio);
        $("#info_nombre").text(selectedRowInfo.persona.nombre);
        $("#info_almacen").text(selectedRowInfo.venta[0].almacen.name);
        $("#info_num_productos").text(num_prods);
        $("#info_monto_total").text("$ "+deuda);
        $("#info_monto_debido").text("$" + ((deuda - monto_pagado) > 3 ? deuda - monto_pagado : 0));

        // Agregar lista de productos del folio
          invList = [];
          uniqueInvs.map(( obj ) => {
            last_id_inventario = obj.idInventario;
            let item = invList.find(x => x.inventario.idProducto == obj.inventario.idProducto)
            if (item && item.inventario.tipo == -1){
              invList.splice($.inArray(item, invList), 1)
            } else {
              invList.push(obj);
            }
          });

          invList.map((obj) => {
            var tipo = parseInt(obj.inventario.tipo)*-1;
            for(var i=0; i < tipo; i++){
              addFolioProductElement(obj.idInventario, obj.inventario.idProducto)
            }
          });
        }

        if (selectedRowInfo.devuelto == "1"){
          $("#folio_already_returned").show();
          alert("Este folio ya ha sido devuelto anteriormente anteriormente!");
        }
      }
    });

    $("#paidCash").change((e) => {
      let toCharge = parseFloat($("#missing_payment").val());
      let toPay = parseFloat($("#paidCash").val());
      let toReturn = toPay - toCharge;
      $("#returnCash").val(toReturn);

    });

    $("#removeFolioBtn").click(function(e){
      if(elementClicked && folio_selected){
        clearFolioProductElements();
      }
    });

    $("#removeProductBtn").click(function(e){
      if(elementClicked && folio_selected){
        $("#folio_products_list input:checked.isReplacement").map(function(obj) {$(this).parent().parent().remove()});
      }
    });

    $("#folio_products_list").click(function(e){
      var prices = $( "#folio_products_list input:checked" ).map(function() {return $(this).parent().parent().not('.isReplacement').find(".folioProd-precio").text()});
      var total = prices.toArray().reduce((a,b) => { return parseInt(a || 0) + parseInt(b || 0)}, 0);
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
      $("#folio_products_list").html("");
      $("#info_codigo").text("");
      $("#info_nombre").text("");
      $("#info_almacen").text("");
      $("#info_num_productos").text("");
      $("#info_monto_total").text("$");
      $("#info_monto_debido").text("$");
      $("#changed_products_value").val("");
      $("#returned_products_value").val("");
      $("#missing_payment").val("");
      $("#folio_already_returned").hide();
      $("#paidCash, #returnCash").val("");
      $("#paidCash").prop("disabled", true);
    }

    function addRowElement(row){
      let devuelto = !parseInt(row['devuelto']) || ("background-color: #D93846;");
      let str = "<tr id="+row['idFolio']+" style='"+devuelto+"'>"
        str += "<th class='hidden'>"+row['idFolio']+"</th>"
        str += "<th class='hidden'>"+row['venta'][0]['almacen']['idAlmacen']+"</th>"
        str += "<th class='hidden'>"+row['idPersona']+"</th>"
        str += "<th>"+row['idFolio']+"</th>"
        str += "<th>"+row.persona.nombre + " " + row.persona.apellido+"</th>"
        str += "<th>"+getIdEstadoDeFolio(row['idEstadoDeFolio'])+"</th>"
        str += "<th>"+row['venta'][0]['almacen']['name']+"</th>"
        str += "</tr>"
      $("#folio_index").prepend(str);
      return str;
    }

    function getIdEstadoDeFolio(id){
      switch(id) {
        case "1":
          return "Pendiente"
        case "2":
          return "Cancelado"
        case "3":
          return "Finalizado"
      }
    }

    function addProductElement(row) {
      let linea = lines.find(obj => obj.idLinea == row["idLinea"]);
      let str = "<tr id="+row['idProducto']+">"
        str += "<th>"+row['codigo']+"</th>"
        str += "<th>"+row['nombre']+"</th>"
        str += "<th>"+linea.nombre+"</th>"
        str += "<th>"+row['precio']+"</th>"
        str += "</tr>"
      $("#product_index").append(str);
    }

    function addFolioProductElement(inventarioId, productoId, isReplacement = false){
      var prod = products.find(obj => obj.idProducto == productoId);
      let linea = lines.find(obj => obj.idLinea == prod.idLinea);
      let str = isReplacement ? "<tr id='"+inventarioId+"' class='isReplacement bg-green'>" : "<tr id='"+inventarioId+"'>";
        str += "<th class='folio_prod_input'>";
        str += "<input class='folio_prod_chck "+ (isReplacement ? "isReplacement" : "") +"' id='"+inventarioId+"' type='checkbox'></th>";
        str += "<th class='folioProd-id hidden'>"+prod['idProducto']+"</th>"
        str += "<th class='folioProd-code'>"+prod['codigo']+"</th>"
        str += "<th>"+prod['nombre']+"</th>"
        str += "<th>"+linea.nombre+"</th>"
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

    $("#btn_accept_devolution").click(function(){
      if(folio_selected && productClicked && elementClicked){
        var devolution = {
          devolution: {
            folio: {},
            new_products: {},
            returned_products: [],
            transaction: {},
            almacen: {}
          }
        }

        selectedFolioInfo = data.find(obj => obj.idFolio == elementClicked.id);
        devolution.devolution.folio = selectedFolioInfo;

        devolution.devolution.returned_products = $( "#folio_products_list input:checked" ).map(function() {return $(this).parent().parent().not('.isReplacement').find(".folioProd-id").text()}).toArray();
        devolution.devolution.new_products = $("#folio_products_list").find(".isReplacement").map(function(child){return $(this).find(".folioProd-id").text()}).toArray().filter(Boolean);

        devolution.devolution.transaction.new_products_value = $("#changed_products_value").val();
        devolution.devolution.transaction.returned_products_value = $("#returned_products_value").val();
        devolution.devolution.transaction.payment_value = $("#missing_payment").val();

        submitDevolution(devolution);
      }
    });

    function submitDevolution(devolution) {
      $("#btn_accept_devolution").addClass("disabled");
      $("#btn_accept_devolution").text("Cargando informacion...");
      $.ajax({
        type: "POST",
        url: "../../devoluciones/create.php",
        data: devolution,
        success: function(res){
          data = res;
          document.location.reload();
        }
      });
    }
  });
</script>
