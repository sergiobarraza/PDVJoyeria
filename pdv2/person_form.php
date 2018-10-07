<form method="post">
  <div class="row mb-2">
    <div class="form-check col-sm-4">
      <input class="form-check-input" checked type="radio" name="payment_type" value="" id="defaultCheck1" onchange="apartadoClick(true);">
        <label class="form-check-label" for="defaultCheck1" >
        Mostrador
      </label>
    </div>
    <div class="form-check col-sm-4">
      <input class="form-check-input" type="radio" name="payment_type" value="" id="defaultCheck2" onchange="apartadoClick(false);">
        <label class="form-check-label" for="defaultCheck2" >
        Apartado
      </label>
    </div>
    <div class="form-check col-sm-4">
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
      <label for="Email" class="col-sm-3 col-form-label">Email</label>
      <div class="col-sm-9 row">
          <input type="text" class="form-control col-sm-10" id="Email" name="email" placeholder="Correo Electronico" readonly>
          <div class="col-sm-2" onclick="search_person('email')" ><i class="fa fa-search clickable"></i></div>
      </div>
    </div>
    <div class="form-group row">
      <label for="RFC" class="col-sm-3 col-form-label">RFC</label>
      <div class="col-sm-9 row">
        <input type="text" class="form-control col-sm-10" id="RFC" name="rfc" placeholder="(opcional)" readonly>
        <div class="col-sm-2" onclick="search_person('rfc')" ><i class="fa fa-search clickable"></i></div>
      </div>
    </div>
    <div class="form-group row">
      <label for="Tel" class="col-sm-3 col-form-label">Tel</label>
      <div class="col-sm-9 row">
        <input type="text" class="form-control col-sm-10" id="Tel" name="tel" placeholder="" readonly>
        <div class="col-sm-2" onclick="search_person('tel')"><i class="fa fa-search clickable"></i></div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-3">
      </div>
    <div class="col-sm-6">
      <input type="submit" name="submit" class="btn-warning" value="Agregar Nuevo" id="btnagregar">
    </div>
  </div>
</form>

<script>
  function search_person(opt) {
    if(!$("#defaultCheck1").prop("checked")){
      var str;
      if (opt == "rfc") {
        str = $("#RFC").val();
      } else if(opt == "tel") {
        str = $("#Tel").val();
      } else if(opt == "email") {
        str = $("#Email").val();
      }

      $.ajax({
        type: "POST",
        url: "pdv2/search_person.php",
        data: {[opt]:str},
        cache: false,
        success: function(res) {
          $("#clientNumber").val(res["id"]);
          $("#Name").val(res["nombre"]);
          $("#LastName").val(res["apellido"]);
          $("#Email").val(res["email"]);
          $("#RFC").val(res["rfc"]);
          $("#Tel").val(res["tel"]);
        }
      });
    }
  }
</script>
