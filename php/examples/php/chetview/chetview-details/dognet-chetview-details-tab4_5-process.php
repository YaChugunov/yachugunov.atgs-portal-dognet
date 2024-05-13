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

// ----- ----- -----
// Определяем номер основного бланка заявки на договор
$query_docblankwork5 = mysqlQuery("SELECT kodblankwork FROM dognet_docblankwork WHERE koddoc=".$__koddoc);
$row_docblankwork5 = mysqli_fetch_assoc($query_docblankwork5); 
if ($row_docblankwork5) {
	// Фиксируем номер бланка на договор, который просматриваем
	$__kodblankwork5 = $row_docblankwork5['kodblankwork'];
} 
else {
	$__kodblankwork5 = "000000000000000";
}

// ----- ----- -----
// Определяем номер основного бланка заявки на договор
$query_blankworkpril5 = mysqlQuery("SELECT kodblankpril FROM dognet_blankworkpril WHERE kodblankwork=".$__kodblankwork5);
$row_blankworkpril5 = mysqli_fetch_assoc($query_blankworkpril5);
if ($row_docblankwork5) {
	// Фиксируем номер бланка на договор, который просматриваем
	$__kodblankpril5 = $row_blankworkpril5['kodblankpril'];
} 
else {
	$__kodblankpril5 = "000000000000000";
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
Editor::inst( $db, 'dognet_blankworkpril' )
	->fields(
		Field::inst( 'dognet_blankworkpril.numberpril' ), 
		Field::inst( 'dognet_blankworkpril.namepril' ),  
		Field::inst( 'dognet_blankworkpril.kodblankwork' ), 
		Field::inst( 'dognet_blankworkpril.kodblankpril' ), 
		Field::inst( 'dognet_blankworkpril_files.kodblankwork' ), 
		Field::inst( 'dognet_blankworkpril_files.file_url' ), 
		Field::inst( 'dognet_blankworkpril_files.file_extension' ), 
		Field::inst( 'dognet_blankworkpril_files.file_name' ) 
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->on( 'preGet', function ( $editor, $id ) use ($__kodblankwork5) { 
		$editor->where(function ( $q ) use ($__kodblankwork5) { 
		    $q->where('dognet_blankworkpril.kodblankwork', $__kodblankwork5);
// 		    $q->where('dognet_blankworkpril.kodblankpril', $__kodblankpril5);
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->leftJoin('dognet_blankworkpril_files', 'dognet_blankworkpril_files.kodblankpril', '=', 'dognet_blankworkpril.kodblankpril')
	->process( $_POST )
	->json();
