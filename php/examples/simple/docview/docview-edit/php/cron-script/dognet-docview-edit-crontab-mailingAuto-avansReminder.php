<?php
date_default_timezone_set('Europe/Moscow');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем конфигурационный файл
// require_once("/var/www/html/atgs-portal.local/www/config.inc.php");
#
# Подключаемся к базе
require_once("/var/www/html/atgs-portal.local/www/_assets/drivers/db_connection.php");
require_once("/var/www/html/atgs-portal.local/www/_assets/drivers/db_controller.php");
$db_handle = new DBController();
#
# Подключаем общие функции безопасности
require("/var/www/html/atgs-portal.local/www/_assets/functions/funcSecure.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$datetimenow = date("Y-m-d");

$_QRY = mysqlQuery("
	SELECT * FROM dognet_dockalplan 
	WHERE 
		useav1plan = '1' AND 
		((useav2plan = '1' AND dateplanav2stage = '".$datetimenow."') OR 
		(useav3plan = '1' AND dateplanav3stage = '".$datetimenow."') OR 
		(useav4plan = '1' AND dateplanav4stage = '".$datetimenow."'))
");
while($_ROW = mysqli_fetch_array($_QRY)) {
	//
	$_QRY1 = mysqli_fetch_array(mysqlQuery("SELECT MIN(dateavans) as firstavans, kodavans FROM dognet_docavans WHERE koddoc = '".$_ROW['kodkalplan']."' LIMIT 1"));
	
	if ($_QRY1 != "") {
		
		$koddoc = $_ROW['koddoc'];
		$kodkalplan = $_ROW['kodkalplan'];
		$kodavans = $_QRY1['kodavans'];
		$firstavans = $_QRY1['firstavans'];
		
		$_QRY_DOCNUMBER = mysqli_fetch_array(mysqlQuery("SELECT koddoc, docnumber FROM dognet_docbase WHERE koddoc = '".$_ROW['koddoc']."'"));
		$_koddoc = $_QRY_DOCNUMBER['koddoc'];
		$_docnum = $_QRY_DOCNUMBER['docnumber'];
		$_stagenum = $_ROW['numberstage'];
		$_stagesumma = $_ROW['summastage'];
		$_namefullstage = $_ROW['namefullstage'];

		if ($_ROW['useav2plan'] == 1 && $_ROW['dateplanav2stage'] == $datetimenow) {

			$num = '2';
			$pravplan2stage = $_ROW['pravplan2stage'];
			$dateplanav2stage = $_ROW['dateplanav2stage'];
			$daysplanav2stage = $_ROW['daysplanav2stage'];
			$_QRY2 = mysqlQuery("INSERT INTO dognet_dockalplan_avansmaillog (koddoc, kodkalplan, kodavans, partnum, pravplanstage, dateplanavstage, daysplanavstage, firstavans, status, mailtimestamp) VALUES ('$koddoc', '$kodkalplan', '$kodavans', '$num', '$pravplanstage', '$dateplanav2stage', '$daysplanav2stage', '$firstavans', '0', NOW())");
			if ($_QRY2) { echo "Record to table 'dognet_dockalplan_avansmaillog' is inserted at ".date("Y-m-d H:i:s")." : success"; }
			else { echo "Crontab is not performed at ".date("Y-m-d H:i:s")." ..."; }

			// 
			$_dateav = date("d.m.Y", strtotime($dateplanav2stage));
			$_prav = $pravplan2stage;
			$_sum = $_ROW['summastage'] * ($pravplan2stage/100);
			include_once("/var/www/html/atgs-portal.local/www/dognet/php/examples/simple/docview/docview-edit/php/cron-script/sendMail_crontab-avansReminder.php");
			// 

		}
		if ($_ROW['useav3plan'] == 1 && $_ROW['dateplanav3stage'] == $datetimenow) {

			$num = '3';
			$pravplan3stage = $_ROW['pravplan3stage'];
			$dateplanav3stage = $_ROW['dateplanav3stage'];
			$daysplanav3stage = $_ROW['daysplanav3stage'];
			$_QRY2 = mysqlQuery("INSERT INTO dognet_dockalplan_avansmaillog (koddoc, kodkalplan, kodavans, partnum, pravplanstage, dateplanavstage, daysplanavstage, firstavans, status, mailtimestamp) VALUES ('$koddoc', '$kodkalplan', '$kodavans', '$num', '$pravplan3stage', '$dateplanav3stage', '$daysplanav3stage', '$firstavans', '0', NOW())");
			if ($_QRY2) { echo "Record to table 'dognet_dockalplan_avansmaillog' is inserted at ".date("Y-m-d H:i:s")." : success"; }
			else { echo "Crontab is not performed at ".date("Y-m-d H:i:s")." ..."; }

			// 
			$_dateav = date("d.m.Y", strtotime($dateplanav3stage));
			$_prav = $pravplan3stage;
			$_sum = $_ROW['summastage'] * ($pravplan3stage/100);
			include_once("/var/www/html/atgs-portal.local/www/dognet/php/examples/simple/docview/docview-edit/php/cron-script/sendMail_crontab-avansReminder.php");
			// 

		}
		if ($_ROW['useav4plan'] == 1 && $_ROW['dateplanav4stage'] == $datetimenow) {
			
			$num = '4';
			$pravplan4stage = $_ROW['pravplan4stage'];
			$dateplanav4stage = $_ROW['dateplanav4stage'];
			$daysplanav4stage = $_ROW['daysplanav4stage'];
			$_QRY2 = mysqlQuery("INSERT INTO dognet_dockalplan_avansmaillog (koddoc, kodkalplan, kodavans, partnum, pravplanstage, dateplanavstage, daysplanavstage, firstavans, status, mailtimestamp) VALUES ('$koddoc', '$kodkalplan', '$kodavans', '$num', '$pravplan4stage', '$dateplanav4stage', '$daysplanav4stage', '$firstavans', '0', NOW())");
			if ($_QRY2) { echo "Record to table 'dognet_dockalplan_avansmaillog' is inserted at ".date("Y-m-d H:i:s")." : success"; }
			else { echo "Crontab is not performed at ".date("Y-m-d H:i:s")." ..."; }

			// 
			$_dateav = date("d.m.Y", strtotime($dateplanav4stage));
			$_prav = $pravplan4stage;
			$_sum = $_ROW['summastage'] * ($pravplan4stage/100);
			include_once("/var/www/html/atgs-portal.local/www/dognet/php/examples/simple/docview/docview-edit/php/cron-script/sendMail_crontab-avansReminder.php");
			// 

		}











	}

}


?>