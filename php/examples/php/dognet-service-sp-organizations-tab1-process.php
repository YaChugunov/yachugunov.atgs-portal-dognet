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
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
// Функция определения нового кода документа/записи (koddocmail) для таблицы заказчиков
//
function newKodzakaz() {
	$query = mysqlQuery("SELECT MAX(kodzakaz) as lastKod FROM mailbox_sp_zakazchiki ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$newKod = $row['lastKod'];
	$newKod++;
	return $newKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
#
#
// Записываем в БД в таблицу mailbox_log отчет о действии пользователя
function insRecord2log ( $db, $table, $action, $comment, $id, $values ) {
	if ( $action == 'CRT' ) {
		$db->insert( 'mailbox_log', array(
			'log_when'		=> date('Y-m-d H:i:s'), 
			'log_table'		=> $table,
			'log_action'	=> $action,
			'log_whoID'		=> $_SESSION['id'],
			'log_whoNAME'	=> $_SESSION['lastname'],
			'log_values'	=> json_encode( $values ), 
			'log_row'		=> $id,
			'log_ID'		=> newKodzakaz(), 
			'log_comment'	=> $comment
		));
	}
	else {
		$__ID = $db->sql( "SELECT kodzakaz FROM mailbox_sp_zakazchiki WHERE id=".$id )->fetchAll();
		$db->insert( 'mailbox_log', array(
			'log_when'		=> date('Y-m-d H:i:s'), 
			'log_table'		=> $table,
			'log_action'	=> $action,
			'log_whoID'		=> $_SESSION['id'],
			'log_whoNAME'	=> $_SESSION['lastname'],
			'log_values'	=> json_encode( $values ), 
			'log_row'		=> $id,
			'log_ID'		=> $__ID[0]['kodzakaz'], 
			'log_comment'	=> $comment
		));
	}
}	
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
#
#
function updateFields ( $db, $action, $id, $values ) {
	$__zakname = $db->sql( "SELECT zakfistname, zakmidname, zaklastname FROM mailbox_sp_zakazchiki WHERE id=".$id )->fetchAll();
	$zakFIO1 = !empty($__zakname[0]['zaklastname']) ? $__zakname[0]['zaklastname'] . " " : "";
	$zakFIO2 = !empty($__zakname[0]['zakfistname']) ? mb_substr($__zakname[0]['zakfistname'], 0, 1) . ". " : "";
	$zakFIO3 = !empty($__zakname[0]['zakmidname']) ? mb_substr($__zakname[0]['zakmidname'], 0, 1) . ". " : "";
// ----- ----- ----- 
	if ( $action == 'CRT' ) {
		$newKodZakaz = newKodzakaz();
		$db->update( 'mailbox_sp_zakazchiki', array(
			'kodzakaz'			=> $newKodZakaz  
		), array(
			'id' => $id	
		));
	}
	$db->update( 'mailbox_sp_zakazchiki', array(
		'zakfio'			=> $zakFIO1.$zakFIO2.$zakFIO3
	), array(
		'id' => $id	
	));
// ----- ----- ----- 
/*
	$db->update( 'mailbox_log', array(
		'log_ID'			=> $newKodZakaz 
	), array(
		'log_row' => $id	
	));
*/
}
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
Editor::inst( $db, 'mailbox_sp_zakazchiki' )
	->fields(
		Field::inst( 'ID' ), 
		Field::inst( 'kodzakaz' ),
		Field::inst( 'koddel' ), 
		Field::inst( 'namezakshot' )  
		->validator( Validate::notEmpty( ValidateOptions::inst()
			->message( 'Краткое наименование Заказчика обязательно' )	
		) ),
		Field::inst( 'namezaklong' )  
		->validator( Validate::notEmpty( ValidateOptions::inst()
			->message( 'Полное наименование Заказчика обязательно' )	
		) ),
		Field::inst( 'zakuraddress' ),  
		Field::inst( 'zakbankch' ), 
		Field::inst( 'zakinn' ), 
		Field::inst( 'zakkpp' ),  
		Field::inst( 'zakdolg' ), 
		Field::inst( 'zakfio' ), 
		Field::inst( 'zakfistname' ), 
		Field::inst( 'zakmidname' ), 
		Field::inst( 'zaklastname' ), 
		Field::inst( 'zaktelnumber' ) 
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
//
//
	->on( 'postCreate', function ( $editor, $id, $values, $row ) {
		updateFields( $editor->db(), 'CRT', $id, $values );
		insRecord2log( 
			$editor->db(), 
			'sp_zakazchiki', 
			'CRT', 
			'Создание записи', 
			$id, 
			$values 
		);
	} )
	->on( 'postEdit', function ( $editor, $id, $values, $row ) {
		$comment = 'Редактирование записи';
		updateFields( $editor->db(), 'UPD', $id, $values );
		insRecord2log( 
			$editor->db(), 
			'sp_zakazchiki', 
			'UPD', 
			'Редактирование записи', 
			$id, 
			$values 
		);
	} )
	->on( 'preRemove', function ( $editor, $id, $values ) {
		insRecord2log( 
			$editor->db(), 
			'sp_zakazchiki', 
			'DEL', 
			'Удаление записи', 
			$id, 
			$values 
		);
	} )
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	->process( $_POST )
	->json();
	
