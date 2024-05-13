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
$__koddoc = $_SESSION['uniqueID'];
// Определяем номер основного бланка заявки на договор
$query_docpaper = mysqlQuery("SELECT koddocpaper, kodpaper FROM dognet_docpaper WHERE koddoc=".$__koddoc);
$row_docpaper = mysqli_fetch_assoc($query_docpaper);
// Фиксируем номер бланка на договор, который просматриваем
$__koddocpaper = $row_docpaper['koddocpaper'];
$__kodpaper = $row_docpaper['kodpaper'];
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
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_docpaper' )
	->fields(
		Field::inst( 'dognet_docpaper.id' ),  
		Field::inst( 'dognet_docpaper.koddocpaper' ), 
		Field::inst( 'dognet_docpaper.koddoc' ),  
		Field::inst( 'dognet_docpaper.kodpaper' ),   
		Field::inst( 'dognet_docpaper.filetype' ),   
		Field::inst( 'dognet_docpaper.paperfull' ),   
		Field::inst( 'dognet_docpaper_files.koddocpaper' ), 
		Field::inst( 'dognet_docpaper_files.kodpaper' ), 
		Field::inst( 'dognet_docpaper_files.paper_rowid' ), 
		Field::inst( 'dognet_docpaper_files.file_url' ), 
		Field::inst( 'dognet_docpaper_files.file_extension' ), 
		Field::inst( 'dognet_docpaper_files.file_name' ) 
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->on( 'preGet', function ( $editor, $id ) use ($__koddoc) {
		$editor->where( function ( $q ) use ($__koddoc) {
				$q->where('dognet_docpaper.koddoc', $__koddoc); 
				$q->where('dognet_docpaper.filetype', 'pdf', '<>'); 
			} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		

	->leftJoin( 'dognet_docpaper_files', 'dognet_docpaper_files.koddocpaper', '=', 'dognet_docpaper.koddocpaper' )
	->process( $_POST )
	->json();
	
