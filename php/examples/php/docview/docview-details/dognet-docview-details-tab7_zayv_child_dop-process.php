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
function nextKodzayvdop() {
	$query = mysqlQuery("SELECT MAX(kodzayvdop) as lastKod FROM dognet_doczayvdop ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 13);
	return $nextKod;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового ID договора ( koddoc)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextNumberdop($kodzayv) {
	$query = mysqlQuery("SELECT MAX(numberdop) as lastNumber FROM dognet_doczayvdop WHERE kodzayv=".$kodzayv." ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastNumber = $row['lastNumber'];
	$nextNumber = $lastNumber + 1;
	return $nextNumber;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_doczayvdop ( $db, $action_doczayvchet, $id, $values, $kodzayv ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВЫЙ ДОГОВОР"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_doczayvchet == 'CRT' ) {
#
#
	// Формируем новый идентификатор договора (koddoc)
		$__nextKodzayvdop = nextKodzayvdop();
		$__nextNumberdop = nextNumberdop($kodzayv);

		$db->update( 'dognet_doczayvdop', array(
			'kodzayv'			=>	$kodzayv,
			'kodzayvdop'	=>	$__nextKodzayvdop,
			'numberdop'		=>	$__nextNumberdop
		), array( 'id' => $id ));
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
	if ( $action_doczayvchet == 'UPD' ) {
#
#

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
	if ( $action_doczayvchet == 'DEL' ) {
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
function doc_block_for_edit( $db, $action_doczayvchet, $id, $values ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_doczayvchet == 'UPD' ) {
#
#


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

if ( !isset($_POST['kodzayv']) || !is_numeric($_POST['kodzayv']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$__kodzayv = $_POST['kodzayv'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_doczayvdop' )
	->fields(
		Field::inst( 'dognet_doczayvdop.koddel' ),
		Field::inst( 'dognet_doczayvdop.kodzayv' )
			->options( Options::inst()
				->table( 'dognet_doczayv' )
				->value( 'kodzayv' )
				->label( array('kodzayv', 'numberzayv', 'datezayv') )
				->render( function ( $row ) use ($__kodzayv) {
					return ("Заявка ".$row['numberzayv']);
					})
				->where(function ($q) use ($__kodzayv) {
					$q->where('kodzayv', $__kodzayv, '=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Заявка обязательна' )
			) ),
		Field::inst( 'dognet_doczayvdop.kodzayvdop' ),
		Field::inst( 'dognet_doczayvdop.numberdop' ),
		Field::inst( 'dognet_doczayvdop.namedop' ),
		Field::inst( 'dognet_doczayvdop.modeldop' ),
		Field::inst( 'dognet_doczayvdop.koldop' ),
		Field::inst( 'dognet_doczayvdop.commentdop' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_doczayv.koddoc' ),
		Field::inst( 'dognet_doczayv.kodzayv' ),
		Field::inst( 'dognet_doczayv.kodispol' ),
		Field::inst( 'dognet_doczayv.kodzayvtel' ),
		Field::inst( 'dognet_doczayv.kodrabzayv' ),
		Field::inst( 'dognet_doczayv.numberzayv' ),
		Field::inst( 'dognet_doczayv.namedoc' ),
		Field::inst( 'dognet_doczayv.kodrabfile' ),
		Field::inst( 'dognet_doczayv.namerabfilespec' ),
		Field::inst( 'dognet_doczayv.rabfileexp' ),
		Field::inst( 'dognet_doczayv.tipusezayv' ),
		Field::inst( 'dognet_doczayv.kodtipzayv' ),
		Field::inst( 'dognet_doczayv.kodusecht' ),
		Field::inst( 'dognet_doczayv.rabzayvdoc' ),
		Field::inst( 'dognet_doczayv.zayvchetcom' ),
		Field::inst( 'dognet_doczayv.kodtipzayvall' ),
		Field::inst( 'dognet_doczayv.koduseobjwork' ),
		Field::inst( 'dognet_doczayv.kodusepoligon' ),
		Field::inst( 'dognet_doczayv.zayvchetcomall' ),
// ----- ----- -----
		Field::inst( 'dognet_docbase.koddoc' ),
		Field::inst( 'dognet_docbase.docnumber' ),
		Field::inst( 'dognet_docbase.docnameshot' ),
// ----- ----- -----
    Field::inst( 'dognet_sptipzayvall.kodtipzayvall' ),
    Field::inst( 'dognet_sptipzayvall.nametipzayvshotall' ),
    Field::inst( 'dognet_sptipzayvall.nametipzayvfullall' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	)
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor_docbase, $id ) {
		$editor_docbase->where( function ( $q ) {
		    $q->where( 'dognet_doczayvdop.koddel', '99', '!=' );
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postCreate', function ( $editor_docbase, $id, $values, $row ) use ($__kodzayv) {
		updateFields_doczayvdop( $editor_docbase->db(), 'CRT', $id, $values, $__kodzayv );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postEdit', function ( $editor_docbase, $id, $values, $row ) use ($__kodzayv) {
		updateFields_doczayvdop( $editor_docbase->db(), 'UPD', $id, $values, $__kodzayv );
	} )
/*
	->on( 'preEdit', function ( $editor_docbase, $id, $values ) {
		doc_block_for_edit( $editor_docbase->db(), 'UPD', $id, $values );
	} )
*/
	->on( 'preRemove', function ( $editor_docbase, $id, $values ) use ($__kodzayv) {
		updateFields_doczayvdop( $editor_docbase->db(), 'DEL', $id, $values, $__kodzayv );
	} )

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_doczayv', 'dognet_doczayv.kodzayv', '=', 'dognet_doczayvdop.kodzayv' )
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_doczayv.koddoc' )
	->leftJoin( 'dognet_sptipzayv', 'dognet_sptipzayv.kodtipzayv', '=', 'dognet_doczayv.kodtipzayv' )
	->leftJoin( 'dognet_sptipzayvall', 'dognet_sptipzayvall.kodtipzayvall', '=', 'dognet_doczayv.kodtipzayvall' )
  ->where( 'dognet_doczayvdop.kodzayv', $__kodzayv )
	->process( $_POST )
	->json();
}

