<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
require $_SERVER['DOCUMENT_ROOT'] . "/config.inc.php";
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
require_once __DIR_ROOT . __SERVICENAME_MAILNEW . '/config.mail.inc.php';
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once __DIR_ROOT . __SERVICENAME_MAILNEW . '/_assets/dbconn/db_connection.php';
require_once __DIR_ROOT . __SERVICENAME_MAILNEW . '/_assets/dbconn/db_controller.php';
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
require_once __DIR_ROOT . '/_assets/functions/funcSecure.inc.php';
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем собственные функции сервиса Почта
require_once __DIR_ROOT . __SERVICENAME_MAILNEW . '/_assets/functions/func.mail.inc.php';
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Включаем режим сессии
// session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

// Код документа в таблице mailbox_incoming
$_kodzayv = isset($_POST['kodzayv']) ? $_POST['kodzayv'] : "";

# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$error_cntComments = $output_cntComments = "";

if (isset($_SESSION['password']) && isset($_SESSION['login'])) {
    if (checkUserAuthorization($_SESSION['login'], $_SESSION['password']) == -1) {
        return "-3";
    } else {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && "" != $_kodzayv) {
            $_reqDB1 = mysqli_fetch_array(mysqlQuery("SELECT COUNT(*) as CommCounts FROM dognet_doczayv_logComments WHERE action IN ('COMMENT','FORM','EMAIL') AND kodzayv = '{$_kodzayv}'"));
            $counts  = $_reqDB1['CommCounts'];
            $_reqDB2 = mysqlQuery("UPDATE dognet_doczayv SET cntComments = '{$counts}' WHERE kodzayv = '{$_kodzayv}'");
            if ($_reqDB1 && "" != $counts && $_reqDB2) {
                $output_cntComments = $counts;
            } else {
                $output_cntComments = "-1";
            }
        } else {
            $output_cntComments = "-2";
        }
    }
}
unset($_POST);
// Вывод сообщений о результате загрузки.
echo $output_cntComments;
