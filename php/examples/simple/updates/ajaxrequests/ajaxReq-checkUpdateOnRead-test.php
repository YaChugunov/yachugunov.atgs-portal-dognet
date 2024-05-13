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
$_action = isset($_POST['action']) ? $_POST['action'] : "";
$output = "none0";
$_datenow = date('Y-m-d H:i:s');
//
if (isset($_SESSION['password']) && isset($_SESSION['login'])) {
	if (checkUserAuthorization($_SESSION['login'], $_SESSION['password']) == -1) {
		return "error -1";
	} else {
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_userid != "" && $_updateid != "") {
			if ($_userid !== '999') {
				$_reqDB_Main = mysqli_fetch_assoc(mysqlQuery("SELECT update_id, noprogressbar FROM dognet_updates WHERE active='1' ORDER BY id DESC LIMIT 1"));
				if (isset($_reqDB_Main) && !empty($_reqDB_Main['update_id'])) {
					$noprogress = !empty($_reqDB_Main['noprogressbar']) ? $_reqDB_Main['noprogressbar'] : "";
					$_reqDB_Views = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM dognet_updates_views WHERE user_id='{$_userid}' AND update_id='{$_updateid}'"));
					if ($_reqDB_Views && $_reqDB_Views['show_update'] == '1') {
						$progress = $_reqDB_Views['show_progress'];
						if ($_action == 'check') {
							$_reqDB_Upd = mysqlQuery("UPDATE dognet_updates_views SET show_progress='0' WHERE user_id='{$_userid}' AND update_id='{$_updateid}'");
							$output = "ok," . $progress;
						} elseif ($_action == 'mark') {
							$_reqDB_Upd = mysqlQuery("UPDATE dognet_updates_views SET show_update='0' WHERE user_id='{$_userid}' AND update_id='{$_updateid}'");
							$output = "none1";
						} else {
							$output = "ok," . $progress;
						}
					} elseif (!$_reqDB_Views) {
						$_reqDB_Ins = mysqlQuery("INSERT INTO dognet_updates_views (update_id, user_id, user_name, timestamp) VALUES ('{$_updateid}', '{$_SESSION['id']}', '{$_SESSION['lastname']}', '{$_datenow}')");
						$output = ($noprogress == "1") ? "ok,0" : "ok,1";
					} else {
						$output = "none2";
					}
				} else {
					$output = "none3";
				}
			} else {
				$_reqDB_Main = mysqli_fetch_assoc(mysqlQuery("SELECT update_id, noprogressbar FROM dognet_updates WHERE testmode='1' ORDER BY id DESC LIMIT 1"));
				if (isset($_reqDB_Main) && !empty($_reqDB_Main['update_id'])) {
					$noprogress = !empty($_reqDB_Main['noprogressbar']) ? $_reqDB_Main['noprogressbar'] : "";
					$_reqDB_Views = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM dognet_updates_views WHERE user_id='{$_userid}' AND update_id='{$_updateid}'"));
					if ($_reqDB_Views && $_reqDB_Views['show_update'] == '1') {
						$progress = $_reqDB_Views['show_progress'];
						if ($_action == 'check') {
							$_reqDB_Upd = mysqlQuery("UPDATE dognet_updates_views SET show_progress='0' WHERE user_id='{$_userid}' AND update_id='{$_updateid}'");
							$output = "ok," . $progress;
						} elseif ($_action == 'mark') {
							$_reqDB_Upd = mysqlQuery("UPDATE dognet_updates_views SET show_update='0' WHERE user_id='{$_userid}' AND update_id='{$_updateid}'");
							$output = "none1";
						} else {
							$output = "ok," . $progress;
						}
					} elseif (!$_reqDB_Views) {
						$_reqDB_Ins = mysqlQuery("INSERT INTO dognet_updates_views (update_id, user_id, user_name, timestamp) VALUES ('{$_updateid}', '{$_SESSION['id']}', '{$_SESSION['lastname']}', '{$_datenow}')");
						$output = ($noprogress == "1") ? "ok,0" : "ok,1";
					} else {
						$output = "none2";
					}
				} else {
					$output = "none3";
				}
			}
		} else {
			$output = "error -2";
		}
	}
}
unset($_POST);
// Вывод сообщений о результате загрузки.
echo $output;
