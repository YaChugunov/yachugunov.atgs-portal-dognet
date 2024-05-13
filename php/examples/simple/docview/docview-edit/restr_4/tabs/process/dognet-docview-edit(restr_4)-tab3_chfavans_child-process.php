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
require($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/docview/docview-edit/dognet-docview-edit-functions.inc.php");
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
function nextKodchfavans() {
	$query = mysqlQuery("SELECT MAX(kodchfavans) as lastKod FROM dognet_chfavans ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 9);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
#
function updateFields_chfavans ( $db, $action_chfavans, $id, $values, $row, $__kodkalplan, $__kodchfact, $__kodshab, $__uniqueID ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВЫЙ ЗАЧЕТ АВАНСА"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	$_QRY = $db->sql( "SELECT * FROM dognet_chfavans WHERE id=".$id )->fetchAll();
	if ( $_QRY ) { $__kodchfact = $_QRY[0]['kodchfact']; }
#
#
	if ( $action_chfavans == 'CRT' ) {
#
#
	$_QRY_CHF = $db->sql( "SELECT kodkalplan, chetfnumber, chetfdate FROM dognet_kalplanchf WHERE kodchfact=".$__kodchfact )->fetchAll();
	// 
	// Формируем новый идентификатор счета-фактуры (kodchfact)

	// Правка от 27.04.21
	// Датой зачета аванса (dateoplav) теперь фиксируется не текущая дата (NOW), а дата СФ (chetfdate)
		$__chefdate = $_QRY_CHF[0]['chetfdate']; // правка от 27.04.21

		$__nextKodchfavans = nextKodchfavans();
		$db->update( 'dognet_chfavans', array(
			'kodchfavans'	=>	$__nextKodchfavans,
			'dateoplav'		=>	$__chefdate
		), array( 'id' => $id));

#
#
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940002', '0000001', $id, $__nextKodchfavans, $__kodchfact, $_QRY[0]['kodavans']);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ПЕРСЧИТЫВАЕМ СУММУ ЗАЧТЕННЫХ АВАНСОВ ПО ЭТАПУ
# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
# ----- ----- -----
				# Считываем ID зачета аванса
				$_QRY1 = $db->sql( "SELECT kodavans FROM dognet_chfavans WHERE id=".$id )->fetchAll();
				# Считываем ID этапа (koddoc) по ID аванса (kodavans)
				$_QRY2 = $db->sql( "SELECT koddoc FROM dognet_docavans WHERE kodavans=".$_QRY1[0]['kodavans'] )->fetchAll();
				# -----
				# Суммируем все авансы по этапу ($_QRY2[0]['koddoc'])
				$_QRY_SUMAV = $db->sql( "SELECT SUM(summaavans) as sum1 FROM dognet_docavans WHERE koddoc='".$_QRY2[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				# -----
				# Суммируем все счета-фактуры по этапу ($_QRY2[0]['koddoc'])
				$_QRY_SUMCHF = $db->sql( "SELECT SUM(chetfsumma) as sum1 FROM dognet_kalplanchf WHERE kodkalplan='".$_QRY2[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				# -----
				# Суммируем все оплаты счетов-фактур по этапу ($_QRY2[0]['koddoc'])
				$_QRY_SUMOPLCHF = $db->sql( "SELECT SUM(summaopl) as sum1 FROM dognet_oplatachf WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_QRY2[0]['koddoc']." AND koddel<>'99') AND koddel<>'99'" )->fetchAll();
				# -----
				# Суммируем все зачеты аванса по всем счетам-фактурам этапа ($_QRY2[0]['koddoc'])
				$_QRY_SUMOPLAV = $db->sql( "SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_QRY2[0]['koddoc']." AND koddel<>'99') AND koddel<>'99'" )->fetchAll();
				$db->update( 'dognet_dockalplan_progress', array(
					'sumoplavstage'	=>	$_QRY_SUMOPLAV[0]['sum1'],
					'zadolsum_av' 	=>	$_QRY_SUMAV[0]['sum1']-$_QRY_SUMOPLAV[0]['sum1'],
					'zadolsum_chf'	=>	$_QRY_SUMCHF[0]['sum1']-($_QRY_SUMOPLCHF[0]['sum1']+$_QRY_SUMOPLAV[0]['sum1'])
				), array( 'kodkalplan' => $_QRY2[0]['koddoc']));
#
				$db->update( 'dognet_chfavans', array(
					'kodkalplan' => $_QRY2[0]['koddoc']
				), array( 'id' => $id ));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
		$_QRY_CHF = $db->sql( "SELECT kodkalplan, chetfnumber, chetfdate FROM dognet_kalplanchf WHERE kodchfact=".$__kodchfact )->fetchAll();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ПЕРСЧИТЫВАЕМ СУММУ ЗАЧТЕННЫХ АВАНСОВ ПО ЭТАПУ
# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
# ----- ----- -----
				# Считываем ID зачета аванса
				$_QRY1 = $db->sql( "SELECT kodchfavans, kodavans FROM dognet_chfavans WHERE id=".$id )->fetchAll();
				# Считываем ID этапа (koddoc) по ID аванса (kodavans)
				$_QRY2 = $db->sql( "SELECT koddoc FROM dognet_docavans WHERE kodavans=".$_QRY1[0]['kodavans'] )->fetchAll();
				# -----
				# Суммируем все авансы по этапу ($_QRY2[0]['koddoc'])
				$_QRY_SUMAV = $db->sql( "SELECT SUM(summaavans) as sum1 FROM dognet_docavans WHERE koddoc='".$_QRY2[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				# -----
				# Суммируем все счета-фактуры по этапу ($_QRY2[0]['koddoc'])
				$_QRY_SUMCHF = $db->sql( "SELECT SUM(chetfsumma) as sum1 FROM dognet_kalplanchf WHERE kodkalplan='".$_QRY2[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				# -----
				# Суммируем все оплаты счетов-фактур по этапу ($_QRY2[0]['koddoc'])
				$_QRY_SUMOPLCHF = $db->sql( "SELECT SUM(summaopl) as sum1 FROM dognet_oplatachf WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_QRY2[0]['koddoc']." AND koddel<>'99') AND koddel<>'99'" )->fetchAll();
				# -----
				# Суммируем все зачеты аванса по всем счетам-фактурам этапа ($_QRY2[0]['koddoc'])
				$_QRY_SUMOPLAV = $db->sql( "SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_QRY2[0]['koddoc']." AND koddel<>'99') AND koddel<>'99'" )->fetchAll();
				$db->update( 'dognet_dockalplan_progress', array(
					'sumoplavstage'	=>	$_QRY_SUMOPLAV[0]['sum1'],
					'zadolsum_av' 	=>	$_QRY_SUMAV[0]['sum1']-$_QRY_SUMOPLAV[0]['sum1'],
					'zadolsum_chf'	=>	$_QRY_SUMCHF[0]['sum1']-($_QRY_SUMOPLCHF[0]['sum1']+$_QRY_SUMOPLAV[0]['sum1'])
				), array( 'kodkalplan' => $_QRY2[0]['koddoc']));
#
			// Правка от 27.04.21
			// Датой зачета аванса (dateoplav) теперь фиксируется не текущая дата (NOW), а дата СФ (chetfdate)
				$__chefdate = $_QRY_CHF[0]['chetfdate']; // правка от 27.04.21
				$db->update( 'dognet_chfavans', array(
					'kodkalplan' 	=> $_QRY2[0]['koddoc'], 
					'dateoplav'		=>	$__chefdate
				), array( 'id' => $id ));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940002', '0000002', $id, $_QRY1[0]['kodchfavans'], $__kodchfact, $_QRY1[0]['kodavans']);
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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ПЕРСЧИТЫВАЕМ СУММУ ЗАЧТЕННЫХ АВАНСОВ ПО ЭТАПУ
# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
# ----- ----- -----
				# Считываем ID зачета аванса
				$_QRY1 = $db->sql( "SELECT * FROM dognet_chfavans WHERE id=".$id )->fetchAll();
				# Считываем ID этапа (koddoc) по ID аванса (kodavans)
				$_QRY2 = $db->sql( "SELECT koddoc FROM dognet_docavans WHERE kodavans=".$_QRY1[0]['kodavans'] )->fetchAll();
				# -----
				# Суммируем все авансы по этапу ($_QRY2[0]['koddoc'])
				$_QRY_SUMAV = $db->sql( "SELECT SUM(summaavans) as sum1 FROM dognet_docavans WHERE koddoc='".$_QRY2[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				# -----
				# Суммируем все счета-фактуры по этапу ($_QRY2[0]['koddoc'])
				$_QRY_SUMCHF = $db->sql( "SELECT SUM(chetfsumma) as sum1 FROM dognet_kalplanchf WHERE kodkalplan='".$_QRY2[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				# -----
				# Суммируем все оплаты счетов-фактур по этапу ($_QRY2[0]['koddoc'])
				$_QRY_SUMOPLCHF = $db->sql( "SELECT SUM(summaopl) as sum1 FROM dognet_oplatachf WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_QRY2[0]['koddoc']." AND koddel<>'99') AND koddel<>'99'" )->fetchAll();
				# -----
				# Суммируем все зачеты аванса по всем счетам-фактурам этапа ($_QRY2[0]['koddoc'])
				$_QRY_SUMOPLAV = $db->sql( "SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan=".$_QRY2[0]['koddoc']." AND koddel<>'99') AND koddel<>'99'" )->fetchAll();
				$db->update( 'dognet_dockalplan_progress', array(
					'sumoplavstage'	=>	$_QRY_SUMOPLAV[0]['sum1']-$_QRY1[0]['summaoplav'],
					'zadolsum_av' 	=>	$_QRY_SUMAV[0]['sum1']-($_QRY_SUMOPLAV[0]['sum1']-$_QRY1[0]['summaoplav']),
					'zadolsum_chf'	=>	$_QRY_SUMCHF[0]['sum1']-($_QRY_SUMOPLCHF[0]['sum1']+$_QRY_SUMOPLAV[0]['sum1']-$_QRY1[0]['summaoplav'])
				), array( 'kodkalplan' => $_QRY2[0]['koddoc']));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
		$_QRY_CHF = $db->sql( "SELECT kodkalplan, chetfnumber FROM dognet_kalplanchf WHERE kodchfact=".$__kodchfact )->fetchAll();
		// Делаем запись в системный лог
		// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940002', '0000003', $id, $_QRY1[0]['kodchfavans'], $__kodchfact, $_QRY1[0]['kodavans']);
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
if ($_KODSHAB == "1" || $_KODSHAB == "3") {
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
						return ("СФ № ".$row['chetfnumber']);
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
					->label( array('koddoc', 'kodavans', 'summaavans', 'ostatokavans', 'dateavans') )
					->render( function ( $row ) use ($kodkalplan) {
						return ("Oт ".date('d.m.Y', strtotime($row['dateavans']))." / ".$row['summaavans']." / ".$row['ostatokavans']);
						})
					->where(function ($q) use ($kodkalplan)  {
						$q->where('koddoc', $kodkalplan, '=');
						})
				)
				->validator( Validate::notEmpty( ValidateOptions::inst()
					->message( 'Объект обязателен' )
				) ),
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	    Field::inst( 'dognet_chfavans.dateoplav' )
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
					updateFields_chfavans( $editor_chfavans->db(), 'CRT', $id, $values, $row, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID );
				} )
				->on( 'postEdit', function ( $editor_chfavans, $id, $values, $row ) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
					updateFields_chfavans( $editor_chfavans->db(), 'UPD', $id, $values, $row, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID );
				} )
				->on( 'preRemove', function ( $editor_chfavans, $id, $values ) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
					updateFields_chfavans( $editor_chfavans->db(), 'DEL', $id, $values, null, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID );
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
if ($_KODSHAB == "2" || $_KODSHAB == "4") {

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
					updateFields_chfavans( $editor_chfavans->db(), 'CRT', $id, $values, $row, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID );
				} )
				->on( 'postEdit', function ( $editor_chfavans, $id, $values, $row ) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
					updateFields_chfavans( $editor_chfavans->db(), 'UPD', $id, $values, $row, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID );
				} )
				->on( 'preRemove', function ( $editor_chfavans, $id, $values ) use ($kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID) {
					updateFields_chfavans( $editor_chfavans->db(), 'DEL', $id, $values, null, $kodkalplan, $kodchfact, $_KODSHAB, $_UNIQUEID );
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