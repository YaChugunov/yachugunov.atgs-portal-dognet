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
// $_UNIQUEID = $_SESSION['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция формирования нового ID счета-фактуры (kodchfact)
# для таблицы этапов 'dognet_kalplanchf'
# ----- ----- -----
function nextKoddocpaper() {
	$query = mysqlQuery("SELECT MAX(koddocpaper) as lastKod FROM dognet_agreepaper ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера файла (file_id) для таблицы файлов
# ----- ----- -----
function newFileID() {
	$query = mysqlQuery("SELECT MAX(file_id) as lastFileID FROM dognet_agreepaper_files ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$newFileID = $row['lastFileID'];
	$newFileID++;
	return $newFileID;
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
	// $Const_Part_Of_PATH = "/STORAGEDOC/AGRPAPER/DNUSE".$__CURRENT_YEAR."/";
	$Const_Part_Of_PATH = "/STORAGEDOC/AGRPAPER/DNUSE/";
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
	$__WEBPATH = $Const_Part_Of_PATH;
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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления нового номера этапа (numberstage)
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- -----
function updateFields_docpaper ( $db, $action_docpaper, $id, $values, $__uniqueID, $varFileArray ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВЫЙ ДОКУМЕНТ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_docpaper == 'CRT' ) {
#
#
	// Формируем новый идентификатор документа (koddocpaper)
		$__nextKoddocpaper = nextKoddocpaper();
		$db->update( 'dognet_agreepaper', array(
			'koddocpaper' => $__nextKoddocpaper,
			'koddoc' => $__uniqueID,
			'docFileID' => ''
		), array( 'id' => $id ));
	}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_docpaper == 'UPD' ) {
	// Выбираем идентификаторы создаваемого документа
		$_QRY_docPaper = $db->sql( "SELECT koddocpaper, koddoc, kodpaper, docFileID FROM dognet_agreepaper WHERE id=".$id )->fetchAll();
		if ($_QRY_docPaper) {
			$_koddoc = $_QRY_docPaper[0]['koddoc'];
			$_koddocpaper = $_QRY_docPaper[0]['koddocpaper'];
			$_docFileID = $_QRY_docPaper[0]['docFileID'];
			$_QRY_docRowID = $db->sql( "SELECT id FROM dognet_agreebase WHERE koddoc=".$_koddoc )->fetchAll();
			$db->update( 'dognet_agreepaper_files', array(
				'koddocpaper' => $_QRY_docPaper[0]['koddocpaper'],
				'koddoc' => $_QRY_docPaper[0]['koddoc'],
				'kodpaper' => $_QRY_docPaper[0]['kodpaper'],
				'doc_rowid' => $_QRY_docRowID[0]['id'],
				'paper_rowid' => $id
			), array(
				'id' => $_docFileID
			));
#
#
# UPD 14/05/20
# УДАЛАЯЕМ (ПОМЕЧАЕМ) ПРЕДЫДУЩИЕ (БОЛЕЕ НЕАКТУАЛЬНЫЕ ЗАГРУЗКИ) К ТОЙ ЖЕ ЗАПИСИ (KODDOCPAPER)
// 		$_QRY_MARK2DEL = $db->sql( "UPDATE dognet_agreepaper_files SET flag='99', koddoc='' WHERE koddocpaper = '".$_koddocpaper."' AND id<>'".$_docFileID."'" );
#
#
			if ($_docFileID != "") {

			// Переименовываем файл
				$_QRY_paperfiles = $db->sql( "SELECT flag, file_truelocation, file_syspath, paper_filetype, file_extension FROM dognet_agreepaper_files WHERE id=".$_docFileID )->fetchAll();
				if ($_QRY_paperfiles[0]['flag'] == "0") {
					$__ext = $_QRY_paperfiles[0]['file_extension'];
					$__newFileName = "NEW-APU{$_koddocpaper}-".$_SESSION['id']."-".date('YmdHis');
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
					$db->update( 'dognet_agreepaper_files', array(
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
	}
#
#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
function delAttachment ( $db, $id ) {
#
#
	$__rowFileID = $db->sql( "SELECT docFileID FROM dognet_agreepaper WHERE id=".$id )->fetchAll();
	$row2delete = $__rowFileID[0]['docFileID'];
	if ($row2delete!="") {
		$row2delete = $__rowFileID[0]['docFileID'];
	// Удаление оригинального файла ($__tmp2) и сим-ссылки ($__tmp1) с диска
		$__file = $db->sql( "SELECT file_truelocation, file_syspath FROM dognet_agreepaper_files WHERE id=".$row2delete )->fetchAll();
		$__tmp1 = unlink($__file[0]['file_syspath']);
		$__tmp2 = unlink($__file[0]['file_truelocation']);
		// Удаление записи в таблице файлов
		if ( $__tmp1 && $__tmp2 ) {
			$query = $db->sql( "DELETE FROM dognet_agreepaper_files WHERE id=".$row2delete );
		}
	}
#
#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
function getKoddocpaper ( $db, $id ) {
#
#
	$_QRY_koddocpaper = $db->sql( "SELECT koddocpaper FROM dognet_agreepaper WHERE id=".$id )->fetchAll();
	if ($_QRY_koddocpaper) {
		$koddocpaper = $_QRY_koddocpaper[0]['koddocpaper'];
	//
		$varFileArray = [ 'koddocpaper' => $koddocpaper ];
	}
#
#
}
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

if ( !isset($_POST['koddoc']) || !is_numeric($_POST['koddoc']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$KODDOC = $_POST['koddoc'];

// Build our Editor instance and process the data coming from _POST
	Editor::inst( $db, 'dognet_agreepaper' )
	  ->fields(
      Field::inst( 'dognet_agreepaper.koddocpaper' ),
      Field::inst( 'dognet_agreepaper.koddoc' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_agreepaper.kodpaper' )
				->options( Options::inst()
					->table( 'dognet_sptippaper' )
					->value( 'kodpaper' )
					->label( array('kodpaper', 'namepaper') )
					->render( function ( $row ) {
						return $row['namepaper'];
						})
				)
				->validator( Validate::notEmpty( ValidateOptions::inst()
					->message( 'Выберите тип документа' )
				) ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_agreepaper.kodmainpaper' ),
      Field::inst( 'dognet_agreepaper.dateloader' )
	        ->validator( Validate::dateFormat(
	            'd.m.Y',
	            ValidateOptions::inst()
	                ->allowEmpty( false ) ) )
	        ->getFormatter( Format::datetime(
	            'Y-m-d',
	            'd.m.Y'
	        ) )
	        ->setFormatter( Format::datetime(
	            'd.m.Y',
	            'Y-m-d'
				) ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_agreepaper.filetype' ),
      Field::inst( 'dognet_agreepaper.paperfull' ),
      Field::inst( 'dognet_agreepaper.commentloader' ),
      Field::inst( 'dognet_agreepaper.commentfile' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_agreepaper.docFileID' )
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
	            $db->update( 'dognet_agreepaper_files', [
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
          ->db( 'dognet_agreepaper_files', 'id', array(
						'paper_filetype' => Upload::DB_EXTN,
						'file_extension' => Upload::DB_EXTN,
						'file_size' => Upload::DB_FILE_SIZE,
						'file_webpath' => '',
						'file_truelocation' => ''
						)
					)
          ->validator( Validate::fileSize( 50000000, 'Размер документа не должен превышать 50МБ' ) )
          ->validator( Validate::fileExtensions( array( 'png', 'jpg', 'pdf', 'doc', 'docx', 'docm', 'xls', 'xlsx' ), "Загрузите документ" ) )
			),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_agreepaper_files.flag' ),
      Field::inst( 'dognet_agreepaper_files.file_webpath' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_sptippaper.namepaper' ),
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_agreebase.koddoc' ),
      Field::inst( 'dognet_agreebase.docnumber' )
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
  )
	->on( 'preGet', function ( $editor_docpaper, $id ) use ($KODDOC) {
		$editor_docpaper->where( function ( $q ) use ($KODDOC) {
			$q->where( 'dognet_agreepaper.koddel', '99', '!=');
// 			$q->where( 'dognet_agreepaper_files.flag', '99', '!=');
		} );
	} )
	->on( 'postCreate', function ( $editor_docpaper, $id, $values, $row ) use ($KODDOC, $varFileArray) {
			updateFields_docpaper( $editor_docpaper->db(), 'CRT', $id, $values, $KODDOC, $varFileArray );
	} )
/*
	->on( 'preGet', function ( $editor, $id ) {
			getKoddocpaper( $editor->db(), $id );
	} )
*/
	->on( 'postEdit', function ( $editor_docpaper, $id, $values, $row ) use ($KODDOC, $varFileArray) {
			updateFields_docpaper( $editor_docpaper->db(), 'UPD', $id, $values, $KODDOC, $varFileArray );
	} )
	->on( 'preRemove', function ( $editor, $id, $values ) {
		delAttachment( $editor->db(), $id );
	} )
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	->leftJoin( 'dognet_agreepaper_files', 'dognet_agreepaper_files.koddocpaper', '=', 'dognet_agreepaper.koddocpaper' )
	->leftJoin( 'dognet_sptippaper', 'dognet_sptippaper.kodpaper', '=', 'dognet_agreepaper.kodpaper' )
	->leftJoin( 'dognet_agreebase', 'dognet_agreebase.koddoc', '=', 'dognet_agreepaper.koddoc' )

  ->where( 'dognet_agreepaper.koddoc', $KODDOC)
  ->process( $_POST )
  ->json();

}
