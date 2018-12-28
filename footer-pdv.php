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
    <script src="/PDVJoyeria/vendor/jquery/jquery.min.js"></script>
    <script src="/PDVJoyeria/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/PDVJoyeria/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="/PDVJoyeria/vendor/chart.js/Chart.min.js"></script>
    <script src="/PDVJoyeria/vendor/datatables/jquery.dataTables.js"></script>
    <script src="/PDVJoyeria/vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/PDVJoyeria/js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="/PDVJoyeria/js/sb-admin-datatables.min.js"></script>
    <script src="/PDVJoyeria/js/sb-admin-charts.min.js"></script>
    
    <script type="text/javascript"> 
     //Escript del descuento
     //Poniendo encima el cursor guarda el ultimo valor
     function onfocusnumeric(elementid){
      inputvar=document.getElementById(elementid);
      intvar = parseInt(inputvar.value);
      inputvar.setAttribute("oldValue",intvar);
     }

     //Presionando la tecla en un numeric input
     function onpresskey(event){
      e=event.which;
      // Allow: backspace, delete, tab, escape, enter and .
      if ($.inArray(e, [46, 8, 9, 27, 13]) !== -1 ||
       // Allow: Ctrl+A
      (e == 65 && event.ctrlKey === true) || 
        // Allow: home, end, left, right
      (e >= 35 && e <= 39)) {
          // let it happen, don't do anything
          return;
      }

      if (( e < 48 || e > 57 )) {
          event.preventDefault();
      }
     } 

     //Cuando cambia algun valor numerico en la tabla
     function changenumericvalue(elementid){
        inp= document.getElementById(elementid);
        row = elementid[6];
        console.log("row "+ row);
        minValue =  parseInt(inp.getAttribute('min'));
        maxValue =  parseInt(inp.getAttribute('max'));
        valueCurrent = parseInt(inp.value);
  
        if (valueCurrent < minValue){
          alert("Por debajo del valor minimo");     
          inp.value = inp.getAttribute("oldValue");    
        }

        if (valueCurrent> maxValue) {
          alert("Por encima del valor maximo");
          inp.value = inp.getAttribute("oldValue");
        }
        actualizarprecio(inp.getAttribute("data-row"));
        if (document.getElementById("quant["+row+"]").value == 0) {
          document.getElementById("item["+row+"]").remove();
        }

      }
      
      //Cuando cambia el precio del descuento
      function changeunitprice(elementid){
        inp= document.getElementById(elementid);
        row = inp.getAttribute("data-row");
        price = inp.value;
        console.log("row= "+row);
        console.log("price= "+ price);
        unit= parseInt(document.getElementById("raw["+row+"]").innerHTML);
        calcprice = (unit - price) * 100.0 / unit;
        console.log("calcprice= "+calcprice);
        pricefloat = parseFloat(calcprice);
        pricefloat=pricefloat.toFixed(4);
        document.getElementById("discRaw["+row+"]").value=pricefloat ;
        changenumericvalue("discRaw["+row+"]");
        //console.log(inp4);
      }

      function botonmenos(elementid){
        row = elementid[4];
        inp = document.getElementById("quant["+row+"]");
        console.log(inp);
        qty = inp.value;
        inp.value =inp.value - 1;
        console.log("New Value "+ inp.value);
        changenumericvalue("quant["+row+"]");
      }

       function botonmas(elementid){
        row = elementid[6];
        inp = document.getElementById("quant["+row+"]");
        qty = inp.value;
        intqty = parseInt(qty);
        inp.value =intqty + 1;
        console.log("New Value "+ inp.value);
        changenumericvalue("quant["+row+"]");
      }

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
          rowid=document.getElementById("item["+row+"]");
          rowid.remove();
        }else{
          actualizarprecio(row);
        }
      }
