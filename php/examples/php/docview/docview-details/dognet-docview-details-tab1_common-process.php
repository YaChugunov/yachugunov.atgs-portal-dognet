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
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = "245847329098834";
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// if (checkIsItSuperadmin($_SESSION['id'])==1) {
// Делаем запись в системный лог
$_QRY = mysqlQuery("SELECT ID, docnumber FROM dognet_docbase WHERE koddoc=" . $__uniqueID);
$_ROW = mysqli_fetch_assoc($_QRY);
// Все параметры в таблице portal_log_messages
PORTAL_SYSLOG('99940100', '0000001', $_ROW['ID'], $__uniqueID, $_ROW['docnumber'], $_SERVER['PHP_SELF']);
// }
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
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
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;
// Build our Editor instance and process the data coming from _POST
Editor::inst($db, 'dognet_docbase')
	->fields(
		Field::inst('dognet_docbase.koddel'),
		Field::inst('dognet_docbase.docnumber')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('№ !?')
			)),
		Field::inst('dognet_docbase.docnumberSTR'),
		Field::inst('dognet_docbase.docpartnernumberSTR'),
		Field::inst('dognet_docbase.docnameshot')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Поле обязательно для заполнения')
			)),
		Field::inst('dognet_docbase.daynachdoc'),
		Field::inst('dognet_docbase.monthnachdoc'),
		Field::inst('dognet_docbase.yearnachdoc'),
		Field::inst('dognet_docbase.dayenddoc'),
		Field::inst('dognet_docbase.monthenddoc'),
		Field::inst('dognet_docbase.yearenddoc'),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.kodstatus')
			->options(
				Options::inst()
					->table('dognet_spstatus')
					->value('kodstatus')
					->label(array('kodstatus', 'statusnameshot'))
					->order('statusnameshot asc')
					->render(function ($row) {
						return $row['statusnameshot'];
					})
					->where(function ($q) {
						$q->where('statusnameshot', '', '<>');
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Поле обязательно для выбора')
			)),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.kodtip')
			->options(
				Options::inst()
					->table('dognet_sptipdog')
					->value('kodtip')
					->label(array('koddel', 'kodtip', 'nametip'))
					->order('nametip asc')
					->render(function ($row) {
						return $row['nametip'];
					})
					->where(function ($q) {
						$q->where('koddel', '99', '<>');
						$q->where('nametip', '', '<>');
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Поле обязательно для выбора')
			)),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.kodobject')
			->options(
				Options::inst()
					->table('sp_objects')
					->value('kodobject')
					->label(array('kodobject', 'nameobjectshot'))
					->order('nameobjectshot asc')
					->render(function ($row) {
						return $row['nameobjectshot'];
					})
					->where(function ($q) {
						$q->where('koddel', '99', '<>');
						$q->where('useindog', '1');
						$q->where('nameobjectshot', '', '<>');
					})
			),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.kodzakaz')
			->options(
				Options::inst()
					->table('sp_contragents')
					->value('kodcontragent')
					->label(array('kodcontragent', 'nameshort', 'namefull'))
					->order('nameshort asc')
					->render(function ($row) {
						return $row['nameshort'];
					})
					->where(function ($q) {
						$q->where('koddel', '99', '<>');
						$q->where('useindog', '1');
						$q->where('nameshort', '', '<>');
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Поле обязательно для заполнения')
			)),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.docsumma'),
		Field::inst('dognet_docbase.summachf'),
		Field::inst('dognet_docbase.docoplata'),
		Field::inst('dognet_docbase.docavans'),
		Field::inst('dognet_docbase.doczadol'),
		Field::inst('dognet_docbase.docnozak'),
		Field::inst('dognet_docbase.docnamefullm'),
		Field::inst('dognet_docbase.usendssumma')
			->getFormatter(
				function ($val, $data) {
					return $val ? 'с НДС'	: 'без НДС';
				}
			),
		Field::inst('dognet_docbase.usedocruk'),
		Field::inst('dognet_docbase.usedoczayv'),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.kodblankwork'),
		// 		Field::inst( 'dognet_docblankwork.numberblankwork' ),
		// 		Field::inst( 'dognet_docblankwork.nameblankwork' ),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.usecreatekcp'),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_sptipdog.nametip'),
		Field::inst('dognet_spstatus.statusnameshot'),
		Field::inst('sp_objects.kodobject'),
		Field::inst('sp_objects.nameobjectshot'),
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		Field::inst('sp_contragents_agent.nameshort'),
		Field::inst('sp_contragents_agent.namefull'),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spdened.namedenedshot'),
		Field::inst('dognet_spdened.html_code'),
		Field::inst('dognet_spdened.short_code')
	)
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	->on('preGet', function ($editor, $id) use ($__uniqueID) {
		$editor->where(function ($q) use ($__uniqueID) {
			$q->where('dognet_docbase.koddoc', $__uniqueID);
			$q->and_where('dognet_docbase.koddel', '99', '!=');
		});
	})
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	// 	->leftJoin( 'dognet_docblankwork', 'dognet_docblankwork.kodblankwork', '=', 'dognet_docbase.kodblankwork' )
	->leftJoin('dognet_sptipdog', 'dognet_sptipdog.kodtip', '=', 'dognet_docbase.kodtip')
	->leftJoin('dognet_spstatus', 'dognet_spstatus.kodstatus', '=', 'dognet_docbase.kodstatus')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_docbase.kodobject')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
	->leftJoin('sp_contragents as sp_contragents_agent', 'sp_contragents_agent.kodcontragent', '=', 'dognet_docbase.kodagent')
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
	->process($_POST)
	->json();
