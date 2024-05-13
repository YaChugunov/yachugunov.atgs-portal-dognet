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
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Функция определения нового кода документа/записи (koddocmail) для таблицы заказчиков
//
function newkodzayvtel() {
	$query = mysqlQuery("SELECT MAX(kodzayvtel) as lastKod FROM dognet_spzayvtel ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$newKod = $row['lastKod'];
	$newKod++;
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
		$newkodzayvtel = newkodzayvtel();
		$db->update( 'dognet_spzayvtel', array(
			'kodzayvtel'			=> $newkodzayvtel
		), array(
			'id' => $id
		));
	}
#
#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
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
Editor::inst( $db, 'dognet_zayvtel_mailinglist' )
	->fields(
		Field::inst( 'dognet_zayvtel_mailinglist.ID' ),
		Field::inst( 'dognet_zayvtel_mailinglist.kodzayvtel' ),
		Field::inst( 'dognet_zayvtel_mailinglist.status' ),
		Field::inst( 'dognet_zayvtel_mailinglist.mailinglist_number' ),
		Field::inst( 'dognet_zayvtel_mailinglist.lastname' ),
		Field::inst( 'dognet_zayvtel_mailinglist.firstname' ),
		Field::inst( 'dognet_zayvtel_mailinglist.middlename' ),
		Field::inst( 'dognet_zayvtel_mailinglist.dept_num' ),
// ----- ----- -----
		Field::inst( 'dognet_zayvtel_mailinglist.recipient_userID1' )
			->options( Options::inst()
				->table( 'dognet_doczayv_users' )
				->value( 'email2' )
				->label( array('lastname', 'firstname', 'middlename', 'email2') )
				->render( function ( $row ) {
					return ($row['lastname']." ( ".$row['email2']." )");
					})
				->where(function ($q) {
					$q->where('status', '1', '=');
					$q->where('mailing_enbl', '1', '=');
					})
			)
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor_docbase, $id ) {
		$editor_docbase->where( function ( $q ) {

		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postCreate', function ( $editor, $id, $values, $row ) {
// 		updateFields( $editor->db(), 'CRT', $id, $values );
	} )
	->on( 'postEdit', function ( $editor, $id, $values, $row ) {
// 		updateFields( $editor->db(), 'UPD', $id, $values );
	} )
	->on( 'preRemove', function ( $editor, $id, $values ) {
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_spzayvtel.kodispol' )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->process( $_POST )
	->json();

