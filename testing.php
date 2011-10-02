<?php  
$input = 4;

$arrh = array();
$arrx = array();

# MASUKIN KE ARRAY
for ($i=0; $i < $input ; $i++) { 
	
	$arrh[] = $i + 1;
	$arrx[] = $i + 1;
}

for ($i=0; $i < $input ; $i++) { 

	// td barus td kolom
	if ($i % 1 == 0) {
		echo "</br>" ;
	}
	foreach ($arrh as $value) {
		echo  $value * ($i + 1) . ' ';
	}
	//echo "1 2 3 4";
	//echo "2 4 6 8";
}
?>