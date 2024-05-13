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
function nextKodavsubpodr() {
	$query = mysqlQuery("SELECT MAX(kodavsubpodr) as lastKod FROM dognet_docavsubpodr ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#	ОПИСАНИЕ : Сумма всех авансов зачтенных в счет-фактуру $kodchfsubpodr
#
#
function SUMMA_AVANSCHF_SUBPODR ($kodchfsubpodr) {
	$_QRY = mysqlQuery( "SELECT SUM(sumavsubpodr) as SummaAvansChf FROM dognet_docavsubpodr WHERE kodchfsubpodr=".$kodchfsubpodr );
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ( $_QRY ) {
		$__SummaAvansChf = $_ROW	['SummaAvansChf'];
	}
	else {
		$__SummaAvansChf = "";
	}
	return $__SummaAvansChf;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ОПИСАНИЕ : Сумма всех оплат счета-фактуры $kodchfsubpodr
#
#
function SUMMA_OPLATCHF_SUBPODR ($kodchfsubpodr) {
	$_QRY = mysqlQuery( "SELECT SUM(sumoplchfsubpodr) as SummaOplatChf FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr=".$kodchfsubpodr );
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ( $_QRY ) {
		$__SummaOplatChf = $_ROW['SummaOplatChf'];
	}
	else {
		$__SummaOplatChf = "";
	}
	return $__SummaOplatChf;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function updateFields_docavsubpodr ( $db, $action, $id, $values ) {

// ID счета фактуры
	$_QRY_1 = $db->sql( "SELECT kodchfsubpodr FROM dognet_docavsubpodr WHERE id=".$id )->fetchAll();
	if ( $_QRY_1 ) {
		$__kodchfsubpodr = $_QRY_1[0]['kodchfsubpodr'];
	}
	else {
		$__kodchfsubpodr = "";
	}
// -----
// Сумма счета-фактуры
	$_QRY_2 = $db->sql( "SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE kodchfsubpodr=".$__kodchfsubpodr )->fetchAll();
	if ( $_QRY_2 ) { $__sumchfsubpodr = $_QRY_2[0]['sumchfsubpodr']; }
// -----

	if ( $action == 'CRT' ) {
		$__nextKodavsubpodr = nextKodavsubpodr();
		$db->update( 'dognet_docavsubpodr', array(
			'kodavsubpodr'			=>	$__nextKodavsubpodr
		), array( 'id' => $id ));
		$_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (SUMMA_OPLATCHF_SUBPODR ($__kodchfsubpodr) + SUMMA_AVANSCHF_SUBPODR ($__kodchfsubpodr));
		$db->update( 'dognet_docchfsubpodr', array(
			'sumzadolchfsubpodr'		=>	$_NEW_sumzadolchfsubpodr
		), array( 'kodchfsubpodr' => $__kodchfsubpodr ));
	}

	if ( $action == 'UPD' ) {
		$_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (SUMMA_OPLATCHF_SUBPODR ($__kodchfsubpodr) + SUMMA_AVANSCHF_SUBPODR ($__kodchfsubpodr));
		$db->update( 'dognet_docchfsubpodr', array(
			'sumzadolchfsubpodr'		=>	$_NEW_sumzadolchfsubpodr
		), array( 'kodchfsubpodr' => $__kodchfsubpodr ));
	}
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = $_GET['uniqueID'];
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
$__koddocsubpodr= $_POST['koddocsubpodr'];
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_docavsubpodr' )
  ->fields(
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_docavsubpodr.kodchfsubpodr' )
			->options( Options::inst()
				->table( 'dognet_docchfsubpodr' )
				->value( 'kodchfsubpodr' )
				->label( array('kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr') )
				->render( function ( $row ) use ($__koddocsubpodr) {
					return ("Счет-фактура : ".$row['numberchfsubpodr']);
					})
				->where(function ($q) use ($__koddocsubpodr)  {
					$q->where('kodchfsubpodr', $__koddocsubpodr, '=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Объект обязателен' )
			) ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_docavsubpodr.kodavsubpodr' ),
    Field::inst( 'dognet_docavsubpodr.dateavsubpodr' )
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
    Field::inst( 'dognet_docavsubpodr.sumavsubpodr' ),
    Field::inst( 'dognet_docchfsubpodr.koddocsubpodr' ),
    Field::inst( 'dognet_docchfsubpodr.kodchfsubpodr' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_docbase.koddoc' ),
    Field::inst( 'dognet_docbase.koddened' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_spdened.koddened' ),
    Field::inst( 'dognet_spdened.html_code' ),
    Field::inst( 'dognet_spdened.short_code' )
  )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postCreate', function ( $editor, $id, $values, $row ) {
		updateFields_docavsubpodr( $editor->db(), 'CRT', $id, $values );
	} )
	->on( 'postEdit', function ( $editor, $id, $values, $row ) {
		updateFields_docavsubpodr( $editor->db(), 'UPD', $id, $values );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsubpodr.kodchfsubpodr' )
	->leftJoin( 'dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docchfsubpodr.koddocsubpodr' )
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
  ->where( 'dognet_docavsubpodr.koddocsubpodr', $__koddocsubpodr )
  ->process( $_POST )
  ->json();
}



?>