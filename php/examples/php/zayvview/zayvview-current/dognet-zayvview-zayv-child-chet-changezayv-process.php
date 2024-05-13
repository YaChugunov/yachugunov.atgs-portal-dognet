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

if ( !isset($_POST['kodzayv']) || !is_numeric($_POST['kodzayv']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$__kodzayv = $_POST['kodzayv'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_doczayvchet' )
	->fields(
		Field::inst( 'dognet_doczayvchet.koddel' ),
		Field::inst( 'dognet_doczayvchet.datezayv' ),
		Field::inst( 'dognet_doczayvchet.kodzayv' )
			->options( Options::inst()
				->table( 'dognet_doczayv' )
				->value( 'kodzayv' )
				->label( array('kodzayv', 'numberzayv', 'datezayv') )
				->render( function ( $row ) {
					return ("Заявка ".$row['numberzayv']);
					})
				->where( function ($q) {
					$q->where('koddel', '99', '!=');
					$q->where(YEAR('datezayv'), date('Y'), '=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Заявка обязательна' )
			) )
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->process( $_POST )
	->json();
}

