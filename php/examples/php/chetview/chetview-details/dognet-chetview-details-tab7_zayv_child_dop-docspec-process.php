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

if ( !isset($_POST['koddoc']) || !is_numeric($_POST['koddoc']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$__koddoc = $_POST['koddoc'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_docpaper' )
	->fields(
      Field::inst( 'dognet_docpaper.koddocpaper' ),
      Field::inst( 'dognet_docpaper.koddoc' ),
      Field::inst( 'dognet_docpaper.kodpaper' ),
      Field::inst( 'dognet_docpaper.kodmainpaper' ),
      Field::inst( 'dognet_docpaper.dateloader' ),
      Field::inst( 'dognet_docpaper.filetype' ),
      Field::inst( 'dognet_docpaper.paperfull' ),
      Field::inst( 'dognet_docpaper.commentloader' ),
      Field::inst( 'dognet_docpaper.commentfile' ),
      Field::inst( 'dognet_docpaper.docFileID' ),
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_docpaper_files.id' ),
	    Field::inst( 'dognet_docpaper_files.file_name' ),
	    Field::inst( 'dognet_docpaper_files.file_size' ),
	    Field::inst( 'dognet_docpaper_files.file_originalname' ),
	    Field::inst( 'dognet_docpaper_files.file_extension' ),
	    Field::inst( 'dognet_docpaper_files.file_webpath' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	)
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor, $id ) {
		$editor->where( function ( $q ) {
		    $q->where( 'dognet_docpaper.koddel', '99', '!=' );
		    $q->and_where( function ( $r ) {
			    // Выбираем только тип "Спецификации"
				    $r->where( 'dognet_docpaper.kodpaper', '245362842313531');
				    $r->or_where( 'dognet_docpaper.kodpaper', '245560251956480');
				} );
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_docpaper_files', 'dognet_docpaper_files.id', '=', 'dognet_docpaper.docFileID' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docpaper.koddoc' )
  ->where( 'dognet_docpaper.koddoc', $__koddoc )
	->process( $_POST )
	->json();
}

