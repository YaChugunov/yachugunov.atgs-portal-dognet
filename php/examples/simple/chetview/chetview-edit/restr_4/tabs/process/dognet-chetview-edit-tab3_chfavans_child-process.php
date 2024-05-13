<?php
#
date_default_timezone_set('Europe/Moscow');
#
# Подключаем конфигурационный файл
# require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
# require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT']."/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$_UNIQUEID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ВАЖНО!!!
# Определяем создан ли договор по шаблону с календарным планом (kodshab=1)
# или без плана (kodshab=2)
# Это определяет будет ли идти привязка в таблицах счетов, оплат и авансов привязка по
# коду этапа (kodkalplan) или по коду договора (koddoc) соответственно
#
	$_QRY_KODSHAB = mysqlQuery("SELECT kodshab FROM dognet_docbase WHERE koddoc=".$_UNIQUEID);
	$_ROW_KODSHAB = mysqli_fetch_assoc($_QRY_KODSHAB);
	$_KODSHAB = $_ROW_KODSHAB['kodshab'];
#
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
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
#
function updateFields_chfavans ( $db, $action_chfavans, $id, $values, $__kodshab, $__uniqueID ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВЫЙ ЗАЧЕТ АВАНСА"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	$_QRY = $db->sql( "SELECT * FROM dognet_chfavans WHERE id=".$id )->fetchAll();
	if ( $_QRY ) {
		$__kodchfact = $_QRY[0]['kodchfact'];
	}
	if ( $action_chfavans == 'CRT' ) {
#
#
		DOCAVANS_PR_OSTATOK_DOC( $db, "chfavans", $id, $action_chfavans );
#
#
		KALPLANCHF_PR_ZADOLG_CHF( $db, "chfavans", $id, $action_chfavans, $__kodchfact );
#
#
		DOCBASE_PR_ZADOLG_DOC( $db, "chfavans", $id, $action_chfavans, $__uniqueID, $__kodshab );
#
#
	}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_chfavans == 'UPD' ) {
#
#
		DOCAVANS_PR_OSTATOK_DOC( $db, "chfavans", $id, $action_chfavans );
#
#
		KALPLANCHF_PR_ZADOLG_CHF( $db, "chfavans", $id, $action_chfavans, $__kodchfact );
#
#
		DOCBASE_PR_ZADOLG_DOC( $db, "chfavans", $id, $action_chfavans, $__uniqueID, $__kodshab );
#
#
	}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "УДАЛИТЬ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_chfavans == 'DEL' ) {
#
#
		DOCAVANS_PR_OSTATOK_DOC( $db, "chfavans", $id, $action_chfavans );
#
#
		KALPLANCHF_PR_ZADOLG_CHF( $db, "chfavans", $id, $action_chfavans, $__kodchfact );
#
#
		DOCBASE_PR_ZADOLG_DOC( $db, "chfavans", $id, $action_chfavans, $__uniqueID, $__kodshab );
