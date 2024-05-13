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
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = "245847329098834";

# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# 
// Вытаскиваем идентификатор календарного плана 
// 	$query = mysqlQuery("SELECT inbox_docID FROM mailbox_incoming WHERE id=".$currID);
// 	$row = mysqli_fetch_assoc($query);
// 	$currDocID = $row['inbox_docID'];
// 	$_SESSION['editedInboxDocID'] = $currDocID;
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
Editor::inst( $db, 'dognet_doczayv' )
	->fields(
// 		Field::inst( 'dognet_doczayvchet.kodzayv' ), 
		Field::inst( 'dognet_doczayv.koddoc' ), 
		Field::inst( 'dognet_doczayv.kodzayv' ), 
		Field::inst( 'dognet_doczayv.kodzayvtel' ), 
		Field::inst( 'dognet_doczayv.kodtipzayv' ), 
		Field::inst( 'dognet_doczayv.kodtipzayvall' ), 
		Field::inst( 'dognet_doczayv.kodispol' ), 
		Field::inst( 'dognet_doczayv.numberzayv' ), 
		Field::inst( 'dognet_doczayv.datezayv' ), 
		Field::inst( 'dognet_doczayv.namerabfilespec' ),

// 		Field::inst( 'dognet_doczayvchet.kodzayvchet' ), 
// 		Field::inst( 'dognet_doczayvchetf.kodzayvchetf' ),   

		Field::inst( 'dognet_spispol.ispolnameshot' ),  
		Field::inst( 'dognet_spzayvtel.namezayvtelshot' ),  
		Field::inst( 'dognet_sptipzayv.namezayvshot' ), 
		Field::inst( 'dognet_sptipzayvall.nametipzayvshotall' ) 

	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->on( 'preGet', function ( $editor, $id ) use ($__uniqueID) {
		$editor->where( function ( $q ) use ($__uniqueID) {
		    $q->where( 'dognet_doczayv.koddoc', $__uniqueID);
		    $q->and_where( 'dognet_doczayv.koddel', "99", "!=");
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->leftJoin( 'dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_doczayv.kodispol' )
	->leftJoin( 'dognet_sptipzayv', 'dognet_sptipzayv.kodtipzayv', '=', 'dognet_doczayv.kodtipzayv' )
	->leftJoin( 'dognet_sptipzayvall', 'dognet_sptipzayvall.kodtipzayvall', '=', 'dognet_doczayv.kodtipzayvall' )
	->leftJoin( 'dognet_spzayvtel', 'dognet_spzayvtel.kodzayvtel', '=', 'dognet_doczayv.kodzayvtel' )

// 	->leftJoin( 'dognet_doczayvchet', 'dognet_doczayvchet.kodzayv', '=', 'dognet_doczayv.kodzayv' )
// 	->leftJoin( 'dognet_doczayvchetf', 'dognet_doczayvchetf.kodzayvchet', '=', 'dognet_doczayvchet.kodzayvchet' )
	->join(
		Mjoin::inst( 'dognet_doczayvchet' )
		->link( 'dognet_doczayvchet.kodzayv', 'dognet_doczayv.kodzayv' )
		->fields(
			Field::inst( 'kodzayv' ), 
			Field::inst( 'kodzayvchet' )  
		) 
	)
	->process( $_POST )
	->json();
	
