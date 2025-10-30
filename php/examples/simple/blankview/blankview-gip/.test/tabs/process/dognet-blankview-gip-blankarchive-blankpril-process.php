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
# Функция формирования нового ID счета-фактуры (kodchfact)
# для таблицы этапов 'dognet_kalplanchf'
# ----- ----- -----
function nextKodblankpril() {
	$query = mysqlQuery("SELECT MAX(kodblankpril) as lastKod FROM dognet_blankworkpril ORDER BY id DESC");
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
	$query = mysqlQuery("SELECT MAX(file_id) as lastFileID FROM dognet_blankworkpril_files ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$newFileID = $row['lastFileID'];
	$newFileID++;
	return $newFileID;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция формирования нового ID счета-фактуры (kodchfact)
# для таблицы этапов 'dognet_kalplanchf'
# ----- ----- -----
function nextNumberpril($kodblankwork) {
	$query = mysqlQuery("SELECT MAX(numberpril) as lastnumber FROM dognet_blankworkpril WHERE kodblankwork=".$kodblankwork." ORDER BY id DESC");
	$nextnumber = 0;
	if ($query) {
		$row = mysqli_fetch_assoc($query);
		$lastnumber = $row['lastnumber'];
		$nextnumber = $lastnumber + 1;
		return $nextnumber;
	}
	else {
		$nextnumber = 1;
	return $nextnumber;
	}
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
	$Const_Part_Of_PATH = "/STORAGEDOC/DOCBLANK/DOCBLANKTR".$__CURRENT_YEAR."/";
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
	$__WEBPATH = "/dognet".$Const_Part_Of_PATH;
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
function updateFields_blankworkpril ( $db, $action_blankworkpril, $id, $values, $_KODBLANKWORK, $varFileArray ) {
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "НОВЫЙ ДОКУМЕНТ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_blankworkpril == 'CRT' ) {
#
#
	// Формируем новый идентификатор документа (koddocpaper)
		$__nextKodblankpril = nextKodblankpril();
		$__nextNumberpril = nextNumberpril($_KODBLANKWORK);
		$db->update( 'dognet_blankworkpril', array(
			'kodblankpril' => $__nextKodblankpril,
			'kodblankwork' => $_KODBLANKWORK,
			'numberpril' => $__nextNumberpril,
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
	if ( $action_blankworkpril == 'UPD' ) {
	// Выбираем идентификаторы создаваемого документа
		$_QRY_blankpaper = $db->sql( "SELECT kodblankpril, kodblankwork, docFileID, numberpril FROM dognet_blankworkpril WHERE id=".$id )->fetchAll();
		if ($_QRY_blankpaper) {
			$_kodblankwork = $_QRY_blankpaper[0]['kodblankwork'];
			$_kodblankpril = $_QRY_blankpaper[0]['kodblankpril'];
			$_docFileID = $_QRY_blankpaper[0]['docFileID'];
			$_numberpril = $_QRY_blankpaper[0]['numberpril'];
			$_QRY_blankRowID = $db->sql( "SELECT id FROM dognet_blankdocpost WHERE kodblankwork=".$_kodblankwork )->fetchAll();
			$db->update( 'dognet_blankworkpril_files', array(
				'kodblankpril' => $_QRY_blankpaper[0]['kodblankpril'],
				'kodblankwork' => $_QRY_blankpaper[0]['kodblankwork'],
				'doc_rowid' => $_QRY_blankRowID[0]['id'],
				'pril_rowid' => $id,
				'pril_num' => $_QRY_blankpaper[0]['numberpril']
			), array(
				'id' => $_docFileID
			));
		// ----- --- -----
			$_QRY = $db->sql( "SELECT file_extension FROM dognet_blankworkpril_files WHERE id=".$_docFileID )->fetchAll();
			$db->update( 'dognet_blankworkpril', array(
				'extfile' => $_QRY[0]['file_extension']
			), array(
				'id' => $id
			));
#
#
			if ($_docFileID != "") {

			// Переименовываем файл
				$_QRY_paperfiles = $db->sql( "SELECT flag, file_truelocation, file_syspath, blank_type, pril_ext, file_extension FROM dognet_blankworkpril_files WHERE id=".$_docFileID )->fetchAll();
				if ($_QRY_paperfiles[0]['flag'] == "0") {
					$__ext = $_QRY_paperfiles[0]['file_extension'];
					$__newFileName = "NEW-B-{$_numberpril}-BLANK-CR-{$_kodblankwork}";
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
					$db->update( 'dognet_blankworkpril_files', array(
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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
# :::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ( $action_blankworkpril == 'DEL' ) {

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
	$__rowFileID = $db->sql( "SELECT docFileID FROM dognet_blankworkpril WHERE id=".$id )->fetchAll();
	if ($__rowFileID) {
		$row2delete = $__rowFileID[0]['docFileID'];
		if ($row2delete != '') {
		// Удаление оригинального файла ($__tmp2) и сим-ссылки ($__tmp1) с диска
			$__file = $db->sql( "SELECT file_truelocation, file_syspath FROM dognet_blankworkpril_files WHERE id=".$row2delete )->fetchAll();
			$__tmp1 = unlink($__file[0]['file_syspath']);
			$__tmp2 = unlink($__file[0]['file_truelocation']);
			// Удаление записи в таблице файлов
			if ( $__tmp1 && $__tmp2 ) {
				$query = $db->sql( "DELETE FROM dognet_blankworkpril_files WHERE id=".$row2delete );
			}
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
	$_QRY_kodblankpril = $db->sql( "SELECT kodblankpril FROM dognet_blankworkpril WHERE id=".$id )->fetchAll();
	if ($_QRY_kodblankpril) {
		$kodblankpril = $_QRY_koddocpaper[0]['kodblankpril'];
	//
		$varFileArray = [ 'kodblankpril' => $kodblankpril ];
	}
#
#
}
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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

if ( !isset($_POST['kodblankwork_archive']) || !is_numeric($_POST['kodblankwork_archive']) ) {
	echo json_encode( [ "data" => [] ] );
}
else {
$_KODBLANKWORK = $_POST['kodblankwork_archive'];

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'dognet_blankworkpril' )
	->fields(
		Field::inst( 'dognet_blankworkpril_files.id' ),
		Field::inst( 'dognet_blankworkpril_files.kodblankwork' ),
		Field::inst( 'dognet_blankworkpril_files.kodblankpril' ),
		Field::inst( 'dognet_blankworkpril_files.blank_type' ),
		Field::inst( 'dognet_blankworkpril_files.pril_num' ),
		Field::inst( 'dognet_blankworkpril_files.file_originalname' ),
		Field::inst( 'dognet_blankworkpril_files.file_name' ),
		Field::inst( 'dognet_blankworkpril_files.file_extension' ),
		Field::inst( 'dognet_blankworkpril_files.file_size' ),
		Field::inst( 'dognet_blankworkpril_files.file_syspath' ),
		Field::inst( 'dognet_blankworkpril_files.file_webpath' ),
		Field::inst( 'dognet_blankworkpril_files.file_url' ),
// ----- ----- ----- ----- -----
		Field::inst( 'dognet_blankworkpril.kodblankwork' )
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
		Field::inst( 'dognet_blankworkpril.id' ),
		Field::inst( 'dognet_blankworkpril.kodblankpril' ),
		Field::inst( 'dognet_blankworkpril.kodtipblank' ),
		Field::inst( 'dognet_blankworkpril.numberpril' ),
		Field::inst( 'dognet_blankworkpril.namepril' ),
		Field::inst( 'dognet_blankworkpril.extfile' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
      Field::inst( 'dognet_blankworkpril.docFileID' )
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
	            $db->update( 'dognet_blankworkpril_files', [
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
          ->db( 'dognet_blankworkpril_files', 'id', array(
						'pril_ext' => Upload::DB_EXTN,
						'file_extension' => Upload::DB_EXTN,
						'file_size' => Upload::DB_FILE_SIZE,
						'file_webpath' => '',
						'file_truelocation' => ''
						)
					)
          ->validator( Validate::fileSize( 50000000, 'Размер документа не должен превышать 50МБ' ) )
          ->validator( Validate::fileExtensions( array( 'png', 'jpg', 'pdf', 'doc', 'docx', 'xls', 'xlsx' ), "Загрузите документ" ) )
			)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	)
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'preGet', function ( $editor_blankworkpril, $id ) use ($_KODBLANKWORK) {
		$editor_blankworkpril->where( function ( $q ) use ($_KODBLANKWORK) {
			$q->where( 'dognet_blankworkpril.koddel', '99', '!=');
		} );
	} )
	->on( 'postCreate', function ( $editor_blankworkpril, $id, $values, $row ) use ($_KODBLANKWORK, $varFileArray) {
			updateFields_blankworkpril( $editor_blankworkpril->db(), 'CRT', $id, $values, $_KODBLANKWORK, $varFileArray );
	} )
/*
	->on( 'preGet', function ( $editor, $id ) {
			getKoddocpaper( $editor->db(), $id );
	} )
*/
	->on( 'postEdit', function ( $editor_blankworkpril, $id, $values, $row ) use ($_KODBLANKWORK, $varFileArray) {
			updateFields_blankworkpril( $editor_blankworkpril->db(), 'UPD', $id, $values, $_KODBLANKWORK, $varFileArray );
	} )
	->on( 'preRemove', function ( $editor_blankworkpril, $id, $values ) {
		delAttachment( $editor_blankworkpril->db(), $id );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

	->leftJoin( 'dognet_blankworkpril_files', 'dognet_blankworkpril_files.kodblankpril', '=', 'dognet_blankworkpril.kodblankpril' )
// 	->leftJoin( 'dognet_blankdocpost', 'dognet_blankdocpost.kodblankwork', '=', 'dognet_blankworkpril.kodblankwork' )
	->where( 'dognet_blankworkpril.kodblankwork', $_KODBLANKWORK )
	->process( $_POST )
	->json();

#
#
}


?>
