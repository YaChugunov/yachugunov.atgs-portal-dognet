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
	$query1 = mysqlQuery("SELECT koddened FROM dognet_docbase WHERE koddoc=".$__uniqueID);
	$row1 = mysqli_fetch_assoc($query1);
	$__koddened = $row1['koddened'];
	$query2 = mysqlQuery("SELECT html_code FROM dognet_spdened WHERE koddened=".$__koddened);
	$row2 = mysqli_fetch_assoc($query2);
	$__dened = $row2['html_code'];
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
Editor::inst( $db, 'dognet_dockalplan' )
  ->fields(
      Field::inst( 'dognet_dockalplan.koddoc' ), 
      Field::inst( 'dognet_dockalplan.kodkalplan' )->set( false ),
      Field::inst( 'dognet_dockalplan.nameshotstage' ), 
      Field::inst( 'dognet_dockalplan.numberstage' ), 
      Field::inst( 'dognet_dockalplan.summastage' ), 
      Field::inst( 'dognet_dockalplan.srokstage' ), 
      Field::inst( 'dognet_dockalplan.dateplan' ),  
      Field::inst( 'dognet_kalplanchf.kodchfact' ), 
      Field::inst( 'dognet_kalplanchf.chetfnumber' ), 
      Field::inst( 'dognet_kalplanchf.chetfdate' ), 
      Field::inst( 'dognet_kalplanchf.chetfsumma' ), 
      Field::inst( 'dognet_docbase.koddened' ), 
      Field::inst( 'dognet_spdened.koddened' ), 
      Field::inst( 'dognet_spdened.html_code' ), 
      Field::inst( 'dognet_spdened.short_code' ) 
  )
	->on( 'preGet', function ( $editor, $id ) use ($__uniqueID) {
		$editor->where( function ( $q ) use ($__uniqueID) {
			$q->where( 'dognet_dockalplan.koddoc', $__uniqueID);
			$q->and_where( 'dognet_dockalplan.koddel', '99', '!=');
		} );
	} )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	->leftJoin( 'dognet_kalplanchf', 'dognet_kalplanchf.kodkalplan', '=', 'dognet_dockalplan.kodkalplan' )
/*
	->join(
    Mjoin::inst( 'dognet_oplatachf' )
      ->link( 'dognet_dockalplan.kodkalplan', 'dognet_kalplanchf.kodkalplan' )
      ->link( 'dognet_oplatachf.kodchfact', 'dognet_kalplanchf.kodchfact' )
      ->field(
        Field::inst( 'kodchfact' )
    )
  )
*/
  ->process( $_POST )
  ->json();
