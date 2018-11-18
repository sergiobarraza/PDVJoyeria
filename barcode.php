<?php
include "header.php";
?>
<input type="text" name="search" class="form-control col-sm-10" style="margin: 0px;width:50%;display: inline-block;" id="productid" autofocus="autofocus" onkeydown="onpresskey(event);">
<script type="text/javascript">
	function onpresskey(event){
      e=event.which;
      console.log(e);
      // Allow: backspace, delete, tab, escape, enter and .
      if (e == 13) {
      	anotar();
      }

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
     
     function anotar(){
     	var SKU= document.getElementById("productid").value;
     	alert("Enter: "+ SKU);
     }

</script>
<?php
include "footer.php"
?>