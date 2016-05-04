<?php
set_time_limit(3000);
require ("includes/dbcon.php");



$sql = "SELECT * FROM root";
$result = mysqli_query($link, $sql);

$biggest;
$k = 0;
while($data = mysqli_fetch_assoc($result)){
  $biggest = $data;
  array_shift($biggest);
  array_shift($biggest);
//  print_r($biggest);
//  echo array_search(max($biggest),$biggest);
//  echo " => ";
//s  echo $biggest[array_search(max($biggest),$biggest)];
//  echo "<br><br>";
  $sql2 = "UPDATE root SET highestcountlocation='".array_search(max($biggest),$biggest)."', highestcount=".$biggest[array_search(max($biggest),$biggest)]." WHERE id=".$data['id'];
//  echo $sql2;
  $result2 = mysqli_query($link, $sql2);
//  echo $sql;
$k++;
if($k == 30){
//  exit;
}
}



 ?>
