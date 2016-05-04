<!doctype html>
<html>
<head></head>

<body>

<?php
set_time_limit(3000);
error_reporting(E_ALL);
ini_set('display_errors', 1);

function ifempty($arg){
	if(empty($arg) || $arg == null){
		return "0";

	}else{
		return $arg;
	}

}



require_once("includes/dbcon.php");

$k=0;
$firstrow = null;
$row=0;
$fullarray;
$file = fopen("overstock.csv","r");
while (($data = fgetcsv($file, 1000, ";")) !== FALSE) {
			 $num = count($data);
			// echo "<p> $num Felder in Zeile $row: <br /></p>\n";
			 if($firstrow == null) {
				  $firstrow = $data;
					//print_r( $firstrow);

			 }
			 $row++;

//generate $fullarray


$fullarray['maf'] = ifempty($data[1]);
$fullarray['mbg'] = ifempty($data[2]);
$fullarray['mch'] = ifempty($data[3]);
$fullarray['mcz'] = ifempty($data[4]);
$fullarray['md'] = ifempty($data[5]);
$fullarray['mdk'] =ifempty( $data[6]);
$fullarray['me'] = ifempty($data[7]);
$fullarray['mee'] =ifempty( $data[8]);
$fullarray['mes'] = ifempty($data[9]);
$fullarray['mf'] = ifempty($data[10]);
$fullarray['mfn'] =ifempty( $data[11]);
$fullarray['mgf'] = ifempty($data[12]);
$fullarray['mhn'] = ifempty($data[13]);
$fullarray['mi'] =ifempty( $data[14]);
$fullarray['mnl'] = ifempty($data[15]);
$fullarray['mnw'] = ifempty($data[16]);
$fullarray['mos'] = ifempty($data[17]);
$fullarray['mpl'] = ifempty($data[18]);
$fullarray['mro'] = ifempty($data[19]);
$fullarray['msa'] = ifempty($data[20]);
$fullarray['msk'] = ifempty($data[21]);
$fullarray['msw'] = ifempty($data[22]);
$fullarray['muk'] = ifempty($data[24]);
$fullarray['mua'] = ifempty($data[23]);
			 $sql = "INSERT INTO root (itemnumber, maf, mbg, mch, mcz, md, mdk, me, mee, mes, mf, mfn, mgf, mhn, mi, mnl, mnw, mos, mpl, mro, msa, msk, msw,mua, muk, highestcountlocation, highestcount)
				VALUES('$data[0]', ".ifempty($data[1]).",".ifempty($data[2]).",".ifempty($data[3]).",".ifempty($data[4]).",".ifempty($data[5]).",".ifempty($data[6]).",
				".ifempty($data[7]).",".ifempty($data[8]).",
				".ifempty($data[9]).",".ifempty($data[10]).",".ifempty($data[11]).",".ifempty($data[12]).",".ifempty($data[13]).",".ifempty($data[14]).",".ifempty($data[15]).",
				".ifempty($data[16]).",".ifempty($data[17]).",".ifempty($data[18]).",".ifempty($data[19]).",".ifempty($data[20]).",".ifempty($data[21]).","
				.ifempty($data[22]).",".ifempty($data[23]).",".ifempty($data[23]).",
				'".array_search(max($fullarray),$fullarray)."', ".$fullarray[array_search(max($fullarray),$fullarray)].")";

//echo $sql;
	mysqli_query($link, $sql);
//echo "<br><br>";
$k++;
if($k == 10){
	//exit;
}



	 }



	 fclose($file);
 ?>

</body>

</html>
