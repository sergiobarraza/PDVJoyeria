<?php
	session_start();
	$securityPass = false;
	//echo "arraylength= ";
	//echo count($pageSecurity);
	//echo "<br>";
	for ($i=0; $i < count($pageSecurity) ; $i++) { 
	 	# code...
	 
    	if ($_SESSION['tipo'] == $pageSecurity[$i]  ) {
    		$securityPass = true;
    		//echo "tagueno";
    	}
	}
	if (!$securityPass) {
		//echo $_SESSION['tipo'];
		include "redirect.php";
	}
?>