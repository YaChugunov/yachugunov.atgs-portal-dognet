<?php
#
date_default_timezone_set('Europe/Moscow');
#
# Подключаем конфигурационный файл
# require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once $_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php";
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
# require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require $_SERVER['DOCUMENT_ROOT'] . "/_assets/functions/funcSecure.inc.php";
# Подключаем собственные функции сервиса Почта
// require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
require $_SERVER['DOCUMENT_ROOT'] . "/_assets/php/devmakis/vendor/autoload.php";

use Devmakis\ProdCalendar\Cache\FileJsonCache;
use Devmakis\ProdCalendar\Calendar;
use Devmakis\ProdCalendar\Clients\XmlCalendarClient;
use Devmakis\ProdCalendar\Country;

$cache    = new FileJsonCache($_SERVER['DOCUMENT_ROOT'] . "/_assets/xml/prodcalendar/prodcalendar.russia.json", 3600);
$client   = new XmlCalendarClient(Country::RUSSIA, $cache);
$calendar = new Calendar($client);

# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$output    = "";
$idsrokopl = $_POST['idsrokopl'];
$chetfdate = $_POST['chetfdate'];
$kodchfact = $_POST['kodchfact'];
$srokopl   = $_POST['srokopl'];

if (isset($_SESSION['password']) && isset($_SESSION['login'])) {
    if (checkUserAuthorization($_SESSION['login'], $_SESSION['password']) == -1) {
        $output = '-1';
    } else {
        if (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 0) == 1) {
            // if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (1 === 1) {

                //$_date = date("Y-m-d", strtotime($chetfdate, "d.m.Y"));
                $_date    = $chetfdate;
                $nextDate = new DateTime($_date);

                $i = 0;
                do {
                    $nextDate->modify('+1 day');
                    $result = $calendar->isNonWorking($nextDate);
                    if (! $result) {
                        $i++;
                    }
                } while ($i < ($srokopl));
                $output = $nextDate->format('d.m.Y');
            } else { $output = "-2";}
        } else { $output = "-3";}
    }
    echo $output;
}
