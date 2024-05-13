<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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
#
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
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;
// Build our Editor instance and process the data coming from _POST
Editor::inst($db, 'dognet_reports_zadolchf_ondate')
	->fields(
		Field::inst('dognet_reports_zadolchf_ondate.koddel'),
		Field::inst('dognet_reports_zadolchf_ondate.koddoc'),
		Field::inst('dognet_reports_zadolchf_ondate.kodkalplan'),
		Field::inst('dognet_reports_zadolchf_ondate.kodchfact'),
		Field::inst('dognet_reports_zadolchf_ondate.chetfnumber'),
		Field::inst('dognet_reports_zadolchf_ondate.chetfdate')
			->set(Field::SET_EDIT)
			->validator(Validate::dateFormat(
				'd.m.Y',
				ValidateOptions::inst()
					->allowEmpty(false)
			))
			->getFormatter(Format::datetime(
				'Y-m-d',
				'd.m.Y'
			))
			->setFormatter(Format::datetime(
				'd.m.Y',
				'Y-m-d'
			)),
		Field::inst('dognet_reports_zadolchf_ondate.chetfsumma'),
		Field::inst('dognet_reports_zadolchf_ondate.summaoplav'),
		Field::inst('dognet_reports_zadolchf_ondate.summaopl'),
		Field::inst('dognet_reports_zadolchf_ondate.summazadol'),
		Field::inst('dognet_reports_zadolchf_ondate.comment'),
		// --- --- --- --- ---
		Field::inst('dognet_docbase.koddoc'),
		Field::inst('dognet_docbase.docnumber'),
		Field::inst('dognet_docbase.docnameshot'),
		Field::inst('dognet_docbase.kodzakaz'),
		Field::inst('dognet_docbase.kodobject'),
		Field::inst('dognet_docbase.koddened'),
		Field::inst('dognet_docbase.kodstatuszdl'),
		Field::inst('dognet_docbase.numberchet'),
		// --- --- --- --- ---
		Field::inst('dognet_dockalplan.kodkalplan'),
		Field::inst('dognet_dockalplan.numberstage'),
		Field::inst('dognet_dockalplan.nameshotstage'),
		Field::inst('dognet_dockalplan.srokopl'),
		// --- --- --- --- ---
		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.namefull'),
		Field::inst('sp_contragents.nameshort'),
		// --- --- --- --- ---
		Field::inst('sp_objects.kodobject'),
		Field::inst('sp_objects.nameobjectlong'),
		Field::inst('sp_objects.nameobjectshot'),
		// --- --- --- --- ---
		Field::inst('dognet_spdened.koddened'),
		Field::inst('dognet_spdened.html_code'),
		Field::inst('dognet_spdened.short_code')
		//
		//
	)
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('preGet', function ($editor, $id) {
		$editor->where(function ($q) {
			$q->where('dognet_reports_zadolchf_ondate.koddel', '99', '!=');
			$q->and_where('dognet_reports_zadolchf_ondate.koddoc', '', '!=');
			$q->and_where('dognet_docbase.numberchet', '', '!=');
		});
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_reports_zadolchf_ondate.koddoc')
	->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_reports_zadolchf_ondate.kodkalplan')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_docbase.kodobject')
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
	->process($_POST)
	->json();
