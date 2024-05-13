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
$kodkalplan = isset($_POST['kodkalplan']) ? $_POST['kodkalplan'] : null;
// print_r ($_POST);

if (empty($kodkalplan)) {
	echo '<option value="">Выберите этап</option>';
} else {
	$sql = mysqlQuery("SELECT kodavans, dateavans, summaavans, ostatokavans FROM dognet_docavans WHERE koddoc = {$kodkalplan} AND ostatokavans > '0'");
	$_req_sumAllAv = mysqli_fetch_assoc(mysqlQuery("SELECT SUM(ostatokavans) AS ostAllAv FROM dognet_docavans WHERE koddoc = {$kodkalplan} AND ostatokavans > '0'"));
	$ostAllAv = $_req_sumAllAv['ostAllAv'];
	if (mysqli_num_rows($sql) < 1) {
		echo '<option value="">Нет доступных авансов</option>';
	} else {
		echo '<option value="nozachet">Без зачета аванса</option>';
		echo '<option value="zachetall">*Зачесть все остатки : ' . number_format((float)($ostAllAv), 2, '.', ' ') . ' / ' . number_format((float)($ostAllAv), 2, '.', ' ') . '</option>';
		while ($row = mysqli_fetch_array($sql)) {
			echo '<option value="' . $row['kodavans'] . '">' . date("d.m.Y", strtotime($row['dateavans'])) . ' : ' . number_format((float)($row['summaavans']), 2, '.', ' ') . ' / ' . number_format((float)($row['ostatokavans']), 2, '.', ' ') . '</option>';
		}
	}
}
#
#
#
#
#
#