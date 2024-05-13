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
#
function nextKodchfact() {
	$query = mysqlQuery("SELECT MAX(kodchfact) as lastKod FROM dognet_kalplanchf ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_kalplanchf( $db, $action_kalplanchf, $id, $values, $__kodshab, $__uniqueID ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВЫЙ СЧЕТ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_kalplanchf == 'CRT' ) {
#
#
	// Формируем новый идентификатор счета-фактуры (kodchfact)
		$__nextKodchfact = nextKodchfact();
		$db->update( 'dognet_kalplanchf', array(
			'kodchfact'			=>	$__nextKodchfact
		), array( 'id' => $id ));
#
#
		$_QRY = $db->sql( "SELECT chetfnumber FROM dognet_kalplanchf WHERE id=".$id )->fetchAll();
	// Делаем запись в системный лог
	// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940010', '0000001', $id, $__nextKodchfact, $_QRY[0]['chetfnumber'], null);
#
#
		KALPLANCHF_PR_ZADOLG_CHF( $db, "kalplanchf", $id, $action_kalplanchf, NULL );
#
#
		DOCBASE_PR_ZADOLG_DOC( $db, "kalplanchf", $id, $action_kalplanchf, $__uniqueID, $__kodshab );
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
	if ( $action_kalplanchf == 'UPD' ) {
#
#
	// Делаем запись в системный лог
	// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940010', '0000002', $id, null, null, null);
#
#
		KALPLANCHF_PR_ZADOLG_CHF( $db, "kalplanchf", $id, $action_kalplanchf, NULL );
#
#
		DOCBASE_PR_ZADOLG_DOC( $db, "kalplanchf", $id, $action_kalplanchf, $__uniqueID, $__kodshab );
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
	if ( $action_kalplanchf == 'DEL' ) {
#
#
	// Делаем запись в системный лог
	// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940010', '0000003', $id, null, null, null);
#
#
	// Выбираем данные счета-фактуры по ID записи (id) из таблицы счетов dognet_kalplanchf
		$_QRY_1 = $db->sql( "SELECT * FROM dognet_kalplanchf WHERE id=".$id )->fetchAll();
		if ( $_QRY_1 ) {
			$__kodchfact = $_QRY_1[0]['kodchfact'];
			$_QRY_DEL1 = $db->sql( "DELETE FROM dognet_kalplanchf_zadol WHERE kodchfact=".$__kodchfact );
			$_QRY_DEL2 = $db->sql( "DELETE FROM dognet_oplatachf WHERE kodchfact=".$__kodchfact );
			$_QRY_DEL3 = $db->sql( "DELETE FROM dognet_chfavans WHERE kodchfact=".$__kodchfact );
#
#
		KALPLANCHF_PR_ZADOLG_CHF( $db, "kalplanchf", $id, $action_kalplanchf, NULL );
#
#
		DOCBASE_PR_ZADOLG_DOC( $db, "kalplanchf", $id, $action_kalplanchf, $__uniqueID, $__kodshab );
#
#
		}
	}
#
#
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
# Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_kalplanchf' )
  ->fields(
      Field::inst( 'dognet_kalplanchf.kodchfact' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_kalplanchf.kodkalplan' )
				->options( Options::inst()
					->table( 'dognet_dockalplan' )
					->value( 'kodkalplan' )
					->label( array('kodkalplan', 'numberstage', 'nameshotstage') )
					->render( function ( $row ) {
						return "Этап ".$row['numberstage']." - ".$row['nameshotstage'];
						})
					->where(function ($q) use ($_UNIQUEID)  {
						$q->where('koddoc', $_UNIQUEID, '=');
						})
				)
				->validator( Validate::notEmpty( ValidateOptions::inst()
					->message( 'Объект обязателен' )
			) ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_kalplanchf.chetfnumber' ),
      Field::inst( 'dognet_kalplanchf.chetfdate' )
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
      Field::inst( 'dognet_kalplanchf.chetfsumma' ),
      Field::inst( 'dognet_kalplanchf.comment' ),
      Field::inst( 'dognet_kalplanchf_zadol.chetfsumzadol' ),
      Field::inst( 'dognet_dockalplan.koddoc' ),
      Field::inst( 'dognet_dockalplan.kodkalplan' ),
      Field::inst( 'dognet_dockalplan.nameshotstage' ),
      Field::inst( 'dognet_dockalplan.numberstage' ),
      Field::inst( 'dognet_dockalplan.summastage' ),
      Field::inst( 'dognet_dockalplan.srokstage' ),
      Field::inst( 'dognet_dockalplan.dateplan' ),
      Field::inst( 'dognet_docbase.koddened' ),
      Field::inst( 'dognet_docbase.kodshab' ),
      Field::inst( 'dognet_docbase.docnumber' ),
			Field::inst( 'dognet_docbase.numberchet' ),
      Field::inst( 'dognet_spdened.koddened' ),
      Field::inst( 'dognet_spdened.html_code' ),
      Field::inst( 'dognet_spdened.short_code' )
  )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor_kalplanchf, $id ) use ($_UNIQUEID) {
		$editor_kalplanchf->where( function ( $q ) use ($_UNIQUEID) {
			$q->where( 'dognet_kalplanchf.koddel', '99', '!=');
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postCreate', function ( $editor_kalplanchf, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor_kalplanchf->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'postEdit', function ( $editor_kalplanchf, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor_kalplanchf->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'preRemove', function ( $editor_kalplanchf, $id, $values ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor_kalplanchf->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_kalplanchf_zadol', 'dognet_kalplanchf_zadol.kodchfact', '=', 'dognet_kalplanchf.kodchfact' )
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	->join(
    Mjoin::inst( 'dognet_oplatachf' )
      ->link( 'dognet_oplatachf.kodchfact', 'dognet_kalplanchf.kodchfact' )
      ->field(
        Field::inst( 'kodchfact' )
    )
  )
  ->where( 'dognet_dockalplan.koddoc', $_UNIQUEID)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  ->process( $_POST )
  ->json();
#
#
}
#
#
if ($_KODSHAB == "2" OR $_KODSHAB == "0") {
//
//
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_kalplanchf' )
  ->fields(
      Field::inst( 'dognet_kalplanchf.kodchfact' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_kalplanchf.kodkalplan' )
				->options( Options::inst()
					->table( 'dognet_docbase' )
					->value( 'koddoc' )
					->label( array('koddoc') )
					->render( function ( $row ) {
						return "Без календарного плана";
						})
					->where(function ($q) use ($_UNIQUEID)  {
						$q->where('koddoc', $_UNIQUEID, '=');
						})
				)
				->validator( Validate::notEmpty( ValidateOptions::inst()
					->message( 'Объект обязателен' )
			) ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_kalplanchf.chetfnumber' ),
      Field::inst( 'dognet_kalplanchf.chetfdate' )
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
      Field::inst( 'dognet_kalplanchf.chetfsumma' ),
      Field::inst( 'dognet_kalplanchf.comment' ),
      Field::inst( 'dognet_kalplanchf_zadol.chetfsumzadol' ),
      Field::inst( 'dognet_docbase.koddened' ),
      Field::inst( 'dognet_docbase.kodshab' ),
      Field::inst( 'dognet_docbase.docnumber' ),
			Field::inst( 'dognet_docbase.numberchet' ),
      Field::inst( 'dognet_spdened.koddened' ),
      Field::inst( 'dognet_spdened.html_code' ),
      Field::inst( 'dognet_spdened.short_code' )
  )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor, $id ) use ($_UNIQUEID) {
		$editor->where( function ( $q ) use ($_UNIQUEID) {
			$q->where( 'dognet_kalplanchf.koddel', '99', '!=');
		} );
	} )
//
	->on( 'postCreate', function ( $editor, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'postEdit', function ( $editor, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'preRemove', function ( $editor, $id, $values ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_kalplanchf( $editor->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_kalplanchf_zadol', 'dognet_kalplanchf_zadol.kodchfact', '=', 'dognet_kalplanchf.kodchfact' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_kalplanchf.kodkalplan' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	->join(
    Mjoin::inst( 'dognet_oplatachf' )
      ->link( 'dognet_oplatachf.kodchfact', 'dognet_kalplanchf.kodchfact' )
      ->field(
        Field::inst( 'kodchfact' )
    )
  )
  ->where( 'dognet_kalplanchf.kodkalplan', $_UNIQUEID)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  ->process( $_POST )
  ->json();
//
//
}
#
#
