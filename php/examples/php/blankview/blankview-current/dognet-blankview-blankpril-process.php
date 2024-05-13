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
$kodblankwork = $_POST['kodblankwork'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_blankworkpril_files' )
	->fields(
		Field::inst( 'dognet_blankworkpril_files.id' ),
		Field::inst( 'dognet_blankworkpril_files.kodblankwork' ),
		Field::inst( 'dognet_blankworkpril_files.kodblankpril' ),
		Field::inst( 'dognet_blankworkpril_files.blank_type' ),
		Field::inst( 'dognet_blankworkpril_files.pril_num' ),
		Field::inst( 'dognet_blankworkpril_files.file_originalname' ),
		Field::inst( 'dognet_blankworkpril_files.file_name' ),
		Field::inst( 'dognet_blankworkpril_files.file_extension' ),
		Field::inst( 'dognet_blankworkpril_files.file_size' ),
		Field::inst( 'dognet_blankworkpril_files.file_syspath' ),
		Field::inst( 'dognet_blankworkpril_files.file_webpath' ),
		Field::inst( 'dognet_blankworkpril_files.file_url' ),
// ----- ----- ----- ----- -----
		Field::inst( 'dognet_blankworkpril.id' ),
		Field::inst( 'dognet_blankworkpril.kodblankwork' ),
		Field::inst( 'dognet_blankworkpril.kodblankpril' ),
		Field::inst( 'dognet_blankworkpril.numberpril' ),
		Field::inst( 'dognet_blankworkpril.namepril' ),
		Field::inst( 'dognet_blankworkpril.extfile' )
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor, $id ) use ($kodblankwork) {

	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	->leftJoin( 'dognet_blankworkpril', 'dognet_blankworkpril.kodblankpril', '=', 'dognet_blankworkpril_files.kodblankpril' )
	->where( 'dognet_blankworkpril_files.kodblankwork', $kodblankwork )
	->process( $_POST )
	->json();

#
#
}


?>
