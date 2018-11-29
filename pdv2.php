<?php
  $pageSecurity = array("venta", "admin", "supervisor");
  require "config/security.php";
  require "config/database.php";
  //require "config/common.php";

  $connection = new PDO($dsn, $username, $password, $options);

  if(isset($_POST['create_person'])) {
    try {
      $new_user = array(
        "nombre" => $_POST['nombre'],
        "apellido" => $_POST['apellido'],
        "tel" => $_POST['tel'],
        "email" => $_POST['email'],
        "tipo" => "cliente",
        "rfc" => $_POST['rfc']
      );

      $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "Persona",
        implode(", ", array_keys($new_user)),
        ":" . implode(", :", array_keys($new_user))
      );

      $statement = $connection->prepare($sql);
      $statement->execute($new_user);
    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }

  $person_count = 0;

  try {

    $sql = "SELECT count(*) FROM Persona";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $person_count = $statement->fetchAll()[0]["count(*)"];

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }

?>

<?php include("header-pdv.php"); ?>
    <div class="row " id="panelprincipal">
      <!-- Articulos -->
      <div class="col-sm-12 col-md-9 bg-white pt-3" >
        <div class="row mb-2" >
          <div class="col-sm-12" id="prendamenu">
            <div class="text-center" style="height: 540px; overflow-y: scroll; max-height: 440px;">
              <table class="table" cellspacing="0" >
                <thead>
                  <tr>
                    <th scope="col" style="display: none;">#</th>
                    <th scope="col">Articulo</th>
                    <th scope="col">Código</th>
                    <th scope="col">Dcto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio Unit</th>
                    <th scope="col">$/dcto</th>
                    <th scope="col">Importe</th>
                  </tr>
                </thead>
                <tbody id="salestable">
                </tbody>
              </table>
            </div><!--text center-->
          </div><!--#PrendaMenu -->
          </div><!--row -->
          <div class="row">
              <div class="col-sm-12">
                  <div class="form-group row">
                    <label for="productid" class="col-sm-1 col-md-1 col-form-label text-right">#</label>
                    <div class="col-sm-10 col-md-6">
                      <div class="row">
                        <form method="post" id="search_form">
                          <input type="text" name="search" class="form-control col-sm-10" style="margin: 0px;width:50%;display: inline-block;" id="productid" autofocus="autofocus" onkeydown="searchfield(event);">
                          <select name="search_select" class="form-control form-control-sm" style="width: 100px;display:inline-block;height:38px;padding:6px 12px;">
                            <option>
                              Código
                            </option>
                            <option>
                              Nombre
                            </option>
                          </select>
                          <button id="submit" class="btn btn-dark" type="submit" style="height: 36px;">
                            <i class="fa fa-search pt-2" style="padding-bottom: 15px;"></i>
                          </button>
                        </form>
                      </div>
                    </div>
                    <div class="form-check col-sm-2">
                      <input class="form-check-input" type="checkbox" value="" id="checkCash"  checked="true">
                      <label class="form-check-label" for="checkCash" >
                        Efectivo
                      </label>
                    </div>
                    <div class="form-check col-sm-3">
                      <input class="form-check-input" type="checkbox" value="" id="checkCard" >
                      <label class="form-check-label" for="checkCard" >
                        Tarjeta de Credito
                      </label>
                    </div>
                  </div>
              <div class="row">
                <div class="col-sm-12 ">
                  <table class="table">
                    <tr>
                      <td class="pt-2">Subtotal</td>
                      <td>
                        <input type="text" name="dcto" value="0.00" id="prod-subtotal" readonly class="form-control pt-1 pb-1 pl-2" style="width: 80px;">
                      </td>
                      <td class="pt-2">Dct</td>
                      <td>
                        <input type="number" min="0" max="37" name="dcto" id="total-dcto" placeholder="0.00" class="form-control pt-1 pb-1 pl-2" style="width: 80px;">
                      </td>
                      <td class="pt-2">IVA</td>
                      <td>
                        <input type="number" id="iva-total" min="0" max="100" name="iva" value="0.00" class="form-control pt-1 pb-1 pl-2" style="width: 80px;">
                      </td>
                      <td class="pt-2">Total</td>
                      <td>
                        <input type="text" name="dcto" id="prod-total" value="0.00" class="form-control pt-1 pb-1 pl-2" style="width: 60px;" readonly="">
                      </td>
                      <td><button class="btn btn-success" data-toggle="modal" data-target="#checkoutModal" onclick="fillCheckoutModal()">Checkout</button></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div><!--col-->
          </div><!--row -->
        </div><!--col -->
        <div class="col-sm-12 col-md-3 bg-white pt-3">
      <div class="row mb-3" style="">
        <div class="col-sm-12 col-md-12" >
          <?php include "pdv2/person_form.php" ?>
        </div><!-- col-->
      </div><!-- row-->
    </div><!--col -->
 </div><!--row -->
