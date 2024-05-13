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
# Подключаем собственные функции сервиса Договор
// require('_assets/functions/funcDognet.inc.php');
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
		//		require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
		// 		include('examples/simple/infoblock-top.php');
		if (checkServiceAccess('allservices') == 1) {
			if ((checkServiceAccess('dognet') == 1) or (checkServiceAccess('dognet') == 0 && checkIsItSuperadmin($_SESSION['id']) == 1)) {
				# ----- ----- ----- ----- -----
				# DOCVIEW ::: ОТКРЫТ
				if (checkDognetSectionAccess('docview', 'access_full') == 1) {
					if (isset($_GET['docview_type'])) {
						if ($_GET['docview_type'] == "current") {
							# ----- ----- ----- ----- -----
							# DOCVIEW-CURRENT ::: ОТКРЫТ
							if (checkDognetSectionAccess('docview', 'access_current') == 1) {
								if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
									if ($_GET['export'] == 'yes' && $_GET['tip'] == 'letter_notify') {
										require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_5/letter/export/___header-export.php");
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_5/letter/export/___controls-export.php");
									} elseif ($_GET['export'] == 'yes' && $_GET['tip'] == 'letter_transfer') {
										require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_5/letter2/export/___header-export.php");
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_5/letter2/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . "/dognet/___header.php");
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_5/dognet-docview-current(restr_5).php");
									}
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
									if ($_GET['export'] == 'yes' && $_GET['tip'] == 'letter_notify') {
										require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_4/letter/export/___header-export.php");
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_4/letter/export/___controls-export.php");
									} elseif ($_GET['export'] == 'yes' && $_GET['tip'] == 'letter_transfer') {
										require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_4/letter2/export/___header-export.php");
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_4/letter2/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . "/dognet/___header.php");
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_4/dognet-docview-current(restr_4).php");
									}
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1) {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/docview/docview-current/restr_3/dognet-docview-current(restr_3).php');
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 2, 1) == 1) {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/docview/docview-current/restr_2/dognet-docview-current(restr_2).php');
								} else {
									include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
								}
							}
							# DOCVIEW-CURRENT ::: ЗАКРЫТ
							else {
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
							}
							# ----- ----- ----- ----- -----
						} elseif ($_GET['docview_type'] == "search") {
							# ----- ----- ----- ----- -----
							# DOCVIEW-SEARCH ::: ОТКРЫТ
							if (checkDognetSectionAccess('docview', 'access_search') == 1) {
								if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/docview/docview-search/restr_5/dognet-docview-search(restr_5).php');
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/docview/docview-search/restr_4/dognet-docview-search(restr_4).php');
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1) {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/docview/docview-search/restr_3/dognet-docview-search(restr_3).php');
								} else {
									include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
								}
							}
							# DOCVIEW-SEARCH ::: ЗАКРЫТ
							else {
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
							}
							# ----- ----- ----- ----- -----
						} elseif ($_GET['docview_type'] == "details") {
							# ----- ----- ----- ----- -----
							# DOCVIEW-DETAILS ::: ОТКРЫТ
							if (checkDognetSectionAccess('docview', 'access_details') == 1) {
								if (isset($_GET['uniqueID']) && !empty($_GET['uniqueID'])) {
									if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										if (DOCBASE_FN_DOC_CHECK_FOR_EDIT($_GET['uniqueID']) == 1) {
											if (isset($_GET['action']) && $_GET['action'] == "unlock") {
												if (DOCBASE_FN_DOC_UNLOCK_FOR_EDIT($_GET['uniqueID']) == 1) {
													include('php/examples/simple/docview/docview-edit/restr_5/dognet-docview-page-docunlocked(restr_5).php');
												} else {
													include('php/examples/simple/docview/docview-edit/restr_5/dognet-docview-page-doclocked(restr_5).php');
												}
											} else {
												include('php/examples/simple/docview/docview-details/restr_5/dognet-docview-details(restr_5).php');
											}
										} else {
											include('php/examples/simple/docview/docview-details/restr_5/dognet-docview-details(restr_5).php');
										}
									} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										if (DOCBASE_FN_DOC_CHECK_FOR_EDIT($_GET['uniqueID']) == 1) {
											if (isset($_GET['action']) && $_GET['action'] == "unlock") {
												if (DOCBASE_FN_DOC_UNLOCK_FOR_EDIT($_GET['uniqueID']) == 1) {
													include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_dognet-doc_unlocked_for_edit.php');
												} else {
													include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_dognet-doc_locked_for_edit.php');
												}
											} else {
												include('php/examples/simple/docview/docview-details/restr_4/dognet-docview-details(restr_4).php');
											}
										} else {
											include('php/examples/simple/docview/docview-details/restr_4/dognet-docview-details(restr_4).php');
										}
									} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/docview/docview-details/restr_3/dognet-docview-details(restr_3).php');
									} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 2, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/docview/docview-details/restr_2/dognet-docview-details(restr_2).php');
									} else {
										include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
									}
								} else {
									if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/docview/docview-current/restr_5/dognet-docview-current(restr_5).php');
									} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/docview/docview-current/restr_4/dognet-docview-current(restr_4).php');
									} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/docview/docview-current/restr_3/dognet-docview-current(restr_3).php');
									} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 2, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/docview/docview-current/restr_2/dognet-docview-current(restr_2).php');
									} else {
										include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
									}
								}
							}
							# DOCVIEW-DETAILS ::: ЗАКРЫТ
							else {
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
							}
							# ----- ----- ----- ----- -----
						} elseif ($_GET['docview_type'] == "edit") {
							# ----- ----- ----- ----- -----
							# DOCVIEW-EDIT ::: ОТКРЫТ
							if (checkDognetSectionAccess('docview', 'access_edit') == 1) {
								if (isset($_GET['uniqueID']) && !empty($_GET['uniqueID'])) {
									if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										if (DOCBASE_FN_DOC_CHECK_FOR_EDIT($_GET['uniqueID']) == 1) {
											if (isset($_GET['action']) && $_GET['action'] == "unlock") {
												if (DOCBASE_FN_DOC_UNLOCK_FOR_EDIT($_GET['uniqueID']) == 1) {
													include('php/examples/simple/docview/docview-details/restr_5/dognet-docview-details(restr_5).php');
												} else {
													include('php/examples/simple/docview/docview-edit/restr_5/dognet-docview-edit(restr_5).php');
												}
											} else {
												DOCBASE_PR_DOC_LOCK_FOR_EDIT($_GET['uniqueID']);
												include('php/examples/simple/docview/docview-edit/restr_5/dognet-docview-edit(restr_5).php');
											}
										} else {
											include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_dognet-doc_locked_for_edit.php');
										}
									} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										if (DOCBASE_FN_DOC_CHECK_FOR_EDIT($_GET['uniqueID']) == 1) {
											if (isset($_GET['action']) && $_GET['action'] == "unlock") {
												if (DOCBASE_FN_DOC_UNLOCK_FOR_EDIT($_GET['uniqueID']) == 1) {
													include('php/examples/simple/docview/docview-details/restr_4/dognet-docview-details(restr_4).php');
												} else {
													include('php/examples/simple/docview/docview-edit/restr_4/dognet-docview-edit(restr_4).php');
												}
											} else {
												DOCBASE_PR_DOC_LOCK_FOR_EDIT($_GET['uniqueID']);
												include('php/examples/simple/docview/docview-edit/restr_4/dognet-docview-edit(restr_4).php');
											}
										} else {
											include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_dognet-doc_locked_for_edit.php');
										}
									} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/docview/docview-current/restr_3/dognet-docview-current(restr_3).php');
									} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 2, 1) == 1) {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/docview/docview-current/restr_2/dognet-docview-current(restr_2).php');
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
									}
								}
							}
							# DOCVIEW-EDIT ::: ЗАКРЫТ
							else {
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
							}
							# ----- ----- ----- ----- -----
						} elseif ($_GET['docview_type'] == "agreements") {
							# ----- ----- ----- ----- -----
							# AGREEVIEW-CURRENT ::: ОТКРЫТ
							if (checkDognetSectionAccess('docview', 'access_current') == 1) {
								if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/docview/docview-agreements-current/restr_5/dognet-docview-agreements-current(restr_5).php');
								} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/docview/docview-agreements-current/restr_4/dognet-docview-agreements-current(restr_4).php');
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
								}
							}
							# AGREEVIEW-CURRENT ::: ЗАКРЫТ
							else {
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
							}
							# ----- ----- ----- ----- -----
						}
					} elseif (!isset($_GET['docview_type'])) {
					}
				}
				# DOCVIEW ::: ЗАКРЫТ
				else {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
				}
				# ----- ----- ----- ----- -----
			} else {
				require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
				include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
			}
		} elseif (checkServiceAccess('allservices') == 0 && checkIsItSuperadmin($_SESSION['id']) == 1) {
			if ($_GET['docview_type'] == "current") {
				if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include('php/examples/simple/docview/docview-current/restr_5/dognet-docview-current(restr_5).php');
				} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include('php/examples/simple/docview/docview-current/restr_4/dognet-docview-current(restr_4).php');
				} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1) {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include('php/examples/simple/docview/docview-current/restr_3/dognet-docview-current(restr_3).php');
				} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 2, 1) == 1) {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include('php/examples/simple/docview/docview-current/restr_2/dognet-docview-current(restr_2).php');
				} else {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
				}
			} elseif ($_GET['docview_type'] == "search") {
				if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include('php/examples/simple/docview/docview-search/restr_5/dognet-docview-search(restr_5).php');
				} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include('php/examples/simple/docview/docview-search/restr_4/dognet-docview-search(restr_4).php');
				} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1) {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include('php/examples/simple/docview/docview-search/restr_3/dognet-docview-search(restr_3).php');
				} else {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
				}
			} elseif (!isset($_GET['docview_type'])) {
			}
		} else {
			require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
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