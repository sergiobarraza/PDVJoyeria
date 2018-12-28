<div class="modal show fade" id="folioInfoModal" tabindex="-1" role="dialog" aria-labelledby="folioInfoModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="folioInfoModal">Resumen del Folio - Joyería Claros</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-folioInfo">
          <h3 class="modal-folioInfo_h3"></h3>
          <div>Estado de folio: <span class="folioState">Pendiente</span></div>
          <div>Devuelto: <span class="folioReturned">No</span></div>
          <hr>
          <div class="clientInfo" style="font-size: 18px;font-weight: 600; margin-bottom: 0px;">
            Información del cliente
          </div>
          <table clas="clientInfo_table">
            <tbody>
              <tr>
                <td style="font-weight: 600;">
                  Nombre:
                </td>
                <td id="clientInfo_name" style="padding-right: 10px;">
                </td>
                <td style="font-weight: 600;">
                  email:
                </td>
                <td id="clientInfo_email">
                </td>
              </tr>
              <tr>
                <td style="font-weight: 600;">
                  rfc:
                </td>
                <td id="clientInfo_rfc" style="padding-right: 10px;">
                </td>
                <td style="font-weight: 600;">
                  tel:
                </td>
                <td id="clientInfo_tel">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <hr>
        <div class="modal-ventaInfo">
          <div style="margin-top:10px;font-weight: 600;">Información de la venta</div>
            <table>
              <tbody>
                <tr style="margin-bottom: 15px;">
                  <td style="font-weight: 600;">Numero de productos:</td>
                  <td id="ventaInfo-prodCount" style="padding: 0 15px;"></td>
                  <td style="font-weight: 600;">Saldo actual:</td>
                  <td id="ventInfo-folioDebt" style="padding: 0 15px;">$0</td>
                </tr>
              </tbody>
            </table>
          <div>
            <table>
              <thead>
                 <tr class="venta-header__tr" style="font-weight: 600;">
                  <td>
                    Nombre
                  </td>
                  <td>
                    Precio
                  </td>
                  <td style="padding-left: 0px;padding-right: 0px;">
                    Cantidad
                  </td>
                  <td style="padding-left: 30px;padding-right: 30px;">
                    Saldo
                  </td>
                  <td>
                    Seleccionar
                  </td>
                </tr>
              </thead>
              <tbody id="venta-tbody">
              </tbody>
            </table>
          </div>
        </div>
        <hr>
        <div>
          <table>
            <tbody>
              <tr>
                <td class="cash_payment">
                  <b>Efectivo</b>
                </td>
                <td class="cash_payment"></td>
                <td class="card_payment">
                  <b>Tarjeta</b>
                </td>
              </tr>
              <tr>
                <td class="cash_payment">Abono a recibir: </td>
                <td style="padding-right: 15px;" class="cash_payment"><input type="text" value="0" name="cash_payment" id="cash_payment" class="form-control" style="width: 90px;"></td>
                <td class="full_card_payment"></td>
                <td class="full_card_payment"></td>
              </tr>
              <tr>
                <td class="cash_payment">Efectivo Recibido: </td>
                <td class="cash_payment"><input type="text" name="cash_received" value="0" id="cash_received" class="form-control" style="width: 90px;" ></td>
                <td class="card_payment">Pago con tarjeta Recibido: </td>
                <td class="card_payment"><input type="text" name="card_received" value="0" id="card_received" class="form-control" style="width: 90px;" ></td>
              </tr>
              <tr>
                <td class="cash_payment">Su Cambio: </td>
                <td class="cash_payment"><input type="text" name="change" id="change" class="form-control" style="width: 90px;"  readonly></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div>
          <hr>
          <div>Historial de pagos</div>
          <table class="payment_history-table">
            <thead class="payment_history-thead">
              <tr>
                <th>monto</th>
                <th>Tipo de pago</th>
                <th>fecha</th>
              </tr>
            </thead>
            <tbody id="payment_history-tbody" class="payment_history-tbody">
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-danger cancel-order" style="float: left;">Cancelar Orden</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="purchaseButton">Registrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(".cancel-order").click((e) => {
      $(".cancel-order").data();
      if(confirm("Confirmas la cancelación del folio?")) {
        $.ajax({
          type: "POST",
          url: "../../devoluciones/index.php",
          data: {cancel_folio: { idFolio: $(".cancel-order").data("id")}},
          success: function(res){
            document.location.reload();
          }
        });
      }
  });
</script>

<style type="text/css">
  .modal-backdrop.in {
    opacity: 0.7;
  }

  .modal-folioInfo_h3 {
    font-weight: 600;
  }

  .venta-header__tr td {
    padding: 15px;
  }

  .venta-body__tr td {
    padding: 0 15px;
  }

  .payment_history-table {
    width: 100%;
    display: block;
  }

  .payment_history-thead {
    display: inline-block;
    width: 94%;
    height: 40px;
    padding: 10px;
    margin: 0 10px;
    border-bottom: 1px solid black;
  }

  .payment_history-thead tr {
    width: 100%;
    display: block;
  }

  .payment_history-thead tr th {
    display: inline-block;
    width: 32%;
    padding: 0 15px;
  }

  .payment_history-tbody {
    height: 100px;
    display: inline-block;
    width: 100%;
    overflow: auto;
    padding-bottom: 15px;
  }
  .payment_history-tbody tr {
    width: 100%;
    display: block;
    border-bottom: 1px solid #ced4da;
    padding: 5px 0;
  }

  .payment_history-tbody tr td {
    display: inline-block;
    width: 32%;
    padding: 0 20px;
  }

  .venta-body__chkbx {
    height: 19px;
  }

  .modal-footer {
    display: block;
    text-align: right;
  }
</style>