<?php include "resumen_compra.php"; ?>
<?php include "footer-pdv.php"; ?>
<script>
  function deleteProduct(id) {
    $('#'+id).remove();
  }

  function changeGeneralTotalPrice(){
    var total = 0;

    $("#salestable").children().map(function(){
      var totprice = parseFloat($("#total-price-"+this.id).text()).toFixed(2);
      var disc = parseFloat($("#discount-"+this.id).val());
      var iva = parseFloat($("#iva-total").val());
      var qty = parseFloat($("#quantity-"+this.id).text());
      var price = parseFloat($("#price-"+this.id).text());
      $("#price-discount-"+this.id).text(parseFloat(price - price * disc / 100).toFixed(2));
      $("#total-price-"+this.id).text((parseFloat($("#price-discount-"+this.id).text() * qty).toFixed(2)));
      return total += (totprice - (totprice * disc / 100) - (totprice * iva / 100));
    });
    $("#prod-total").val(total);
  }

  function changeProdDiscountPrice(id){
    var qty = parseFloat($("#quantity-"+id).text());
    var price = parseFloat($("#price-"+id).text());
    var dcto = parseFloat($("#discount-"+id).val());
    if (dcto > 37){
      dcto = 37;
      $("#discount-"+id).val(37);
    }
    $("#price-discount-"+id).text(qty * (price - price * dcto / 100));
    changeGeneralTotalPrice();
  }

  $(document).ready(function(){

    $("#search_form").on('submit', function (e){
      e.preventDefault();
      var searchstr = $("#productid").val();
      $.ajax({
        type: "POST",
        url: "pdv2/search_post.php",
        data: $("#search_form").serialize(),
        cache: false,
        success: function(result) {
          appendNewProduct(result);
          changeGeneralSubotalPrice();
          changeGeneralTotalPrice();
        }
      })
      return false;
    });
    function appendNewProduct(result) {
      $("#productid").val("");
      $("#productid").focus();

      var ids = $("#salestable").children().map(function(){
        return this.id;
      });
      var candidateId = $(result).find('tr').prevObject.attr('id');

      if (ids.toArray().indexOf(candidateId) != -1){
        doAddProductQuantity(candidateId);
        // notify addition
      } else {
        doNewAddProduct(result);
      }
      changeProdDiscountPrice(candidateId);
    }

    function doNewAddProduct(html) {
      $("#salestable").append(html);
    }

    function doAddProductQuantity(id) {
      var th = $("#quantity-"+id);
      var Qty = parseFloat(th.text());
      th.text( Qty + 1);
      changeProdTotalPrice(id);
      return true;
    }

    function changeProdTotalPrice(id) {
      var qty = parseFloat($("#quantity-"+id).text());
      var price = parseFloat($("#price-"+id).text());
      var prodTotal = $("#total-price-"+id);
      return prodTotal.text(qty * price);
    }

    function changeGeneralSubotalPrice(){
      var total = 0;
      $("#salestable").children().map(function(){
        return total += parseFloat($("#total-price-"+this.id).text());
      });
      $("#prod-subtotal").val(parseFloat(total));
    }

    $("#total-dcto").on('change', function(){
      if (parseFloat(this.value) > 37){
        $(this).val(37);
      }
      var newVal = $(this).val();

      $("#salestable").children().map(function(){
        return $("#discount-"+this.id).val(newVal);
      });
      changeGeneralTotalPrice()
      return true;
    });

    $("#iva-total").on('change', function(){
      changeGeneralTotalPrice();
    })
  });

  var clientNum = $("#clientNumber").val();
  var products;
  $("#clientNumber").val(1);
  $("#btnagregar").attr("disabled", true);
  function apartadoClick(isDefault){
    if(isDefault) {
      $("#clientNumber").val(1);
      $("#Name").attr("readonly", true).val("");
      $("#LastName").attr("readonly", true).val("");
      $("#Email").attr("readonly", true).val("");
      $("#Rfc").attr("readonly", true).val("");
      $("#Tel").attr("readonly", true).val("");
      $("#btnagregar").attr("disabled", true);
    } else {
      $("#clientNumber").val(clientNum);
      $("#Name").attr("readonly", false).focus();
      $("#LastName").attr("readonly", false);
      $("#Email").attr("readonly", false);
      $("#Rfc").attr("readonly", false);
      $("#Tel").attr("readonly", false);
      $("#btnagregar").removeAttr("disabled");
    }
  }

  function fillCheckoutModal() {
    var date = getDate();
    $("#checkout-modal__date").text("fecha: "+date);

    //Articulos
    products = $("#salestable").children().map(function(){
      var obj = {}
      var id = this.id;

       obj["id"] = $(this).find("#id-"+id).text();
       obj["name"] = $(this).find(".prod-name").text();
       obj["price"] = $(this).find("#price-"+id).text();
       obj["porc_dcto"] = $(this).find("#discount-"+id).val();
       obj["importe"] = $(this).find("#price-discount-"+id).text();
       obj["qty"] = $(this).find("#quantity-"+id).text();
       obj["dcto"] = parseFloat($(this).find("#total-price-"+id).text() - obj["importe"]).toFixed(3);

      return obj;
    });

    $("#checkout-modal__products").text("");
    products.each(function(){
      $("#checkout-modal__products").append('<tr>');
      $("#checkout-modal__products").append('<td>'+this['name']+'</td>')
      $("#checkout-modal__products").append('<td>'+this['price']+'</td>')
      $("#checkout-modal__products").append('<td>'+this['qty']+'</td>')
      $("#checkout-modal__products").append('<td>'+parseFloat(this['porc_dcto']).toFixed(2)+'%</td>')
      $("#checkout-modal__products").append('<td>'+parseFloat(this['importe']).toFixed(2)+'</td>')
      $("#checkout-modal__products").append('<td>'+parseFloat(this['importe'] * this['qty']).toFixed(2)+'</td>')
      $("#checkout-modal__products").append('</tr>');
      return true
    });

    var nums = $(products).map(function(){ return parseFloat(this['qty'])}).toArray();
    var subtotal = $("#prod-subtotal").val();
    var descuento = subtotal - $("#prod-total").val();
    var iva_total = $("#iva-total").val();
    var prod_total = $("#prod-total").val();
    $("#checkout-modal__products").append('<tr>');
    $("#checkout-modal__products").append('<td>'+nums.reduce((a,b)=> a + b, 0) + " Art(s)"+'</td>');
    $("#checkout-modal__products").append('<td></td>');
    $("#checkout-modal__products").append('<td></td>');
    $("#checkout-modal__products").append('<td>Subtotal: </td>');
    $("#checkout-modal__products").append('<td>'+parseFloat(subtotal).toFixed(2)+'</td>');
    $("#checkout-modal__products").append('</tr>');

    $("#checkout-modal__products").append('<tr>');
    $("#checkout-modal__products").append('</tr>');

    $("#checkout-modal__products").append('<tr>');
    $("#checkout-modal__products").append('<td></td>');
    $("#checkout-modal__products").append('<td></td>');
    $("#checkout-modal__products").append('<td></td>');
    $("#checkout-modal__products").append('<td>Descuento: </td>');
    $("#checkout-modal__products").append('<td>'+descuento.toFixed(2)+'</td>');
    $("#checkout-modal__products").append('</tr>');

    $("#checkout-modal__products").append('<tr>');
    $("#checkout-modal__products").append('<td></td>');
    $("#checkout-modal__products").append('<td></td>');
    $("#checkout-modal__products").append('<td></td>');
    $("#checkout-modal__products").append('<td>Total: </td>');
    $("#checkout-modal__products").append('<td><b>$'+parseFloat(prod_total).toFixed(2)+'</b></td>');
    $("#checkout-modal__products").append('</tr>');

    $(".cash_payment").hide();
    if($("#checkCash").is(':checked')){
      $(".cash_payment").show();
      $("#cash_payment").val(parseFloat(prod_total).toFixed(2));
      if(!$("#checkCard").is(':checked')){
        $("#cash_payment").attr('readonly', true);
      }
    }

    $(".card_payment").hide();
    $(".full_card_payment").hide();
    if($("#checkCard").is(':checked')){
      $(".card_payment").show();
      $("#cash_payment").attr('readonly', false);
      if(!$("#checkCash").is(':checked')){
        $(".full_card_payment").show();
        $("#cash_received").val(0);
        $("#card_payment").val(prod_total).attr("readonly", true);
        togglePurchaseButton();
      }
    }

    $("#cash_received, #card_received, input[name='payment_type']").change(()=>{
      var cash = parseFloat($("#cash_payment").val());
      var received = parseFloat($("#cash_received").val());
      var card_received = parseFloat($("#card_received").val());
      togglePurchaseButton();

      $("#change").val("$ " + (received + card_received - cash).toFixed(3));
    });

    $("#btnagregar").click(()=>{
      togglePurchaseButton();
    });

    function togglePurchaseButton(){
      var cash = $("#cash_received").val();
      var card = $("#card_received").val();
      var deposit = parseFloat(card + cash);
      var is_separated = $("#defaultCheck2").is(":checked");
      var btn = $("#purchaseButton");

      if(deposit >= prod_total ){
        if(btn.hasClass("disabled")){
          btn.removeClass("disabled");
        }
      } else {
        if(!btn.hasClass("disabled") && !is_separated){
          btn.addClass("disabled");
        }
      }

      if(deposit >= 100 && (prod_total * 0.25 < deposit) && is_separated && prod_total > 250){
        if(btn.hasClass("disabled")){
          btn.removeClass("disabled");
        }
      }
    }

    $("#purchaseButton").click(function(e){
      togglePurchaseButton();
      if(!$(this).hasClass('disabled')) {
        let btn = $(this);
        btn.attr("disabled", true);
        btn.text("CARGANDO...");
        e.preventDefault();

        let order_type = $("input[name='payment_type']:checked").attr('id');

        var cash = parseFloat($("#cash_received").val());
        var card = parseFloat($("#card_received").val());
        var change = $("#change").val().replace(/[^0-9.]/g,'');
        var deposit = parseFloat($("#cash_payment").val()).toFixed(2);

        var data = {
          register_purchase: {
            idPersona: $("#clientNumber").val(),
            monto_total: parseFloat(prod_total).toFixed(3),
            monto_tarjeta: card,
            monto_efectivo: ($("#defaultCheck1").is(":checked") ? cash - change : cash),
            fecha: new Date().toJSON().slice(0,10),
            payment_type: {
            },
            order_type: order_type,
            productos: products.toArray()
          }
        }

        if($("#checkCash").is(':checked')){
          data['register_purchase']['payment_type']['efectivo'] = true;
        }

        if($("#checkCard").is(':checked')){
          data['register_purchase']['payment_type']['tarjeta'] = true;
        }

        if($("#defaultCheck2").is(":checked")){
          data['register_purchase']['abono'] = card + cash;
        }

        $.ajax({
          type: "POST",
          url: "pdv2/register_purchase.php",
          data: data,
          cache: false,
          dataType: "json",
          success: function(result) {
            btn.text("OK!");
            let idFolio = result.folio;
            window.open("imprimirticket.php?folio="+idFolio, "_blank");
            document.location.reload();
          }
        })
			}
    });

    function getDate(){
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1;
      var yyyy = today.getFullYear();

      if(dd<10) {
        dd = '0'+dd
      }

      if(mm<10) {
        mm = '0'+mm
      }

      today = dd + '/' + mm + '/' + yyyy;
      return today;
    }

 	}

