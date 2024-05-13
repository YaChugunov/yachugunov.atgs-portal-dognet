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


if ( ! isset($_POST['kodchfsubpodr']) || ! is_numeric($_POST['kodchfsubpodr']) ) {
	echo json_encode( [ "data" => [] ] );
}
else { 
$__kodchfsubpodr= $_POST['kodchfsubpodr']; 
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_docavsubpodr' )
  ->fields(
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst( 'dognet_docavsubpodr.kodchfsubpodr' )
			->options( Options::inst()
				->table( 'dognet_docchfsubpodr' )
				->value( 'kodchfsubpodr' )
				->label( array('kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr') )
				->render( function ( $row ) use ($__kodchfsubpodr) {
					return ("Счет-фактура : ".$row['numberchfsubpodr']); 
					})
				->where(function ($q) use ($__kodchfsubpodr)  { 
					$q->where('kodchfsubpodr', $__kodchfsubpodr, '=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Объект обязателен' )	
			) ), 
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),  
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
    Field::inst( 'dognet_docavsubpodr.kodavsubpodr' ),
    Field::inst( 'dognet_docavsubpodr.dateavsubpodr' ),
    Field::inst( 'dognet_docavsubpodr.sumavsubpodr' ), 
    Field::inst( 'dognet_docchfsubpodr.koddocsubpodr' ), 
    Field::inst( 'dognet_docchfsubpodr.kodchfsubpodr' ), 
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
	->leftJoin( 'dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docoplchfsubpodr.kodchfsubpodr' )
	->leftJoin( 'dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docchfsubpodr.koddocsubpodr' )
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
  ->where( 'dognet_docoplchfsubpodr.kodchfsubpodr', $__kodchfsubpodr )
  ->process( $_POST )
  ->json();
}



?>