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
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = "245847329098834";

# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
Editor::inst( $db, 'dognet_spcontact' )
	->fields(
		//
		Field::inst( 'dognet_spcontact.koddel' ),
		Field::inst( 'dognet_spcontact.kodcontact' ),
		Field::inst( 'dognet_spcontact.koddoc' ),
		Field::inst( 'dognet_spcontact.kodblankwork' ),
		Field::inst( 'dognet_spcontact.kodzakaz' ),
		Field::inst( 'dognet_spcontact.namecontactend' ),
		Field::inst( 'dognet_spcontact.namecontactfist' ),
		Field::inst( 'dognet_spcontact.namecontactsecond' ),
		Field::inst( 'dognet_spcontact.namecontactshot' ),
		Field::inst( 'dognet_spcontact.telcontact1' ),
		Field::inst( 'dognet_spcontact.telcontact2' ),
		Field::inst( 'dognet_spcontact.telcontact3' ),
		Field::inst( 'dognet_spcontact.telcontactmobi' ),
		Field::inst( 'dognet_spcontact.emailcontact' ),
		Field::inst( 'dognet_spcontact.faxcontact' ),
		Field::inst( 'dognet_spcontact.doljcontact' ),
		Field::inst( 'dognet_spcontact.contactprim' )
	)
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
	->where( 'dognet_spcontact.koddoc', $__uniqueID )
	->process( $_POST )
	->json();

