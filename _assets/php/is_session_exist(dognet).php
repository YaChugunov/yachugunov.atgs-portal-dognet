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
require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// $_UNIQUEID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// You can access the values posted by jQuery.ajax
// through the global variable $_POST, like this:
// print_r ($_POST);
$sessID = $_POST['chksessionID'];
$__ip = $_SERVER['REMOTE_ADDR'];
//
$output1 = "";
if ($sessID!="") {
	$output1 = (is_session_exists()) ? "1" : "0";
	if ($output1=="1") {
		$__login = $_SESSION['login'];
		$_QRY = mysqlQuery("SELECT SESSID FROM log_auth WHERE ip='$__ip' AND user_login='$__login' ORDER BY lastactivity_timestamp DESC LIMIT 1");
		$_ROW = mysqli_fetch_array($_QRY);
		$output1 = ($sessID<>$_ROW['SESSID']) ? "-1" : "1";
	}
}
else {
	$output1 = "0";
}
echo $output1;

?>