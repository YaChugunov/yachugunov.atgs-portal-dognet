<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT'] . "/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// You can access the values posted by jQuery.ajax
// through the global variable $_POST, like this:
// print_r ($_POST);
$_updateid = isset($_POST['updateid']) ? $_POST['updateid'] : "";
$_userid = isset($_POST['userid']) ? $_POST['userid'] : "";
$_donotshow = isset($_POST['donotshow']) ? $_POST['donotshow'] : "";
//
if (isset($_SESSION['password']) && isset($_SESSION['login'])) {
	if (checkUserAuthorization($_SESSION['login'], $_SESSION['password']) == -1) {
		return "-3";
	} else {
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_userid != "" && $_updateid != "") {
			$_reqDB1 = mysqlQuery("SELECT * FROM dognet_updates WHERE update_id = '{$_updateid}' AND active='1'");
			if ($_reqDB1) {
				$_reqDB2 = mysqlQuery("SELECT * FROM dognet_updates_views WHERE user_id='{$_SESSION['id']}' AND update_id='{$_updateid}'");
				if ($_reqDB2 && $_donotshow == '1') {
					$_reqDB3 = mysqlQuery("UPDATE dognet_updates_views SET show_update='0',show_progress='0' WHERE user_id='{$_SESSION['id']}' AND update_id='{$_updateid}'");
				} elseif ($_reqDB2 && empty($_donotshow)) {
					$_reqDB4 = mysqlQuery("UPDATE dognet_updates_views SET show_progress='0' WHERE user_id='{$_SESSION['id']}' AND update_id='{$_updateid}'");
				} else {
					$_reqDB5 = mysqlQuery("INSERT INTO dognet_updates_views (update_id, user_id) VALUES ('{$_updateid}', {$_SESSION['id']}')");
				}
			}
			if ($_reqDB1 && ($_reqDB2 || $_reqDB3 || $_reqDB4 || $_reqDB5)) {
				$output = "1";
			} else {
				$output = "-1";
			}
		} else {
			$output = "-2";
		}
	}
}
unset($_POST);
// Вывод сообщений о результате загрузки.
echo $output;