// Tecla Enter funciona como tecla Tab
  $(document).ready(function(){
    $("form.create_person_form").keydown(function(e){
      if(e.keyCode == 13) {
        var inputs = $(this).eq(0).find(":input");
        var idx = inputs.index(e.target);
        if (idx == inputs.length - 1) {
          inputs[0].select()
        } else {
          inputs[idx + 1].focus();
          inputs[idx + 1].select();
				}
        e.preventDefault();
        return e.keyCode = 9; // event a tecla tab
      }
    });
  });
    let canSubmitForm = false;

    $("#btnagregar").click((e)=>{
      e.preventDefault();
      var data = {
        nombre: $("#Name"),
        lastName: $("#LastName"),
        email: $("#Email"),
        rfc: $("#Rfc"),
        tel: $("#Tel")
      }

      var fieldsUnique = validatePersonFieldsUnique(data);

      if (canSubmitForm){
        // verificar que no hay errores en los campos antes del submit
        $("form.create_person_form").submit();
      }
    });

    function validateSingleField(){
       $("#email-error").text("");
       $("#rfc-error").text("");
       $("#tel-error").text("");

       var data = {
        email: $("#Email"),
        rfc: $("#Rfc"),
        tel: $("#Tel")
      }
      validatePersonFieldsUnique(data);
    }

    function validatePersonFieldsUnique(data){
      var obj = {validatePersonFields: {}}
      var result = true;
      Object.keys(data).map(function(key, index) {
        if(data[key].val() && data[key].hasClass("unique-field")){
         $("#"+key.substr(0,1).toUpperCase()+key.substr(1))[0].setCustomValidity("");
          return obj["validatePersonFields"][key] = data[key].val();
        }
      });
      $.ajax({
        type: "POST",
        url: "pdv2/verify_person_field.php",
        data: obj,
        dataType: "json",
        success: function(res) {
          Object.keys(res).map( key => {
            if(!res[key]){
              $(`#${key}-error`).text(`* El ${key} proporcionado ya existe.`);
              let field = key.substr(0,1).toUpperCase()+key.substr(1);
              $("#"+field)[0].setCustomValidity("Email existe.");
            }
            canSubmitForm = Object.keys(res).every((k)=> {return res[k]});
          });
        }
      });
    }
</script>
