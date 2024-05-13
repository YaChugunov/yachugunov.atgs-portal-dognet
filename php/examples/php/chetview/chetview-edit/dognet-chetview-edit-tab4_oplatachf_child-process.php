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
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция формирования нового ID счета-фактуры (kodchfact) 
# для таблицы этапов 'dognet_kalplanchf'
# ----- ----- ----- 
function nextKodoplata() {
	$query = mysqlQuery("SELECT MAX(kodoplata) as lastKod FROM dognet_oplatachf ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция обновления нового номера этапа (numberstage) 
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- ----- 
function updateFields_oplatachf ( $db, $action, $id, $values ) { 
	$__nextKodoplata = nextKodoplata();
	if ( $action == 'CRT' ) { 
		$db->update( 'dognet_oplatachf', array(
			'kodoplata'			=>	$__nextKodoplata 
		), array( 'id' => $id ));
	}
}
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


if ( ! isset($_POST['kodchfact']) || ! is_numeric($_POST['kodchfact']) ) {
	echo json_encode( [ "data" => [] ] );
}
else { 
$__kodchfact= $_POST['kodchfact']; 
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_oplatachf' )
  ->fields(
    Field::inst( 'dognet_oplatachf.comment' ),  
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst( 'dognet_oplatachf.kodchfact' )
			->options( Options::inst()
				->table( 'dognet_kalplanchf' )
				->value( 'kodchfact' )
				->label( array('kodkalplan', 'kodchfact', 'chetfnumber', 'chetfdate') )
				->render( function ( $row ) use ($__kodchfact) {
					return ("Счет-фактура : ".$row['chetfnumber']); 
					})
				->where(function ($q) use ($__kodchfact)  { 
					$q->where('kodchfact', $__kodchfact, '=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Объект обязателен' )	
			) ), 
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),  
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
    Field::inst( 'dognet_oplatachf.kodoplata' ),
    Field::inst( 'dognet_oplatachf.dateopl' ),
    Field::inst( 'dognet_oplatachf.summaopl' ), 
    Field::inst( 'dognet_kalplanchf.kodkalplan' ), 
    Field::inst( 'dognet_dockalplan.kodkalplan' ), 
    Field::inst( 'dognet_docbase.koddoc' ), 
    Field::inst( 'dognet_docbase.koddened' ), 
    Field::inst( 'dognet_spdened.html_code' ), 
    Field::inst( 'dognet_spdened.short_code' ) 
  )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->on( 'postCreate', function ( $editor, $id, $values, $row ) {
		updateFields_oplatachf( $editor->db(), 'CRT', $id, $values );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->leftJoin( 'dognet_kalplanchf', 'dognet_kalplanchf.kodchfact', '=', 'dognet_oplatachf.kodchfact' )
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
  ->where( 'dognet_kalplanchf.kodchfact', $__kodchfact )
  ->process( $_POST )
  ->json();
}



?>