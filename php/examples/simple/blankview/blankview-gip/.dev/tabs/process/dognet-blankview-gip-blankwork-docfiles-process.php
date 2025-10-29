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
// Фиксируем номер договора, который просматриваем
// $__koddoc = $_SESSION['uniqueID'];
// Определяем номер основного бланка заявки на договор
// $query_docblankwork = mysqlQuery("SELECT kodblankwork FROM dognet_docblankwork WHERE koddoc=".$__koddoc);
// $row_docblankwork = mysqli_fetch_assoc($query_docblankwork);
// Фиксируем номер бланка на договор, который просматриваем
// $__kodblankwork = $row_docblankwork['kodblankwork'];
// $__kodblankwork = $_SESSION['uniqueID'];
# ----- ----- -----
//
//
//
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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

if ( !isset($_POST['kodblankwork']) || !is_numeric($_POST['kodblankwork']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$_KODBLANKWORK = $_POST['kodblankwork'];
$_KODTIPBLANK = $_POST['kodtipblank'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_docblankwork_files' )
	->fields(
		Field::inst( 'dognet_docblankwork_files.id' ),
		Field::inst( 'dognet_docblankwork_files.kodblankwork' ),
		Field::inst( 'dognet_docblankwork_files.blank_type' ),
		Field::inst( 'dognet_docblankwork_files.blank_status' ),
		Field::inst( 'dognet_docblankwork_files.file_id' ),
		Field::inst( 'dognet_docblankwork_files.file_originalname' ),
		Field::inst( 'dognet_docblankwork_files.file_name' ),
		Field::inst( 'dognet_docblankwork_files.file_extension' ),
		Field::inst( 'dognet_docblankwork_files.file_size' ),
		Field::inst( 'dognet_docblankwork_files.file_syspath' ),
		Field::inst( 'dognet_docblankwork_files.file_webpath' ),
		Field::inst( 'dognet_docblankwork_files.file_url' ),
// ----- ----- ----- ----- -----
		Field::inst( 'dognet_sysdefs_blankstatus.status_kod' ),
		Field::inst( 'dognet_sysdefs_blankstatus.status_description' )
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor, $id ) use ($_KODBLANKWORK) {

	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	->on( 'preGet', function ( $editor, $id ) use ($_KODTIPBLANK) {
		if ($_KODTIPBLANK == "CR") {
			$editor
				->where( function ( $q ) use ($_KODTIPBLANK) {
			    $q->where( 'dognet_docblankwork.koddel', '99', '!=' );
			    $q->and_where( 'dognet_docblankwork_files.blank_status', $_KODTIPBLANK, '=' );
				} );
		}
		if ($_KODTIPBLANK == "RD") {
			$editor
				->where( function ( $q ) use ($_KODTIPBLANK) {
			    $q->where( 'dognet_docblankwork.koddel', '99', '!=' );
				} );
		}
	} )
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_docblankwork', 'dognet_docblankwork.kodblankwork', '=', 'dognet_docblankwork_files.kodblankwork' )
	->leftJoin( 'dognet_sysdefs_blankstatus', 'dognet_sysdefs_blankstatus.status_kod', '=', 'dognet_docblankwork_files.blank_status' )
	->where( 'dognet_docblankwork_files.kodblankwork', $_KODBLANKWORK )
	->process( $_POST )
	->json();

#
#
}


?>