//Una vez que se modifica la cantidad o el descuento, se actualiza el precio.
      function actualizarprecio(row){
          quantity = document.getElementById("quant["+row+"]").value;
          coldisc = document.getElementById("disc["+row+"]");
          coldiscraw = document.getElementById("discRaw["+row+"]").value;
          colraw = document.getElementById("raw["+row+"]").innerHTML;
          coltotal = document.getElementById("total["+row+"]");
          calc=0.00;
          calc= (1-coldiscraw/100)*colraw;
          calc=calc.toFixed(2);
          coldisc.value=calc;
          calc= calc * quantity;
          calc=calc.toFixed(2);
          coltotal.innerHTML = calc;

      }


      function filterproduct(){
        //alert("Doing a query");
      }

    //Llenar la tabla de venta Impotante!!! CAMBIAR ESTE PARA QUE PUEDA SERVIR DESPUES
      $('.prodrow').click(function(e){
        e.preventDefault();
        prodid = $(this).attr('data-id');
        description = $(this).attr('data-desc');
        price = $(this).attr('data-price'); 
        if (nextprod.length == 0) {
          nextprod.push(1);
        }else{
          nextprod[nextprod.length]=nextprod[nextprod.length-1]+1;
        }
        row = nextprod[nextprod.length-1];
        console.log(row);
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
        //td4.className="p-1";
        inp4=document.createElement("input");
        inp4.className= "form-control mx-auto";
        inp4.style.width="55px";
        inp4.min="0";
        inp4.max="99";
        inp4.type = "text";
        inp4.name="discRaw["+row+"]";
        inp4.setAttribute("data-row", row); 
        inp4.setAttribute("value", 0);
        inp4.setAttribute("oldValue",0);
        inp4.onkeydown=function(){ onpresskey(event);};
        inp4.onchange=function(){ changenumericvalue(this.id);};
        inp4.onfocusin=function(){ onfocusnumeric(this.id);};
        inp4.id="discRaw["+row+"]";
        td4.appendChild(inp4);
        tr.appendChild(td4); 

        td5=document.createElement("td");
        div5=document.createElement("div");
        div5.className="input-group";
        spanminus5=document.createElement("span");
        spanminus5.className="input-group-btn";
        buttonminus5=document.createElement("button");
        buttonminus5.type="button";
        buttonminus5.className="btn btn-default btn-number";
        buttonminus5.setAttribute("data-type","minus");
        buttonminus5.setAttribute("data-field","quant["+row+"]");
        buttonminus5.id = "mas["+row+"]";

        buttonminus5.onclick=function(){botonmenos(this.id)};
        im5=document.createElement("i");
        im5.className="fa fa-minus";
        //Numeric Input
        inp5=document.createElement("input");
        inp5.type="text";
        inp5.name="quant["+row+"]";
        inp5.className="form-control input-number";
        inp5.setAttribute("data-row", ""+row); 
        inp5.setAttribute("value",1);
        inp5.setAttribute("oldValue",1);
        inp5.setAttribute("min",0);
        inp5.setAttribute("max",999);
        inp5.style.width= "40px";
        inp5.id="quant["+row+"]";
        inp5.onchange=function(){changenumericvalue(this.id)}; 
        inp5.onfocusin=function(){ onfocusnumeric(this.id);};
        inp5.onkeydown=function(){ onpresskey(event);};
        
        spanplus5=document.createElement("span");
        spanplus5.className="input-group-btn";
        buttonplus5=document.createElement("button");
        buttonplus5.type="button";
        buttonplus5.className="btn btn-default btn-number";
        buttonplus5.setAttribute("data-type","plus");
        buttonplus5.setAttribute("data-field","quant[1]");
        buttonplus5.id = "minus["+row+"]";
        buttonplus5.onclick=function(){botonmas(this.id)};
        ip5=document.createElement("i");
        ip5.className="fa fa-plus"; 

        buttonminus5.appendChild(im5);
        spanminus5.appendChild(buttonminus5);
        div5.appendChild(spanminus5);
        td5.appendChild(div5);
        tr.appendChild(td5);
        div5.appendChild(inp5);
        buttonplus5.appendChild(ip5);
        spanplus5.appendChild(buttonplus5); 
        div5.appendChild(spanplus5);

        td6=document.createElement("td");
        td6.id= "raw["+row+"]";
        price = parseFloat(price);
        price=price.toFixed(2);
        td6.innerHTML= price;
        tr.appendChild(td6);

        td7=document.createElement("td");
        inp7=document.createElement("input");
        inp7.className= "form-control mx-auto text-center ";
        inp7.style.width="70px";
        inp7.min="0";
        inp7.max="99";
        inp7.type = "text";
        inp7.name="disc["+row+"]";
        inp7.setAttribute("data-row", row); 
        inp7.setAttribute("value", price);
        inp7.setAttribute("oldValue",0);
        inp7.onkeydown=function(){ onpresskey(event);};
        inp7.onchange=function(){ changeunitprice(this.id);};
        inp7.onfocusin=function(){ onfocusnumeric(this.id);};
        inp7.id="disc["+row+"]";
        td7.appendChild(inp7);
        //td7.id= "disc["+row+"]";
        tr.appendChild(td7);

        td8=document.createElement("td");
        td8.id= "total["+row+"]";
        td8.innerHTML= price;
        tr.appendChild(td8);

        tbody.appendChild(tr);

        })
    </script>

    <script type="text/javascript">


      function searchfield(event){
        e=event.which;
        if(e== 13){
        }
      }
    </script>
  </div>
</body>

</html>
