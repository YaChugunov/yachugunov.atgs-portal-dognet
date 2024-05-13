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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция формирования нового ID счета-фактуры (kodchfact) 
# для таблицы этапов 'dognet_kalplanchf'
# ----- ----- ----- 
function nextKodchfact() {
	$query = mysqlQuery("SELECT MAX(kodchfact) as lastKod FROM dognet_kalplanchf ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция обновления полей таблицы счетов-фактур 'dognet_kalplanchf'
# 
# ----- ----- ----- 
function updateFields_kalplanchf ( $db, $action, $id, $values ) { 
	$__nextKodchfact = nextKodchfact();
	if ( $action == 'CRT' ) { 
		$db->update( 'dognet_kalplanchf', array(
			'kodchfact'			=>	$__nextKodchfact 
		), array( 'id' => $id ));
	}
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция обновления полей таблицы договоров 'dognet_docbase'
# 
# ----- ----- ----- 
function updateFields_docbase ( $db, $action, $id ) { 
/*
	$query1 = mysqlQuery("SELECT kodkalplan FROM dognet_kalplanchf WHERE id=".$id);
	$row1 = mysqli_fetch_assoc($query1);
	$query2 = mysqlQuery("SELECT koddoc FROM dognet_dockalplan WHERE kodkalplan=".$row1['kodkalplan']." ORDER BY kodkalplan LIMIT 1");
	$row2 = mysqli_fetch_assoc($query2);
	$_koddoc = $row2['koddoc'];
*/
	if ( $action == 'UPD' ) { 
		$query = mysqlQuery("SELECT kodkalplan FROM dognet_dockalplan WHERE koddoc=".$__uniqueID);
		$_summachf = 0;
		$_docoplata = 0;
		$_docavans = 0;
		$_docsumma =	DOCBASE_FN_SUM_STAGES_DOC($__uniqueID);
		while( $row = mysqli_fetch_assoc($query) ) { 
			$_kodkalplan = $row['kodkalplan'];
			$_summachf	+=	DOCBASE_FN_SUM_CHF_STAGE($_kodkalplan);
			$_docavans	+=	DOCBASE_FN_SUM_AVANS_STAGE($_kodkalplan);
			$_oplatachf	+=	DOCBASE_FN_SUM_OPLATCHF_STAGE($_kodkalplan);
			$_avanschf	+=	DOCBASE_FN_SUM_AVANSCHF_STAGE($_kodkalplan);
		}
		// 
		$db->update( 'dognet_docbase', array(
			'docsumma'			=>	$_docsumma,  
			'summachf'			=>	$_summachf,  
			'docavans'			=>	$_docavans, 
			'docoplata'			=>	$_oplatachf  
		), 
		array( 
			'koddoc'				=>	$__uniqueID 
		));
		// 
	}
}
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
Editor::inst( $db, 'dognet_kalplanchf' )
  ->fields(
      Field::inst( 'dognet_kalplanchf.kodchfact' ), 
      Field::inst( 'dognet_kalplanchf.chetfnumber' ), 
      Field::inst( 'dognet_kalplanchf.chetfdate' ), 
      Field::inst( 'dognet_kalplanchf.chetfsumma' ), 
      Field::inst( 'dognet_kalplanchf.comment' ),  
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
			Field::inst( 'dognet_kalplanchf.kodkalplan' )
				->options( Options::inst()
					->table( 'dognet_dockalplan' )
					->value( 'kodkalplan' )
					->label( array('koddoc', 'kodkalplan', 'numberstage', 'nameshotstage') )
					->render( function ( $row ) use ($__uniqueID) {
						return ("Этап : ".$row['numberstage']); 
						})
					->where(function ($q) use ($__uniqueID)  { 
						$q->where('koddoc', $__uniqueID, '=');
						})
				)
				->validator( Validate::notEmpty( ValidateOptions::inst()
					->message( 'Объект обязателен' )	
				) ), 
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
      Field::inst( 'dognet_dockalplan.koddoc' ), 
      Field::inst( 'dognet_dockalplan.kodkalplan' ),  
      Field::inst( 'dognet_dockalplan.numberstage' ),  
      Field::inst( 'dognet_dockalplan.nameshotstage' ),  
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
      Field::inst( 'dognet_docbase.koddoc' ), 
      Field::inst( 'dognet_docbase.koddened' ),  
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
      Field::inst( 'dognet_spdened.koddened' ), 
      Field::inst( 'dognet_spdened.html_code' ), 
      Field::inst( 'dognet_spdened.short_code' )  
  )
// 
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
// 
	->on( 'preGet', function ( $editor, $id ) use ($__uniqueID) {
		$editor->where( function ( $q ) use ($__uniqueID) {
			$q->where( 'dognet_kalplanchf.koddel', '99', '!=' );
			$q->and_where( 'dognet_dockalplan.koddoc', $__uniqueID );
			$q->and_where( 'dognet_dockalplan.koddel', '99', '!=' );
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->on( 'postCreate', function ( $editor, $id, $values, $row ) {
		updateFields_kalplanchf( $editor->db(), 'CRT', $id, $values );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->on( 'postEdit', function ( $editor, $id, $values, $row ) { 
		updateFields_docbase( $editor->db(), 'UPD', $id );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_kalplanchf.kodkalplan' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
  ->process( $_POST )
  ->json();
