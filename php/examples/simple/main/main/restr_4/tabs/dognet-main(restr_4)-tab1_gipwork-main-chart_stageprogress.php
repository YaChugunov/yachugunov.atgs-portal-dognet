<?php


/*
$_QRY = mysqlQuery("
	SELECT DATE_FORMAT(`chetfdate`, '%Y-%m') as x, SUM(`chetfsumma`) as y
	FROM `dognet_kalplanchf`
	WHERE `chetfdate` >= DATE_FORMAT(CURRENT_DATE - INTERVAL 11 MONTH, '%Y-%m-01')
	GROUP BY x
");
$dataPoints = array();
while ($_ROW = mysqli_fetch_assoc($_QRY)) {
   $dataPoints[] = $_ROW;
}
*/



$stmt1 = $db_handle->runQuery("
	SELECT DATE_FORMAT(`chetfdate`, '%Y-%m') as x, SUM(`chetfsumma`) as y
	FROM `dognet_kalplanchf`
	WHERE `chetfdate` >= DATE_FORMAT(CURRENT_DATE - INTERVAL 23 MONTH, '%Y-%m-01')
	GROUP BY x
");
$dataPoints1 = [];
$k=0;
foreach($stmt1 as $key) {
	$dataPoints1[$k] = [ 'x' => date("U", strtotime($key['x']))*1000, 'y' => $key['y'] ];
	$k++;
}
# ----- ----- ----- ----- -----
$stmt2 = $db_handle->runQuery("
	SELECT DATE_FORMAT(`dateopl`, '%Y-%m') as x, SUM(`summaopl`) as y
	FROM `dognet_oplatachf`
	WHERE `dateopl` >= DATE_FORMAT(CURRENT_DATE - INTERVAL 23 MONTH, '%Y-%m-01')
	GROUP BY x
");
$dataPoints2 = [];
$k=0;
foreach($stmt2 as $key) {
	$dataPoints2[$k] = [ 'x' => date("U", strtotime($key['x']))*1000, 'y' => $key['y'] ];
	$k++;
}
# ----- ----- ----- ----- -----
$stmt3 = $db_handle->runQuery("
	SELECT DATE_FORMAT(`dateavans`, '%Y-%m') as x, SUM(`summaavans`) as y
	FROM `dognet_docavans`
	WHERE `dateavans` >= DATE_FORMAT(CURRENT_DATE - INTERVAL 23 MONTH, '%Y-%m-01')
	GROUP BY x
");
$dataPoints3 = [];
$k=0;
foreach($stmt3 as $key) {
	$dataPoints3[$k] = [ 'x' => date("U", strtotime($key['x']))*1000, 'y' => $key['y'] ];
	$k++;
}


// var_dump($dataPoints);

/*
 $dataPoints = array(
	array("x" => 946665000000, "y" => 3289),
	array("x" => 978287400000, "y" => 3830),
	array("x" => 1009823400000, "y" => 2009),
	array("x" => 1041359400000, "y" => 2840),
	array("x" => 1072895400000, "y" => 2396),
	array("x" => 1104517800000, "y" => 1613),
	array("x" => 1136053800000, "y" => 1821),
	array("x" => 1167589800000, "y" => 2000),
	array("x" => 1199125800000, "y" => 1397),
	array("x" => 1230748200000, "y" => 2506),
	array("x" => 1262284200000, "y" => 6704),
	array("x" => 1293820200000, "y" => 5704),
	array("x" => 1325356200000, "y" => 4009),
	array("x" => 1356978600000, "y" => 3026),
	array("x" => 1388514600000, "y" => 2394),
	array("x" => 1420050600000, "y" => 1872),
	array("x" => 1451586600000, "y" => 2140)
 );
*/

?>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>


