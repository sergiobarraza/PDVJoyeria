<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="checkoutModalLabel">Resumen de Compra - Joyería Claros</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="checkout-modal__date"></div>
        <div>
        <hr>
          <div>Articulos</div>
          <table style="text-align: center;">
            <thead>
              <th>Nombre</th>
              <th>Precio U.</th>
              <th>Cantidad</th>
              <th>%DCTO</th>
              <th>DCTO</th>
              <th>Importe</th>
            </thead>
            <tbody id="checkout-modal__products">
            </tbody>
          </table>
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
              <td class="cash_payment">Monto a recibir: </td>
              <td style="padding-right: 15px;" class="cash_payment"><input type="text" name="cash_payment" id="cash_payment" class="form-control" style="width: 60px;"></td>
              <td class="full_card_payment">Pago con Tarjeta: </td>
              <td class="full_card_payment"><input type="text" name="card_payment" id="card_payment" class="form-control" style="width: 60px;" ></td>
            </tr>
            <tr>
              <td class="cash_payment">Efectivo Recibido: </td>
              <td class="cash_payment"><input type="text" name="cash_received" value="0" id="cash_received" class="form-control" style="width: 60px;" ></td>
              <td class="card_payment">Pago con tarjeta Recibido: </td>
              <td class="card_payment"><input type="text" name="card_received" value="0" id="card_received" class="form-control" style="width: 60px;" ></td>
            </tr>
            <tr>
              <td class="cash_payment">Su Cambio: </td>
              <td class="cash_payment"><input type="text" name="change" id="change" class="form-control" style="width: 60px;"  readonly></td>
            </tr>
          </tbody>
        </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary disabled" id="purchaseButton">Registrar Compra</button>
      </div>
    </div>
  </div>
</div>
