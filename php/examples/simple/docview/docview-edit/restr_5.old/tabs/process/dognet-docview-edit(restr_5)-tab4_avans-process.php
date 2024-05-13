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
# Функция формирования следующего ID аванса (kodavans)
# для таблицы этапов 'dognet_docavans'
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
function nextKodavans() {
	$query = mysqlQuery("SELECT MAX(kodavans) as lastKod FROM dognet_docavans ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function updateFields_docavans ( $db, $action_docavans, $id, $values, $__kodshab, $__uniqueID ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВЫЙ АВАНС"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	$__nextKodavans = nextKodavans();
#
#
	if ( $action_docavans == 'CRT' ) {
		$db->update( 'dognet_docavans', array(
			'kodavans'			=>	$__nextKodavans
		), array( 'id' => $id ));
#
#
		$_QRY = $db->sql( "SELECT koddoc, dateavans FROM dognet_docavans WHERE id=".$id )->fetchAll();
	// Делаем запись в системный лог
	// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940020', '0000001', $id, $__nextKodavans, $_QRY[0]['dateavans'], $_QRY[0]['koddoc']);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ПЕРЕСЧИТЫВАЕМ СУММУ АВАНСОВ ПО ЭТАПУ
# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
# ----- ----- -----
				$_QRY1 = $db->sql( "SELECT koddoc FROM dognet_docavans WHERE id=".$id )->fetchAll();
# ----- ----- -----
#
		// Определяем срок выполнения этапа с учетом появившегося аванса
		$_QRY_STAGE = $db->sql( "SELECT * FROM dognet_dockalplan WHERE kodkalplan='".$_QRY1[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
		// Нужно теперь определить срок выполнения этапа (если он был задан в днях)
		$expiry_date = "";
		if ($_QRY_STAGE[0]['idsrokstage']==0 && $_QRY_STAGE[0]['srokstage']!="") {
			$srokstage = $_QRY_STAGE[0]['srokstage'];
			$_QRY_AV = $db->sql( "SELECT MIN(dateavans) as firstavans FROM dognet_docavans WHERE koddoc=".$_QRY1[0]['koddoc']." LIMIT 1" )->fetchAll();
			if ($_QRY_AV[0]['firstavans']!="") {
				$dateavans = new DateTime($_QRY_AV[0]['firstavans']);
				$firstavans = $dateavans->format('Y-m-d');
				if (is_string($srokstage)) { $srokdays = (int)$srokstage; }
				$expiry_date = $dateavans->add(new DateInterval('P'.$srokdays.'D'))->format('Y-m-d');
			}
			else {
				$expiry_date = "";
			}
		}
#
# ----- ----- -----
				$_QRY = $db->sql( "SELECT SUM(summaavans) as sum1 FROM dognet_docavans WHERE koddoc='".$_QRY1[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				$_QRY_MINAV = $db->sql( "SELECT MIN(dateavans) as firstdateavans FROM dognet_docavans WHERE koddoc='".$_QRY1[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				$_QRY_C = $db->sql( "SELECT sumoplavstage FROM dognet_dockalplan_progress WHERE kodkalplan=".$_QRY1[0]['koddoc'] )->fetchAll();
				$firstdateavans = ($_QRY_MINAV[0]['firstdateavans']!="") ? $_QRY_MINAV[0]['firstdateavans'] : "";
				$db->update( 'dognet_dockalplan_progress', array(
					'firstdateavans'	=>	$firstdateavans,
					'srokstage_date'	=>	$expiry_date,
					'sumavstage'		=>	$_QRY[0]['sum1'],
					'zadolsum_av'		=>	$_QRY[0]['sum1']-$_QRY_C[0]['sumoplavstage']
				), array( 'kodkalplan' => $_QRY1[0]['koddoc']));
# ----- ----- -----
#
# ПРАВКА ОТ 12.10.2021
# ОБНОВЛЯЕМ ПЛАНИРУЕМЫЕ ДАТЫ ЧАСТЕЙ АВАНСОВ ОТНОСИТЕЛЬНО 1-ГО АВАНСА ПО ЭТАПУ
#
		if ( $firstdateavans != "" ) {
			if ( $_QRY_STAGE[0]['useav2plan']==1 && $_QRY_STAGE[0]['daysplanav2stage']!="" ) { 

				$daysplanav2stage = $_QRY_STAGE[0]['daysplanav2stage'];
				$dateavans = new DateTime($firstdateavans);
				$dateplanav2stage = $dateavans->add(new DateInterval('P'.$daysplanav2stage.'D'))->format('Y-m-d');

				$db->update( 'dognet_dockalplan', array(
					'dateplanav2stage'	=>	$firstdateavans
				), array( 'kodkalplan' => $_QRY1[0]['koddoc']));

			}
			if ( $_QRY_STAGE[0]['useav3plan']==1 && $_QRY_STAGE[0]['daysplanav3stage']!="" ) { 

				$daysplanav3stage = $_QRY_STAGE[0]['daysplanav3stage'];
				$dateavans = new DateTime($firstdateavans);
				$dateplanav3stage = $dateavans->add(new DateInterval('P'.$daysplanav3stage.'D'))->format('Y-m-d');

				$db->update( 'dognet_dockalplan', array(
					'dateplanav3stage'	=>	$firstdateavans
				), array( 'kodkalplan' => $_QRY1[0]['koddoc']));

			}
			if ( $_QRY_STAGE[0]['useav4plan']==1 && $_QRY_STAGE[0]['daysplanav4stage']!="" ) { 

				$daysplanav4stage = $_QRY_STAGE[0]['daysplanav4stage'];
				$dateavans = new DateTime($firstdateavans);
				$dateplanav4stage = $dateavans->add(new DateInterval('P'.$daysplanav4stage.'D'))->format('Y-m-d');

				$db->update( 'dognet_dockalplan', array(
					'dateplanav4stage'	=>	$firstdateavans
				), array( 'kodkalplan' => $_QRY1[0]['koddoc']));

			}
		}
		else {
			$db->update( 'dognet_dockalplan', array(
				'dateplanav2stage'	=>	NULL, 
				'dateplanav3stage'	=>	NULL, 
				'dateplanav4stage'	=>	NULL 
			), array( 'kodkalplan' => $_QRY1[0]['koddoc']));
		}

#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
		DOCAVANS_PR_OSTATOK_DOC( $db, "docavans", $id, $action_docavans );
#
#
		DOCBASE_PR_ZADOLG_DOC( $db, "docavans", $id, $action_docavans, $__uniqueID, $__kodshab );
#
#

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
	if ( $action_docavans == 'UPD' ) {
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ПЕРЕСЧИТЫВАЕМ СУММУ АВАНСОВ ПО ЭТАПУ
# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
# ----- ----- -----
$_QRY1 = $db->sql( "SELECT kodavans, koddoc FROM dognet_docavans WHERE id=".$id )->fetchAll();
# ----- ----- -----
#
		// Определяем срок выполнения этапа с учетом появившегося аванса
		$_QRY_STAGE = $db->sql( "SELECT * FROM dognet_dockalplan WHERE kodkalplan='".$_QRY1[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
		// Нужно теперь определить срок выполнения этапа (если он был задан в днях)
		$expiry_date = "";
		if ($_QRY_STAGE[0]['idsrokstage']==0 && $_QRY_STAGE[0]['srokstage']!="") {
			$srokstage = $_QRY_STAGE[0]['srokstage'];
			$_QRY_AV = $db->sql( "SELECT MIN(dateavans) as firstavans FROM dognet_docavans WHERE koddoc=".$_QRY1[0]['koddoc']." LIMIT 1" )->fetchAll();
			if ($_QRY_AV[0]['firstavans']!="") {
				$dateavans = new DateTime($_QRY_AV[0]['firstavans']);
				$firstavans = $dateavans->format('Y-m-d');
				if (is_string($srokstage)) { $srokdays = (int)$srokstage; }
				$expiry_date = $dateavans->add(new DateInterval('P'.$srokdays.'D'))->format('Y-m-d');
			}
			else {
				$expiry_date = "";
			}
		}
#
# ----- ----- -----
				$_QRY = $db->sql( "SELECT SUM(summaavans) as sum1 FROM dognet_docavans WHERE koddoc='".$_QRY1[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				$_QRY_MINAV = $db->sql( "SELECT MIN(dateavans) as firstdateavans FROM dognet_docavans WHERE koddoc='".$_QRY1[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				$_QRY_C = $db->sql( "SELECT sumoplavstage FROM dognet_dockalplan_progress WHERE kodkalplan=".$_QRY1[0]['koddoc'] )->fetchAll();
				$firstdateavans = ($_QRY_MINAV[0]['firstdateavans']!="") ? $_QRY_MINAV[0]['firstdateavans'] : "";
				$db->update( 'dognet_dockalplan_progress', array(
					'firstdateavans'	=>	$firstdateavans,
					'srokstage_date'	=>	$expiry_date,
					'sumavstage'		=>	$_QRY[0]['sum1'],
					'zadolsum_av'		=>	$_QRY[0]['sum1']-$_QRY_C[0]['sumoplavstage']
				), array( 'kodkalplan' => $_QRY1[0]['koddoc']));
# ----- ----- -----
#
# ПРАВКА ОТ 12.10.2021
# ОБНОВЛЯЕМ ПЛАНИРУЕМЫЕ ДАТЫ ЧАСТЕЙ АВАНСОВ ОТНОСИТЕЛЬНО 1-ГО АВАНСА ПО ЭТАПУ
#
		if ( $firstdateavans != "" ) {
			if ( $_QRY_STAGE[0]['useav2plan']==1 && $_QRY_STAGE[0]['daysplanav2stage']!="" ) { 

				$daysplanav2stage = $_QRY_STAGE[0]['daysplanav2stage'];
				$dateavans = new DateTime($firstdateavans);
				$dateplanav2stage = $dateavans->add(new DateInterval('P'.$daysplanav2stage.'D'))->format('Y-m-d');

				$db->update( 'dognet_dockalplan', array(
					'dateplanav2stage'	=>	$dateplanav2stage
				), array( 'kodkalplan' => $_QRY1[0]['koddoc']));

			}
			if ( $_QRY_STAGE[0]['useav3plan']==1 && $_QRY_STAGE[0]['daysplanav3stage']!="" ) { 

				$daysplanav3stage = $_QRY_STAGE[0]['daysplanav3stage'];
				$dateavans = new DateTime($firstdateavans);
				$dateplanav3stage = $dateavans->add(new DateInterval('P'.$daysplanav3stage.'D'))->format('Y-m-d');

				$db->update( 'dognet_dockalplan', array(
					'dateplanav3stage'	=>	$dateplanav3stage
				), array( 'kodkalplan' => $_QRY1[0]['koddoc']));

			}
			if ( $_QRY_STAGE[0]['useav4plan']==1 && $_QRY_STAGE[0]['daysplanav4stage']!="" ) { 

				$daysplanav4stage = $_QRY_STAGE[0]['daysplanav4stage'];
				$dateavans = new DateTime($firstdateavans);
				$dateplanav4stage = $dateavans->add(new DateInterval('P'.$daysplanav4stage.'D'))->format('Y-m-d');

				$db->update( 'dognet_dockalplan', array(
					'dateplanav4stage'	=>	$dateplanav4stage
				), array( 'kodkalplan' => $_QRY1[0]['koddoc']));

			}
		}
		else {
			$db->update( 'dognet_dockalplan', array(
				'dateplanav2stage'	=>	NULL, 
				'dateplanav3stage'	=>	NULL, 
				'dateplanav4stage'	=>	NULL 
			), array( 'kodkalplan' => $_QRY1[0]['koddoc']));
		}

# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
		DOCAVANS_PR_OSTATOK_DOC( $db, "docavans", $id, $action_docavans );
#
#
		DOCBASE_PR_ZADOLG_DOC( $db, "docavans", $id, $action_docavans, $__uniqueID, $__kodshab );
#
#
	// Делаем запись в системный лог
	// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940020', '0000002', $id, $_QRY1[0]['kodavans'], null, $_QRY1[0]['koddoc']);
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
	if ( $action_docavans == 'DEL' ) {
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ПЕРЕСЧИТЫВАЕМ СУММУ АВАНСОВ ПО ЭТАПУ
# ДЛЯ ТАБЛИЦЫ ПРОГРЕССА ЭТАПОВ - dockalplan_progress
# ----- ----- -----
# Получаем данные до удаления выбранного аванса
$_QRY1 = $db->sql( "SELECT koddoc, kodavans, summaavans FROM dognet_docavans WHERE id=".$id )->fetchAll();
# ----- ----- -----
#
		// Определяем срок выполнения этапа с учетом появившегося аванса
		$_QRY_STAGE = $db->sql( "SELECT idsrokstage, srokstage FROM dognet_dockalplan WHERE kodkalplan='".$_QRY1[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
		// Нужно теперь определить срок выполнения этапа (если он был задан в днях)
		$expiry_date = "";
		if ($_QRY_STAGE[0]['idsrokstage']==0 && $_QRY_STAGE[0]['srokstage']!="") {
			$srokstage = $_QRY_STAGE[0]['srokstage'];
			$_QRY_AV = $db->sql( "SELECT MIN(dateavans) as firstavans FROM dognet_docavans WHERE koddoc='".$_QRY1[0]['koddoc']."' AND kodavans<>'".$_QRY1[0]['kodavans']."' LIMIT 1" )->fetchAll();
			if ($_QRY_AV[0]['firstavans']!="") {
				$dateavans = new DateTime($_QRY_AV[0]['firstavans']);
				$firstavans = $dateavans->format('Y-m-d');
				if (is_string($srokstage)) { $srokdays = (int)$srokstage; }
				$expiry_date = $dateavans->add(new DateInterval('P'.$srokdays.'D'))->format('Y-m-d');
			}
			else {
				$expiry_date = "";
			}
		}
#
#
	// Делаем запись в системный лог
	// Все параметры в таблице portal_log_messages
		PORTAL_SYSLOG('99940020', '0000003', $id, $_QRY1[0]['kodavans'], null, $_QRY1[0]['koddoc']);
#
# ----- ----- -----
				# Суммируем все авансы по этапу (включая удаляемый)
				$_QRY = $db->sql( "SELECT SUM(summaavans) as sum1 FROM dognet_docavans WHERE koddoc='".$_QRY1[0]['koddoc']."' AND koddel<>'99'" )->fetchAll();
				$_QRY_MINAV = $db->sql( "SELECT MIN(dateavans) as firstdateavans FROM dognet_docavans WHERE koddoc='".$_QRY1[0]['koddoc']."' AND kodavans<>'".$_QRY1[0]['kodavans']."' AND koddel<>'99'" )->fetchAll();
				# Удаляем все зачеты по удаляемому авансу
				$_QRY_DEL_OPLAV = $db->sql( "DELETE FROM dognet_chfavans WHERE kodavans=".$_QRY1[0]['kodavans'] );
				# Снова суммируем все зачеты аванса по всем счетам-фактурам этапа (удаленные зачеты уже не учитываются)
				$_QRY_RECALC_OPLAV = $db->sql( "SELECT SUM(summaoplav) as sum1 FROM dognet_chfavans WHERE kodchfact IN (SELECT kodchfact FROM dognet_kalplanchf WHERE kodkalplan='".$_QRY1[0]['koddoc']."' AND koddel<>'99') AND koddel<>'99'" )->fetchAll();
				# Пишем в БД сумму зачтенных авансов (с учетом удаленных)
				$db->update( 'dognet_dockalplan_progress', array(
					'sumoplavstage'	=>	$_QRY_RECALC_OPLAV[0]['sum1']
				), array( 'kodkalplan' => $_QRY1[0]['koddoc']));
				# Пишем в БД
				# - сууму всех авансов (за вычетоv удаляемого)
				# - незачтенную сумму (сумма всех авансов - пересчитанные зачеты)
				$firstdateavans = ($_QRY_MINAV[0]['firstdateavans']!="") ? $_QRY_MINAV[0]['firstdateavans'] : "";
				$db->update( 'dognet_dockalplan_progress', array(
					'firstdateavans'	=>	$firstdateavans,
					'srokstage_date'	=>	$expiry_date,
					'sumavstage'		=>	$_QRY[0]['sum1']-$_QRY1[0]['summaavans'],
					'zadolsum_av'		=>	($_QRY[0]['sum1']-$_QRY1[0]['summaavans'])-$_QRY_RECALC_OPLAV[0]['sum1']
				), array( 'kodkalplan' => $_QRY1[0]['koddoc']));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
		DOCAVANS_PR_OSTATOK_DOC( $db, "docavans", $id, $action_docavans );
#
#
		DOCBASE_PR_ZADOLG_DOC( $db, "docavans", $id, $action_docavans, $__uniqueID, $__kodshab );
#
#
	}
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
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
#
#
if ($_KODSHAB == "1" || $_KODSHAB == "3") {
#
#
# Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_docavans' )
	->fields(
		Field::inst( 'dognet_docbase.koddel' ),
		Field::inst( 'dognet_docbase.kodshab' ),
		Field::inst( 'dognet_docbase.docnumber' ),
		Field::inst( 'dognet_docbase.docnameshot' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	    Field::inst( 'dognet_dockalplan.koddoc' ),
	    Field::inst( 'dognet_dockalplan.kodkalplan' ),
	    Field::inst( 'dognet_dockalplan.numberstage' ),
	    Field::inst( 'dognet_dockalplan.nameshotstage' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_docavans.nameavans' ),
		Field::inst( 'dognet_docavans.comment' ),
		Field::inst( 'dognet_docavans.summaavans' ),
		Field::inst( 'dognet_docavans.ostatokavans' ),
		Field::inst( 'dognet_docavans.dateavans' )
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
		Field::inst( 'dognet_docavans.kodavans' ),
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_docavans.koddoc' )
			->options( Options::inst()
				->table( 'dognet_dockalplan' )
				->value( 'kodkalplan' )
				->label( array('koddoc', 'kodkalplan', 'numberstage', 'nameshotstage') )
				->render( function ( $row ) use ($_UNIQUEID) {
					return ("Этап ".$row['numberstage']." : ".$row['nameshotstage']);
					})
				->where(function ($q) use ($_UNIQUEID)  {
					$q->where('koddoc', $_UNIQUEID);
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Объект обязателен' )
			) ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

// 		Field::inst( 'dognet_docavans_ostatok.kodavans' ),
// 		Field::inst( 'dognet_docavans_ostatok.ostatokavans' ),

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	    Field::inst( 'dognet_docbase.koddened' ),
	    Field::inst( 'dognet_spdened.koddened' ),
	    Field::inst( 'dognet_spdened.html_code' ),
	    Field::inst( 'dognet_spdened.short_code' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	)
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
	->on( 'preGet', function ( $editor, $id ) use ($_UNIQUEID) {
		$editor->where( function ( $q ) use ($_UNIQUEID) {
	    $q->where( 'dognet_docavans.koddel', '99', '!=' );
	    $q->and_where( 'dognet_docavans.koddoc', '(SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc='.$_UNIQUEID.')', 'IN', false );
		} );
	} )
//
	->on( 'postCreate', function ( $editor_docavans, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_docavans( $editor_docavans->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'postEdit', function ( $editor_docavans, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_docavans( $editor_docavans->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'preRemove', function ( $editor_docavans, $id, $values ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_docavans( $editor_docavans->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
// 	->leftJoin( 'dognet_docavans_ostatok', 'dognet_docavans_ostatok.kodavans', '=', 'dognet_docavans.kodavans' )
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docavans.koddoc' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	->process( $_POST )
	->json();
#
#
}
#
#
if ($_KODSHAB == "2" || $_KODSHAB == "4") {
#
#
# Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_docavans' )
	->fields(
		Field::inst( 'dognet_docbase.koddel' ),
		Field::inst( 'dognet_docbase.kodshab' ),
		Field::inst( 'dognet_docbase.docnumber' ),
		Field::inst( 'dognet_docbase.docnameshot' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_docavans.nameavans' ),
		Field::inst( 'dognet_docavans.comment' ),
		Field::inst( 'dognet_docavans.summaavans' ),
		Field::inst( 'dognet_docavans.ostatokavans' ),
		Field::inst( 'dognet_docavans.dateavans' )
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
		Field::inst( 'dognet_docavans.kodavans' ),
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_docavans.koddoc' )
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
// 		Field::inst( 'dognet_docavans_ostatok.kodavans' ),
// 		Field::inst( 'dognet_docavans_ostatok.ostatokavans' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_docbase.koddened' ),
    Field::inst( 'dognet_spdened.koddened' ),
    Field::inst( 'dognet_spdened.html_code' ),
    Field::inst( 'dognet_spdened.short_code' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	)
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
	->on( 'preGet', function ( $editor_docavans, $id ) {
		$editor_docavans->where( function ( $q ) {
	    $q->where( 'dognet_docavans.koddel', '99', '!=' );
		} );
	} )
//
	->on( 'postCreate', function ( $editor_docavans, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_docavans( $editor_docavans->db(), 'CRT', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'postEdit', function ( $editor_docavans, $id, $values, $row ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_docavans( $editor_docavans->db(), 'UPD', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
	->on( 'preRemove', function ( $editor_docavans, $id, $values ) use ($_KODSHAB, $_UNIQUEID) {
		updateFields_docavans( $editor_docavans->db(), 'DEL', $id, $values, $_KODSHAB, $_UNIQUEID );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
// 	->leftJoin( 'dognet_docavans_ostatok', 'dognet_docavans_ostatok.kodavans', '=', 'dognet_docavans.kodavans' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docavans.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
  ->where( 'dognet_docavans.koddoc', $_UNIQUEID )
	->process( $_POST )
	->json();
#
#
}
#
#
?>