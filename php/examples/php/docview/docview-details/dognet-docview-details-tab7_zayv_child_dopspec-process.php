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
function nextKodzayvdopspec() {
	$query = mysqlQuery("SELECT MAX(kodzayvdopspec) as lastKod FROM dognet_doczayvdopspec ORDER BY id DESC");
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
function nextNumberdopspec($kodzayv) {
	$query = mysqlQuery("SELECT MAX(numberdopspec) as lastNumber FROM dognet_doczayvdopspec WHERE kodzayv=".$kodzayv." ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastNumber = $row['lastNumber'];
	$nextNumber = $lastNumber + 1;
	return $nextNumber;
}
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
// 	$Const_Part_Of_PATH = "/STORAGEDOC/DOCZAYV/DOCZAYV".$__CURRENT_YEAR."/";
	$Const_Part_Of_PATH = "/STORAGEDOC/DOCZAYV/DOCZAYV".$__CURRENT_YEAR."/";
#
#
# Имя столбца в таблице файлов: file_truelocation
# Путь, где распологается оригинальный файл
#
	# Для отладки на локальной машине
// 	$d = dir("/Volumes/Work/tmp/mnt/docNET".$Const_Part_Of_PATH);
#
	# Для работы с реальным сервером
		# Рабочий путь
			$d = dir("/mnt/docNET".$Const_Part_Of_PATH);
		# Отладочный путь
// 			$d = dir("/mnt/__docNET".$Const_Part_Of_PATH);

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
function updateFields_doczayv_files ( $db, $action_doczayvchet, $id, $values, $varFileArray, $kodzayv ) {
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
	//
		$__nextKodzayvdopspec = nextKodzayvdopspec();
		$__nextNumberdopspec = nextNumberdopspec($kodzayv);

		$db->update( 'dognet_doczayvdopspec', array(
			'kodzayv' => $kodzayv,
			'kodzayvdopspec'			=>	$__nextKodzayvdopspec,
			'numberdopspec'		=>	$__nextNumberdopspec,
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
	if ( $action_doczayvchet == 'UPD' ) {
#
#
	// В papermemo храним номер договора, чтобы не создавать новое специальное поле
		$_QRY_1 = $db->sql( "SELECT kodzayv, docFileID, dopFileID, kodmainspec FROM dognet_doczayvdopspec WHERE id=".$id )->fetchAll();
	//
		if ($_QRY_1) {
			$_kodzayv = $_QRY_1[0]['kodzayv'];
			$_docFileID = $_QRY_1[0]['docFileID'];
			$_dopFileID = $_QRY_1[0]['dopFileID'];
			$_kodmainspec = $_QRY_1[0]['kodmainspec'];
			//
			$_QRY_zayvRowID = $db->sql( "SELECT id, koddoc FROM dognet_doczayv WHERE kodzayv=".$_kodzayv )->fetchAll();
			$_koddoc = $_QRY_zayvRowID[0]['koddoc'];
			$__zayvRowID = $_QRY_zayvRowID[0]['id'];
			//
			$_QRY_docRowID = $db->sql( "SELECT id FROM dognet_docbase WHERE koddoc=".$_koddoc )->fetchAll();
			$__docRowID = $_QRY_docRowID[0]['id'];
			//
			$db->update( 'dognet_doczayvdopspec_files', array(
				'kodzayv' => $_kodzayv,
				'zayv_rowid' => $__zayvRowID
			), array(
				'id' => $_dopFileID
			));
			//
			if ($_kodmainspec == 1) {
				$db->update( 'dognet_doczayv', array(
					'docFileID' => $_docFileID
				), array(
					'kodzayv' => $_kodzayv
				));
			}
			//
#
#
			if ($_dopFileID != "") {

			// Переименовываем файл
				$_QRY_paperfiles = $db->sql( "SELECT flag, file_truelocation, file_syspath, file_extension FROM dognet_doczayvdopspec_files WHERE id=".$_dopFileID )->fetchAll();
				if ($_QRY_paperfiles[0]['flag'] == "0") {
					$__ext = $_QRY_paperfiles[0]['file_extension'];
					$__newFileName = "DOPSPEC{$_kodzayv}";
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
					$db->update( 'dognet_doczayvdopspec_files', array(
						"file_name" => $__newFileName,
						"file_symname" => $__newFileName,
						"file_truelocation" => $varFileArray['docpath']."{$__newFileName}.{$__ext}",
						"file_syspath" => $varFileArray['syspath']."{$__newFileName}.{$__ext}", // Симлинк пока не используем!
						"file_webpath" => $varFileArray['webpath']."{$__newFileName}.{$__ext}", // Симлинк пока не используем!
						"file_url" => $__NewURL,
						"flag" => "1"
					), array(
						"id" => $_dopFileID
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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция удаления файлов и записи в таблице файлов счетов-фактур (dognet_doczayvchetf)
#
function delAttachment ( $db, $id ) {
#
#
	$__rowFileID = $db->sql( "SELECT * FROM dognet_doczayvdopspec WHERE id=".$id )->fetchAll();
	$kodzayv = $__rowFileID[0]['kodzayv'];
	$row2delete = $__rowFileID[0]['dopFileID'];
	$kodmainspec = $__rowFileID[0]['kodmainspec'];

	if ($row2delete!="") {
	// Удаление оригинального файла ($__tmp2) и сим-ссылки ($__tmp1) с диска
		$__file = $db->sql( "SELECT file_truelocation, file_syspath FROM dognet_doczayvdopspec_files WHERE id=".$row2delete )->fetchAll();
		$__tmp1 = unlink($__file[0]['file_syspath']);
		$__tmp2 = unlink($__file[0]['file_truelocation']);
		// Удаление записи в таблице файлов
		if ( $__tmp1 && $__tmp2 ) {
			$query = $db->sql( "DELETE FROM dognet_doczayvdopspec_files WHERE id=".$row2delete );
			if ($kodmainspec=1) {
				$query = $db->sql( "UPDATE dognet_doczayv SET docFileID='' WHERE kodzayv=".$kodzayv );
			}
		}
	}
#
#
}
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
Editor::inst( $db, 'dognet_doczayvdopspec' )
	->fields(
    Field::inst( 'dognet_doczayvdopspec.kodzayv' ),
    Field::inst( 'dognet_doczayvdopspec.kodzayvdopspec' ),
    Field::inst( 'dognet_doczayvdopspec.datedopspec' )
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
    Field::inst( 'dognet_doczayvdopspec.numberdopspec' ),
    Field::inst( 'dognet_doczayvdopspec.namedopspec' ),
    Field::inst( 'dognet_doczayvdopspec.kodmainspec' ),
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst( 'dognet_doczayvdopspec.dopFileID' )
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
            $db->update( 'dognet_doczayvdopspec_files', [
							'flag' => '0',
// ---
							'file_year' => $varFileArray['year'],
							'file_id' => $id,
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
        ->db( 'dognet_doczayvdopspec_files', 'id', array(
					'file_extension' => Upload::DB_EXTN,
					'file_size' => Upload::DB_FILE_SIZE,
					'file_webpath' => '',
					'file_truelocation' => ''
					)
				)
        ->validator( Validate::fileSize( 50000000, 'Размер документа не должен превышать 50МБ' ) )
        ->validator( Validate::fileExtensions( array( 'png', 'jpg', 'pdf', 'doc', 'docx', 'xls', 'xlsx' ), "Загрузите документ" ) )
		),
// ----- ----- -----
		Field::inst( 'dognet_doczayv.kodrabzayv' ),
		Field::inst( 'dognet_doczayv.numberzayv' ),
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
	->on( 'preGet', function ( $editor_doczayv_files, $id ) {

	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postCreate', function ( $editor_doczayv_files, $id, $values, $row ) use ($varFileArray, $__kodzayv) {
		updateFields_doczayv_files( $editor_doczayv_files->db(), 'CRT', $id, $values, $varFileArray, $__kodzayv );
	} )
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on( 'postEdit', function ( $editor_doczayv_files, $id, $values, $row ) use ($varFileArray, $__kodzayv) {
		updateFields_doczayv_files( $editor_doczayv_files->db(), 'UPD', $id, $values, $varFileArray, $__kodzayv );
	} )
/*
	->on( 'preEdit', function ( $editor_doczayv_files, $id, $values ) {
		doc_block_for_edit( $editor_doczayv_files->db(), 'UPD', $id, $values );
	} )
*/
	->on( 'preRemove', function ( $editor_doczayv_files, $id, $values ) use ($varFileArray, $__kodzayv) {
		delAttachment( $editor_doczayv_files->db(), $id );
		updateFields_doczayv_files( $editor_doczayv_files->db(), 'DEL', $id, $values, $varFileArray, $__kodzayv );
	} )

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin( 'dognet_doczayv', 'dognet_doczayv.kodzayv', '=', 'dognet_doczayvdopspec.kodzayv' )
	->leftJoin( 'dognet_sptipzayvall', 'dognet_sptipzayvall.kodtipzayvall', '=', 'dognet_doczayv.kodtipzayvall' )
  ->where( 'dognet_doczayvdopspec.kodzayv', $__kodzayv )
	->process( $_POST )
	->json();
}

