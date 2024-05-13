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
# для таблицы этапов 'dognet_docpaperotgr'
# ----- ----- -----
function nextKoddocpaper() {
	$query = mysqlQuery("SELECT MAX(koddoc) as lastKod FROM dognet_docpaperotgr ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(13, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: О Б Р А Б О Т Ч И К   З А Г Р У З К И   Ф А Й Л А
# :::
#
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
#
	$__CURRENT_YEAR = date('Y');
	$tmpfolder = $__CURRENT_YEAR;
#
# ----- --- ----- --- ----- ---
# !!! ОЧЕНЬ ВАЖНЫЕ СТРОКИ !!!
# ----- --- ----- --- ----- ---
#
# Постоянная часть пути
// 	$Const_Part_Of_PATH = "/STORAGEDOC/DOCOTGRP/OTGR".$__CURRENT_YEAR."/";
	$Const_Part_Of_PATH = "/STORAGEDOC/DOCOTGRP/OTGR".$__CURRENT_YEAR."/";
#
#
# Имя столбца в таблице файлов: file_truelocation
# Путь, где распологается оригинальный файл
	$_QRY_GetStorageFolder = mysqlQuery("SELECT storagefolder_name FROM dognet_settings_storagefolders WHERE storagefolder_use = '1'");

	$_ROW_GetStorageFolder = mysqli_fetch_assoc($_QRY_GetStorageFolder);
	if ($_QRY_GetStorageFolder) { $StorageName = $_ROW_GetStorageFolder['storagefolder_name']; }

	$d = dir($StorageName.$Const_Part_Of_PATH);
	$__DOCPATH = $d->path;
#
#
# Имя столбца в таблице файлов: file_webpath
# Формируем часть URL (без http://, имени хоста и сервиса) симлинка на оригинальный файл
// 	$__WEBPATH = "/dognet".$Const_Part_Of_PATH;
	$__WEBPATH = "".$Const_Part_Of_PATH;
#
#
# Имя столбца в таблице файлов: file_syspath
# Серверный путь (PATH) к симлинку на оригинальный файл
	$__SYSPATH = $_SERVER['DOCUMENT_ROOT']."/dognet".$Const_Part_Of_PATH;
#
# ----- --- ----- --- ----- ---
#
	$varFileArray = [
		'year' => $__CURRENT_YEAR,
		'docpath' => $__DOCPATH,
		'webpath' => $__WEBPATH,
		'syspath' => $__SYSPATH
	];
#
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_docpaperotgr ( $db, $action_docpaperotgr, $id, $values, $varFileArray ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВЫЙ ДОГОВОР"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_docpaperotgr == 'CRT' ) {
#
#
		$_QRY_docPapermemo = $db->sql( "SELECT papermemo FROM dognet_docpaperotgr WHERE id=".$id )->fetchAll();
		$_QRY_docbase = $db->sql( "SELECT koddoc FROM dognet_docbase WHERE docnumber=".$_QRY_docPapermemo[0]['papermemo'] )->fetchAll();
	// Формируем новый идентификатор договора (koddoc)
		$__nextKoddocpaper = nextKoddocpaper();

		$db->update( 'dognet_docpaperotgr', array(
			'koddocpaper'			=>	$__nextKoddocpaper,
			'koddoc'			=>	$_QRY_docbase[0]['koddoc'],
			'docFileID' => ""
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
	if ( $action_docpaperotgr == 'UPD' ) {
#
#
	// В papermemo храним номер договора, чтобы не создавать новое специальное поле
		$_QRY_docPapermemo = $db->sql( "SELECT papermemo FROM dognet_docpaperotgr WHERE id=".$id )->fetchAll();
		$_QRY_docbase = $db->sql( "SELECT koddoc FROM dognet_docbase WHERE docnumber=".$_QRY_docPapermemo[0]['papermemo'] )->fetchAll();

	// Выбираем идентификаторы создаваемого документа
		$_QRY_docPaper = $db->sql( "SELECT koddocpaper, koddoc, kodpaper, docFileID FROM dognet_docpaperotgr WHERE id=".$id )->fetchAll();
		if ($_QRY_docPaper) {
			$_koddoc = $_QRY_docbase[0]['koddoc'];
			$_koddocpaper = $_QRY_docPaper[0]['koddocpaper'];
			$_docFileID = $_QRY_docPaper[0]['docFileID'];
			$_QRY_docRowID = $db->sql( "SELECT id FROM dognet_docbase WHERE koddoc=".$_koddoc )->fetchAll();
			$db->update( 'dognet_docpaperotgr_files', array(
				'koddocpaper' => $_QRY_docPaper[0]['koddocpaper'],
				'koddoc' => $_koddoc,
				'kodpaper' => $_QRY_docPaper[0]['kodpaper'],
				'doc_rowid' => $_QRY_docRowID[0]['id'],
				'paper_rowid' => $id
			), array(
				'id' => $_docFileID
			));
		// Обновляем koddoc на случай, если был изменен номер договора в поле papermemo
			$db->update( 'dognet_docpaperotgr', array(
				'koddoc' => $_koddoc,
			), array(
				'id' => $id
			));
#
#
			if ($_docFileID != "") {

			// Переименовываем файл
				$_QRY_paperfiles = $db->sql( "SELECT flag, file_truelocation, file_syspath, paper_filetype, file_extension FROM dognet_docpaperotgr_files WHERE id=".$_docFileID )->fetchAll();
				if ($_QRY_paperfiles[0]['flag'] == "0") {
					$__ext = $_QRY_paperfiles[0]['file_extension'];
					$__newFileName = "NEW-OTGR{$_koddocpaper}";
				// Формируем новый симлинк
					$md5 = md5(uniqid());
					$__newFileSymName = "{$md5}.{$__ext}";
				// Переименовываем реальный файл
					rename($_QRY_paperfiles[0]['file_truelocation'], $varFileArray['docpath']."{$__newFileName}.{$__ext}");
				// Формируем новый симлинк
					symlink( $varFileArray['docpath']."{$__newFileName}.{$__ext}", $varFileArray['syspath']."{$__newFileName}.{$__ext}" );
				// Удаляем старый симлинк
					unlink($_QRY_paperfiles[0]['file_syspath']);
				// Формируем новый URL
					$__NewURL = str_replace($_SERVER['DOCUMENT_ROOT'], 'http://'.$_SERVER['HTTP_HOST'], $varFileArray['syspath']."{$__newFileName}.{$__ext}");
				// Обновляем запись в таблице файлов
					$db->update( 'dognet_docpaperotgr_files', array(
						"file_name" => $__newFileName,
						"file_symname" => $__newFileName,
						"file_truelocation" => $varFileArray['docpath']."{$__newFileName}.{$__ext}",
						"file_syspath" => $varFileArray['syspath']."{$__newFileName}.{$__ext}", // Симлинк пока не используем!
						"file_webpath" => $varFileArray['webpath']."{$__newFileName}.{$__ext}", // Симлинк пока не используем!
						"file_url" => $__NewURL,
						"flag" => "1"
					), array(
						"id" => $_docFileID
					));
				}
			}
		}
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
	if ( $action_docpaperotgr == 'DEL' ) {
#
#

//

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
Editor::inst( $db, 'dognet_docpaperotgr' )
	->fields(
		Field::inst( 'dognet_docpaperotgr.koddel' ),
		Field::inst( 'dognet_docpaperotgr.koddocpaper' ),
		Field::inst( 'dognet_docpaperotgr.koddoc' ),
		Field::inst( 'dognet_docpaperotgr.kodpaper' )
			->options( Options::inst()
				->table( 'dognet_sptippaper' )
				->value( 'kodpaper' )
				->label( array('kodpaper', 'namepaper') )
				->render( function ( $row ) {
					return $row['namepaper'];
					})
				->where(function ($q) {
					$q->where('namepaper', '', '!=');
					$q->and_where('kodusepril', '2', '=');
					})
			)
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Выберите тип документа' )
			) ),
		Field::inst( 'dognet_docpaperotgr.filetype' ),
		Field::inst( 'dognet_docpaperotgr.papermemo' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Номер договора ХХХХ' )
			) ),
		Field::inst( 'dognet_docpaperotgr.commentloader' ),
		Field::inst( 'dognet_docpaperotgr.dateloader' )
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
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_docpaperotgr.dateotgr' )
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
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_docpaperotgr.nameotgr' ),
		Field::inst( 'dognet_docpaperotgr.nameorgotgr' ),
		Field::inst( 'dognet_docpaperotgr.namedocotgr' ),
		Field::inst( 'dognet_docpaperotgr.commentotgr' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_docpaperotgr.docFileID' )
        ->setFormatter( Format::ifEmpty( null ) )
        ->upload(
        	Upload::inst( function ( $file, $id ) use ( $varFileArray, $db ) {
						$__pref = date('Y').$_SESSION['id'].date('mdHis');
// 					$__name = $__pref."-".$file['name'];
						$__name = $file['name'];
						$__nameTmp = $file['tmp_name'];
						$__ext = explode('.', $__name);
						$__ext = strtolower(end($__ext));
						$md5 = md5(uniqid());
						$__nameMD5 = "{$md5}.{$__ext}";
						$__name2save = "TMPNAME.{$__pref}";

//
						$__url = str_replace($_SERVER['DOCUMENT_ROOT'], 'http://'.$_SERVER['HTTP_HOST'], $varFileArray['syspath'].$__nameMD5);
//
						move_uploaded_file($__nameTmp, $varFileArray['docpath']."{$__name2save}");
						symlink( $varFileArray['docpath']."{$__name2save}", $varFileArray['syspath'].$__nameMD5 );
//
// Database table to update
            $db->update( 'dognet_docpaperotgr_files', [
							'flag' => '0',
// ---
							'file_year' => $varFileArray['year'],
							'file_id' => '',
							'file_name' => $__name2save,
							'file_originalname' => $__name,
							'file_symname' => $__nameMD5,
							'file_truelocation' => $varFileArray['docpath']."{$__name2save}",
// ---
							'file_syspath' => $varFileArray['syspath'].$__nameMD5,
							'file_webpath' => $varFileArray['webpath'].$__nameMD5,
							'file_url' => $__url
							], [ 'id' => $id ]
	          );
            return $id;
        	})
        ->db( 'dognet_docpaperotgr_files', 'id', array(
					'paper_filetype' => Upload::DB_EXTN,
					'file_extension' => Upload::DB_EXTN,
					'file_size' => Upload::DB_FILE_SIZE,
					'file_webpath' => '',
					'file_truelocation' => ''
					)
				)
        ->validator( Validate::fileSize( 50000000, 'Размер документа не должен превышать 50МБ' ) )
        ->validator( Validate::fileExtensions( array( 'png', 'jpg', 'pdf', 'doc', 'docx', 'xls', 'xlsx' ), "Загрузите документ" ) )
		),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_docbase.koddoc' ),
    Field::inst( 'dognet_docbase.docnumber' ),
    Field::inst( 'dognet_docbase.docnamefullm' ),
    Field::inst( 'dognet_docbase.docnameshot' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
    Field::inst( 'dognet_sptippaper.kodpaper' ),
    Field::inst( 'dognet_sptippaper.namepaper' )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	)
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor_docpaperotgr, $id ) {
		$editor_docpaperotgr->where( function ( $q ) {
		    $q->where( 'dognet_docpaperotgr.koddel', '99', '!=' );
		} );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postCreate', function ( $editor_docpaperotgr, $id, $values, $row ) use ($varFileArray) {
		updateFields_docpaperotgr( $editor_docpaperotgr->db(), 'CRT', $id, $values, $varFileArray );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postEdit', function ( $editor_docpaperotgr, $id, $values, $row ) use ($varFileArray) {
		updateFields_docpaperotgr( $editor_docpaperotgr->db(), 'UPD', $id, $values, $varFileArray );
	} )
/*
	->on( 'preEdit', function ( $editor_docpaperotgr, $id, $values ) {
		doc_block_for_edit( $editor_docpaperotgr->db(), 'UPD', $id, $values );
	} )
*/
	->on( 'preRemove', function ( $editor_docpaperotgr, $id, $values ) use ($varFileArray) {
		updateFields_docpaperotgr( $editor_docpaperotgr->db(), 'DEL', $id, $values, $varFileArray );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docpaperotgr.koddoc' )
	->leftJoin( 'dognet_sptippaper', 'dognet_sptippaper.kodpaper', '=', 'dognet_docpaperotgr.kodpaper' )
	->process( $_POST )
	->json();

