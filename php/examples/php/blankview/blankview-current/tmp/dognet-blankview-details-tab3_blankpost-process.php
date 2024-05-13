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
$__kodblankwork = $_SESSION['uniqueID'];
// $__kodblankwork = "245847329098834";

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
Editor::inst($db, 'dognet_blankdocpost')
	->fields(
		Field::inst('dognet_blankdocpost.koddel'),
		Field::inst('dognet_blankdocpost.kodblankwork'),
		Field::inst('dognet_blankdocpost.kodblankpost'),
		Field::inst('dognet_blankdocpost.kodispol'),
		Field::inst('dognet_blankdocpost.kodispolruk'),
		Field::inst('dognet_blankdocpost.kodtipblank'),
		Field::inst('dognet_blankdocpost.kodorgzakaz'),
		Field::inst('dognet_blankdocpost.kodorgispol'),
		Field::inst('dognet_blankdocpost.kodzakaz'),
		Field::inst('dognet_blankdocpost.namedocblank'),
		Field::inst('dognet_blankdocpost.csummadocopl'),
		Field::inst('dognet_blankdocpost.csummaopl1usl'),
		Field::inst('dognet_blankdocpost.csummaopl2usl'),
		Field::inst('dognet_blankdocpost.cnumberoplday2usl'),
		Field::inst('dognet_blankdocpost.cnumberoplday3usl'),
		Field::inst('dognet_blankdocpost.ctextoplotherusl'),
		Field::inst('dognet_blankdocpost.nameendcontact'),
		Field::inst('dognet_blankdocpost.namefistcontact'),
		Field::inst('dognet_blankdocpost.namesecondcontact'),
		Field::inst('dognet_blankdocpost.namedoljcontact'),
		Field::inst('dognet_blankdocpost.numbertelrab'),
		Field::inst('dognet_blankdocpost.numbertelmob'),
		Field::inst('dognet_blankdocpost.numbertelfax'),
		Field::inst('dognet_blankdocpost.nameemail'),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
		Field::inst('dognet_spispolruk.kodispolruk'),
		Field::inst('dognet_spispolruk.ispolruknamefull'),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
		Field::inst('dognet_spispol.kodispol'),
		Field::inst('dognet_spispol.ispolnamefull'),
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.nameshort')
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
	)
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	//
	->on('preGet', function ($editor, $id) use ($__kodblankwork) {
		$editor->where(function ($q) use ($__kodblankwork) {
			$q->where('dognet_blankdocpost.kodblankwork', $__kodblankwork);
			$q->and_where('dognet_blankdocpost.koddel', '99', '!=');
		});
	})
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	//
	->leftJoin('dognet_spispolruk', 'dognet_spispolruk.kodispolruk', '=', 'dognet_blankdocpost.kodispolruk')
	->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_blankdocpost.kodispol')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_blankdocpost.kodzakaz')

	->process($_POST)
	->json();
