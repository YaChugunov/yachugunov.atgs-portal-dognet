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


if ( ! isset($_POST['koddocsubpodr']) || ! is_numeric($_POST['koddocsubpodr']) ) {
	echo json_encode( [ "data" => [] ] );
}
else { 
$__koddocsubpodr = $_POST['koddocsubpodr']; 
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_docchfsubpodr' )
  ->fields(
    Field::inst( 'dognet_docchfsubpodr.numberchfsubpodr' ),  
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst( 'dognet_docchfsubpodr.koddocsubpodr' )
			->options( Options::inst()
				->table( 'dognet_docsubpodr' )
				->value( 'koddocsubpodr' )
				->label( array('koddoc', 'koddocsubpodr', 'numberdocsubpodr', 'datedocsubpodr') )
				->render( function ( $row ) use ($__koddocsubpodr) {
					return ("Договор : ".$row['numberdocsubpodr']); 
					})
				->where(function ($q) use ($__koddocsubpodr)  { 
					$q->where('koddocsubpodr', $__koddocsubpodr, '=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Объект обязателен' )	
			) ), 
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),  
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
    Field::inst( 'dognet_docchfsubpodr.kodchfsubpodr' ),
    Field::inst( 'dognet_docchfsubpodr.datechfsubpodr' ),
    Field::inst( 'dognet_docchfsubpodr.sumchfsubpodr' ), 
    Field::inst( 'dognet_docsubpodr.koddoc' ), 
    Field::inst( 'dognet_docsubpodr.koddocsubpodr' ), 
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
	->leftJoin( 'dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docchfsubpodr.koddocsubpodr' )
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	->join(
    Mjoin::inst( 'dognet_docoplchfsubpodr' )
      ->link( 'dognet_docoplchfsubpodr.kodchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr' )
      ->field(
        Field::inst( 'kodchfsubpodr' )
    )
  )
  ->where( 'dognet_docchfsubpodr.koddocsubpodr', $__koddocsubpodr )
  ->process( $_POST )
  ->json();
}



?>