<?php // require('aSDj02H875hgDtebbB980yY1loO0olI.checkrestrictions'); 
?>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.inc.php');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require($_SERVER['DOCUMENT_ROOT'] . '/_assets/drivers/db_connection.php');
// require('../_assets/drivers/db_controller.php');
// $db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
require($_SERVER['DOCUMENT_ROOT'] . '/_assets/functions/funcSecure.inc.php');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем собственные функции сервиса Договор
require('_assets/functions/funcDognet.inc.php');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
if (isset($_SESSION['password']) && isset($_SESSION['login'])) {
	if (checkUserAuthorization($_SESSION['login'], $_SESSION['password']) == -1) {
		// Редирект на главную страницу
?>
<meta http-equiv="refresh" content="0; url=http://192.168.1.89">
<?php
	} else {
		// при удачном входе пользователю выдается все, что расположено ниже между звездочками.
		// ************************************************************************************
		logActivity();
		// 		require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
		// 		include('examples/simple/infoblock-top.php');
		if (checkServiceAccess('allservices') == 1) {
			if ((checkServiceAccess('dognet') == 1) or (checkServiceAccess('dognet') == 0 && checkIsItSuperadmin($_SESSION['id']) == 1)) {
				# ----- ----- ----- ----- -----
				# ZAYVVIEW ::: ОТКРЫТ
				if (checkDognetSectionAccess('zayvview', 'access_full') == 1) {
					if (isset($_GET['zayvview_type'])) {
						if ($_GET['zayvview_type'] == "current") {
							# ----- ----- ----- ----- -----
							# ZAYVVIEW-CURRENT ::: ОТКРЫТ
							if (checkDognetSectionAccess('zayvview', 'access_current') == 1) {
								if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1 && checkIsItZAYV($_SESSION['id']) == 1) {
									if (isset($_GET['export'])) {
										if ($_GET['export'] == "yes") {
											# ----- ----- ----- ----- -----
											# ZAYVVIEW-CURRENT-EXPORT ::: ОТКРЫТ
											if (checkDognetSectionAccess('zayvview', 'access_export') == 1) {
												require('php/examples/simple/zayvview/zayvview-current/restr_5/export/___header-export.php');
												include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-current/restr_5/export/___control-export.php");
											}
											# ZAYVVIEW-CURRENT-EXPORT ::: ЗАКРЫТ
											else {
												require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
												include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
											}
											# ----- ----- ----- ----- -----
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-current/restr_5/dognet-zayvview-current(restr_5).php');
										}
									} elseif (isset($_GET['mailing'])) {
										if ($_GET['mailing'] == "yes") {
											# ----- ----- ----- ----- -----
											# ZAYVVIEW-CURRENT-MAILING ::: ОТКРЫТ
											if (checkDognetSectionAccess('zayvview', 'access_mailing') == 1) {
												require('php/examples/simple/zayvview/zayvview-current/restr_5/mailing/___header-mailing.php');
												include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-current/restr_5/mailing/___direct-mailing.php");
											}
											# ZAYVVIEW-CURRENT-MAILING ::: ЗАКРЫТ
											else {
												require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
												include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
											}
											# ----- ----- ----- ----- -----
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-current/restr_5/dognet-zayvview-current(restr_5).php');
										}
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/zayvview/zayvview-current/restr_5/dognet-zayvview-current(restr_5).php');
									}
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1 && checkIsItZAYV($_SESSION['id']) == 1) {
									if (isset($_GET['export'])) {
										if ($_GET['export'] == "yes") {
											# ----- ----- ----- ----- -----
											# ZAYVVIEW-CURRENT-EXPORT ::: ОТКРЫТ
											if (checkDognetSectionAccess('zayvview', 'access_export') == 1) {
												require('php/examples/simple/zayvview/zayvview-current/restr_3/export/___header-export.php');
												include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-current/restr_3/export/___controls-export.php");
											}
											# ZAYVVIEW-CURRENT-EXPORT ::: ЗАКРЫТ
											else {
												require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
												include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
											}
											# ----- ----- ----- ----- -----
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-current/restr_3/dognet-zayvview-current(restr_3).php');
										}
									} elseif (isset($_GET['mailing'])) {
										if ($_GET['mailing'] == "yes") {
											# ----- ----- ----- ----- -----
											# ZAYVVIEW-CURRENT-MAILING ::: ОТКРЫТ
											if (checkDognetSectionAccess('zayvview', 'access_mailing') == 1) {
												require('php/examples/simple/zayvview/zayvview-current/restr_3/mailing/___header-mailing.php');
												include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-current/restr_3/mailing/___direct-mailing.php");
											}
											# ZAYVVIEW-CURRENT-MAILING ::: ЗАКРЫТ
											else {
												require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
												include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
											}
											# ----- ----- ----- ----- -----
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-current/restr_3/dognet-zayvview-current(restr_3).php');
										}
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/zayvview/zayvview-current/restr_3/dognet-zayvview-current(restr_3).php');
									}
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1 && checkIsItZAYV($_SESSION['id']) == 1) {
									if (isset($_GET['export'])) {
										if ($_GET['export'] == "yes") {
											# ----- ----- ----- ----- -----
											# ZAYVVIEW-CURRENT-EXPORT ::: ОТКРЫТ
											if (checkDognetSectionAccess('zayvview', 'access_export') == 1) {
												require('php/examples/simple/zayvview/zayvview-current/restr_3/export/___header-export.php');
												include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-current/restr_3/export/___controls-export.php");
											}
											# ZAYVVIEW-CURRENT-EXPORT ::: ЗАКРЫТ
											else {
												require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
												include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
											}
											# ----- ----- ----- ----- -----
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-current/restr_3/dognet-zayvview-current(restr_3).php');
										}
									} elseif (isset($_GET['mailing'])) {
										if ($_GET['mailing'] == "yes") {
											# ----- ----- ----- ----- -----
											# ZAYVVIEW-CURRENT-MAILING ::: ОТКРЫТ
											if (checkDognetSectionAccess('zayvview', 'access_mailing') == 1) {
												require('php/examples/simple/zayvview/zayvview-current/restr_3/mailing/___header-mailing.php');
												include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-current/restr_3/mailing/___direct-mailing.php");
											}
											# ZAYVVIEW-CURRENT-MAILING ::: ЗАКРЫТ
											else {
												require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
												include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
											}
											# ----- ----- ----- ----- -----
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-current/restr_3/dognet-zayvview-current(restr_3).php');
										}
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/zayvview/zayvview-current/restr_3/dognet-zayvview-current(restr_3).php');
									}
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 2, 1) == 1) {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 1, 1) == 1 && checkIsItZAYV($_SESSION['id']) == 1) {
									if (isset($_GET['export'])) {
										if ($_GET['export'] == "yes") {
											# ----- ----- ----- ----- -----
											# ZAYVVIEW-CURRENT-EXPORT ::: ОТКРЫТ
											if (checkDognetSectionAccess('zayvview', 'access_export') == 1) {
												require('php/examples/simple/zayvview/zayvview-current/restr_1/export/___header-export.php');
												include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-current/restr_1/export/___controls-export.php");
											}
											# ZAYVVIEW-CURRENT-EXPORT ::: ЗАКРЫТ
											else {
												require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
												include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
											}
											# ----- ----- ----- ----- -----
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-current/restr_1/dognet-zayvview-current(restr_1).php');
										}
									} elseif (isset($_GET['mailing'])) {
										if ($_GET['mailing'] == "yes") {
											# ----- ----- ----- ----- -----
											# ZAYVVIEW-CURRENT-MAILING ::: ОТКРЫТ
											if (checkDognetSectionAccess('zayvview', 'access_mailing') == 1) {
												require('php/examples/simple/zayvview/zayvview-current/restr_1/mailing/___header-mailing.php');
												include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-current/restr_1/mailing/___direct-mailing.php");
											}
											# ZAYVVIEW-CURRENT-MAILING ::: ЗАКРЫТ
											else {
												require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
												include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
											}
											# ----- ----- ----- ----- -----
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-current/restr_1/dognet-zayvview-current(restr_1).php');
										}
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/zayvview/zayvview-current/restr_1/dognet-zayvview-current(restr_1).php');
									}
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
								}
							}
							# ZAYVVIEW-CURRENT ::: ЗАКРЫТ
							else {
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
							}
							# ----- ----- ----- ----- -----
						} elseif ($_GET['zayvview_type'] == "chet") {
							# ----- ----- ----- ----- -----
							# ZAYVVIEW-ZAYVCHET ::: ОТКРЫТ
							if (checkDognetSectionAccess('zayvview', 'access_zayvchet') == 1) {
								if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1 && checkIsItZAYV($_SESSION['id']) == 1) {
									if (isset($_GET['mailing'])) {
										if ($_GET['mailing'] == "yes") {
											require('php/examples/simple/zayvview/zayvview-chet/restr_5/mailing/___header-mailing.php');
											include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-chet/restr_5/mailing/___direct-mailing.php");
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-chet/restr_5/dognet-zayvview-chet(restr_5).php');
										}
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/zayvview/zayvview-chet/restr_5/dognet-zayvview-chet(restr_5).php');
									}
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1 && checkIsItZAYV($_SESSION['id']) == 1) {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/zayvview/zayvview-chet/restr_3/dognet-zayvview-chet(restr_3).php');
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1 && checkIsItZAYV($_SESSION['id']) == 1) {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/zayvview/zayvview-chet/restr_3/dognet-zayvview-chet(restr_3).php');
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
								}
							}
							# ZAYVVIEW-ZAYVCHET ::: ЗАКРЫТ
							else {
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
							}
							# ----- ----- ----- ----- -----
						} elseif ($_GET['zayvview_type'] == "chetf") {
							# ----- ----- ----- ----- -----
							# ZAYVVIEW-ZAYVCHETF ::: ОТКРЫТ
							if (checkDognetSectionAccess('zayvview', 'access_zayvchetf') == 1) {
								if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1 && checkIsItZAYV($_SESSION['id']) == 1) {
									if (isset($_GET['mailing'])) {
										if ($_GET['mailing'] == "yes") {
											require('php/examples/simple/zayvview/zayvview-chetf/restr_5/mailing/___header-mailing.php');
											include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_5/mailing/___direct-mailing.php");
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-chetf/restr_5/dognet-zayvview-chetf(restr_5).php');
										}
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/zayvview/zayvview-chetf/restr_5/dognet-zayvview-chetf(restr_5).php');
									}
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1 && checkIsItZAYV($_SESSION['id']) == 1) {
									if (isset($_GET['mailing'])) {
										if ($_GET['mailing'] == "yes") {
											require('php/examples/simple/zayvview/zayvview-chetf/restr_3/mailing/___header-mailing.php');
											include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_3/mailing/___direct-mailing.php");
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-chetf/restr_3/dognet-zayvview-chetf(restr_3).php');
										}
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/zayvview/zayvview-chetf/restr_3/dognet-zayvview-chetf(restr_3).php');
									}
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1 && checkIsItZAYV($_SESSION['id']) == 1) {
									if (isset($_GET['mailing'])) {
										if ($_GET['mailing'] == "yes") {
											require('php/examples/simple/zayvview/zayvview-chetf/restr_3/mailing/___header-mailing.php');
											include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/zayvview/zayvview-chetf/restr_3/mailing/___direct-mailing.php");
										} else {
											require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
											include('php/examples/simple/zayvview/zayvview-chetf/restr_3/dognet-zayvview-chetf(restr_3).php');
										}
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/zayvview/zayvview-chetf/restr_3/dognet-zayvview-chetf(restr_3).php');
									}
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
								}
							}
							# ZAYVVIEW-ZAYVCHETF ::: ЗАКРЫТ
							else {
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
							}
							# ----- ----- ----- ----- -----
						}
					} elseif (!isset($_GET['zayvview_type'])) {
					}
				}
				# ZAYVVIEW ::: ЗАКРЫТ
				else {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
				}
				# ----- ----- ----- ----- -----
			} else {
				include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
			}
		} elseif (checkServiceAccess('allservices') == 0 && checkIsItSuperadmin($_SESSION['id']) == 1) {
			if ($_GET['zayvview_type'] == "current") {
				if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
					include('php/examples/simple/zayvview/zayvview-current/restr_5/dognet-zayvview-current(restr_5).php');
				} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
					include('php/examples/simple/zayvview/zayvview-current/restr_3/dognet-zayvview-current(restr_3).php');
				} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1) {
					include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
				} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 2, 1) == 1) {
					include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
				} else {
					include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
				}
			} elseif (!isset($_GET['zayvview_type'])) {
			}
		} else {
			include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
		}
		// 		include('examples/simple/infoblock-bottom.php');
		require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___footer.php');

		// ************************************************************************************
		// при удачном входе пользователю выдается все, что расположено ВЫШЕ между звездочками.
	}
} else {
	// Редирект на главную страницу
	?>
<meta http-equiv="refresh" content="0; url=http://<?php echo $_SERVER['HTTP_HOST']; ?>">
<?php
}
?>