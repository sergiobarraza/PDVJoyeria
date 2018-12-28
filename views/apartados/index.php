<?php
$pageSecurity = array("admin", "supervisor","venta");
require "../../config/security.php";
include("../../header-pdv.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="/PDVJoyeria/css/apartados.css" rel="stylesheet">
<div class="row" style="padding-bottom: 15px;">
  <div class="container" style=" min-width: 999px;">
    <div class="header-container">
      <h2 style="text-align: center;">Apartados</h2>
    </div>
    <div class="body-container">
      <div class="filter-container">
        <div class="search-container">
          <h4 style="margin-bottom: 13px;text-align: left;">
            Buscar
          </h4>
          <input
            class="form-control"
            id="search_query"
            placeholder="Introduce un valor"
          />
        </div>
        <div class="search_type-container">
          <p style="text-align: left;">
            Tipo de busqueda
          </p>
          <select id="select_option" class="form-control">
            <option id="numFolio" value="Num Folio">Numero de folio</option>
            <option id="clientName" value="Client Name">Nombre de cliente</option>
          </select>
        </div>
        <div class="search_almacen-container">
          <p style="text-align: left;">
            Por almacen
          </p>
           <select id="almacen_select" class="form-control">
            <option value="All">Todos los Almacenes</option>
          </select>
        </div>
        <div class="search_btn-container">
          <button id="searchButton" class="btn btn-primary">Buscar</button>
        </div>
      </div>
      <div id="folio_index" class="folio_index-container">
        <div class="loader-parent" id="folio-loader-parent">
          <div class="loader"></div>
        </div>
      </div>
    </div>
  </div>

<?php include "folio_info_modal.php"; ?>
</div>

<?php include "../../footer-pdv.php"; ?>

<script>
  $(document).ready(function(){
    let data = [];
    let products = [];
    let lines = [];
    let folio_selected;
    $.ajax({
      type: "POST",
      url: "../../devoluciones/index.php",
      data: {folio_index: { idEstadoDeFolio: 1}},
      dataType: "json",
      success: function(res){
        $("#folio-loader-parent").hide();
        data = res;
        res.map(row => {
          addFolioElement(row);
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
      }
    });


    $.ajax({
      type: "GET",
      url: "../../apartados/index.php",
      data: {almacen_index: true},
      dataType: "json",
      success: function(res){
        res.almacenes.map(row => {
          addAlmacenToFilterSearch(row);
        });
      }
     });

    $(".folio_index-container").on("click", function(e){
      if($(e.target ).is( ":button" )) {
        let folioId = $(e.target).data().idfolio;
        folio_selected = data.find(obj => obj.idFolio == folioId)
        fillModalInfo(folio_selected);
      }
    });

    $("#folioInfoModal").on('hidden.bs.modal', function(){
      clearProductToVentaInfo();
    });

    $("#searchButton").click(function(){
      var query = $("#search_query").val();
      var search_type = $("#select_option option:selected").val();
      var almacen = $("#almacen_select option:selected").val();
      let result = data;
      if(query) {
        if(search_type == "Client Name"){
          result = result.filter(obj => (
              query.indexOf(obj.persona.nombre) >= 0 ||
              obj.persona.nombre.indexOf(query) >= 0 ||
              query.indexOf(obj.persona.apellido) >= 0 ||
              obj.persona.apellido.indexOf(query) >= 0
          ));
        } else if (search_type == "Num Folio"){
          result = result.filter(obj => (
            query.indexOf(obj.idFolio) >= 0 ||
            obj.idFolio.indexOf(query) >= 0
          ));
        }
      }

      if(almacen !== "All"){
        result = result.filter(obj => obj.venta[0].almacen.idAlmacen == almacen);
      }

      clearFolioIndex();
      result.map(row => {
        addFolioElement(row);
      });
    });

    function fillModalInfo(folio) {
      // Informacion del cliente
      $(".modal-folioInfo_h3").text("Folio: "+folio.idFolio);
      $(".folioState").text("Pendiente");
      $(".folioReturned").text(parseInt(folio.devuelto) ? "Si" : "No");
      $("#clientInfo_name").text(folio.persona.nombre +" "+folio.persona.apellido);
      $("#clientInfo_email").text(folio.persona.email);
      $("#clientInfo_rfc").text(folio.persona.rfc);
      $("#clientInfo_tel").text(folio.persona.tel);

      $(".cancel-order").data("id", folio.idFolio);

      //informacion de la venta
      let uniqueInvs = [];
      folio.venta.filter(function(item) {
        var i = uniqueInvs.findIndex(x => x.idInventario == item.idInventario);
        if(i <= -1 && item.inventario && item.inventario.idAlmacen == 200) {
          uniqueInvs.push({
            idInventario: item.idInventario,
            idProducto: item.inventario.idProducto,
            tipo: item.inventario.tipo,
            idAlmacen: item.inventario.idAlmacen,
            descuento: item.descuento
          });
        }
      });

        //num de productos
      let prodCount = uniqueInvs.reduce((a, b) => a + parseInt(b.tipo), 0);
      $("#ventaInfo-prodCount").text(prodCount);

         // lista de pagos
      let uniqueTransaction = [];
      let paid_amount = 0;
      let prodPaid = []

      if(folio.venta[0].transaccion) {
        let payments = folio.venta.map((obj) => {return obj.transaccion});
        payments.filter(function(item){
          if(item){
            var i = uniqueTransaction.findIndex(x => x.idTransaccion == item.idTransaccion);
            if(i <= -1) {
              uniqueTransaction.push(item);
              if(item.monto > 0) {
                addPaymentHistoryElement(item);
              }
            }
          }
        });
      }

      if(folio.venta[0].inventario){
        uniqueInvs = [];
        folio.venta.filter(function(item) {
          var i = uniqueInvs.findIndex(x => x.idInventario == item.idInventario);
          if(i <= -1) {
            uniqueInvs.push(item);
          }
        })

        let uniqueTrans = [];
        folio.venta.filter(function(item) {
        var i = uniqueTrans.findIndex(x => x.idTransaccion == item.idTransaccion);
          if(i <= -1) {
            uniqueTrans.push(item);
          }
        })

        invList = [];
        uniqueTrans.map(( obj ) => {
          last_id_inventario = obj.idInventario;
          if (obj.inventario && (obj.inventario.idAlmacen == 200 || obj.inventario.tipo === "0")) {
            if (obj.inventario.tipo >= 0){
              invList.push(obj);
            } else {
              let item = invList.find(x => x.inventario.idProducto == obj.inventario.idProducto)
              if ((item.inventario.tipo) == -1){
                invList.splice($.inArray(item, invList), 1)
              } else {
                let itemQty = invList[$.inArray(item, invList)].inventario.tipo;
                invList[$.inArray(item, invList)].inventario.tipo = parseInt(itemQty) -1;
              }
            }
          }
        });

        let current_debt;
        let unique_cobranza = []
        if (folio.idEstadoDeFolio == "1") {
          let folio_ventas = folio.venta.map((obj) => {return obj})

          if(folio.venta[0].cobranza) {
            let cobranza = folio.venta.map((obj) => {return obj.cobranza});
            folio.venta.filter(function(item){
              if(item.idCobranza){
                var i = unique_cobranza.findIndex(x => x.idCobranza == item.idCobranza);
                if(i <= -1) {
                  unique_cobranza.push(item);
                }
              }
            });
          }

          current_debt = "$ " + unique_cobranza.reduce((a, b) => a + parseFloat(b.cobranza.monto), 0).toFixed(3);
        } else {
          current_debt = "Liquidado";
        }
        $("#ventInfo-folioDebt").text(current_debt);

        unique_cobranza.map((obj) => {
          val = prodPaid[obj.inventario.idProducto]
          prodPaid[obj.inventario.idProducto] =
            (val == null ? parseFloat(obj.cobranza.monto) : val += parseFloat(obj.cobranza.monto));
        });

        uniqueInvs.map((obj) => {
          if(obj.inventario.idAlmacen === "200" ){
            addProductToVentaInfo(obj, (prodPaid[obj.inventario.idProducto] || "none"));
          }
        })
      }
    }

      // deuda actual
    $("#cash_payment, #cash_received, #card_received").change(function(e) {
      let cash_payment = parseFloat($("#cash_payment").val() || 0);
      let cash_received = parseFloat($("#cash_received").val() || 0);
      let card_received = parseFloat($("#card_received").val() || 0);
      let change = $("#change");
      change.val((cash_received + card_received) - cash_payment);
    });

    $("#purchaseButton").click(function(e){
      if(!$(this).hasClass("disabled")){
        $(this).addClass("disabled");
        $(this).text("Cargando...");

        deposit = {
          folio: folio_selected,
          deposit_amount: parseFloat($("#cash_payment").val() || 0),
          cash: parseFloat($("#cash_received").val() || 0),
          card: parseFloat($("#card_received").val() || 0),
          selected_product_id: $('input[name=payment_selected]:checked').data("id"),
        }

        $.ajax({
          type: "POST",
          url: "../../devoluciones/index.php",
          data: {deposit: deposit},
          success: function(res){
            //generar ticket
            //cantidad efectivo y cambio
            window.open("../../imprimirticket_abono_apartado.php?folio="+deposit.folio.idFolio+"&cantidad="+deposit.cash+"&cambio="+($("#change").val()));
            document.location.reload();
          }
        });
      }
    });

    $("#give_product").on('click', 'selector', function(e){
      debugger;
    });

    function giveAwayProduct(e){
      debugger;
    }


    function addProductToVentaInfo(obj, debt, taken=false) {
      let prod = products.find(e => e.idProducto == obj.inventario.idProducto);
      let precio = prod.precio * (100 - obj.descuento) / 100;
      let qty = obj.inventario.tipo;
      let paid = obj.transaccion ? obj.transaccion.monto : 0;
      let dcto = (100 - obj.descuento) / 100;
      let str;
      if(taken) {
        str = "<tr class='venta-body__tr'>"
           str += "<td>"+prod.nombre+"</td>"
           str += "<td>$"+precio+"</td>"
           str += "<td style='text-align: center;'>"+qty+"</td>"
           str += "<td>"+"Entregado"+"</td>"
           str += "<td><input disabled data-id='"+obj.inventario.idProducto+"' type='radio' name='payment_selected' class='form-control venta-body__chkbx' id='prod-"+obj.inventario.idProducto+"'></td>"
         str += "</tr>";
      } else {
        str = "<tr class='venta-body__tr'>"
           str += "<td>"+prod.nombre+"</td>"
           str += "<td>$"+precio+"</td>"
           str += "<td style='text-align: center;'>"+qty+"</td>"
           str += "<td style='padding-right:0px;'>"+(debt === "none" ? "<input type='button' id='give_product' onclick='giveAwayProduct("+obj.inventario.idProducto+")' data-id='"+obj.inventario.idProducto+"' value='Entregar'/>" : "$ "+(debt).toFixed(2))+"</td>"
           str += "<td><input "+ (debt === "none" ? "disabled" : "") +" data-id='"+obj.inventario.idProducto+"' type='radio' name='payment_selected' class='form-control venta-body__chkbx' id='prod-"+obj.inventario.idProducto+"'></td>"
         str += "</tr>";
      }
      $("#venta-tbody").append(str)
      return {product: prod, price: precio, qty: qty, discount: obj.descuento}
    }

    function addPaymentHistoryElement(obj){
      let str = "<tr>"
          str += "<td>$"+obj.monto+"</td>"
          str += "<td>"+obj.tipoDePago+"</td>"
          str += "<td>"+obj.fecha+"</td>"
          str += "</tr>"
      $("#payment_history-tbody").append(str);
    }

    function clearProductToVentaInfo(){
      $("#venta-tbody").text("");
      $("#payment_history-tbody").text("");
    }

    function clearFolioIndex() {
      $("#folio_index").text("");
    }


    function addAlmacenToFilterSearch(row){
      var option = new Option(row.name, row.idAlmacen);
      $("#almacen_select").append($(option));
    }

    function addFolioElement(row) {
      let str = "<div id='folio-"+row.idFolio+"' class='folio_item-container'>"
          str += "<div>Folio: "+row.idFolio+"</div>"
          str += "<div>Almacen: "+row.venta[0].almacen.name+"</div>"
          str += "<div>Cliente: "+row.persona.nombre+" "+row.persona.apellido+"</div>"
          str += "<div>Creado: "+ row.venta[0].inventario.fecha+"</div>"
          str += "<div class='folio_item-btn_container'>"
            str += "<button class='btn btn-primary btn-folioInfo' data-idfolio='"+row.idFolio+"' data-toggle='modal' data-target='#folioInfoModal' >Más Información +</button>"
          str += "</div>"
        str += "</div>"
      $("#folio_index").prepend(str);
    }

  });
</script>

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
