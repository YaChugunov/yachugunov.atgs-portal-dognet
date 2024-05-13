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
$koddocToCheck = $_POST['koddocToCheck'];
$rowID = $_POST['checkRowID'];
$id = $_SESSION['id'];
$ip = $_SERVER['REMOTE_ADDR'];
$login = $_SESSION['login'];


if ($koddocToCheck!="") {
	// Формируем запрос на снятие блокировки и пишем его в таблицу 'dognet_doc_unlock_request'
	$sql2 = mysqlQuery(" SELECT * FROM dognet_doc_unlock_request WHERE id='{$rowID}' AND koddoc='{$koddocToCheck}' AND user_login='{$login}' ");
	$row2 = mysqli_fetch_array($sql2);
	if ($sql2) {
		$output2 = $row2['req_status'];
	}
	else {
		$output2 = "-1";
	}
}
else {
	$output2 = "-2";
}
echo $output2;
#
#
#
#
#
#
?>