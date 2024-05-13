<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT'] . "/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ID ПОЛЬЗОВАТЕЛЯ
if ($_SESSION['id'] == "1011" || checkIsItSuperadmin($_SESSION['id']) == 1) {
	#	$__USERID = '1052'; // Щукин
	#	$__USERID = '1105'; // Лавров
	$__USERID = '1043'; // Тимофеев
	#	$__USERID = '1037'; // Зельдин
} else {
	$__USERID = $_SESSION['id'];
}

# ИНТЕРВАЛ ДЕДЛАЙНА
$__DATEDIFF = 180;

# ТЕКУЩАЯ ДАТА
$__DATENOW = date("Y-m-d H:i:s");

// ОПРЕДЕЛЯЕМ KODISPOL ГИПА ПО ЕГО ID
$_QRY_KODISPOL = mysqlQuery("SELECT * FROM dognet_users_kods WHERE id='" . $__USERID . "'");
$_ROW_KODISPOL = mysqli_fetch_assoc($_QRY_KODISPOL);
$__KODISPOL = $_ROW_KODISPOL['kodispol'];
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
/*
 * Example PHP implementation used for the index.html example
*/
// DataTables PHP library
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_datatables-php-api-editor/DataTables.php");
// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin;
// Build our Editor instance and process the data coming from _POST
Editor::inst($db, 'dognet_dockalplan')
	->fields(
		Field::inst('dognet_docbase.koddel'),
		Field::inst('dognet_dockalplan.koddoc'),
		Field::inst('dognet_dockalplan.kodkalplan'),
		Field::inst('dognet_dockalplan.numberstage'),
		Field::inst('dognet_dockalplan.nameshotstage'),
		Field::inst('dognet_dockalplan.namefullstage'),
		Field::inst('dognet_dockalplan.dateplan')
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_dockalplan.dateoplall')
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_dockalplan.summastage'),
		//
		Field::inst('dognet_dockalplan.srokstage'),
		Field::inst('dognet_dockalplan.srokstage_date')
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_dockalplan.idsrokstage'),
		Field::inst('dognet_dockalplan.srokopl'),
		Field::inst('dognet_dockalplan.idsrokopl'),
		Field::inst('dognet_dockalplan.numberdayoplstage'),
		//
		Field::inst('dognet_dockalplan_progress.firstdateavans'),
		Field::inst('dognet_dockalplan_progress.idsrokstage'),
		Field::inst('dognet_dockalplan_progress.srokstage'),
		Field::inst('dognet_dockalplan_progress.srokstage_date'),
		Field::inst('dognet_dockalplan_progress.idsrokopl'),
		Field::inst('dognet_dockalplan_progress.srokopl'),
		Field::inst('dognet_dockalplan.idobjectready'),
		Field::inst('dognet_dockalplan_progress.dateplan'),
		Field::inst('dognet_dockalplan_progress.numberdayoplstage'),
		Field::inst('dognet_dockalplan_progress.dateoplall'),
		Field::inst('dognet_dockalplan_progress.summastage'),
		Field::inst('dognet_dockalplan_progress.sumchfstage'),
		Field::inst('dognet_dockalplan_progress.zadolsum_chf'),
		Field::inst('dognet_dockalplan_progress.zadolsum_stage'),
		//
		Field::inst('sp_objects.nameobjectshot'),
		//
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		//
		Field::inst('dognet_spispol.ispolnameshot'),
		Field::inst('dognet_spispol.ispolnamefull'),
		//
		Field::inst('dognet_docbase.koddoc'),
		Field::inst('dognet_docbase.koddened'),
		Field::inst('dognet_docbase.docnumber'),
		Field::inst('dognet_docbase.docnameshot'),
		Field::inst('dognet_docbase.docnamefullm'),
		Field::inst('dognet_docbase.kodstatus'),
		//
		Field::inst('dognet_spdened.koddened'),
		Field::inst('dognet_spdened.html_code'),
		Field::inst('dognet_spdened.short_code')
	)
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	->on('preGet', function ($editor, $id) {
		$editor->where(function ($q) {
			$q->where(function ($r1) {
				$r1->where('dognet_docbase.kodstatus', '245381842747296'); // Статус договора "Текущий"
				$r1->or_where('dognet_docbase.kodstatus', '245381842145343'); // Статус договора "Проект"
				$r1->or_where('dognet_docbase.kodstatus', '245267756667430'); // Статус договора "Подписание"
			});
			$q->where(function ($r2) {
				$r2->where('dognet_dockalplan_progress.srokstage_date', 'DATE_ADD(NOW(), INTERVAL 1 DAY)', '<', false);
				$r2->and_where('dognet_dockalplan_progress.dateplan', 'DATE_ADD(NOW(), INTERVAL 1 DAY)', '<', false);
			});
		});
	})
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	->leftJoin('dognet_dockalplan_progress', 'dognet_dockalplan_progress.kodkalplan', '=', 'dognet_dockalplan.kodkalplan')
	->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_dockalplan.kodobject')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_docbase.kodispol')

	->where('dognet_docbase.kodispol', $__KODISPOL, '=')
	->where('dognet_dockalplan.koddel', '99', '!=')
	->where('dognet_dockalplan_progress.zadolsum_stage', '0.0', '>')
	->where('dognet_docbase.koddel', '99', '!=')

	->where('dognet_dockalplan_progress.srokstage_date', 'NULL', '!=')
	->where('dognet_dockalplan_progress.srokstage_date', '0000-00-00', '!=')

	->process($_POST)
	->json();
