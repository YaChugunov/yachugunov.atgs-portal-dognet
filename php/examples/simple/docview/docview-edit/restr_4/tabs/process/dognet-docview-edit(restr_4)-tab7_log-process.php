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
// $_UNIQUEID = $_GET['uniqueID'];
$_DOCBASE = mysqli_fetch_assoc(mysqlQuery( "SELECT docnumber FROM dognet_docbase WHERE koddoc='".$_UNIQUEID."'" ));
$_DOCNUMBER = $_DOCBASE['docnumber'];
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
Editor::inst( $db, 'portal_syslog' )
	->fields(
		Field::inst( 'id' ),
		Field::inst( 'user_id' ),
		Field::inst( 'user_ip' ),
		Field::inst( 'user_login' ),
		Field::inst( 'user_agent' ),
		Field::inst( 'user_firstname' ),
		Field::inst( 'user_lastname' ),
		Field::inst( 'timestamp' )
      ->validator( Validate::dateFormat(
          'd.m.Y H:i:s',
          ValidateOptions::inst()
              ->allowEmpty( true ) ) )
      ->getFormatter( Format::datetime(
          'Y-m-d H:i:s',
          'd.m.Y H:i:s'
      ) )
      ->setFormatter( Format::datetime(
          'd.m.Y H:i:s',
          'Y-m-d H:i:s'
		) ),
		Field::inst( 'SESSID' ),
		Field::inst( 'service' ),
		Field::inst( 'subgroup' ),
		Field::inst( 'access_level' ),
		Field::inst( 'message' ),
		Field::inst( 'row_id' ),
		Field::inst( 'doc_id' ),
		Field::inst( 'field_info1' ),
		Field::inst( 'field_info2' ),
		Field::inst( 'comment' ),
		Field::inst( 'doc_number' )
	)
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
	->on( 'preGet', function ( $editor, $id ) use ($_UNIQUEID, $_DOCNUMBER) {
		$editor->where( function ( $q ) use ($_UNIQUEID, $_DOCNUMBER) {
			$q->where( 'doc_number', $_DOCNUMBER, '=' );
// 			$q->or_where( 'doc_id', $_UNIQUEID);
			$q->order('timestamp desc, id desc');
		} );
	} )
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
// 	->where( 'doc_id', $_UNIQUEID )
// 	->where( 'doc_number', $_DOCBASE['docnumber'] )
// 	->where( 'user_id', '999', '!=' )
// 	->where( 'user_id', '1011', '!=' )
	->where( 'subgroup', 'Карточка договора', '!=' )
	->process( $_POST )
	->json();

