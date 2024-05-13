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
// require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
require_once ($_SERVER['DOCUMENT_ROOT']."/_assets/php/isdayoff/vendor/autoload.php");

use isDayOff\Client\IsDayOff;
// Countries
use isDayOff\Filters\UkraineFilter;
use isDayOff\Filters\RussianFilter;
// Additional
use isDayOff\Collections\FiltersCollection;
use isDayOff\Filters\CovidFilter;
use isDayOff\Filters\PreHolidayFilter;

# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$output = "";
$idsrokopl = $_POST['idsrokopl'];
$chetfdate = $_POST['chetfdate'];
$kodchfact = $_POST['kodchfact'];
$srokopl = $_POST['srokopl'];

if (isset($_SESSION ['password']) && isset($_SESSION ['login'])) {
	if ( checkUserAuthorization($_SESSION['login'],$_SESSION['password']) == -1 ) {
		$output = '-1';
	}
	else {
		if (checkUserRestrictions($_SESSION['id'],'dognet', 4, 0)==1) {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

                $client = new IsDayOff();
                //$_date = date("Y-m-d", strtotime($chetfdate, "d.m.Y"));
                $_date = $chetfdate;
                $nextDate = new DateTime($_date);

                $i = 0;
                do {
                    $nextDate->modify('+1 day');
                    $result = $client->date()->isDayOff($nextDate);
                    if($result != 1) {
                        $i++;
                    }
                } while ($i < ($srokopl));
                $output = $nextDate->format('d.m.Y');
			}
			else { $output = "-2"; }
		}
		else { $output = "-3"; }
	}
echo $output;
}

?>