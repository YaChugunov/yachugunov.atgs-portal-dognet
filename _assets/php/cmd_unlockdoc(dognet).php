<?php


require($_SERVER['DOCUMENT_ROOT'].'/config.inc.php');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require($_SERVER['DOCUMENT_ROOT'].'/_assets/drivers/db_connection.php');
// require('../_assets/drivers/db_controller.php');
// $db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
require($_SERVER['DOCUMENT_ROOT'].'/_assets/functions/funcSecure.inc.php');
# Подключаем собственные функции сервиса Договор
// require('_assets/functions/funcDognet.inc.php');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$cmdUnlock_koddoc = $_POST['cmdUnlock_koddoc'];

if (isset($_SESSION ['password']) && isset($_SESSION ['login'])) {
	if ( checkUserAuthorization($_SESSION['login'],$_SESSION['password']) == -1 ) {
		$output3 = '0';
	}
	else {
		if (checkUserRestrictions($_SESSION['id'],'dognet', 4, 0)==1) {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				$_QRY1 = mysqlQuery( "DELETE FROM dognet_doc_locked WHERE koddoc='".$cmdUnlock_koddoc."' AND user_id='".$_SESSION['id']."'" );
				$_QRY2 = mysqlQuery( "UPDATE dognet_doc_unlock_request SET req_status='0' WHERE koddoc='".$cmdUnlock_koddoc."'" );
				if ($_QRY1&&$_QRY2) {
					$output3 = '1';
				}
				else { $output3 = '0'; }
			}
			else { $output3 = '0'; }
		}
		else { $output3 = '0'; }
	}
echo $output3;
}

?>