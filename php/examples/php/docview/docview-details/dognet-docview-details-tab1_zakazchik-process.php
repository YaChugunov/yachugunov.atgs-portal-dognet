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
		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		Field::inst('sp_contragents.director_fio'),
		Field::inst('sp_contragents.zakfio'),
		Field::inst('sp_contragents.director_firstname'),
		Field::inst('sp_contragents.director_lastname'),
		Field::inst('sp_contragents.director_post'),
		Field::inst('sp_contragents.tel_official'),
		Field::inst('sp_contragents.fax_official'),
		Field::inst('sp_contragents.email_official'),
		Field::inst('sp_contragents.web_official'),
		Field::inst('sp_contragents.tel1'),
		Field::inst('sp_contragents.tel2'),
		Field::inst('sp_contragents.inn'),
		Field::inst('sp_contragents.kpp'),
		Field::inst('sp_contragents.address_postal'),
		Field::inst('sp_contragents.address_legal'),
		Field::inst('sp_contragents.zakbankch')
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
	->process($_POST)
	->json();
