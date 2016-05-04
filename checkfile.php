<?php

require ("includes/dbcon.php");

if(isset($_POST['submit'])){
  $target_dir = "";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$file = fopen("xlss/".$_FILES["fileToUpload"]["name"],"r");
$prodrow = $_POST['prodrow'];
$qut=$_POST['qutrow'];
$realstock;
$bestellmenge;
while (($data = fgetcsv($file, 1000, ";")) !== FALSE) {
  $bestellmenge= $data[$qut];

			 $num = count($data);
			// echo "<p> $num Felder in Zeile $row: <br /></p>\n";

    $sql = "SELECT root.itemnumber,highestcount, highestcountlocation, stock, incomming, realstock, lastorders FROM root
LEFT OUTER JOIN db2data
ON root.itemnumber=db2data.itemnumber
 WHERE root.itemnumber='".$data[$prodrow]."'
";

$result = mysqli_query($link,$sql);
$datas = mysqli_fetch_assoc($result);

$realstock = $datas['stock'] + $datas['incomming'];

//if if if if if
if($bestellmenge <= $datas['highestcount'] && $realstock < $datas['lastorders']){
  echo "=======> filename: ".$_FILES["fileToUpload"]["name"]." Bestellmenge: ".$bestellmenge." highestcount: ".$datas['highestcount']." highestcountlocation: ".$datas['highestcountlocation']." Realtstock: ".$realstock.". PROD: ".$data[$prodrow]." Lastorders:".$datas['lastorders'];
  echo "<br>";
}

//echo $sql;



     }
}

 ?>


 <!DOCTYPE html>
 <html>
 <body>

 <form action="" method="post" enctype="multipart/form-data">
     Select image to upload:<br>
     <input type="text" name="prodrow" value="prodrow"/><br>
     <input type="text" name="qutrow" value="qutrow"/><br>
     <input type="file" name="fileToUpload" id="fileToUpload"><br>

     <input type="submit" value="Upload Image" name="submit"><br>
 </form>

 </body>
 </html>
