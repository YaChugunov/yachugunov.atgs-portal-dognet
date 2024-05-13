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
	<meta http-equiv="refresh" content="0; url=http://192.168.1.89">
	<?php
	}
	else {
	// при удачном входе пользователю выдается все, что расположено ниже между звездочками.
	// ************************************************************************************
		logActivity();
// 		require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
// 		include('examples/simple/infoblock-top.php');
		if (checkServiceAccess('allservices')==1) {
			if ((checkServiceAccess('dognet')==1) OR (checkServiceAccess('dognet')==0 && checkIsItSuperadmin($_SESSION['id'])==1)) {
			# ----- ----- ----- ----- -----
			# ACTVIEW ::: ОТКРЫТ
				if (checkDognetSectionAccess('actview', 'access_full')==1) {
					if (isset($_GET['actview_type'])) {
						if ($_GET['actview_type'] == "list") {
						# ----- ----- ----- ----- -----
						# ACTVIEW-CURRENT ::: ОТКРЫТ
							if (checkDognetSectionAccess('actview', 'access_current')==1) {
								if (checkUserRestrictions($_SESSION['id'],'dognet',5,1)==1) {
									if ($_GET['export'] == "yes") {
										require('php/examples/simple/actview/actview-current/restr_5/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/actview/actview-current/restr_5/export/___controls-export.php");
									}
									elseif ($_GET['export'] == "letter") {
										require('php/examples/simple/actview/actview-current/restr_5/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/actview/actview-current/restr_5/export-letter/___controls-export.php");
									}
									else {
										require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
										include('php/examples/simple/actview/actview-current/restr_5/dognet-actview-current(restr_5).php');
									}
								}
								elseif (checkUserRestrictions($_SESSION['id'],'dognet',4,1)==1) {
									if ($_GET['export'] == "yes") {
										require('php/examples/simple/actview/actview-current/restr_4/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/actview/actview-current/restr_4/export/___controls-export.php");
									}
									elseif ($_GET['export'] == "letter") {
										require('php/examples/simple/actview/actview-current/restr_4/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/actview/actview-current/restr_4/export-letter/___controls-export.php");
									}
									else {
										require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
										include('php/examples/simple/actview/actview-current/restr_4/dognet-actview-current(restr_4).php');
									}
								}
								else {
									require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
									include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-nopermission185.php');
								}
							}
						# ACTVIEW-CURRENT ::: ЗАКРЫТ
							else {
								require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
								include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-noaccess185.php');
							}
						# ----- ----- ----- ----- -----
						}
					}
					elseif (!isset($_GET['actview_type'])) {

					}
				}
			# ACTVIEW ::: ЗАКРЫТ
				else {
					require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
					include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-noaccess185.php');
				}
			# ----- ----- ----- ----- -----
			}
			else {
				require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
				include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-noaccess185.php');
			}
		}
		elseif (checkServiceAccess('allservices')==0 && checkIsItSuperadmin($_SESSION['id'])==1) {
			if ($_GET['actview_type'] == "list") {
				if (checkUserRestrictions($_SESSION['id'],'dognet',5,1)==1) {
					if ($_GET['export'] == "yes") {
						require('php/examples/simple/actview/actview-current/restr_5/export/___header-export.php');
						include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/actview/actview-current/restr_5/export/___controls-export.php");
					}
					else {
						require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
						include('php/examples/simple/actview/actview-current/restr_5/dognet-actview-current(restr_5).php');
					}
				}
				elseif (checkUserRestrictions($_SESSION['id'],'dognet',5,1)==1) {
					if ($_GET['export'] == "yes") {
						require('php/examples/simple/actview/actview-current/restr_4/export/___header-export.php');
						include($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/actview/actview-current/restr_4/export/___controls-export.php");
					}
					else {
						require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
						include('php/examples/simple/actview/actview-current/restr_4/dognet-actview-current(restr_4).php');
					}
				}
				else {
					require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
					include($_SERVER['DOCUMENT_ROOT'].'/_assets/includes/msg.inc/message_service-nopermission185.php');
				}
			}
			elseif (!isset($_GET['actview_type'])) {

			}
		}
		else {
			require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
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