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
# Функция определения нового ID договора ( koddoc)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextKoddoc() {
	$query = mysqlQuery("SELECT MAX(koddoc) as lastKod FROM dognet_docbase ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_docbase ( $db, $action_docbase, $id, $values ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВЫЙ ДОГОВОР"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_docbase == 'CRT' ) {
#
#

#
#
	}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_docbase == 'UPD' ) {
#
#

#
#
	}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "УДАЛИТЬ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_docbase == 'DEL' ) {
#
#

#
#
	}
#
#
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function doc_block_for_edit( $db, $action_docbase, $id, $values ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_docbase == 'UPD' ) {
#
#
// 			DOCBASE_PR_DOC_BLOCK_FOR_EDIT( $db, "docbase", $id, $action_docbase );
#
#
	}
}
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
// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_docjurnalact' )
	->fields(
		Field::inst( 'dognet_docjurnalact.koddel' ),
		Field::inst( 'dognet_docjurnalact.koddocjurnal'),
		Field::inst( 'dognet_docjurnalact.koddoc'),
		Field::inst( 'dognet_docjurnalact.koddockalplan'),
		Field::inst( 'dognet_docjurnalact.datecreateact')
        ->validator( Validate::dateFormat(
            'd.m.Y H:i:s',
            ValidateOptions::inst()
                ->allowEmpty( true ) ) )
        ->getFormatter( Format::datetime(
            'Y-m-d H:i:s',
            'd.m.Y H:i:s',
        ) )
        ->setFormatter( Format::datetime(
            'd.m.Y H:i:s',
            'Y-m-d H:i:s',
				) ),
		Field::inst( 'dognet_docjurnalact.numberdocact'),
		Field::inst( 'dognet_docjurnalact.summadocact'),
		Field::inst( 'dognet_docjurnalact.docactcreater'),
		Field::inst( 'dognet_docjurnalact.nameactcreate'),
		Field::inst( 'dognet_docjurnalact.docFileID'),
// ----- ----- ----- -----
		Field::inst( 'dognet_docjurnalact_files.id' ),
		Field::inst( 'dognet_docjurnalact_files.flag' ),
		Field::inst( 'dognet_docjurnalact_files.koddocjurnal' ),
		Field::inst( 'dognet_docjurnalact_files.koddoc' ),
		Field::inst( 'dognet_docjurnalact_files.doc_rowid' ),
		Field::inst( 'dognet_docjurnalact_files.file_year' ),
		Field::inst( 'dognet_docjurnalact_files.file_id' ),
		Field::inst( 'dognet_docjurnalact_files.file_name' ),
		Field::inst( 'dognet_docjurnalact_files.file_originalname' ),
		Field::inst( 'dognet_docjurnalact_files.file_extension' ),
		Field::inst( 'dognet_docjurnalact_files.file_symname' ),
		Field::inst( 'dognet_docjurnalact_files.file_size' ),
		Field::inst( 'dognet_docjurnalact_files.file_truelocation' ),
		Field::inst( 'dognet_docjurnalact_files.file_syspath' ),
		Field::inst( 'dognet_docjurnalact_files.file_webpath' ),
		Field::inst( 'dognet_docjurnalact_files.file_url' ),
// ----- ----- ----- -----
		Field::inst( 'dognet_docbase.koddel' ),
		Field::inst( 'dognet_docbase.docnumber' ),
		Field::inst( 'dognet_docbase.docnameshot' ),
		Field::inst( 'dognet_docbase.koddoc' ),
		Field::inst( 'dognet_docbase.koddened' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_dockalplan.kodkalplan' ),
		Field::inst( 'dognet_dockalplan.numberstage' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
	->on( 'preGet', function ( $editor_docbase, $id ) {
		$editor_docbase->where( function ( $q ) {
		    $q->where( 'dognet_docbase.koddel', '99', '!=' );
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postCreate', function ( $editor_docbase, $id, $values, $row ) {
		updateFields_docbase( $editor_docbase->db(), 'CRT', $id, $values );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postEdit', function ( $editor_docbase, $id, $values, $row ) {
		updateFields_docbase( $editor_docbase->db(), 'UPD', $id, $values );
	} )
/*
	->on( 'preEdit', function ( $editor_docbase, $id, $values ) {
		doc_block_for_edit( $editor_docbase->db(), 'UPD', $id, $values );
	} )
*/
	->on( 'preRemove', function ( $editor_docbase, $id, $values ) {
		updateFields_docbase( $editor_docbase->db(), 'DEL', $id, $values );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_docjurnalact_files', 'dognet_docjurnalact_files.id', '=', 'dognet_docjurnalact.docFileID' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docjurnalact.koddoc' )
	->leftJoin( 'dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docjurnalact.koddockalplan' )
	->leftJoin( 'dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened' )
	->process( $_POST )
	->json();

