<?php
  require "config/database.php";
  require "config/common.php";

  $connection = new PDO($dsn, $username, $password, $options);

  if(isset($_POST['submit'])) {
    try {
      $new_user = array(
        "nombre" => $_POST['nombre'],
        "apellido" => $_POST['apellido'],
        "tel" => $_POST['tel'],
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
                    <th scope="col">#</th>
                    <th scope="col">Articulo</th>
                    <th scope="col">Descripción</th>
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
                    <div class="col-sm-10 col-md-4">
                      <div class="row">
                        <form method="post" id="search_form">
                          <input type="text" name="search" class="form-control col-sm-10" id="productid" autofocus="autofocus" onkeydown="searchfield(event);">
                          <div class="col-sm-1 col-md-1">
                            <button id="submit" type="submit">
                              <i class="fa fa-search pt-2"></i>
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="form-check col-sm-3">
                      <input class="form-check-input" type="checkbox" value="" id="CheckEfectivo"  checked="true">
                      <label class="form-check-label" for="defaultCheck1" >
                        Efectivo
                      </label>
                    </div>
                    <div class="form-check col-sm-3">
                      <input class="form-check-input" type="checkbox" value="" id="CheckEfectivo" >
                      <label class="form-check-label" for="defaultCheck1" >
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
                        <input type="text" name="dcto" value="0.00" id="prod-subtotal" readonly class="form-control pt-1 pb-1 pl-2" style="width: 60px;">
                      </td>
                      <td class="pt-2">Dct</td>
                      <td>
                        <input type="number" min="0" max="100" name="dcto" id="total-dcto" placeholder="0.00" class="form-control pt-1 pb-1 pl-2" style="width: 60px;">
                      </td>
                      <td class="pt-2">IVA</td>
                      <td>
                        <input type="number" id="iva-total" min="0" max="100" name="iva" value="0.00" class="form-control pt-1 pb-1 pl-2" style="width: 60px;">
                      </td>
                      <td class="pt-2">Total</td>
                      <td>
                        <input type="text" name="dcto" id="prod-total" value="0.00" class="form-control pt-1 pb-1 pl-2" style="width: 60px;" readonly="">
                      </td>
                      <td><button class="btn btn-success" data-toggle="modal" data-target="#checkoutModal">Checkout</button></td>
                    </tr>
                  </table>
                </div>
              </div>
        </div><!--col-->
            </div><!--row -->
        </div><!--col -->
        <div class="col-sm-12 col-md-3 bg-white pt-3">
      <div class="row mb-3" style="height: 300px; overflow-y: scroll; max-height: 240px;">
        <div class="col-sm-12 col-md-12" >
            <table class="table">
              <thead>
                <tr>
                    <th scope="col">Folio</th>
                    <th scope="col">Nombre</th>
                </tr>
            </thead>
              <tbody>
                <tr>
                    <td>12345</td>
                    <td>Otto</td>
                </tr>
                <tr>
                    <td>123678</td>
                    <td>Thornton</td>
                </tr>
                <tr>
                    <td>12908</td>
                    <td>the Bird</td>
                </tr>
                <tr >
                    <td >12678</td>
                    <td>the Bird</td>
                </tr>
                <tr>
                    <td>12678</td>
                    <td>the Bird</td>
                </tr>
              </tbody>
          </table>
          </div><!-- col-->
      </div><!-- row-->
      <div class="row">
            <div class="col-sm-12">
          <form method="post">
            <div class="row mb-2">
              <div class="form-check col-sm-5">
                <input class="form-check-input" checked type="radio" name="payment_type" value="" id="defaultCheck1" onchange="apartadoClick(true);">
                  <label class="form-check-label" for="defaultCheck1" >
                  Mostrador
                </label>
              </div>
              <div class="form-check col-sm-5">
                <input class="form-check-input" type="radio" name="payment_type" value="" id="defaultCheck2" onchange="apartadoClick(false);">
                  <label class="form-check-label" for="defaultCheck2" >
                  Apartado
                </label>
              </div>
              <div class="form-check col-sm-5">
                <input class="form-check-input" type="radio" name="payment_type" value="" id="defaultCheck3" onchange="apartadoClick(false);">
                  <label class="form-check-label" for="defaultCheck3">
                  Factura
                </label>
              </div>
            </div>
              <div class="form-group row">
                <label for="clientNumber" class="col-sm-3 col-form-label">#</label>
                <div class="col-sm-9 row">
                <input type="text"  class="form-control col-sm-10" id="clientNumber" value="<?php echo $person_count + 1;?>" readonly onchange="buscarcliente();">
                    <div class="col-sm-2"><i class="fa fa-search clickable"></i></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="Name" class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-9 row">
                    <input type="text" class="form-control col-sm-10" id="Name" name="nombre" placeholder="Mostrador" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="LastName" class="col-sm-3 col-form-label">Apellido</label>
                <div class="col-sm-9 row">
                    <input type="text" class="form-control col-sm-10" id="LastName" name="apellido" placeholder="Mostrador" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="RFC" class="col-sm-3 col-form-label">RFC</label>
                <div class="col-sm-9 row">
                    <input type="text" class="form-control col-sm-10" id="RFC" name="rfc" placeholder="(opcional)" readonly>
                    <div class="col-sm-2"><i class="fa fa-search clickable"></i></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="Tel" class="col-sm-3 col-form-label">Tel</label>
                <div class="col-sm-9 row">
                    <input type="text" class="form-control col-sm-10" id="Tel" name="tel" placeholder="" readonly>
                    <div class="col-sm-2"><i class="fa fa-search clickable"></i></div>
                </div>
              </div>
              <div class="form-group row">
              <div class="col-sm-3">
              </div>
              <div class="col-sm-6">
                <input type="submit" name="submit" class="btn-warning" value="Agregar Nuevo" id="btnagregar">
               <!--  <button type="button" class="btn-warning" id="btnagregar" onclick="agregarcliente();">Agregar Nuevo</button> -->
                <button type="button" class="btn-success" id="btnagregar" onclick="aceptarcliente();" style="display: none;">Aceptar</button>
                </div>
              </div>
          </form>
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
      var totprice = parseInt($("#total-price-"+this.id).text());
      var disc = parseInt($("#discount-"+this.id).val());
      var iva = parseInt($("#iva-total").val());
      return total += (totprice - (totprice * disc / 100) - (totprice * iva / 100));
    });
    $("#prod-total").val(total);
  }

  function changeProdDiscountPrice(id){
    var qty = parseInt($("#quantity-"+id).text());
    var price = parseInt($("#price-"+id).text());
    var dcto = parseInt($("#discount-"+id).val());
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
      var ids = $("#salestable").children().map(function(){
        return this.id;
      });
      var candidateId = $(result).find('tr').prevObject.attr('id');

      if (ids.toArray().indexOf(candidateId) != -1){
        doAddProductQuantity(candidateId);
        changeProdDiscountPrice(candidateId);
        // notify addition
      } else {
        doNewAddProduct(result);
      }
    }

    function doNewAddProduct(html) {
      $("#salestable").append(html);
    }

    function doAddProductQuantity(id) {
      var th = $("#quantity-"+id);
      var Qty = parseInt(th.text());
      th.text( Qty + 1);
      changeProdTotalPrice(id);
      return true;
    }

    function changeProdTotalPrice(id) {
      var qty = parseInt($("#quantity-"+id).text());
      var price = parseInt($("#price-"+id).text());
      var prodTotal = $("#total-price-"+id);
      return prodTotal.text(qty * price);
    }

    function changeGeneralSubotalPrice(){
      var total = 0;
      $("#salestable").children().map(function(){
        return total += parseInt($("#total-price-"+this.id).text());
      });
      $("#prod-subtotal").val(parseFloat(total));
    }

    $("#total-dcto").on('change', function(){
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

  function apartadoClick(isDefault){
    if(isDefault) {
      $("#clientNumber").focus();
      $("#Name").attr("readonly", true);
      $("#LastName").attr("readonly", true);
      $("#RFC").attr("readonly", true);
      $("#Tel").attr("readonly", true);
    } else {
      $("#clientNumber").focus();
      $("#Name").attr("readonly", false);
      $("#LastName").attr("readonly", false);
      $("#RFC").attr("readonly", false);
      $("#Tel").attr("readonly", false);
    }
  }



</script>
