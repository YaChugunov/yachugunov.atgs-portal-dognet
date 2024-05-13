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
if (isset($_SESSION ['password']) && isset($_SESSION ['login'])) {
	if ( checkUserAuthorization($_SESSION['login'],$_SESSION['password']) == -1 ) {
		$output2 = '0';
	}
	else {
		if (checkUserRestrictions($_SESSION['id'],'dognet', 4, 0)==1) {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				$_QRY = mysqlQuery( "SELECT * FROM dognet_doc_unlock_request WHERE req_status='1' AND koddoc IN (SELECT koddoc FROM dognet_doc_locked WHERE user_id='".$_SESSION['id']."')" );
				$_ROW = mysqli_fetch_array($_QRY);
				if ($_QRY&&mysqli_num_rows($_QRY)>0) {
					$output2 = '1';
					$_QRY1 = mysqlQuery( "SELECT firstname, lastname FROM users WHERE id='".$_ROW['user_id']."'" );
					$_ROW1 = mysqli_fetch_array($_QRY1);
					$output2 .= "/".$_ROW1['firstname']." ".$_ROW1['lastname'];
					$_QRY2 = mysqlQuery( "SELECT docnumber FROM dognet_docbase WHERE koddoc='".$_ROW['koddoc']."'" );
					$_ROW2 = mysqli_fetch_array($_QRY2);
					$output2 .= "/".$_ROW2['docnumber'];
					$output2 .= "/".$_ROW['koddoc'];
				}
				else { $output2 = '0'; }
			}
			else { $output2 = '0'; }
		}
		else { $output2 = '0'; }
	}
echo $output2;
}

?>