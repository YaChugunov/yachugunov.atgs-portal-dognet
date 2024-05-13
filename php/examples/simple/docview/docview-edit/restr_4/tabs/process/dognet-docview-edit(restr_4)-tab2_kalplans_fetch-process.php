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
// print_r ($_POST);
$koddoc = $_POST['koddoc'];
if ($koddoc!="") {
$sql = mysqlQuery(" SELECT kodtip FROM dognet_docbase WHERE koddoc='".$koddoc."' AND koddel<>'99' ");
$row = mysqli_fetch_array($sql);
	if (!empty($row['kodtip'])) {
		$output = str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($row['kodtip']));
		echo $output;
	}
	else {
		echo "??-1";
	}
}
else {
	echo "??-2";
}
#
#
#
#
#
#
?>