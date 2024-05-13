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
$_UNIQUEID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// You can access the values posted by jQuery.ajax
// through the global variable $_POST, like this:
$kodblankwork = isset($_POST['kodblankwork']) ? $_POST['kodblankwork'] : null;
// print_r ($_POST);

if ( empty($kodblankwork) ) {
	echo 'blank no selected';
}
else {
	$_QRY = mysqlQuery("SELECT kodzakaz, kodispol, kodispolruk, nameblankwork FROM dognet_docblankwork WHERE kodblankwork = {$kodblankwork}");
	if (mysqli_num_rows($_QRY) < 1) {
		echo 'no items';
	}
	else {
		$_ROW = mysqli_fetch_assoc($_QRY);
		$qry_zakaz = mysqlQuery("SELECT namezakshot FROM sp_contragents WHERE kodzakaz=".$_ROW['kodzakaz']." AND koddel<>'99'");
		$row_zakaz = mysqli_fetch_assoc($qry_zakaz);

		echo $_ROW['kodzakaz'].":".$_ROW['kodispol'].":".$_ROW['kodispolruk'].":".$_ROW['nameblankwork'];
	}
}
#
#
#
#
#
#
