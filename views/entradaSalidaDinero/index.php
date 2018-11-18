<?php include("../../header-pdv.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="/PDVJoyeria/css/entradasalida.css" rel="stylesheet">
<div class="row" style="padding-bottom: 35px;">
  <div class="container">
    <span class="col col-6 display-inline left pt6 center">
      <h2>Entrada</h2>
      <div>
        <input
          type="number"
          placeholder="Cantidad a depositar - $"
          id="deposit-qty"
          class="form-control">
        <textarea rows"3" maxlength="90" class="form-control" id="deposit-concepto" style="padding: 15px 10px;margin: 15px 0;" placeholder="Concepto del depósito"></textarea>
        <button class="btn btn-primary" id="btn-deposit" style="width: 100%;">Confirmar Depósito</button>
      </div>
    </span>
    <span class="col col-6 display-inline left pt6 center">
      <h2>Salida</h2>
      <div>
        <input
          type="number"
          placeholder="Cantidad a retirar - $"
          id="withdraw-qty"
          class="form-control">
        <textarea rows"3" maxlength="90" class="form-control" id="withdraw-concepto" style="padding: 15px 10px;margin: 15px 0;" placeholder="Concepto del retiro"></textarea>
        <button class="btn btn-primary" id="btn-withdraw" style="width: 100%;">Confirmar Retiro</button>
      </div>
    </span>
  </div>
</div>
<?php include "../../footer-pdv.php"; ?>
<script>
  $(document).ready(function(){
    $("#btn-withdraw").click(function(){
      let qty = $("#withdraw-qty").val();
      let concepto = "Salida - " + $("#withdraw-concepto").val();
      qty = (qty > 0 ? qty : qty * -1);

      let obj = {
        withdraw: {
          monto: qty,
          concepto: concepto
        }
      };
      confirmTransaction(obj);
    });

    $("#btn-deposit").click(function(){
      let qty = $("#deposit-qty").val();
      let concepto = "Entrada - " + $("#deposit-concepto").val();
      let obj = {
        deposit: {
          monto: qty,
          concepto: concepto
        }
      };
      confirmTransaction(obj);
    });

    function confirmTransaction(obj) {
      $.ajax({
        type: "POST",
        url: "../../entradaSalida/create.php",
        data: obj,
        dataType: "json",
        success: function(res){
          data = res;
          debugger;
        }
      });
    }

  });
</script>
