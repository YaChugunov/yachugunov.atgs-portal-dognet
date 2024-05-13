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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
#  
# 
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
Editor::inst($db, 'dognet_docbase')
	->fields(
		Field::inst('dognet_docbase.koddel'),
		Field::inst('dognet_docbase.docnumber'),
		Field::inst('dognet_docbase.docnameshot'),
		Field::inst('dognet_docbase.koddoc'),
		Field::inst('dognet_docbase.kodstatus'),
		Field::inst('dognet_docbase.daynachdoc'),
		Field::inst('dognet_docbase.monthnachdoc'),
		Field::inst('dognet_docbase.yearnachdoc'),
		Field::inst('dognet_docbase.dayenddoc'),
		Field::inst('dognet_docbase.monthenddoc'),
		Field::inst('dognet_docbase.yearenddoc'),
		Field::inst('dognet_docbase.docsumma'),
		Field::inst('dognet_docbase.docnamefullm'),

		Field::inst('dognet_spstatus.kodstatus'),
		Field::inst('dognet_spstatus.statusnameshot'),
		Field::inst('dognet_spstatus.statusnamefull'),

		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),

		Field::inst('sp_contragents_agent.kodcontragent'),
		Field::inst('sp_contragents_agent.nameshort'),
		Field::inst('sp_contragents_agent.namefull'),

		Field::inst('dognet_sptipdog.kodtip'),
		Field::inst('dognet_sptipdog.nametip'),

		Field::inst('sp_objects.kodobject'),
		Field::inst('sp_objects.nameobjectshot'),
		Field::inst('sp_objects.nameobjectlong'),

		Field::inst('dognet_spispol.kodispol'),
		Field::inst('dognet_spispol.ispolnameshot'),
		Field::inst('dognet_spispol.ispolnamefull')

	)
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	//
	->on('preGet', function ($editor, $id) {
		$editor->where(function ($q) {
			$q->where('dognet_docbase.koddel', '99', '!=');
		});
	})
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	//
	->leftJoin('dognet_spstatus', 'dognet_spstatus.kodstatus', '=', 'dognet_docbase.kodstatus')
	->leftJoin('dognet_sptipdog', 'dognet_sptipdog.kodtip', '=', 'dognet_docbase.kodtip')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_docbase.kodobject')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
	->leftJoin('sp_contragents as sp_contragents_agent', 'sp_contragents_agent.kodcontragent', '=', 'dognet_docbase.kodagent')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_docbase.kodispol')
	->process($_POST)
	->json();
