<?php
#
date_default_timezone_set('Europe/Moscow');
#
# Подключаем конфигурационный файл
# require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
# require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT']."/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
// require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$output = "";
$usekodavans = $_POST['usekodavans'];
$useavans = $_POST['useavans'];

if (isset($_SESSION ['password']) && isset($_SESSION ['login'])) {
	if ( checkUserAuthorization($_SESSION['login'],$_SESSION['password']) == -1 ) {
		$output = '-1';
	}
	else {
		if (checkUserRestrictions($_SESSION['id'],'dognet', 4, 0)==1) {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				$_QRY = mysqli_fetch_array(mysqlQuery("SELECT MIN(dateavans) as firstavans, summaavans FROM dognet_docavans WHERE koddoc=".$koddoc." LIMIT 1"));
				$output = ($_QRY != "") ? $_QRY['firstavans']."/".$_QRY['summaavans'] : "0";
			}
			else { $output = "-2"; }
		}
		else { $output = "-3"; }
	}
echo $output;
}