<form method="post" class="create_person_form">
  <input type="text" name="create_person" value="" id="hidden_create_person_field" style="display: none;">
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
        <input
          type="text"
          class="form-control col-sm-10"
          id="Name"
          name="nombre"
          placeholder="Mostrador"
          minlength="4"
          readonly required>
      </div>
    </div>
    <div class="form-group row">
      <label for="LastName" class="col-sm-3 col-form-label">Apellido</label>
      <div class="col-sm-9 row">
          <input type="text" class="form-control col-sm-10" minlength="4" id="LastName" name="apellido" placeholder="Mostrador" readonly required>
      </div>
    </div>
    <span id="email-error" style="font-size: 16px;color: red;"></span>
    <div class="form-group row">
      <label for="Email" class="col-sm-3 col-form-label">Email</label>
      <div class="col-sm-9 row">
          <input type="email" class="form-control col-sm-10 unique-field"
             id="Email"
             name="email"
             placeholder="Correo Electronico"
             onChange="validateSingleField()"
             readonly
             required>
          <div class="col-sm-2" onclick="search_person('email')" ><i class="fa fa-search clickable"></i></div>
      </div>
    </div>
    <span id="rfc-error" style="font-size: 16px;color: red;"></span>
    <div class="form-group row">
      <label for="Rfc" class="col-sm-3 col-form-label">RFC</label>
      <div class="col-sm-9 row">
        <input type="text" class="form-control col-sm-10 unique-field"
          id="Rfc"
          name="rfc"
          placeholder="Ingrese un Rfc (opcional)"
          readonly
          onChange="validateSingleField()"
          onkeyup="validateRfc(this)"
        >
        <div class="col-sm-2" onclick="search_person('rfc')" ><i class="fa fa-search clickable"></i></div>
      </div>
    </div>
    <span id="tel-error" style="font-size: 16px;color: red;"></span>
    <div class="form-group row">
      <label for="Tel" class="col-sm-3 col-form-label">Tel</label>
      <div class="col-sm-9 row">
        <input
          type="tel"
          class="form-control col-sm-10 unique-field"
          id="Tel"
          name="tel"
          onChange="validateSingleField()"
          placeholder="871-123-4567"
          readonly
          pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
          required>
        <div class="col-sm-2" onclick="search_person('tel')"><i class="fa fa-search clickable"></i></div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-3">
      </div>
    <div class="col-sm-6">
      <input type="submit" name="btnSubmit" class="btn-warning" value="Agregar Nuevo" id="btnagregar">
    </div>
  </div>
</form>
<link rel="stylesheet" type="text/css" href="css/person_form.css">

<script>
  function search_person(opt) {
    if(!$("#defaultCheck1").prop("checked")){
      var str;
      if (opt == "rfc") {
        str = $("#Rfc").val();
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
          $("#Rfc").val(res["rfc"]);
          $("#Tel").val(res["tel"]);
        }
      });
    }
  }

  function validateRfc(input){
    var rfc = input.value.trim().toUpperCase(),
        result = $("#resultRFC"),
        valid;

    input.value ?
      input.required = true :
      input.required = false

    var rfcValid = rfcValido(rfc);
    if (rfcValid){
      input.setCustomValidity("");
    }else {
      input.setCustomValidity('El Rfc No coincide');
    }
  }

  function rfcValido(rfc) {
    const rfc_regex = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var   rfc_valid = rfc.match(rfc_regex);
    return !!rfc_valid;
  }
</script>

