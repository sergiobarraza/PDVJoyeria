<?php 
function numtowords($num)
{ 
	$ones = array(
				0 => "", 
				1 => "UN", 
				2 => "DOS", 
				3 => "TRES", 
				4 => "CUATRO", 
				5 => "CINCO", 
				6 => "SEIS", 
				7 => "SIETE", 
				8 => "OCHO", 
				9 => "NUEVE", 
				10 => "DIEZ", 
				11 => "ONCE", 
				12 => "DOCE", 
				13 => "TRECE", 
				14 => "CATORCE", 
				15 => "QUINCE", 
				16 => "DIECISÉIS", 
				17 => "DIECISIETE", 
				18 => "DIECIOCHO", 
				19 => "DIECINUEVE",
				20 => "VEINTE",
				21 => "CEINTIUN",
				22 => "CEINTIDOS",
				23 => "CEINTITRES",
				24 => "CIENTICUATRO",
				25 => "VEINTICINCO",
				26 => "VEINTISEIS",
				27 => "VEINTISIETE",
				28 => "VEINTIOCHO",
				29 => "VEINTINUEVE",

			); 

	$tens = array(
				0 => "",
				1 => "", 
				2 => "VEINTI", 
				3 => "TREINTA", 
				4 => "CUARENTA", 
				5 => "CINCUENTA", 
				6 => "SESENTA", 
				7 => "SETENTA", 
				8 => "OCHENTA", 
				9 => "NOVENTA" 
	); 
	$thousands = array(
				"", 				
				"MIL", 
				"MILLON", 
				); //limit t quadrillion 
	$hundreds = array (
				1 => "CIENTO",
				2 => "DOSCIENTOS", 
				3 => "TRESCIENTOS", 
				4 => "CUATROCIENTOS", 
				5 => "QUINIENTOS", 
				6 => "SEISCIENTOS", 
				7 => "SETECIENTOS", 
				8 => "OCHOCIENTOS", 
				9 => "NOVECIENTOS" 
				);
	$num = number_format($num,2,".",","); 
	//echo $num;
	$num_arr = explode(".",$num); 
	$wholenum = $num_arr[0]; 
	$decnum = $num_arr[1]; 
	$whole_arr = array_reverse(explode(",",$wholenum)); 
	krsort($whole_arr); 
	$rettxt = "("; 
	foreach($whole_arr as $key => $i)
	{ 	
		$int = (int)$i;
		//echo "I= ".$i."<br>";
		//echo "Key= ".$key."<br>";
		/*if($i < 21)
		{ 
			$int = (int)$i;
			$rettxt .= $ones[$int]; 
		}elseif($i < 100){ 
			
			//$rettxt .= $tens[substr($i,0,1)]; 
			//$rettxt .= " ".$ones[substr($i,1,1)]; 
		}else{ 
			//$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
			//$rettxt .= " ".$tens[substr($i,1,1)]; 
			//$rettxt .= " ".$ones[substr($i,2,1)]; 
		}*/

		if($key > 1)//Fuera de los miles
		{	
			if ($i == 0 )
			{
				//$rettxt .= "cero";	
				
			}elseif($i==1){
				$rettxt .= $ones[$int];
				$rettxt .= " ".$thousands[$key]." ";
			}
			elseif ($i < 30)
			{
				$rettxt .= $ones[$int];
				$rettxt .= " ".$thousands[$key]."es ";

			}elseif($i<100)
			{
				$decenas =substr($i,-2,1);
				//echo "decenas= ".$decenas."<br>";
				$rettxt .= $tens[$decenas];
				$unidades = substr($i,-1 ,1);
				if ($unidades >0)
				$rettxt .= 	" y ";
				$rettxt .= " ".$ones[$unidades];
				$rettxt .= " ".$thousands[$key]."ES ";
			}elseif($i==100)
			{
				$rettxt .= "CIEN";
				$rettxt .= " ".$thousands[$key]."ES ";
			}
			else{
				$centenas=substr($i,-3,1);
				$rettxt .= $hundreds[$centenas]." ";
				$restante=substr($i,-2);
				//echo "Restante= ".$restante."<br>";
				if($restante < 30)
				{
					$restante = (int)$restante;
					$rettxt .= $ones[$restante];
				}else{
					$decenas =substr($restante,-2,1);
					$rettxt .= $tens[$decenas];
					$unidades = substr($restante,-1	,1);
					if ($unidades >0)
						$rettxt .= 	" y ";
					$rettxt .= " ".$ones[$unidades];
				}
				$rettxt .= " ".$thousands[$key]."ES ";
			}

			 
		} elseif($key==1){ //Dentro de los miles
			if ($i == 1)
			{
				$rettxt .= " ".$thousands[$key]." "; 
			}elseif($i == 0){
				
			}elseif($i <30){
				$rettxt .= $ones[$int];
				$rettxt .= " ".$thousands[$key]." ";
			}elseif($i<100){
				$decenas =substr($i,-2,1);
				$rettxt .= $tens[$decenas]." y ";
				$unidades = substr($i,-1,1);
				$rettxt .= " ".$ones[$unidades];
				$rettxt .= " ".$thousands[$key]." ";
			}elseif($i==100)
			{
				$rettxt .= "CIEN ";
			}else{
				$centenas=substr($i,-3,1);
				$rettxt .= $hundreds[$centenas]." ";
				$restante=substr($i,-2);
				//echo "Restante= ".$restante."<br>";
				if($restante < 30)
				{
					$restante = (int)$restante;
					$rettxt .= $ones[$restante];
				}else{
					$decenas =substr($restante,-2,1);
					//echo "decenas= ".$decenas."<br>";
					$rettxt .= $tens[$decenas]." Y ";
					$unidades = substr($restante,-1	,1);
					//echo "unidades= ".$unidades."<br>";
					$rettxt .= " ".$ones[$unidades];
				}
				$rettxt .= " ".$thousands[$key]." ";
			}
		}else{	
			if ($i == 0 )
			{
				//$rettxt .= "cero";	
				
			}elseif($i==1){
				$rettxt .= $ones[$int];
				$rettxt .= " ".$thousands[$key]." ";
			}
			elseif ($i < 30)
			{
				$rettxt .= $ones[$int];
				$rettxt .= " ".$thousands[$key]." ";

			}elseif($i<100)
			{
				$decenas =substr($i,-2,1);
				//echo "decenas= ".$decenas."<br>";
				$rettxt .= $tens[$decenas];
				$unidades = substr($i,-1 ,1);
				if ($unidades >0)
				$rettxt .= 	" Y ";
				$rettxt .= " ".$ones[$unidades];
				$rettxt .= " ".$thousands[$key]." ";
			}elseif($i==100)
			{
				$rettxt .= "CIEN";
				$rettxt .= " ".$thousands[$key]." ";
			}
			else{
				$centenas=substr($i,-3,1);
				$rettxt .= $hundreds[$centenas]." ";
				$restante=substr($i,-2);
				//echo "Restante= ".$restante."<br>";
				if($restante < 30)
				{
					$restante = (int)$restante;
					$rettxt .= $ones[$restante];
				}else{
					$decenas =substr($restante,-2,1);
					$rettxt .= $tens[$decenas];
					$unidades = substr($restante,-1	,1);
					if ($unidades >0)
						$rettxt .= 	" Y ";
					$rettxt .= " ".$ones[$unidades];
				}
				$rettxt .= " ".$thousands[$key]." ";
			}

			 
		} 
		//echo "Text= ".$rettxt."<br>";
		//echo "-------------------<br>";
	} 

	$rettxt .= " PESOS ";
	 
		if($decnum < 10)
		{ 
			//$rettxt .= 0;
			$rettxt .= $decnum; 
		}else
		{ 
			$rettxt .= $decnum;
			//$rettxt .= $tens[substr($decnum,0,1)]; 
			//$rettxt .= " ".$ones[substr($decnum,1,1)]; 
		}
		$rettxt .= "/100 - M.N.)";

	
	return $rettxt; 
} 
		//$i = 100.75;
		//echo $i."= ".numtowords($i)."<br>";
	
?>