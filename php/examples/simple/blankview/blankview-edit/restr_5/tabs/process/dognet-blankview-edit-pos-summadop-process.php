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
# Функция формирования нового ID доп суммы к бланку ПНР (kodsummadop)
# для таблицы этапов 'dognet_blanksummadop'
# ----- ----- -----
function nextKodbsummadop() {
	$query = mysqlQuery("SELECT MAX(kodsummadop) as lastKod FROM dognet_blanksummadop ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function updateFields_blanksummadop ( $db, $action_blanksummadop, $id, $values, $kodblankwork, $kodtipblank ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВЫЙ ДОКУМЕНТ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_blanksummadop == 'CRT' ) {
#
#
	// Формируем новый идентификатор документа (koddocpaper)
		$__nextKodsummadop = nextKodbsummadop();
		$db->update( 'dognet_blanksummadop', array(
			'kodsummadop' => $__nextKodsummadop,
			'kodblankwork' => $kodblankwork,
			'kodtipblank' => $kodtipblank
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
	if ( $action_blanksummadop == 'UPD' ) {
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
	if ( $action_blanksummadop == 'DEL' ) {
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
#
# Example PHP implementation used for the index.html example
#
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

if ( !isset($_POST['kodblankwork_tab2_summadop']) || !is_numeric($_POST['kodblankwork_tab2_summadop']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$_KODBLANKWORK = $_POST['kodblankwork_tab2_summadop'];
$_KODTIPBLANK = $_POST['kodtipblank_tab2_summadop'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_blanksummadop' )
	->fields(
		Field::inst( 'dognet_blanksummadop.id' ),
// ----- ----- ----- ----- -----
		Field::inst( 'dognet_blanksummadop.kodblankwork' )
		->options( Options::inst()
			->table( 'dognet_blankdocpost' )
			->value( 'kodblankwork' )
			->label( array('kodblankwork') )
			->render( function ( $row ) {
				return $row['kodblankwork'];
				})
			->where(function ($q) use ($_KODBLANKWORK)  {
				$q->where('kodblankwork', $_KODBLANKWORK, '=');
				})
		)
		->validator( Validate::notEmpty( ValidateOptions::inst()
			->message( 'Выберите бланк' )
		) ),
// ----- ----- ----- ----- -----
		Field::inst( 'dognet_blanksummadop.kodsummadop' ),
		Field::inst( 'dognet_blanksummadop.kodtipblank' ),
		Field::inst( 'dognet_blanksummadop.namesummadop' ),
		Field::inst( 'dognet_blanksummadop.summadopblank' ),
// ----- ----- ----- ----- -----
		Field::inst( 'dognet_sysdefs_blankstatus.status_kod' ),
		Field::inst( 'dognet_sysdefs_blankstatus.status_description' )
	)
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	->on( 'preGet', function ( $editor_blanksummadop, $id ) {
		$editor_blanksummadop->where( function ( $q ) {
		    $q->where( 'dognet_blanksummadop.koddel', '99', '!=' );
		} );
	} )
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	->on( 'postCreate', function ( $editor_blanksummadop, $id, $values, $row ) use ($_KODBLANKWORK, $_KODTIPBLANK) {
			updateFields_blanksummadop( $editor_blanksummadop->db(), 'CRT', $id, $values, $_KODBLANKWORK, $_KODTIPBLANK );
	} )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_docblankwork', 'dognet_docblankwork.kodblankwork', '=', 'dognet_blanksummadop.kodblankwork' )
	->leftJoin( 'dognet_sysdefs_blankstatus', 'dognet_sysdefs_blankstatus.status_kod', '=', 'dognet_blanksummadop.kodtipblank' )
	->where( 'dognet_docblankwork.kodblankwork', $_KODBLANKWORK )
	->process( $_POST )
	->json();

#
#
}


?>
