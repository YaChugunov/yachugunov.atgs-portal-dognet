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
<meta http-equiv="refresh" content="0; url=http://<?php echo $_SERVER['HTTP_HOST']; ?>">
<?php
	} else {
		// при удачном входе пользователю выдается все, что расположено ниже между звездочками.
		// ************************************************************************************
		logActivity();
		// 		require($_SERVER['DOCUMENT_ROOT'].'/dognet/___header.php');
		// 		include('examples/simple/infoblock-top.php');
		if (checkServiceAccess('allservices') == 1) {
			if ((checkServiceAccess('dognet') == 1) or (checkServiceAccess('dognet') == 0 && checkIsItSuperadmin($_SESSION['id']) == 1)) {
				// ----- -- ----- -- ----- -- ----- -- -----
				if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
					if (!empty($_GET['reportview']) && isset($_GET['reportview'])) {
						switch ($_GET['reportview']) {
							case "zadolchf":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/spravka/zadolchf/export/___header-export.php');
									if ($_GET['zak'] != '') {
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/letter/zakzadolchf/export/___controls-export.php");
									} else {
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/zadolchf/export/___controls-export.php");
									}
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/spravka/zadolchf/dognet-report-reportview(restr_5)-spravka-zadolchf.php');
								}
								break;
							case "zadolchf_ondate":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/spravka/zadolchf_ondate/export/___header-export.php');
									if ($_GET['zak'] != '') {
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/letter/zakzadolchf_ondate/export/___controls-export.php");
									} else {
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/zadolchf_ondate/export/___controls-export.php");
									}
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/spravka/zadolchf_ondate/dognet-report-reportview(restr_5)-spravka-zadolchf_ondate.php');
								}
								break;
							case "zadolsub":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/spravka/zadolsub/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/zadolsub/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/spravka/zadolsub/dognet-report-reportview(restr_5)-spravka-zadolsub.php');
								}
								break;
							case "zadolsub_ondate":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/spravka/zadolsub_ondate/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/zadolsub_ondate/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/spravka/zadolsub_ondate/dognet-report-reportview(restr_5)-spravka-zadolsub_ondate.php');
								}
								break;
							case "docprogress":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/other/docprogress/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/other/docprogress/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/other/docprogress/dognet-report-reportview(restr_5)-other-docprogress.php');
								}
								break;
							case "opl":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/oplav/opl/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/oplav/opl/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/oplav/opl/dognet-report-reportview(restr_5)-oplav-opl.php');
								}
								break;
							case "av":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/oplav/av/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/oplav/av/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/oplav/av/dognet-report-reportview(restr_5)-oplav-av.php');
								}
								break;
							case "unoplav":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/spravka/unoplav/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/unoplav/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/spravka/unoplav/dognet-report-reportview(restr_5)-spravka-unoplav.php');
								}
								break;
							case "unoplav_ondate":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/spravka/unoplav_ondate/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/unoplav_ondate/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/spravka/unoplav_ondate/dognet-report-reportview(restr_5)-spravka-unoplav_ondate.php');
								}
								break;
							case "alldocsexp":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/other/alldocsexp/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/other/alldocsexp/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/other/alldocsexp/dognet-report-reportview(restr_5)-other-alldocsexp.php');
								}
								break;
							case "postexp":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/other/postexp/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/other/postexp/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/other/postexp/dognet-report-reportview(restr_5)-other-postexp.php');
								}
								break;
							case "missions":
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include('php/examples/simple/report/report-details/restr_5/reports/other/missions/dognet-report-reportview(restr_5)-other-missions.php');
								break;
							case "bankform1":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/bankform/form1/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/bankform/form1/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/bankform/form1/dognet-report-reportview(restr_5)-bankform-form1.php');
								}
								break;
							case "bankform2":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/bankform/form2/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/bankform/form2/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/bankform/form2/dognet-report-reportview(restr_5)-bankform-form2.php');
								}
								break;
							case "uncomplstages":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/list/uncomplstages/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/list/uncomplstages/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/list/uncomplstages/dognet-report-reportview(restr_5)-list-uncomplstages.php');
								}
								break;
							case "filterdocs":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/list/filterdocs/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/list/filterdocs/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/list/filterdocs/dognet-report-reportview(restr_5)-list-filterdocs.php');
								}
								break;
							case "gazpromform1":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/gazprom/form1/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/gazprom/form1/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/gazprom/form1/dognet-report-reportview(restr_5)-gazprom-form1.php');
								}
								break;
							case "pko":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/tenders/pko/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/tenders/pko/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/tenders/pko/dognet-report-reportview(restr_5)-tenders-pko.php');
								}
								break;
							case "pko_v2":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/tenders/pko_v2/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/tenders/pko_v2/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/tenders/pko_v2/dognet-report-reportview(restr_5)-tenders-pko.php');
								}
								break;
							case "tend_exp":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_5/reports/tenders/exp/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/tenders/exp/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/tenders/exp/dognet-report-reportview(restr_4)-tenders-exp.php');
								}
								break;
							default:
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include('php/examples/simple/report/report-details/restr_5/dognet-report-details(restr_5).php');
						}
					} else {
						require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
						include('php/examples/simple/report/report-details/restr_5/dognet-report-details(restr_5).php');
					}
				}
				// ----- -- ----- -- ----- -- ----- -- -----
				elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
					if (!empty($_GET['reportview']) && isset($_GET['reportview'])) {
						switch ($_GET['reportview']) {
							case "zadolchf":
								if (isset($_GET['export']) && $_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/export/___header-export.php');
									if ($_GET['zak'] != '') {
										if (checkIsItSuperadmin($_SESSION['id']) == 1) {
											include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_5/reports/letter/zakzadolchf/export/___controls-export.php");
										} else {
											include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/letter/zakzadolchf/export/___controls-export.php");
										}
									} else {
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/export/___controls-export.php");
									}
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/dognet-report-reportview(restr_4)-spravka-zadolchf.php');
								}
								break;
							case "zadolchf_ondate":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf_ondate/export/___header-export.php');
									if ($_GET['zak'] != '') {
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/letter/zakzadolchf_ondate/export/___controls-export.php");
									} else {
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf_ondate/export/___controls-export.php");
									}
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf_ondate/dognet-report-reportview(restr_4)-spravka-zadolchf_ondate.php');
								}
								break;
							case "zadolsub":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolsub/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolsub/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolsub/dognet-report-reportview(restr_4)-spravka-zadolsub.php');
								}
								break;
							case "zadolsub_ondate":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolsub_ondate/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolsub_ondate/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolsub_ondate/dognet-report-reportview(restr_4)-spravka-zadolsub_ondate.php');
								}
								break;
							case "docprogress":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/other/docprogress/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/other/docprogress/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/other/docprogress/dognet-report-reportview(restr_4)-other-docprogress.php');
								}
								break;
							case "opl":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/oplav/opl/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/oplav/opl/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/oplav/opl/dognet-report-reportview(restr_4)-oplav-opl.php');
								}
								break;
							case "av":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/oplav/av/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/oplav/av/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/oplav/av/dognet-report-reportview(restr_4)-oplav-av.php');
								}
								break;
							case "unoplav":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/spravka/unoplav/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/unoplav/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/spravka/unoplav/dognet-report-reportview(restr_4)-spravka-unoplav.php');
								}
								break;
							case "unoplav_ondate":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/spravka/unoplav_ondate/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/unoplav_ondate/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_5/reports/spravka/unoplav_ondate/dognet-report-reportview(restr_4)-spravka-unoplav_ondate.php');
								}
								break;
							case "alldocsexp":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/other/alldocsexp/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/other/alldocsexp/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/other/alldocsexp/dognet-report-reportview(restr_4)-other-alldocsexp.php');
								}
								break;
							case "postexp":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/other/postexp/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/other/postexp/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/other/postexp/dognet-report-reportview(restr_4)-other-postexp.php');
								}
								break;
							case "missions":
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include('php/examples/simple/report/report-details/restr_4/reports/other/missions/dognet-report-reportview(restr_4)-other-missions.php');
								break;
							case "docreestr":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/other/docreestr/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/other/docreestr/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/other/docreestr/dognet-report-reportview(restr_4)-other-docreestr.php');
								}
								break;
							case "bankform1":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/bankform/form1/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/bankform/form1/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/bankform/form1/dognet-report-reportview(restr_4)-bankform-form1.php');
								}
								break;
							case "bankform2":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/bankform/form2/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/bankform/form2/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/bankform/form2/dognet-report-reportview(restr_4)-bankform-form2.php');
								}
								break;
							case "uncomplstages":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/list/uncomplstages/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/list/uncomplstages/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/list/uncomplstages/dognet-report-reportview(restr_4)-list-uncomplstages.php');
								}
								break;
							case "filterdocs":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/dognet-report-reportview(restr_4)-list-filterdocs.php');
								}
								break;
							case "gazpromform1":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/gazprom/form1/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/gazprom/form1/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/gazprom/form1/dognet-report-reportview(restr_4)-gazprom-form1.php');
								}
								break;
							case "pko":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/tenders/pko/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/pko/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/tenders/pko/dognet-report-reportview(restr_4)-tenders-pko.php');
								}
								break;
							case "pko_v2":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/tenders/pko_v2/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/pko_v2/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/tenders/pko_v2/dognet-report-reportview(restr_4)-tenders-pko.php');
								}
								break;
							case "pko_stages":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages/dognet-report-reportview(restr_4)-tenders-pko.php');
								}
								break;
							case "pko_stages_v2":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages_v2/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages_v2/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages_v2/dognet-report-reportview(restr_4)-tenders-pko.php');
								}
								break;
							case "tend_exp":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/tenders/exp/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/exp/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/tenders/exp/dognet-report-reportview(restr_4)-tenders-exp.php');
								}
								break;
								// >>>
								// Редакция 10.01.24
								// Вывод списка счетов-фактур по выбранному договору. В общий список отчетов не добавляется, вызывается по клику из карточки договора.
							case "chetfindoc":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/list/chetfindoc/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/list/chetfindoc/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/list/chetfindoc/dognet-report-reportview(restr_4)-list-chetfindoc.php');
								}
								break;
								// <<<	
								// >>>
								// Редакция 12.02.24
								// risks - Вывод сводной информации о рисках на основе данных из бланков заявок ГИПов на договора за календарный год
								// unoplavsub_ondate - Отчет о незакрытых авансах по договорам субподряда на любую дату (по аналогии с обычными договорами)
							case "blankrisks":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/other/blankrisks/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/other/blankrisks/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/other/blankrisks/dognet-report-reportview(restr_4)-blankrisks.php');
								}
								break;
							case "unoplavsub_ondate":
								if ($_GET['export'] == 'yes') {
									require('php/examples/simple/report/report-details/restr_4/reports/spravka/unoplavsub_ondate/export/___header-export.php');
									include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/unoplavsub_ondate/export/___controls-export.php");
								} else {
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/spravka/unoplavsub_ondate/dognet-report-reportview(restr_4)-unoplavsub_ondate.php');
								}
								break;
								// <<<	
							default:
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include('php/examples/simple/report/report-details/restr_4/dognet-report-details(restr_4).php');
						}
					} else {
						require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
						include('php/examples/simple/report/report-details/restr_4/dognet-report-details(restr_4).php');
					}
				}
				// ----- -- ----- -- ----- -- ----- -- -----
				elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1) {
					if (!empty($_GET['reportview']) && isset($_GET['reportview'])) {
						// Доступ к отчетам для ТЕСТ (1011), Мохнаткина (1073), Столяровой (1053), Ртищевой (1065)
						if ($_SESSION['id'] == '1073' || $_SESSION['id'] == '1053' || $_SESSION['id'] == '1065') {
							switch ($_GET['reportview']) {
								case "zadolchf":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/export/___header-export.php');
										if ($_GET['zak'] != '') {
											include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/letter/zakzadolchf/export/___controls-export.php");
										} else {
											include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/export/___controls-export.php");
										}
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/dognet-report-reportview(restr_4)-spravka-zadolchf.php');
									}
									break;
								case "zadolchf_ondate":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf_ondate/export/___header-export.php');
										if ($_GET['zak'] != '') {
											include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/letter/zakzadolchf_ondate/export/___controls-export.php");
										} else {
											include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf_ondate/export/___controls-export.php");
										}
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf_ondate/dognet-report-reportview(restr_4)-spravka-zadolchf_ondate.php');
									}
									break;
								case "zadolsub":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolsub/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolsub/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/spravka/zadolsub/dognet-report-reportview(restr_4)-spravka-zadolsub.php');
									}
									break;
								case "docprogress":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/other/docprogress/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/other/docprogress/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/other/docprogress/dognet-report-reportview(restr_4)-other-docprogress.php');
									}
									break;
								case "opl":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/oplav/opl/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/oplav/opl/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/oplav/opl/dognet-report-reportview(restr_4)-oplav-opl.php');
									}
									break;
								case "av":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/oplav/av/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/oplav/av/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/oplav/av/dognet-report-reportview(restr_4)-oplav-av.php');
									}
									break;
								case "unoplav":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/spravka/unoplav/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/unoplav/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/spravka/unoplav/dognet-report-reportview(restr_4)-spravka-unoplav.php');
									}
									break;
								case "alldocsexp":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/other/alldocsexp/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/other/alldocsexp/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/other/alldocsexp/dognet-report-reportview(restr_4)-other-alldocsexp.php');
									}
									break;
								case "postexp":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/other/postexp/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/other/postexp/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/other/postexp/dognet-report-reportview(restr_4)-other-postexp.php');
									}
									break;
								case "missions":
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/reports/other/missions/dognet-report-reportview(restr_4)-other-missions.php');
									break;
								case "docreestr":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/other/docreestr/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/other/docreestr/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/other/docreestr/dognet-report-reportview(restr_4)-other-docreestr.php');
									}
									break;
								case "bankform1":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/bankform/form1/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/bankform/form1/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/bankform/form1/dognet-report-reportview(restr_4)-bankform-form1.php');
									}
									break;
								case "bankform2":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/bankform/form2/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/bankform/form2/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/bankform/form2/dognet-report-reportview(restr_4)-bankform-form2.php');
									}
									break;
								case "uncomplstages":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/list/uncomplstages/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/list/uncomplstages/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/list/uncomplstages/dognet-report-reportview(restr_4)-list-uncomplstages.php');
									}
									break;
								case "filterdocs":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/list/filterdocs/dognet-report-reportview(restr_4)-list-filterdocs.php');
									}
									break;
								case "gazpromform1":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/gazprom/form1/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/gazprom/form1/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/gazprom/form1/dognet-report-reportview(restr_4)-gazprom-form1.php');
									}
									break;
								case "pko":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/tenders/pko/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/pko/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/tenders/pko/dognet-report-reportview(restr_4)-tenders-pko.php');
									}
									break;
								case "pko_stages":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages/dognet-report-reportview(restr_4)-tenders-pko.php');
									}
									break;
								case "pko_stages_v2":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages_v2/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages_v2/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/tenders/pko_stages_v2/dognet-report-reportview(restr_4)-tenders-pko.php');
									}
									break;
								case "tend_exp":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/tenders/exp/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/exp/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/tenders/exp/dognet-report-reportview(restr_4)-tenders-exp.php');
									}
									break;
									// >>>
									// Редакция 10.01.24
									// Вывод списка счетов-фактур по выбранному договору. В общий список отчетов не добавляется, вызывается по клику из карточки договора.
								case "chetfindoc":
									if ($_GET['export'] == 'yes') {
										require('php/examples/simple/report/report-details/restr_4/reports/list/chetfindoc/export/___header-export.php');
										include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/list/chetfindoc/export/___controls-export.php");
									} else {
										require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
										include('php/examples/simple/report/report-details/restr_4/reports/list/chetfindoc/dognet-report-reportview(restr_4)-list-chetfindoc.php');
									}
									break;
									// <<<	
								default:
									require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
									include('php/examples/simple/report/report-details/restr_4/dognet-report-details(restr_4).php');
							}
						} elseif ($_GET['reportview'] == "chetfindoc") {
							// >>>
							// Редакция 10.01.24
							// Вывод списка счетов-фактур по выбранному договору. В общий список отчетов не добавляется, вызывается по клику из карточки договора.
							if ($_GET['export'] == 'yes') {
								require('php/examples/simple/report/report-details/restr_4/reports/list/chetfindoc/export/___header-export.php');
								include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/list/chetfindoc/export/___controls-export.php");
							} else {
								require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
								include('php/examples/simple/report/report-details/restr_4/reports/list/chetfindoc/dognet-report-reportview(restr_4)-list-chetfindoc.php');
							}
							// <<<	
						} else {
							require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
							include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
						}
					} else {
						// Доступ к отчетам для ТЕСТ (1011), Мохнаткина (1073), Столяровой (1053), Ртищевой (1065)
						if ($_SESSION['id'] == '1073' || $_SESSION['id'] == '1053' || $_SESSION['id'] == '1011' || $_SESSION['id'] == '1065') {
							require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
							include('php/examples/simple/report/report-details/restr_4/dognet-report-details(restr_4).php');
						} else {
							require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
							include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
						}
					}
				}
				// ----- -- ----- -- ----- -- ----- -- -----
				elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 2, 1) == 1) {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
				} else {
					require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
					include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
				}
			} else {
				require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
				include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-noaccess185.php');
			}
		} elseif (checkServiceAccess('allservices') == 0 && checkIsItSuperadmin($_SESSION['id']) == 1) {
			require($_SERVER['DOCUMENT_ROOT'] . '/dognet/___header.php');
			if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
				include('php/examples/simple/report/report-details/restr_5/dognet-report-details(restr_5).php');
			} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 4, 1) == 1) {
				include('php/examples/simple/report/report-details/restr_4/dognet-report-details(restr_4).php');
			} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 3, 1) == 1) {
				include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
			} elseif (checkUserRestrictions($_SESSION['id'], 'dognet', 2, 1) == 1) {
				include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
			} else {
				include($_SERVER['DOCUMENT_ROOT'] . '/_assets/includes/msg.inc/message_service-nopermission185.php');
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