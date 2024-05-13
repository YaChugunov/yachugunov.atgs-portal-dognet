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
Editor::inst( $db, 'dognet_doczayv' )
	->fields(
		Field::inst( 'dognet_docbase.koddel' ),
		Field::inst( 'dognet_doczayv.kodzayv' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.koddoc' )
			->options( Options::inst()
				->table( 'dognet_docbase' )
				->value( 'koddoc' )
				->label( array('koddoc', 'docnumber', 'docnameshot') )
				->render( function ( $row ) {
					return ("Договор 3-4/".$row['docnumber']." : ".$row['docnameshot']);
					})
				->where(function ($q) {
					$q->where('koddel', '99', '!=');
					})
			),
		Field::inst( 'dognet_doczayv.kodispol' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodzayvtel' )
			->options( Options::inst()
				->table( 'dognet_spzayvtel' )
				->value( 'kodzayvtel' )
				->label( array('kodzayvtel', 'namezayvtelshot') )
				->render( function ( $row ) {
					return ($row['namezayvtelshot']);
					})
				->where(function ($q) {
					$q->where('koddel', '99', '!=');
					$q->where('kodzayvtel', '0000000000000000', '!=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Заявитель обязателен' )
			) ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodrabzayv' ),
		Field::inst( 'dognet_doczayv.numberzayv' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.datezayv' )
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
		Field::inst( 'dognet_doczayv.namedoc' ),
		Field::inst( 'dognet_doczayv.kodrabfile' ),
		Field::inst( 'dognet_doczayv.namerabfilespec' ),
		Field::inst( 'dognet_doczayv.rabfileexp' ),
		Field::inst( 'dognet_doczayv.tipusezayv' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodtipzayv' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodusecht' ),
		Field::inst( 'dognet_doczayv.rabzayvdoc' ),
		Field::inst( 'dognet_doczayv.zayvchetcom' ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodtipzayvall' )
			->options( Options::inst()
				->table( 'dognet_sptipzayvall' )
				->value( 'kodtipzayvall' )
				->label( array('kodtipzayvall', 'nametipzayvshotall') )
				->render( function ( $row ) {
					return ($row['nametipzayvshotall']);
					})
				->where(function ($q) {
					$q->where('koddel', '99', '!=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Тип обязателен' )
			) ),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.koduseobjwork' ),
		Field::inst( 'dognet_doczayv.kodusepoligon' ),
		Field::inst( 'dognet_doczayv.zayvchetcomall' ),
// ----- ----- -----
		Field::inst( 'dognet_docbase.docnumber' ),
		Field::inst( 'dognet_docbase.docnameshot' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_sptipzayv.kodtipzayv' ),
    Field::inst( 'dognet_sptipzayv.namezayvshot' ),
    Field::inst( 'dognet_sptipzayv.namezayvfull' ),
    Field::inst( 'dognet_sptipzayv.shifrzayv' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_sptipzayvall.kodtipzayvall' ),
    Field::inst( 'dognet_sptipzayvall.nametipzayvshotall' ),
    Field::inst( 'dognet_sptipzayvall.nametipzayvfullall' ),
    Field::inst( 'dognet_sptipzayvall.usesimple' ),
    Field::inst( 'dognet_sptipzayvall.usespec' ),
    Field::inst( 'dognet_sptipzayvall.koddoclim' ),
    Field::inst( 'dognet_sptipzayvall.kodshab' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	)
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor_docbase, $id ) {
		$editor_docbase->where( function ( $q ) {
		    $q->where( 'dognet_doczayv.koddel', '99', '!=' );
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
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_doczayv.koddoc' )
	->leftJoin( 'dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_doczayv.kodispol' )
	->leftJoin( 'dognet_sptipzayv', 'dognet_sptipzayv.kodtipzayv', '=', 'dognet_doczayv.kodtipzayv' )
	->leftJoin( 'dognet_sptipzayvall', 'dognet_sptipzayvall.kodtipzayvall', '=', 'dognet_doczayv.kodtipzayvall' )
	->process( $_POST )
	->json();

