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
require($_SERVER['DOCUMENT_ROOT']."/mail/_assets/functions/funcMail.inc.php");
# Включаем режим сессии
session_start();
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Функция определения нового кода документа/записи (koddocmail) для таблицы заказчиков
//
function newKodispolruk() {
	$query = mysqlQuery("SELECT MAX(kodispolruk) as lastKod FROM dognet_spispolruk ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$newKod = $lastKod + rand(13, 33);
	return $newKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
function updateFields ( $db, $action, $id, $values ) {
#
#
	if ( $action == 'CRT' ) {
		$newKodispolruk = newKodispolruk();
		$db->update( 'dognet_spispolruk', array(
			'kodispolruk'			=> $newKodispolruk
		), array(
			'id' => $id
		));
	}
#
#


#
#
}
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
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_spispolruk' )
	->fields(
		Field::inst( 'ID' ),
		Field::inst( 'kodispolruk' ),
		Field::inst( 'koddel' ),
		Field::inst( 'ispolrukname' ),
		Field::inst( 'ispolruknamefull' ),
		Field::inst( 'ispolrukjob' ),
		Field::inst( 'ispolrukemail' ),
		Field::inst( 'ispolruktel' ),
		Field::inst( 'kodrukgip' )
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
	->on( 'postCreate', function ( $editor, $id, $values, $row ) {
		updateFields( $editor->db(), 'CRT', $id, $values );
	} )
	->on( 'postEdit', function ( $editor, $id, $values, $row ) {
		updateFields( $editor->db(), 'UPD', $id, $values );
	} )
	->on( 'preRemove', function ( $editor, $id, $values ) {
	} )
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->process( $_POST )
	->json();

