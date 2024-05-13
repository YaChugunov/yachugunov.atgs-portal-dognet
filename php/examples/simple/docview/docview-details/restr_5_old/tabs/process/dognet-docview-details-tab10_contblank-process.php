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
// PORTAL_SYSLOG('99940100', '0000001', $_ROW['ID'], $__uniqueID, $_ROW['docnumber'], $_SERVER['PHP_SELF']);
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
Editor::inst($db, 'dognet_docblankwork')
	->fields(
		Field::inst('dognet_docblankwork.kodblankwork'),
		Field::inst('dognet_docblankwork.numberblankwork'),
		Field::inst('dognet_docblankwork.yearblankwork'),
		Field::inst('dognet_docblankwork.dateblankwork')
			->validator(Validate::dateFormat(
				'd.m.Y',
				ValidateOptions::inst()
					->allowEmpty(true)
			))
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_docblankwork.dateblankorder')
			->validator(Validate::dateFormat(
				'd.m.Y',
				ValidateOptions::inst()
					->allowEmpty(true)
			))
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_docblankwork.dateblankdoc')
			->validator(Validate::dateFormat(
				'd.m.Y',
				ValidateOptions::inst()
					->allowEmpty(true)
			))
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_docblankwork.nametipblankwork'),
		Field::inst('dognet_docblankwork.nameblankwork'),
		Field::inst('dognet_docblankwork.nameorgblankwork'),
		Field::inst('dognet_docblankwork.kodstatusblank'),
		Field::inst('dognet_docblankwork.statusblankwork'),
		Field::inst('dognet_docblankwork.odcomments'),
		Field::inst('dognet_docblankwork.koddoc')
			->options(
				Options::inst()
					->table('dognet_docbase')
					->value('koddoc')
					->label(array('koddoc', 'docnumber', 'docnameshot'))
					->where(function ($q) {
						$q->where('yearnachdoc', date('Y'), '=');
						$q->and_where('numberchet', '', '=');
					})
					->render(function ($row) {
						return "№ " . $row['docnumber'] . " : " . $row['docnameshot'];
					})
			),
		Field::inst('dognet_docblankwork.numberdoccr'),
		Field::inst('dognet_docblankwork.kodzakaz')
			->options(
				Options::inst()
					->table('sp_contragents')
					->value('kodcontragent')
					->label(array('kodcontragent', 'nameshort'))
					->render(function ($row) {
						return $row['nameshort'];
					})
			),
		Field::inst('dognet_docblankwork.kodsubpodr')
			->options(
				Options::inst()
					->table('sp_contragents')
					->value('kodcontragent')
					->label(array('kodcontragent', 'nameshort'))
					->render(function ($row) {
						return $row['nameshort'];
					})
			),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docblankwork.kodispol'),
		Field::inst('dognet_docblankwork.kodispolruk'),
		Field::inst('dognet_docblankwork.kodtipblank'),
		Field::inst('dognet_docblankwork.kodblankdone'),
		Field::inst('dognet_docblankwork.blank_rowID'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_sysdefs_blankstatus.id'),
		Field::inst('dognet_sysdefs_blankstatus.status_description'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_sysdefs_blanktype.id'),
		Field::inst('dognet_sysdefs_blanktype.type_description'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_objects.kodobject'),
		Field::inst('sp_objects.nameobjectshot'),
		Field::inst('sp_objects.nameobjectlong'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spispol.kodispol'),
		Field::inst('dognet_spispol.ispolnameshot'),
		Field::inst('dognet_spispol.ispolnamefull'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spispolruk.kodispolruk'),
		Field::inst('dognet_spispolruk.ispolrukname'),
		Field::inst('dognet_spispolruk.ispolruknamefull'),
		//
		// ::: Включаем в запрос данные из таблицы бланков на поставку (dognet_blankdocpost)
		//
		Field::inst('dognet_blankdocpost.ID'),
		Field::inst('dognet_blankdocpost.nameendcontact'),
		Field::inst('dognet_blankdocpost.namefistcontact'),
		Field::inst('dognet_blankdocpost.namesecondcontact'),
		Field::inst('dognet_blankdocpost.numbertelrab'),
		Field::inst('dognet_blankdocpost.numbertelmob'),
		Field::inst('dognet_blankdocpost.numbertelfax'),
		Field::inst('dognet_blankdocpost.nameemail'),
		Field::inst('dognet_blankdocpost.namedoljcontact'),
		//
		// ::: Включаем в запрос данные из таблицы бланков на ПНР (dognet_blankdocpnr)
		//
		Field::inst('dognet_blankdocpnr.ID'),
		Field::inst('dognet_blankdocpnr.nameendcontact'),
		Field::inst('dognet_blankdocpnr.namefistcontact'),
		Field::inst('dognet_blankdocpnr.namesecondcontact'),
		Field::inst('dognet_blankdocpnr.numbertelrab'),
		Field::inst('dognet_blankdocpnr.numbertelmob'),
		Field::inst('dognet_blankdocpnr.numbertelfax'),
		Field::inst('dognet_blankdocpnr.nameemail'),
		Field::inst('dognet_blankdocpnr.namedoljcontact'),
		Field::inst('dognet_blankdocpnr.dopcontact1'),
		Field::inst('dognet_blankdocpnr.dopcontact2'),
		//
		// ::: Включаем в запрос данные из таблицы бланков на субподряд (dognet_blankdocsub)
		//
		Field::inst('dognet_blankdocsub.ID'),
		Field::inst('dognet_blankdocsub.nameendcontact'),
		Field::inst('dognet_blankdocsub.namefistcontact'),
		Field::inst('dognet_blankdocsub.namesecondcontact'),
		Field::inst('dognet_blankdocsub.numbertelrab'),
		Field::inst('dognet_blankdocsub.numbertelmob'),
		Field::inst('dognet_blankdocsub.numbertelfax'),
		Field::inst('dognet_blankdocsub.nameemail'),
		Field::inst('dognet_blankdocsub.namedoljcontact')
	)
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	#
	->leftJoin('dognet_sysdefs_blankstatus', 'dognet_sysdefs_blankstatus.status_kod', '=', 'dognet_docblankwork.kodstatusblank')
	->leftJoin('dognet_sysdefs_blanktype', 'dognet_sysdefs_blanktype.type_kod', '=', 'dognet_docblankwork.kodtipblank')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_docblankwork.kodispol')
	->leftJoin('dognet_spispolruk', 'dognet_spispolruk.kodispolruk', '=', 'dognet_docblankwork.kodispolruk')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docblankwork.kodzakaz')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docblankwork.kodsubpodr')
	->leftJoin('dognet_blankdocpost', 'dognet_blankdocpost.id', '=', 'dognet_docblankwork.blank_rowID')
	->leftJoin('dognet_blankdocpnr', 'dognet_blankdocpnr.id', '=', 'dognet_docblankwork.blank_rowID')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_blankdocpnr.kodobject')
	->leftJoin('dognet_blankdocsub', 'dognet_blankdocsub.id', '=', 'dognet_docblankwork.blank_rowID')
	->where('dognet_docblankwork.kodblankdone', "1", "=")
	->where('dognet_docblankwork.kodstatusblank', "DO", "=")
	->where('dognet_docblankwork.koddoc', $__uniqueID)
	->process($_POST)
	->json();
