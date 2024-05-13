<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT']."/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
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
require( $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_datatables-php-api-editor/DataTables.php" );
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
Editor::inst( $db, 'dognet_reports_zadolchf' )
	->fields(
		Field::inst( 'dognet_reports_zadolchf.koddel' ), 
		Field::inst( 'dognet_reports_zadolchf.koddoc' ), 
		Field::inst( 'dognet_reports_zadolchf.kodkalplan' ), 
		Field::inst( 'dognet_reports_zadolchf.kodchfact' ), 
		Field::inst( 'dognet_reports_zadolchf.chetfnumber' ), 
		Field::inst( 'dognet_reports_zadolchf.chetfdate' ), 
		Field::inst( 'dognet_reports_zadolchf.chetfsumma' ), 
		Field::inst( 'dognet_reports_zadolchf.summaoplav' ), 
		Field::inst( 'dognet_reports_zadolchf.summaopl' ), 
		Field::inst( 'dognet_reports_zadolchf.summazadol' ), 
		Field::inst( 'dognet_reports_zadolchf.dateopl' ), 
		Field::inst( 'dognet_reports_zadolchf.comment' ) 
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
//
	->on( 'preGet', function ( $editor, $id ) {
		$editor->where( function ( $q ) {
		    $q->where( 'dognet_reports_zadolchf.koddel', '99', '!=' );
		} );
	} )
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
//
	->process( $_POST )
	->json();
	
