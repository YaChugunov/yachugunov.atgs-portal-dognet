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
# Функция определения нового ID договора ( koddoc)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextKodzayvchet() {
	$query = mysqlQuery("SELECT MAX(kodzayvchet) as lastKod FROM dognet_doczayvchet ORDER BY id DESC");
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
function updateFields ( $db, $id, $values, $row, $chetRowID ) {

	$_QRY_ZAYV = $db->sql( "SELECT kodzayv FROM dognet_doczayv WHERE id=".$id )->fetchAll();
	$_QRY_CHET = mysqlQuery( "UPDATE dognet_doczayvchet SET kodzayv=".$_QRY_ZAYV[0]['kodzayv']." WHERE id=".$chetRowID );

}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
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

if ( !isset($_POST['chRowID']) || !is_numeric($_POST['chRowID']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$__chetRowID = $_POST['chRowID'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_doczayvchet' )
	->fields(
		Field::inst( 'dognet_doczayvchet.id' ),
		Field::inst( 'dognet_doczayvchet.kodzayv' )
	)
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postEdit', function ( $editor_docbase, $id, $values, $row ) use ($__chetRowID)  {
		updateFields( $editor_docbase->db(), $id, $values, $row, $__chetRowID );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
  ->where( 'dognet_doczayvchet.id', $__chetRowID )
	->process( $_POST )
	->json();
}