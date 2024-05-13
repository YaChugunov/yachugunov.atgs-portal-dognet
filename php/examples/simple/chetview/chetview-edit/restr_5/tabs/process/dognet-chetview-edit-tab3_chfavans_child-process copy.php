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
function nextKodavans() {
	$query = mysqlQuery("SELECT MAX(kodavans) as lastKod FROM dognet_chfavans ORDER BY id DESC");
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
function updateFields_chfavans ( $db, $action, $id, $values ) { 
	$__nextKodavans = nextKodavans();
	if ( $action == 'CRT' ) { 
		$db->update( 'dognet_chfavans', array(
			'kodavans'			=>	$__nextKodavans 
		), array( 'id' => $id ));
	}
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция пересчета задолженности по счету-фактуре (kodchfact) 
# для таблицы счетов-фактур 'dognet_kalplanchf'
# ----- ----- ----- 
function update_chfZadol( $db, $id, $kodchfact ) { 

		$_QRY_1 = $db->sql( "SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=".$kodchfact )->fetchAll();
		if ( $_QRY_1 ) { $__summachfact = $_QRY_1[0]['chetfsumma']; }
	// ----- 
		$_QRY_2 = $db->sql( "SELECT SUM(summaoplav) as sumoplav FROM dognet_chfavans WHERE kodchfact=".$kodchfact )->fetchAll();
		if ( $_QRY_2 ) { $__summaoplav = $_QRY_2[0]['sumoplav']; }
	// ----- 
	// Пересчитываем сумму задолженности по счету-фактуре
		$_NEW_sumzadolchfact = $__summachfact - (SUMMA_OPLATCHF($kodchfact) + $__summaoplav);
	// ----- 
		$db->update( 'dognet_kalplanchf_zadol', array(
			'chetfsumzadol'		=>	$_NEW_sumzadolchfact 
		), array( 'kodchfact' => $kodchfact ));

}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция пересчета задолженности по счетам-фактурам (NOT kodchfact) 
# отличным от выбранного для таблицы счетов-фактур 'dognet_kalplanchf'
# ----- ----- ----- 
function update_otherChfZadol( $db, $id, $kodkalplan, $kodchfact ) { 

	$_QRY = mysqlQuery( "SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$kodkalplan );
	while( $_ROW = mysqli_fetch_assoc($_QRY) ) {

		$kod = $_ROW['kodchfact'];
	// ----- 
		$_QRY_1 = $db->sql( "SELECT chetfsumma FROM dognet_kalplanchf WHERE kodchfact=".$kod )->fetchAll();
		if ( $_QRY_1 ) { $__summachfact = $_QRY_1[0]['chetfsumma']; }
	// ----- 
		$_QRY_2 = $db->sql( "SELECT SUM(summaopl) as sumoplata FROM dognet_oplatachf WHERE kodchfact=".$kod )->fetchAll();
		if ( $_QRY_2 ) { $__summaopl = $_QRY_2[0]['sumoplata']; }
	// ----- 
		$_QRY_3 = $db->sql( "SELECT SUM(summaoplav) as sumavans FROM dognet_chfavans WHERE kodchfact=".$kod )->fetchAll();
		if ( $_QRY_3 ) { $__sumavans = $_QRY_3[0]['sumavans']; }
	// ----- 
		$_NEW_sumzadolchfact = $__summachfact - ($__summaopl + $__sumavans);
	// ----- 
		if ($kod != $kodchfact) {
			$db->update( 'dognet_kalplanchf_zadol', array(
				'chetfsumzadol'		=>	$_NEW_sumzadolchfact 
			), array( 'kodchfact' => $kod ));
		}
		
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
$__kodchfact = $_POST['kodchfact']; 
$__kodkalplan = $_POST['kodkalplan']; 
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_chfavans' )
  ->fields(
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst( 'dognet_chfavans.kodchfact' )
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
    Field::inst( 'dognet_docavans.kodavans' ),
    Field::inst( 'dognet_docavans.summaavans' ),
    Field::inst( 'dognet_docavans.dateavans' )
    	->set( Field::SET_EDIT )
        ->validator( Validate::dateFormat(
            'd.m.Y',
            ValidateOptions::inst()
                ->allowEmpty( false ) ) )
        ->getFormatter( Format::datetime(
            'Y-m-d',
            'd.m.Y'
        ) )
        ->setFormatter( Format::datetime(
            'd.m.Y',
            'Y-m-d'
		) ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
    Field::inst( 'dognet_chfavans.kodavans' ) 
			->options( Options::inst()
				->table( 'dognet_docavans' )
				->value( 'kodavans' )
				->label( array('koddoc', 'kodavans', 'summaavans', 'dateavans') )
				->render( function ( $row ) use ($__kodkalplan) {
					return ("Аванс ID : ".$row['kodavans']." от ".$row['dateavans']." / ".$row['summaavans']); 
					})
				->where(function ($q) use ($__kodkalplan)  { 
					$q->where('koddoc', $__kodkalplan, '=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Объект обязателен' )	
			) ), 
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
    Field::inst( 'dognet_chfavans.summaoplav' ), 
    Field::inst( 'dognet_kalplanchf.kodkalplan' ), 
    Field::inst( 'dognet_dockalplan.kodkalplan' ), 
    Field::inst( 'dognet_docbase.koddoc' ), 
    Field::inst( 'dognet_docbase.koddened' ), 
    Field::inst( 'dognet_spdened.html_code' ), 
    Field::inst( 'dognet_spdened.short_code' ) 
  )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
			->on( 'preEdit', function ( $editor, $id, $values ) { 
				update_chfZadol( $editor->db(), $id, $_POST['kodchfact'] );
			} )
			->on( 'postCreate', function ( $editor, $id, $values, $row ) { 
				updateFields_chfavans( $editor->db(), 'CRT', $id, $values );
				update_chfZadol( $editor->db(), $id, $_POST['kodchfact'] );
				update_otherChfZadol( $editor->db(), $id, $_POST['kodkalplan'], $_POST['kodchfact'] );
			} )
			->on( 'postEdit', function ( $editor, $id, $values, $row ) {
				updateFields_chfavans( $editor->db(), 'UPD', $id, $values );
				update_chfZadol( $editor->db(), $id, $_POST['kodchfact'] );
				update_otherChfZadol( $editor->db(), $id, $_POST['kodkalplan'], $_POST['kodchfact'] );
			} )
			->on( 'postRemove', function ( $editor, $id, $values ) {
				updateFields_chfavans( $editor->db(), 'UPD', $id, $values );
				update_chfZadol( $editor->db(), $id, $_POST['kodchfact'] );
				update_otherChfZadol( $editor->db(), $id, $_POST['kodkalplan'], $_POST['kodchfact'] );
			} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->leftJoin( 'dognet_kalplanchf', 'dognet_kalplanchf.kodchfact', '=', 'dognet_chfavans.kodchfact' )
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan' )
	->leftJoin( 'dognet_docavans', 'dognet_docavans.kodavans', '=', 'dognet_chfavans.kodavans' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
  ->where( 'dognet_kalplanchf.kodchfact', $__kodchfact )
  ->process( $_POST )
  ->json();
}



?>