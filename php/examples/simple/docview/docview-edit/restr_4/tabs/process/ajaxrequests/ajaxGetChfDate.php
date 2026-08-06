<?php
//
date_default_timezone_set('Europe/Moscow');
//
// Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Подключаемся к базе
require_once ($_SERVER['DOCUMENT_ROOT'].'/_assets/drivers/db_connection.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/_assets/drivers/db_controller.php');
$db_handle = new DBController();
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require ($_SERVER['DOCUMENT_ROOT'].'/_assets/functions/funcSecure.inc.php');
// Подключаем собственные функции сервиса Почта
require ($_SERVER['DOCUMENT_ROOT'].'/dognet/_assets/functions/funcDognet.inc.php');
// Включаем режим сессии
session_start();
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$_UNIQUEID = $_SESSION['uniqueID'];
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$kodchfact = $_POST['kodchfact'] ?? 0;

if ($kodchfact > 0) {
    $_reqChfDate = mysqli_fetch_array(mysqlQuery("SELECT chetfdate FROM dognet_kalplanchf WHERE kodchfact = '".$kodchfact."' ORDER BY chetfdate DESC LIMIT 1"));

    if (! empty($_reqChfDate)) {
        echo $_reqChfDate['chetfdate'];
    } else {
        echo '';
    }
} else {
    echo '';
}
?>