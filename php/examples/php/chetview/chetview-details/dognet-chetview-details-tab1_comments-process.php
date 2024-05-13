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
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
$__startDateIn = $_SESSION['in_startTableDate'];
$__endDateIn = $_SESSION['in_endTableDate'];
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
Editor::inst( $db, 'dognet_docbase' )
	->fields(
		Field::inst( 'dognet_docbase.koddel' ),  
		Field::inst( 'dognet_docbase.docnumber' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( '№ !?' )	
			) ),
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
		Field::inst( 'dognet_docbase.comments' ) 
	)
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
//
	->on( 'preGet', function ( $editor, $id ) use ($__uniqueID) {
		$editor->where( function ( $q ) use ($__uniqueID) {
		    $q->where( 'dognet_docbase.koddoc', $__uniqueID);
		    $q->and_where( 'dognet_docbase.koddel', '99', '!=' );
		} );
	} )
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
//
	->process( $_POST )
	->json();
	
