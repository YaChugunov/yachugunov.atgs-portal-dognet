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

if ( !isset($_POST['kodzayv']) || !is_numeric($_POST['kodzayv']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$__kodzayv = $_POST['kodzayv'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_doczayv_files' )
	->fields(
    Field::inst( 'dognet_doczayv_files.id' ),
    Field::inst( 'dognet_doczayv_files.kodzayv' ),
    Field::inst( 'dognet_doczayv_files.koddoc' ),
    Field::inst( 'dognet_doczayv_files.zayv_type' ),
    Field::inst( 'dognet_doczayv_files.zayv_filetype' ),
    Field::inst( 'dognet_doczayv_files.zayv_rowid' ),
    Field::inst( 'dognet_doczayv_files.doc_rowid' ),
    Field::inst( 'dognet_doczayv_files.file_year' ),
    Field::inst( 'dognet_doczayv_files.file_id' ),
    Field::inst( 'dognet_doczayv_files.file_name' ),
    Field::inst( 'dognet_doczayv_files.file_size' ),
    Field::inst( 'dognet_doczayv_files.file_originalname' ),
    Field::inst( 'dognet_doczayv_files.file_extension' ),
    Field::inst( 'dognet_doczayv_files.file_webpath' ),
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_doczayv.namerabfilespec' ),
    Field::inst( 'dognet_doczayv.kodrabfile' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	)
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor_doczayv_files, $id ) {

	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_doczayv', 'dognet_doczayv.kodzayv', '=', 'dognet_doczayv_files.kodzayv' )
  ->where( 'dognet_doczayv_files.kodzayv', $__kodzayv )
  ->where( 'dognet_doczayv_files.zayv_type', '', '!=' )
	->process( $_POST )
	->json();
}

