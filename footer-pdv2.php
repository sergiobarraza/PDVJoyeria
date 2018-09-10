</div>
<!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Barraza.mx 2018</small>
        </div>
      </div>
    </footer>
    
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <script>
      function openNav() {
        document.getElementById("mySidenav").style.width = "440px";
      }

      function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
      }  
    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
    <script type="text/javascript">
        //plugin bootstrap minus and plus
      $('.btn-number').click(function(e){
         e.preventDefault();
          
          fieldName = $(this).attr('data-field');
          type      = $(this).attr('data-type');
          var input = $("input[name='"+fieldName+"']");
          var currentVal = parseInt(input.val());
          if (!isNaN(currentVal)) {
              if(type == 'minus') {
                  
                  if(currentVal > input.attr('min')) {
                      input.val(currentVal - 1).change();
                  } 
                  if(parseInt(input.val()) == input.attr('min')) {
                      $(this).attr('disabled', true);
                  }

              } else if(type == 'plus') {

                  if(currentVal < input.attr('max')) {
                      input.val(currentVal + 1).change();
                  }
                  if(parseInt(input.val()) == input.attr('max')) {
                      $(this).attr('disabled', true);
                  }

              }
          } else {
              input.val(0);
          }
      });
      $('.input-number').focusin(function(){
         $(this).data('oldValue', $(this).val());
      });
      $('.input-number').change(function() {
            
          minValue =  parseInt($(this).attr('min'));
          maxValue =  parseInt($(this).attr('max'));
          valueCurrent = parseInt($(this).val());
          
          name = $(this).attr('name');
          if(valueCurrent >= minValue) {
              $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
          } else {
              alert('No es valido valores menores a 0');
              $(this).val($(this).data('oldValue'));
          }
          if(valueCurrent <= maxValue) {
              $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
          } else {
              alert('Valor maximo sobrepasado');
              $(this).val($(this).data('oldValue'));
          }
          
          
      });
      $(".input-number").keydown(function (e) {
              // Allow: backspace, delete, tab, escape, enter and .
              if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                   // Allow: Ctrl+A
                  (e.keyCode == 65 && e.ctrlKey === true) || 
                   // Allow: home, end, left, right
                  (e.keyCode >= 35 && e.keyCode <= 39)) {
                       // let it happen, don't do anything
                       return;
              }
              // Ensure that it is a number and stop the keypress
              if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                  e.preventDefault();
              }
          });
      </script>
      <script type="text/javascript">
     
      $('.input-number2').focusin(function(){
         $(this).data('oldValue', $(this).val());
      });
      $('.input-number2').change(function() {
          minValue =  parseInt($(this).attr('min'));
          maxValue =  parseInt($(this).attr('max'));
          valueCurrent = parseInt($(this).val());
          rownumber = parseInt($(this).attr('data-row'));//.parentElement.parentElement.children[0].innerHTML);
          console.log(rownumber);
          name = $(this).attr('name');
          if(valueCurrent >= minValue) {
            if(valueCurrent <= maxValue) {
              actualizarprecio(rownumber);
            } else {
                alert('Valor maximo sobrepasado');
                $(this).val($(this).data('oldValue'));
            }
          } else {
              alert('No es valido valores menores a 0');
              $(this).val($(this).data('oldValue'));
          }
          
          
          
      });
      
       $(".input-number2").keydown(function (e) {
              // Allow: backspace, delete, tab, escape, enter and .
              if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                   // Allow: Ctrl+A
                  (e.keyCode == 65 && e.ctrlKey === true) || 
                   // Allow: home, end, left, right
                  (e.keyCode >= 35 && e.keyCode <= 39)) {
                       // let it happen, don't do anything
                       return;
              }
              // Ensure that it is a number and stop the keypress
              if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                  e.preventDefault();
              }
          });
      </script>
      <script type="text/javascript">
        var nextprod= [];

        function changequantity(row){
          quantity = document.getElementById("quant["+row+"]").value;
          if (quantity == 0){
            rowid=document.getElementById("item["+row+"]")
            rowid.remove();
          }else{
            actualizarprecio(row);
          }
        }

        function actualizarprecio(row){
            quantity = document.getElementById("quant["+row+"]").value;
            coldisc = document.getElementById("disc["+row+"]");
            coldiscraw = document.getElementById("discRaw["+row+"]").value;
            colraw = document.getElementById("raw["+row+"]").innerHTML;
            coltotal = document.getElementById("total["+row+"]");
            calc=0.00;
            calc= (1-coldiscraw/100)*colraw;
            calc=calc.toFixed(2);
            coldisc.innerHTML=calc;
            calc= calc * quantity;
            calc=calc.toFixed(2);
            coltotal.innerHTML = calc;

        }

        $('.button-linea').click(function(e){
          e.preventDefault();
          datalinea = $(this).attr('data-linea');
          idlinea = $(this).attr('data-id');
          document.getElementById("filtrolinea").innerHTML=datalinea;;          
          document.getElementById("filtrobuttonlinea").style.display = "block";
          document.getElementById("lineaInput").value= idlinea;
          document.getElementById("blocklinea").style.display="none";
          document.getElementById("blockdepto").style.display="flex";
          if (document.getElementById("deptoInput").value == "") {
            document.getElementById("blocklinea").style.display="none";
            document.getElementById("blockdepto").style.display="flex";
          }else{
            document.getElementById("blocklinea").style.display="none";
            document.getElementById("blockdepto").style.display="none";
            document.getElementById("blockprod").style.display="flex";
            filterproduct();
          }
          })

        $('.button-depto').click(function(e){
          e.preventDefault();
          datalinea = $(this).attr('data-linea');
          idlinea = $(this).attr('data-id');
          document.getElementById("filtrodepto").innerHTML=datalinea;;          
          document.getElementById("filtrobuttondepto").style.display = "block";
          document.getElementById("deptoInput").value= idlinea;
          document.getElementById("blocklinea").style.display="none";
          document.getElementById("blockdepto").style.display="none";
          filterproduct();
          document.getElementById("blockprod").style.display="flex";

          })

        function byelinea(){
          
          document.getElementById("blocklinea").style.display="flex";
          document.getElementById("blockdepto").style.display="none";
          document.getElementById("blockprod").style.display="none";
          document.getElementById("lineaInput").value= "";
          document.getElementById("filtrobuttonlinea").style.display = "none";
        }

        function byedepto(){
          if (document.getElementById("lineaInput").value != "") {          
            document.getElementById("blocklinea").style.display="none";
            document.getElementById("blockdepto").style.display="flex";
            document.getElementById("blockprod").style.display="none";
          }
          
          document.getElementById("deptoInput").value= "";
          document.getElementById("filtrobuttondepto").style.display = "none";
        }

        function filterproduct(){
          //alert("Doing a query");
        }
