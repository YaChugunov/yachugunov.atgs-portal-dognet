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
$koddocToUnlock = $_POST['koddocToUnlock'];
$id = $_SESSION['id'];
$ip = $_SERVER['REMOTE_ADDR'];
$login = $_SESSION['login'];


if ($koddocToUnlock!="") {
	// Формируем запрос на снятие блокировки и пишем его в таблицу 'dognet_doc_unlock_request'
	$sql1 = mysqlQuery(" INSERT INTO dognet_doc_unlock_request (koddoc, user_id, user_ip, user_login, req_timestamp, req_status, comment) VALUES ('$koddocToUnlock', '$id', '$ip', '$login', NOW(), '1', '') ");
	$inserted_id = mysqli_insert_id(DB::$linkDB);
	if ($sql1) {
		$output1 = "1"."/".$inserted_id;
	}
	else {
		$output1 = "-1"."/";
	}
}
else {
	$output1 = "-2"."/";
}
echo $output1;
#
#
#
#
#
#
?>