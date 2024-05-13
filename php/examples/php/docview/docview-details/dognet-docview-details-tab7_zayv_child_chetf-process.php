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

if ( !isset($_POST['kodzayvchet']) || !is_numeric($_POST['kodzayvchet']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$__kodzayvchet = $_POST['kodzayvchet'];
$__kodzayv = $_POST['kodzayv'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_doczayvchetf' )
	->fields(
		Field::inst( 'dognet_doczayvchetf.koddel' ),
		Field::inst( 'dognet_doczayvchetf.kodzayvchet' ),
		Field::inst( 'dognet_doczayvchetf.kodzayvchetf' ),
		Field::inst( 'dognet_doczayvchetf.zayvchetfnumber' ),
		Field::inst( 'dognet_doczayvchetf.zayvchetfdate' )
        ->validator( Validate::dateFormat(
            'd.m.Y',
            ValidateOptions::inst()
                ->allowEmpty( true ) ) )
        ->getFormatter( Format::datetime(
            'Y-m-d',
            'd.m.Y'
        ) )
        ->setFormatter( Format::datetime(
            'd.m.Y',
            'Y-m-d'
		) ),
		Field::inst( 'dognet_doczayvchetf.zayvchetfsumma' ),
		Field::inst( 'dognet_doczayvchetf.zayvchetfcomment' ),
		Field::inst( 'dognet_doczayvchetf.kodusevalid' ),
		Field::inst( 'dognet_doczayvchetf.namevaliduse' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_doczayvchetf.docFileID' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_doczayvchetf_files.file_webpath' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_doczayvchet.kodzayv' ),
		Field::inst( 'dognet_doczayvchet.zayvchetnumber' ),
		Field::inst( 'dognet_doczayvchet.zayvchetsumma' ),
		Field::inst( 'dognet_doczayvchet.zayvchetdate' )
        ->validator( Validate::dateFormat(
            'd.m.Y',
            ValidateOptions::inst()
                ->allowEmpty( true ) ) )
        ->getFormatter( Format::datetime(
            'Y-m-d',
            'd.m.Y'
        ) )
        ->setFormatter( Format::datetime(
            'd.m.Y',
            'Y-m-d'
		) ),
// ----- ----- -----
		Field::inst( 'dognet_docbase.koddoc' ),
		Field::inst( 'dognet_docbase.docnumber' ),
		Field::inst( 'dognet_docbase.docnameshot' ),
// ----- ----- -----
    Field::inst( 'dognet_spdened.koddened' ),
    Field::inst( 'dognet_spdened.html_code' ),
    Field::inst( 'dognet_spdened.short_code' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	)
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor_doczayvchetf, $id ) {
		$editor_doczayvchetf->where( function ( $q ) {
		    $q->where( 'dognet_doczayvchetf.koddel', '99', '!=' );
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_doczayvchetf_files', 'dognet_doczayvchetf_files.id', '=', 'dognet_doczayvchetf.docFileID' )
	->leftJoin( 'dognet_doczayvchet', 'dognet_doczayvchet.kodzayvchet', '=', 'dognet_doczayvchetf.kodzayvchet' )
	->leftJoin( 'dognet_doczayv', 'dognet_doczayv.kodzayv', '=', 'dognet_doczayvchet.kodzayv' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_doczayv.koddoc' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
  ->where( 'dognet_doczayvchetf.kodzayvchet', $__kodzayvchet )
	->process( $_POST )
	->json();
}
