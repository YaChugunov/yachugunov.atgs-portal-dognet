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
$action = $_POST['action'];
$koddoc = $_POST['koddoc'];
$kodkalplan = $_POST['kodkalplan'];
$sum = $_POST['sum'];
//
//
if ($koddoc != "" && $kodkalplan != "") {
	//
	$sql1 = mysqlQuery(" SELECT docsumma FROM dognet_docbase WHERE koddoc='" . $koddoc . "' AND koddel<>'99'");
	$row1 = mysqli_fetch_array($sql1);
	$docsumma = $row1['docsumma'];
	//
	$sql2 = mysqlQuery(" SELECT SUM(summastage) as sum2 FROM dognet_dockalplan WHERE koddoc='" . $koddoc . "' AND koddel<>'99'");
	$row2 = mysqli_fetch_array($sql2);
	$sql3 = mysqlQuery(" SELECT summastage FROM dognet_dockalplan WHERE koddoc='" . $koddoc . "' AND kodkalplan='" . $kodkalplan . "' AND koddel<>'99'");
	$row3 = mysqli_fetch_array($sql3);
	$tmp = $row2['sum2'] - $row3['summastage'];
	if ($sql2 && $sql3) {
		$output2 = str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($tmp)) + $sum;
	} else {
		$output2 = "";
	}
	//
	$sql4 = mysqlQuery(" SELECT SUM(summaavans) as sumav, SUM(ostatokavans) as sumost FROM dognet_docavans WHERE koddoc IN ( SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc = '{$koddoc}' AND koddel <> '99' ) ");
	$row4 = mysqli_fetch_array($sql4);
	if (!empty($row4['sumav'])) {
		$sumav = (float)str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($row4['sumav']));
	} else {
		$sumav = "";
	}
	if (!empty($row4['sumost'])) {
		$sumost = (float)str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($row4['sumost']));
	} else {
		$sumost = "";
	}
	//
	$sql5 = mysqlQuery(" SELECT SUM(summaoplav) as sumoplavchf FROM dognet_chfavans WHERE kodkalplan IN ( SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc = '{$koddoc}' AND koddel <> '99' ) ");
	$row5 = mysqli_fetch_array($sql5);
	if (!empty($row5['sumoplavchf'])) {
		$sumoplavchf = (float)str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($row5['sumoplavchf']));
	} else {
		$sumoplavchf = "";
	}
} elseif ($koddoc != "" && $kodkalplan == NULL) {
	//
	$sql1 = mysqlQuery(" SELECT docsumma FROM dognet_docbase WHERE koddoc='" . $koddoc . "' AND koddel<>'99'");
	$row1 = mysqli_fetch_array($sql1);
	$docsumma = $row1['docsumma'];
	//
	$sql2 = mysqlQuery(" SELECT SUM(summastage) as sum2 FROM dognet_dockalplan WHERE koddoc='" . $koddoc . "' AND koddel<>'99'");
	$row2 = mysqli_fetch_array($sql2);
	if (!empty($row2['sum2'])) {
		$output2 = (float)str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($row2['sum2'])) + (float)$sum;
	} else {
		$output2 = "";
	}
	//
	$sql4 = mysqlQuery(" SELECT SUM(summaavans) as sumav, SUM(ostatokavans) as sumost FROM dognet_docavans WHERE koddoc IN ( SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc = '{$koddoc}' AND koddel <> '99' ) ");
	$row4 = mysqli_fetch_array($sql4);
	if (!empty($row4['sumav'])) {
		$sumav = (float)str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($row4['sumav']));
	} else {
		$sumav = "";
	}
	if (!empty($row4['sumost'])) {
		$sumost = (float)str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($row4['sumost']));
	} else {
		$sumost = "";
	}
	//
	$sql5 = mysqlQuery(" SELECT SUM(summaoplav) as sumoplavchf FROM dognet_chfavans WHERE kodkalplan IN ( SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc = '{$koddoc}' AND koddel <> '99' ) ");
	$row5 = mysqli_fetch_array($sql5);
	if (!empty($row5['sumoplavchf'])) {
		$sumoplavchf = (float)str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($row5['sumoplavchf']));
	} else {
		$sumoplavchf = "";
	}
}
echo number_format((float)($docsumma), 2, '.', ' ') . " / " . number_format((float)($output2), 2, '.', ' ') . " / " . number_format((float)($sumav), 2, '.', ' ') . " / " . number_format((float)($sumost), 2, '.', ' ') . " / " . number_format((float)($sumoplavchf), 2, '.', ' ');
#
#
#
#
#
#