<?php include("../../header-pdv.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="/PDVJoyeria/css/apartados.css" rel="stylesheet">
<div class="row" style="padding-bottom: 15px;">
  <div class="container">
    <div class="header-container">
      <h2 style="text-align: center;">Apartados</h2>
    </div>
    <div class="body-container">
      <div class="filter-container">
        <div class="search-container">
          <h4 style="margin-bottom: 13px;">
            Buscar
          </h4>
          <input
            class="form-control"
            placeholder="Introduce un valor"
          />
        </div>
        <div class="search_type-container">
          <p>
            Tipo de busqueda
          </p>
          <select class="form-control">
            <option value="Num Folio">Numero de folio</option>
          </select>
        </div>
        <div class="search_almacen-container">
          <p>
            Por almacen
          </p>
           <select class="form-control">
            <option value="All">Todos los Almacenes</option>
          </select>
        </div>
        <div class="search_btn-container">
          <button class="btn btn-primary">Buscar</button>
        </div>
      </div>
      <div id="folio_index" class="folio_index-container">
        <div class="loader-parent" id="folio-loader-parent">
          <div class="loader"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "../../footer-pdv.php"; ?>
<script>
  $(document).ready(function(){
    let data = [];
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

    function addFolioElement(row) {
      let str = "<div class='folio_item-container'>"
          str += "<li>Folio: 1234</li>"
          str += "<li> Almacen: Central</li>"
          str += "<li>Cliente: Daniel Rocha</li>"
          str += "<li>Creado: 17 abril 2018</li>"
          str += "<div>"
          str += "<button class='btn btn-primary'>Más Información +</button>"
          str += "</div>"
          str += "</div>"
      $("#folio_index").prepend(str);
    }
  });
</script>
