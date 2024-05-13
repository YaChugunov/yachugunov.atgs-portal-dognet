<?php // require('aSDj02H875hgDtebbB980yY1loO0olI.checkrestrictions'); ?>

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
	// Редирект на главную страницу
	?>
<meta http-equiv="refresh" content="0; url=http://<?php echo $_SERVER['HTTP_HOST']; ?>">
	<?php
	}
	else {
	// при удачном входе пользователю выдается все, что расположено ниже между звездочками.
	// ************************************************************************************
		logActivity();
		require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
// 		include('examples/simple/infoblock-top.php');
		if (checkServiceAccess('allservices')==1) {
			if ((checkServiceAccess('dognet')==1) OR (checkServiceAccess('dognet')==0 && checkIsItSuperadmin($_SESSION['id'])==1)) { 
				if (checkUserRestrictions($_SESSION['id'],'dognet',1,0)==1) {
					include('php/examples/simple/free_access/dognet-free_access(restr_1).php'); 
				}
				else { 
					include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-nopermission185.php'); 
				}
			}
			else { 
				include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-noaccess185.php'); 
			}
		}
		elseif (checkServiceAccess('allservices')==0 && checkIsItSuperadmin($_SESSION['id'])==1) { 
			if (checkUserRestrictions($_SESSION['id'],'dognet',1,0)==1) {
				include('php/examples/simple/free_access/dognet-free_access(restr_1).php'); 
			}
			else { 
				include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-nopermission185.php'); 
			}
		}
		else {
			include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-noaccess185.php');
		}
// 		include('examples/simple/infoblock-bottom.php');
		require($_SERVER['DOCUMENT_ROOT'].'/dognet/___footer.php');

	// ************************************************************************************
	// при удачном входе пользователю выдается все, что расположено ВЫШЕ между звездочками.
	}
}
else
{
// Редирект на главную страницу
?>
<meta http-equiv="refresh" content="0; url=http://<?php echo $_SERVER['HTTP_HOST']; ?>">
<?php
}
?>