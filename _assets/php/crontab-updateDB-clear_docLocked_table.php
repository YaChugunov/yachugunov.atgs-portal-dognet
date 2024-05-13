<?php
date_default_timezone_set('Europe/Moscow');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем конфигурационный файл
// require_once("/var/www/html/atgs-portal.local/www/config.inc.php");
#
# Подключаемся к базе
require_once("/var/www/html/atgs-portal.local/www/_assets/drivers/db_connection.php");
require_once("/var/www/html/atgs-portal.local/www/_assets/drivers/db_controller.php");
$db_handle = new DBController();
#
# Подключаем общие функции безопасности
require("/var/www/html/atgs-portal.local/www/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
// require("/var/www/html/atgs-portal.local/www/dognet/_assets/functions/funcDognet.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

# Очищаем таблицу блокировок договоров
$_QRY = mysqlQuery( "TRUNCATE TABLE dognet_doc_locked" );
if ($_QRY) {
	echo "Table 'dognet_doc_locked' is cleared at ".date("Y-m-d H:m:i")." : success";
}
else {
	echo "Crontab is not performed at ".date("Y-m-d H:m:i")." ...";
}