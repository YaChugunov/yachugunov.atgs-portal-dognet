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
$query_docblankwork = mysqlQuery("SELECT kodblankwork FROM dognet_docblankwork WHERE koddoc=".$__koddoc);
$row_docblankwork = mysqli_fetch_assoc($query_docblankwork); 
if ($row_docblankwork) { 
	// Фиксируем номер бланка на договор, который просматриваем
	$__kodblankwork = $row_docblankwork['kodblankwork'];
}
else { 
	$__kodblankwork = "000000000000000"; 
}
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
Editor::inst( $db, 'dognet_docblankwork_files' )
	->fields(
		Field::inst( 'dognet_docblankwork_files.kodblankwork' ), 
		Field::inst( 'dognet_docblankwork_files.blank_status' ), 
		Field::inst( 'dognet_docblankwork_files.blank_rowid' ), 
		Field::inst( 'dognet_docblankwork_files.file_url' ), 
		Field::inst( 'dognet_docblankwork_files.file_extension' ), 
		Field::inst( 'dognet_docblankwork_files.file_name' ) 
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->on( 'preGet', function ( $editor, $id ) use ($__kodblankwork) {
		$editor->where( function ( $q ) use ($__kodblankwork) {
				$q->where('dognet_docblankwork_files.kodblankwork', $__kodblankwork);
				$q->where('dognet_docblankwork_files.blank_status', 'DO', '<>'); 
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->process( $_POST )
	->json();
	