#
#
	}
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Вытаскиваем идентификатор валюты договора
#
	$query1 = mysqlQuery("SELECT koddened FROM dognet_docbase WHERE koddoc=".$_UNIQUEID);
	$row1 = mysqli_fetch_assoc($query1);
	$__koddened = $row1['koddened'];
	$query2 = mysqlQuery("SELECT html_code FROM dognet_spdened WHERE koddened=".$__koddened);
	$row2 = mysqli_fetch_assoc($query2);
	$__dened = $row2['html_code'];
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Example PHP implementation used for the index.html example
#
# DataTables PHP library
require( $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_datatables-php-api-editor/DataTables.php" );
# Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;
#
#
if ($_KODSHAB == "1") {
#
#
	if ( ! isset($_POST['kodchfact_chfavans']) || ! is_numeric($_POST['kodchfact_chfavans']) ) {
		echo json_encode( [ "data" => [] ] );
	}
	else {
	$kodchfact = $_POST['kodchfact_chfavans'];
	$kodkalplan = $_POST['kodkalplan_chfavans'];
	// Build our Editor instance and process the data coming from _POST
	Editor::inst( $db, 'dognet_chfavans' )
	  ->fields(
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst( 'dognet_chfavans.kodchfact' )
				->options( Options::inst()
					->table( 'dognet_kalplanchf' )
					->value( 'kodchfact' )
					->label( array('kodkalplan', 'kodchfact', 'chetfnumber', 'chetfdate') )
					->render( function ( $row ) use ($kodchfact) {
						return ("Счет-фактура : ".$row['chetfnumber']);
						})
					->where(function ($q) use ($kodchfact)  {
						$q->where('kodchfact', $kodchfact, '=');
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
					->render( function ( $row ) use ($kodkalplan) {
						return ("Аванс ID : ".$row['kodavans']." от ".$row['dateavans']." / ".$row['summaavans']);
						})
					->where(function ($q) use ($kodkalplan)  {
						$q->where('koddoc', $kodkalplan, '=');
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
				->on( 'postCreate', function ( $editor_chfavans, $id, $values, $row ) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
					updateFields_chfavans( $editor_chfavans->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID );
				} )
				->on( 'postEdit', function ( $editor_chfavans, $id, $values, $row ) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
					updateFields_chfavans( $editor_chfavans->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID );
				} )
				->on( 'preRemove', function ( $editor_chfavans, $id, $values ) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
					updateFields_chfavans( $editor_chfavans->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID );
				} )
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin( 'dognet_kalplanchf', 'dognet_kalplanchf.kodchfact', '=', 'dognet_chfavans.kodchfact' )
		->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan' )
		->leftJoin( 'dognet_docavans', 'dognet_docavans.kodavans', '=', 'dognet_chfavans.kodavans' )
		->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
		->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	  ->where( 'dognet_kalplanchf.kodchfact', $kodchfact )
	  ->process( $_POST )
	  ->json();
	}
#
#
}
#
#
if ($_KODSHAB == "2" OR $_KODSHAB == "0") {

	if ( ! isset($_POST['kodchfact_chfavans']) || ! is_numeric($_POST['kodchfact_chfavans']) ) {
		echo json_encode( [ "data" => [] ] );
	}
	else {
	$kodchfact = $_POST['kodchfact_chfavans'];
	$kodkalplan = $_POST['kodkalplan_chfavans'];
	// Build our Editor instance and process the data coming from _POST
	Editor::inst( $db, 'dognet_chfavans' )
	  ->fields(
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst( 'dognet_chfavans.kodchfact' )
				->options( Options::inst()
					->table( 'dognet_kalplanchf' )
					->value( 'kodchfact' )
					->label( array('kodkalplan', 'kodchfact', 'chetfnumber', 'chetfdate') )
					->render( function ( $row ) use ($kodchfact) {
						return ("Счет-фактура : ".$row['chetfnumber']);
						})
					->where(function ($q) use ($kodchfact)  {
						$q->where('kodchfact', $kodchfact, '=');
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
					->render( function ( $row ) use ($_UNIQUEID) {
						return ("Аванс ID : ".$row['kodavans']." от ".$row['dateavans']." / ".$row['summaavans']);
						})
					->where(function ($q) use ($_UNIQUEID)  {
						$q->where('koddoc', $_UNIQUEID, '=');
						})
				)
				->validator( Validate::notEmpty( ValidateOptions::inst()
					->message( 'Объект обязателен' )
				) ),
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	    Field::inst( 'dognet_chfavans.summaoplav' ),
	    Field::inst( 'dognet_kalplanchf.kodkalplan' ),
	    Field::inst( 'dognet_docbase.koddoc' ),
	    Field::inst( 'dognet_docbase.koddened' ),
	    Field::inst( 'dognet_spdened.html_code' ),
	    Field::inst( 'dognet_spdened.short_code' )
	  )
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				->on( 'postCreate', function ( $editor_chfavans, $id, $values, $row ) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
					updateFields_chfavans( $editor_chfavans->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID );
				} )
				->on( 'postEdit', function ( $editor_chfavans, $id, $values, $row ) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
					updateFields_chfavans( $editor_chfavans->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID );
				} )
				->on( 'preRemove', function ( $editor_chfavans, $id, $values ) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
					updateFields_chfavans( $editor_chfavans->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID );
				} )
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin( 'dognet_kalplanchf', 'dognet_kalplanchf.kodchfact', '=', 'dognet_chfavans.kodchfact' )
		->leftJoin( 'dognet_docavans', 'dognet_docavans.kodavans', '=', 'dognet_chfavans.kodavans' )
		->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_kalplanchf.kodkalplan' )
		->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	  ->where( 'dognet_kalplanchf.kodchfact', $kodchfact )
	  ->process( $_POST )
	  ->json();
	}
#
#
}
#
#
?>