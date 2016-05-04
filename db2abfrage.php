<?php
set_time_limit(3000);
function ifempty($arg){
	if(empty($arg) || $arg == null){
		return "0";

	}else{
		return $arg;
	}

}
$conn =odbc_connect("BPCSData8_Read","dbcon2","db111");
$sql = "select  IPROD, STOCK, INCOMMING, (STOCK+INCOMMING) AS REALSTOCK, LASTORDERS
from (
     SELECT IPROD FROM BPOSCMF01.IIM
     WHERE IID ='IM'
  ) as TMPIIM left outer join (

/* Hier Stock */

     SELECT WPROD, sum(WOPB+WRCT+WADJ-WISS-WCUSA) as stock
     FROM BPOSCMF01.IWI
     WHERE WWHS <> '06' AND WWHS <> '34' AND WWHS <> '87' and WID='WI'
     GROUP BY WPROD
  ) as TMPSTOCK on (IPROD=WPROD) left outer join (
  /*INCOMMING ORDERS*/
  SELECT PPROD, sum(PQORD-PQREC) as incomming
FROM BPOSCMF01.HPO
WHERE PID ='PO' AND
now()+5 MONTHS > TO_DATE( cast(PDDTE as char(8)),'YYYYMMDD')
AND PQORD > PQREC
AND PSHIP <> '06' AND PSHIP <>'34' AND PSHIP <> '87'
GROUP BY PPROD
ORDER BY PPROD
) as TMPINORD ON (IPROD=PPROD) LEFT OUTER JOIN   (
/*LAST 6 MONTHS ORDERS  */
    select S02PRO, SUM(month1)as lastOrders from (
    SELECT S02PRO,
            CASE MONTH(now())
                WHEN 1 THEN SUM(S02Q04+S02Q05+S02Q06+S02Q07+S02Q08+S02Q09)
                WHEN 2 THEN SUM(S02Q05+S02Q06+S02Q07+S02Q08+S02Q09+S02Q10)
                WHEN 3 THEN SUM(S02Q06+S02Q07+S02Q08+S02Q09+S02Q10+S02Q11)
                WHEN 4 THEN SUM(S02Q07+S02Q08+S02Q09+S02Q10+S02Q11+S02Q12)
                WHEN 5 THEN SUM(S02Q08+S02Q09+S02Q10+S02Q11+S02Q12)
                WHEN 6 THEN SUM(S02Q09+S02Q10+S02Q11+S02Q12)
                WHEN 7 THEN SUM(S02Q10+S02Q11+S02Q12)
                WHEN 8 THEN SUM(S02Q11+S02Q12)
                WHEN 9 THEN SUM(S02Q12)
            END AS month1
            from BUOSCMF01.SAL02P
            WHERE  S02fyr = YEAR(now())-1
            GROUP BY S02PRO
    union all
    SELECT S02PRO,
            CASE MONTH(now())
                /*WHEN 1 THEN SUM()   */
                /*WHEN 2 THEN SUM()   */
                /*WHEN 3 THEN SUM()   */
                /*WHEN 4 THEN SUM()   */
                WHEN 5 THEN SUM(S02Q01)
                WHEN 6 THEN SUM(S02Q01+S02Q02)
                WHEN 7 THEN SUM(S02Q01+S02Q02+S02Q03)
                WHEN 8 THEN SUM(S02Q01+S02Q02+S02Q03+S02Q04)
                WHEN 9 THEN SUM(S02Q01+S02Q02+S02Q03+S02Q04+S02Q05)
                WHEN 10 THEN SUM(S02Q01+S02Q02+S02Q03+S02Q04+S02Q05+S02Q06)
                WHEN 11 THEN SUM(S02Q02+S02Q03+S02Q04+S02Q05+S02Q06+S02Q07)
                WHEN 12 THEN SUM(S02Q03+S02Q04+S02Q05+S02Q06+S02Q07+S02Q08)
            END AS month1
            from BUOSCMF01.SAL02P
            WHERE  S02fyr = YEAR(now())
            GROUP BY S02PRO
    ) as tmpxxxx
    GROUP BY S02PRO
    ORDER BY S02PRO ASC
) AS TMPLASTORDERS      ON(IPROD=S02PRO)

";
require_once("includes/dbcon.php");
$k = 0;
$result = odbc_exec($conn,$sql);
while(odbc_fetch_row($result)){
         for($i=1;$i<=odbc_num_fields($result);$i++){
      //  echo "Result is ".odbc_result($result,$i);
    }
    $sql = "INSERT INTO db2data (itemnumber, stock, incomming, realstock, lastorders) VALUES('".odbc_result($result,1)."',".ifempty(odbc_result($result,2)).",".ifempty(odbc_result($result,3)).",".ifempty(odbc_result($result,4)).",".ifempty(odbc_result($result,5)).")";
$result2 = mysqli_query($link, $sql);


    echo "<br><br>";
}
 ?>
