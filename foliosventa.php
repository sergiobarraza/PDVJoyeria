<?php
$pageSecurity = array("admin");
require "config/security.php";
include("header-pdv.php");
require "config/database.php";
		?>
<div class="container text-center mt-5">
	<h2>Folios de venta</h2>
	<div class="row">
		<div class="col-sm-0 col-md-2"></div>
		<label for="folioid" class="col-sm-2 col-form-label">Folio de Venta:<i class="fa fa-search pl-4 pt-2"></i></label>
		<div class="col-sm-10 col-md-6">
			<form>
				<input type="text" name="folioid" class="form-control col-sm-10" style="margin: 0px;width:100%;display: inline-block;" id="folioid" autofocus="autofocus" >
			</form>
		</div>
		<div class="col-sm-0 col-md-2"></div>

	</div>
	<?php

	?>
	<!-- Example DataTables Card-->
    <div class="card mb-3 mt-3">
        <div class="card-header">
          	<i class="fa fa-table"></i> Folios de Venta</div>	
        <div class="card-body">
          	<div class="table-responsive">
            	<table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
              		<thead>
		                <tr>	
							<th>Código</th>
							<th>name</th>
							<th>Seleccionar</th>
						</tr>
						
					</thead>
					<tbody>
						<tr>
							<td>1234</td>
							<td>asdasdasd</td>
							<td><input href="foliosventa.php?folio=1" class="btn btn-success" value="Seleccionar" onclick="myFunction(1)"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	
<?php 
		include "footer-pdv.php";

?>
<script type="text/javascript">
	function myFunction(idfolio){
		location.href="imprimirticket.php?folio="+idfolio;
	}
</script>