//Llenar la tabla de venta
        $('.prodrow').click(function(e){
          e.preventDefault();
          prodid = $(this).attr('data-id');
          description = $(this).attr('data-desc');
          price = $(this).attr('data-price'); 
          if (nextprod.length == 0) {
            nextprod.push(2);
          }else{
            nextprod[nextprod.length]=nextprod[nextprod.length-1]+1;
          }
          row = nextprod[nextprod.length-1];
          //Empezamos a llenar la tabla
          tbody=document.getElementById('salestable');
          tr=document.createElement("tr");
          tr.id="item["+row+"]";
          td1=document.createElement("th");
          td1.innerHTML=row;
          td1.scope="row";
          tr.appendChild(td1);

          td2=document.createElement("td");
          td2.innerHTML=prodid
          tr.appendChild(td2);

          td3=document.createElement("td");
          td3.innerHTML=description
          tr.appendChild(td3);

          td4=document.createElement("td");
          //td4.addClass("p-2");
          inp4=document.createElement("input");
          inp4.className= "form-control input-number mx-auto input-number2";
          /*inp4.value="0";*/
          inp4.style.width="55px";
          inp4.min="0";
          inp4.max="99";
          inp4.type = "text";
          inp4.name="discRaw["+row+"]";
          inp4.setAttribute("data-row", row);
          inp4.setAttribute("value", 0);
          inp4.onkeydown=function(){ onpress();};
          inp4.id="discRaw["+row+"]";
          td4.appendChild(inp4);
          tr.appendChild(td4);  

          tbody.appendChild(tr);

          })
      </script>
  </div>
</body>

</html>