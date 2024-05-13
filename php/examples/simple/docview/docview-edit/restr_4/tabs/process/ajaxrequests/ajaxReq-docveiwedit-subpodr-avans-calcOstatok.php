<?php
#
date_default_timezone_set('Europe/Moscow');
#
# Подключаем конфигурационный файл
# require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
# require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT'] . "/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$_UNIQUEID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// You can access the values posted by jQuery.ajax
// through the global variable $_POST, like this:
// print_r ($_POST);
$kodavsubpodr = !empty($_POST['kodavsubpodr']) ? $_POST['kodavsubpodr'] : "";
$kodchfsubpodr = !empty($_POST['kodchfsubpodr']) ? $_POST['kodchfsubpodr'] : "";
$usekodchfsubpodr = !empty($_POST['kodchfsubpodr']) ? 1 : 0;
$inputValue = !empty($_POST['inputvalue']) ? $_POST['inputvalue'] : 0;

if ($kodavsubpodr != "") {
	$_QRY1 = mysqli_fetch_array(mysqlQuery(" SELECT SUM(sumavsubpodr) as sumav FROM dognet_docavsubpodr WHERE kodavsubpodr='{$kodavsubpodr}'"));
	$_QRY2 = mysqli_fetch_array(mysqlQuery(" SELECT SUM(sumavsplit) as sumavsplit FROM dognet_docavsplitsubpodr WHERE kodavsubpodr='{$kodavsubpodr}'"));
	$_QRY3 = mysqli_fetch_array(mysqlQuery(" SELECT SUM(sumavsplit) as sumavchfsplit FROM dognet_docavsplitsubpodr WHERE kodavsubpodr='{$kodavsubpodr}' AND kodchfsubpodr<>''"));

	$sumav = !empty($_QRY1['sumav']) ? $_QRY1['sumav'] : 0;
	$sumavsplit = !empty($_QRY2['sumavsplit']) ? $_QRY2['sumavsplit'] : 0;
	$sumavchfsplit = !empty($_QRY3['sumavchfsplit']) ? $_QRY3['sumavchfsplit'] : 0;
	$sumavsplit2 = (float)$sumavsplit + $inputValue;
	$sumavchfsplit2 = (float)($sumavchfsplit + ($usekodchfsubpodr * $inputValue));
	$output = $sumav . "///" . $sumavsplit . "///" . $sumavchfsplit . "///" . $sumavsplit2 . "///" . $sumavchfsplit2;
	$output = str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($output));
} else {
	$output = "-1";
}
echo $output;
#
#
#
#
#
#