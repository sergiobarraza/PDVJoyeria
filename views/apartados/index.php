<?php include("../../header-pdv.php"); ?>
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
    $.ajax({
      type: "POST",
      url: "../../devoluciones/index.php",
      data: {folio_index: true},
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
        let folio = data.find(obj => obj.idFolio == folioId)
        fillModalInfo(folio);
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
      $(".folioState").text(folio.idEstadoDeFolio);
      $(".folioReturned").text(parseInt(folio.devuelto) ? "Si" : "No");
      $("#clientInfo_name").text(folio.persona.nombre +" "+folio.persona.apellido);
      $("#clientInfo_email").text(folio.persona.email);
      $("#clientInfo_rfc").text(folio.persona.rfc);
      $("#clientInfo_tel").text(folio.persona.tel);

      //informacion de la venta
      let uniqueInvs = [];
      folio.venta.filter(function(item) {
        var i = uniqueInvs.findIndex(x => x.idInventario == item.idInventario);
        if(i <= -1) {
          uniqueInvs.push({
            idInventario: item.idInventario,
            idProducto: item.inventario.idProducto,
            tipo: item.inventario.tipo,
            descuento: item.descuento
          });
        }
      });

        //num de productos
      let prodCount = uniqueInvs.map((obj) => {return parseInt(obj.tipo)}).reduce((a, b) => a + b, 0);
      $("#ventaInfo-prodCount").text(prodCount * -1);

         // lista de pagos
      let uniqueTransaction = [];
      let paid_amount = 0;
      if(folio.venta[0].transaccion) {
        let payments = folio.venta.map((obj) => {return obj.transaccion});
        payments.filter(function(item){
          if(item){
            var i = uniqueTransaction.findIndex(x => x.idTransaccion == item.idTransaccion);
            if(i <= -1) {
              uniqueTransaction.push(item);
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

        invList = [];
        uniqueInvs.map(( obj ) => {
          last_id_inventario = obj.idInventario;
          if (obj.inventario.idAlmacen == 200) {
            if (obj.inventario.tipo > 0){
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

        invList.map((obj) => {
          addProductToVentaInfo(obj)
          if(obj.transaccion && obj.transaccion.monto > 0) {
            addPaymentHistoryElement(obj.transaccion);
          }
        });
      }

      // deuda actual
      let current_debt;
      if (folio.idEstadoDeFolio == "1") {
        let last_cobranza = folio.venta.map((obj) => {return obj.cobranza}).filter(n => n).slice(-1)[0];
        let paid_amount = uniqueTransaction.reduce((a, b) => a + parseFloat(b.monto), 0);
        current_debt = "$ "+ last_cobranza.monto;
      } else {
        current_debt = "Liquidado";
      }
      $("#ventInfo-folioDebt").text(current_debt);


    }

    function addProductToVentaInfo(obj) {
      let prod = products.find(e => e.idProducto == obj.inventario.idProducto);
      let precio = prod.precio * (100 - obj.descuento) / 100;
      let qty = obj.inventario.tipo;
      let paid = obj.transaccion ? obj.transaccion.monto : 0;
      let str = "<tr class='venta-body__tr'>"
           str += "<td>"+prod.nombre+"</td>"
           str += "<td>$"+precio+"</td>"
           str += "<td style='text-align: center;'>"+qty+"</td>"
           str += "<td>$"+((precio * qty) - parseFloat(paid))+"</td>"
           str += "<td><input type='checkbox' class='form-control venta-body__chkbx' id='prod-"+obj.idProducto+"'></td>"
         str += "</tr>";
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
