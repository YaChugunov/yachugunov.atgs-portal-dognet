<?php
date_default_timezone_set('Europe/Moscow');
# Подключаем конфигурационный файл
// require($_SERVER['DOCUMENT_ROOT']."/config.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаемся к базе
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/_assets/drivers/db_controller.php");
$db_handle = new DBController();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Подключаем общие функции безопасности
// require(dirname(__FILE__) . '/_assets/functions/funcSecure.inc.php');
require($_SERVER['DOCUMENT_ROOT'] . "/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового ID договора ( koddoc)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextKodzayvchetf()
{
	$query = mysqlQuery("SELECT MAX(kodzayvchetf) as lastKod FROM dognet_doczayvchetf ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ОПИСАНИЕ : Сумма всех оплат счета-фактуры $kodchfsubpodr
#
#
function SUMMA_CHET_CHF($kodzayvchet)
{
	$_QRY = mysqlQuery("SELECT SUM(zayvchetfsumma) as SummaChf FROM dognet_doczayvchetf WHERE kodzayvchet=" . $kodzayvchet);
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY) {
		$__SummaChf = $_ROW['SummaChf'];
	} else {
		$__SummaChf = "";
	}
	return $__SummaChf;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ОПИСАНИЕ : Сумма всех оплат счета-фактуры $kodchfsubpodr
#
#
function PERCENT_CHET_OPL($kodzayvchet)
{
	$_QRY = mysqlQuery("SELECT SUM(zayvchetfsumma) as SummaChf FROM dognet_doczayvchetf WHERE kodzayvchet=" . $kodzayvchet);
	$_ROW = mysqli_fetch_assoc($_QRY);
	if ($_QRY) {
		$__SummaChf = $_ROW['SummaChf'];
		$_QRY1 = mysqlQuery("SELECT zayvchetsumma FROM dognet_doczayvchet WHERE kodzayvchet=" . $kodzayvchet);
		$_ROW1 = mysqli_fetch_assoc($_QRY1);
		if ($_QRY1) {
			$__SummaCh = $_ROW1['zayvchetsumma'];
			$__percentChetOpl = ($__SummaChf / $__SummaCh) * 100;
		} else {
			$__percentChetOpl = "";
		}
	} else {
		$__percentChetOpl = "";
	}
	return $__percentChetOpl;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::
# ::: О Б Р А Б О Т Ч И К   З А Г Р У З К И   Ф А Й Л А
# :::
#
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
	$Const_Part_Of_PATH = "/STORAGEDOC/ZAYVCFZ/CFZ" . $__CURRENT_YEAR . "/";
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
	$d = dir("/mnt/docNET" . $Const_Part_Of_PATH);
	# Отладочный путь
	// $d = dir("/mnt/__docNET".$Const_Part_Of_PATH);

	$__DOCPATH = $d->path;
	#
	#
	# Имя столбца в таблице файлов: file_webpath
	# Формируем часть URL (без http://, имени хоста и сервиса) симлинка на оригинальный файл
	// 	$__WEBPATH = "/dognet".$Const_Part_Of_PATH;
	$__WEBPATH = "" . $Const_Part_Of_PATH;
	#
	#
	# Имя столбца в таблице файлов: file_syspath
	# Серверный путь (PATH) к симлинку на оригинальный файл
	$__SYSPATH = $_SERVER['DOCUMENT_ROOT'] . "/dognet" . $Const_Part_Of_PATH;
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
function updateFields_doczayvchetf($db, $action_doczayvchetf, $id, $values, $varFileArray, $kodzayvchet)
{
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВЫЙ ДОГОВОР"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_doczayvchetf == 'CRT') {
		#
		#
		$__nextKodzayvchetf = nextKodzayvchetf();

		$db->update('dognet_doczayvchetf', array(
			'kodzayvchetf'			=>	$__nextKodzayvchetf,
			'kodzayvchet'			=>	$kodzayvchet,
			'docFileID' => ""
		), array('id' => $id));
		// .....
		// Считаем процент закрытия счета
		$_QRY = $db->sql("SELECT kodzayvchet, zayvchetfsumma FROM dognet_doczayvchetf WHERE id=" . $id)->fetchAll();
		$kod = $_QRY[0]['kodzayvchet'];
		$sumchf = $_QRY[0]['zayvchetfsumma'];
		$_QRY1 = $db->sql("SELECT zayvchetsumma FROM dognet_doczayvchet WHERE kodzayvchet=" . $kod)->fetchAll();
		$sumch = $_QRY1[0]['zayvchetsumma'];
		//
		$_QRY2 = $db->sql("SELECT SUM(zayvchetfsumma) as SummaChf FROM dognet_doczayvchetf WHERE kodzayvchet=" . $kod)->fetchAll();
		$sumallchf = $_QRY2[0]['SummaChf'];
		$sumallchf0 = $sumallchf - $sumchf;
		$perc = ($sumallchf / $sumch) * 100;
		$zadol = $sumch - $sumallchf;
		//
		$db->update('dognet_doczayvchet', array(
			'zayvchetpr' => $perc,
			'zayvchetzadol' => $zadol
		), array(
			'kodzayvchet' => $kod
		));
		// .....
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
	if ($action_doczayvchetf == 'UPD') {
		#
		#
		// В papermemo храним номер договора, чтобы не создавать новое специальное поле
		$_QRY_1 = $db->sql("SELECT kodzayvchet, zayvchetfsumma FROM dognet_doczayvchetf WHERE id=" . $id)->fetchAll();
		$_QRY_2 = $db->sql("SELECT kodzayv FROM dognet_doczayvchet WHERE kodzayvchet=" . $_QRY_1[0]['kodzayvchet'])->fetchAll();
		//
		// Выбираем идентификаторы создаваемого документа
		$_QRY_3 = $db->sql("SELECT kodzayvchet, kodzayvchetf, docFileID FROM dognet_doczayvchetf WHERE id=" . $id)->fetchAll();
		if ($_QRY_3) {
			$_kodzayvchetf = $_QRY_3[0]['kodzayvchetf'];
			$_kodzayvchet = $_QRY_1[0]['kodzayvchet'];
			$_kodzayv = $_QRY_2[0]['kodzayv'];
			$_docFileID = $_QRY_3[0]['docFileID'];
			//
			$_QRY_chtRowID = $db->sql("SELECT id FROM dognet_doczayvchet WHERE kodzayvchet=" . $_kodzayvchet)->fetchAll();
			$__chtRowID = $_QRY_chtRowID[0]['id'];
			//
			$_QRY_zayvRowID = $db->sql("SELECT id FROM dognet_doczayv WHERE kodzayv=" . $_kodzayv)->fetchAll();
			$__zayvRowID = $_QRY_zayvRowID[0]['id'];
			//
			$db->update('dognet_doczayvchetf_files', array(
				'kodzayv' => $_kodzayv,
				'kodzayvchet' => $_kodzayvchet,
				'kodzayvchetf' => $_kodzayvchetf,
				'zayv_rowid' => $__zayvRowID,
				'zayvchet_rowid' => $__chtRowID,
				'zayvchetf_rowid' => $id
			), array(
				'id' => $_docFileID
			));
			//
			$sumchf = $_QRY_1[0]['zayvchetfsumma'];
			$_QRY_4 = $db->sql("SELECT zayvchetsumma FROM dognet_doczayvchet WHERE kodzayvchet=" . $_kodzayvchet)->fetchAll();
			$sumch = $_QRY_4[0]['zayvchetsumma'];
			//
			$_QRY2 = $db->sql("SELECT SUM(zayvchetfsumma) as SummaChf FROM dognet_doczayvchetf WHERE kodzayvchet=" . $_kodzayvchet)->fetchAll();
			$sumallchf = $_QRY2[0]['SummaChf'];
			$sumallchf0 = $sumallchf - $sumchf;
			$perc = ($sumallchf / $sumch) * 100;
			$zadol = $sumch - $sumallchf;
			//
			$db->update('dognet_doczayvchet', array(
				'zayvchetpr' => $perc,
				'zayvchetzadol' => $zadol
			), array(
				'kodzayvchet' => $_kodzayvchet
			));
			#
			#
			if ($_docFileID != "") {

				// Переименовываем файл
				$_QRY_paperfiles = $db->sql("SELECT flag, file_truelocation, file_syspath, zayvchetf_filetype, file_extension FROM dognet_doczayvchetf_files WHERE id=" . $_docFileID)->fetchAll();
				if ($_QRY_paperfiles[0]['flag'] == "Just uploaded") {
					$__ext = $_QRY_paperfiles[0]['file_extension'];
					$__newFileName = "CFZ{$_kodzayvchetf}";
					// Формируем новый симлинк
					$md5 = md5(uniqid());
					$__newFileSymName = "{$md5}.{$__ext}";
					// Переименовываем реальный файл
					rename($_QRY_paperfiles[0]['file_truelocation'], $varFileArray['docpath'] . "{$__newFileName}.{$__ext}");
					// Формируем новый симлинк
					symlink($varFileArray['docpath'] . "{$__newFileName}.{$__ext}", $varFileArray['syspath'] . "{$__newFileName}.{$__ext}");
					// Удаляем старый симлинк
					unlink($_QRY_paperfiles[0]['file_syspath']);
					// Формируем новый URL
					$__NewURL = str_replace($_SERVER['DOCUMENT_ROOT'], 'http://' . $_SERVER['HTTP_HOST'], $varFileArray['syspath'] . "{$__newFileName}.{$__ext}");
					// Обновляем запись в таблице файлов
					$db->update('dognet_doczayvchetf_files', array(
						"file_name" => $__newFileName,
						"file_symname" => $__newFileName,
						"file_truelocation" => $varFileArray['docpath'] . "{$__newFileName}.{$__ext}",
						"file_syspath" => $varFileArray['syspath'] . "{$__newFileName}.{$__ext}", // Симлинк пока не используем!
						"file_webpath" => $varFileArray['webpath'] . "{$__newFileName}.{$__ext}", // Симлинк пока не используем!
						"file_url" => $__NewURL,
						"flag" => "Ready for use"
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
	if ($action_doczayvchetf == 'DEL') {
		#
		#
		$_QRY = $db->sql("SELECT kodzayvchet, zayvchetfsumma FROM dognet_doczayvchetf WHERE id=" . $id)->fetchAll();
		$kod = $_QRY[0]['kodzayvchet'];
		$sumchf = $_QRY[0]['zayvchetfsumma'];
		$_QRY1 = $db->sql("SELECT zayvchetsumma FROM dognet_doczayvchet WHERE kodzayvchet=" . $kod)->fetchAll();
		$sumch = $_QRY1[0]['zayvchetsumma'];
		//
		$_QRY2 = $db->sql("SELECT SUM(zayvchetfsumma) as SummaChf FROM dognet_doczayvchetf WHERE kodzayvchet=" . $kod)->fetchAll();
		$sumallchf = $_QRY2[0]['SummaChf'];
		$sumallchf0 = $sumallchf - $sumchf;
		$perc = ($sumallchf0 / $sumch) * 100;
		$zadol = $sumch - $sumallchf0;
		//
		$db->update('dognet_doczayvchet', array(
			'zayvchetpr' => $perc,
			'zayvchetzadol' => $zadol
		), array(
			'kodzayvchet' => $kod
		));
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
function delAttachment($db, $id)
{
	#
	#
	$__rowFileID = $db->sql("SELECT docFileID FROM dognet_doczayvchetf WHERE id=" . $id)->fetchAll();
	$row2delete = $__rowFileID[0]['docFileID'];
	if ($row2delete != "") {
		// Удаление оригинального файла ($__tmp2) и сим-ссылки ($__tmp1) с диска
		$__file = $db->sql("SELECT file_truelocation, file_syspath FROM dognet_doczayvchetf_files WHERE id=" . $row2delete)->fetchAll();
		$__tmp1 = unlink($__file[0]['file_syspath']);
		$__tmp2 = unlink($__file[0]['file_truelocation']);
		// Удаление записи в таблице файлов
		if ($__tmp1 && $__tmp2) {
			$query = $db->sql("DELETE FROM dognet_doczayvchetf_files WHERE id=" . $row2delete);
		}
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
/*
 * Example PHP implementation used for the index.html example
*/
// DataTables PHP library
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_datatables-php-api-editor/DataTables.php");
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

if (!isset($_POST['kodzayvchet_archive']) || !is_numeric($_POST['kodzayvchet_archive'])) {
	echo json_encode(["data" => []]);
} else {
	$__kodzayvchet = $_POST['kodzayvchet_archive'];

	// Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_doczayvchetf')
		->fields(
			Field::inst('dognet_doczayvchetf.ID'),
			Field::inst('dognet_doczayvchetf.koddel'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_doczayvchetf.kodzayvchetf'),
			Field::inst('dognet_doczayvchetf.zayvchetfnumber'),
			Field::inst('dognet_doczayvchetf.zayvchetfdate')
				->validator(Validate::dateFormat(
					'd.m.Y',
					ValidateOptions::inst()
						->allowEmpty(true)
				))
				->getFormatter(Format::datetime(
					'Y-m-d',
					'd.m.Y'
				))
				->setFormatter(Format::datetime(
					'd.m.Y',
					'Y-m-d'
				)),
			Field::inst('dognet_doczayvchetf.zayvchetfsumma'),
			Field::inst('dognet_doczayvchetf.zayvchetfcomment'),
			Field::inst('dognet_doczayvchetf.kodusevalid'),
			Field::inst('dognet_doczayvchetf.namevaliduse'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_doczayvchetf.docFileID')
				->setFormatter(Format::ifEmpty(null))
				->upload(
					Upload::inst(function ($file, $id) use ($varFileArray, $db) {
						$__pref = date('Y') . $_SESSION['id'] . date('mdHis');
						// 					$__name = $__pref."-".$file['name'];
						$__name = $file['name'];
						$__nameTmp = $file['tmp_name'];
						$__ext = explode('.', $__name);
						$__ext = strtolower(end($__ext));
						$md5 = md5(uniqid());
						$__nameMD5 = "{$md5}.{$__ext}";
						$__name2save = "TMPNAME.{$__pref}";

						//
						$__url = str_replace($_SERVER['DOCUMENT_ROOT'], 'http://' . $_SERVER['HTTP_HOST'], $varFileArray['syspath'] . $__nameMD5);
						//
						move_uploaded_file($__nameTmp, $varFileArray['docpath'] . "{$__name2save}");
						symlink($varFileArray['docpath'] . "{$__name2save}", $varFileArray['syspath'] . $__nameMD5);
						//
						// Database table to update
						$db->update(
							'dognet_doczayvchetf_files',
							[
								'flag' => 'Just uploaded',
								// ---
								'file_year' => $varFileArray['year'],
								'file_id' => '',
								'file_name' => $__name2save,
								'file_originalname' => $__name,
								'file_symname' => $__nameMD5,
								'file_truelocation' => $varFileArray['docpath'] . "{$__name2save}",
								// ---
								'file_syspath' => $varFileArray['syspath'] . $__nameMD5,
								'file_webpath' => $varFileArray['webpath'] . $__nameMD5,
								'file_url' => $__url
							],
							['id' => $id]
						);
						return $id;
					})
						->db(
							'dognet_doczayvchetf_files',
							'id',
							array(
								'zayvchetf_filetype' => Upload::DB_EXTN,
								'file_extension' => Upload::DB_EXTN,
								'file_size' => Upload::DB_FILE_SIZE,
								'file_webpath' => '',
								'file_truelocation' => ''
							)
						)
						->validator(Validate::fileSize(50000000, 'Размер документа не должен превышать 50МБ'))
						->validator(Validate::fileExtensions(array('png', 'jpg', 'pdf', 'doc', 'docx', 'xls', 'xlsx'), "Загрузите документ"))
				),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_doczayvchet.ID'),
			Field::inst('dognet_doczayvchet.kodzayv'),
			Field::inst('dognet_doczayvchet.koddel'),
			Field::inst('dognet_doczayvchet.kodpost'),
			Field::inst('dognet_doczayvchet.kodzayvchet'),
			Field::inst('dognet_doczayvchet.zayvchetnumber'),
			Field::inst('dognet_doczayvchet.zayvchetdate'),
			Field::inst('dognet_doczayvchet.zayvchetsumma'),
			Field::inst('dognet_doczayvchet.zayvchetpr'),
			Field::inst('dognet_doczayvchet.zayvchetzadol'),
			Field::inst('dognet_doczayvchet.zayvchetcomment'),
			Field::inst('dognet_doczayvchet.controlrab'),
			Field::inst('dognet_doczayvchet.zayvchetchetfcom'),
			Field::inst('dognet_doczayvchet.kodpokup'),
			Field::inst('dognet_doczayvchet.controlrab1'),
			// ----- ----- -----
			Field::inst('dognet_docbase.koddoc'),
			Field::inst('dognet_docbase.docnumber'),
			Field::inst('dognet_docbase.docnameshot'),
			// ----- ----- -----
			Field::inst('dognet_spdened.koddened'),
			Field::inst('dognet_spdened.html_code'),
			Field::inst('dognet_spdened.short_code')
		)
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		#
		#
		->on('preGet', function ($editor_doczayvchetf, $id) {
			$editor_doczayvchetf->where(function ($q) {
				$q->where('dognet_doczayvchetf.koddel', '99', '!=');
			});
		})
		//
		->on('postCreate', function ($editor_doczayvchetf, $id, $values, $row) use ($varFileArray, $__kodzayvchet) {
			updateFields_doczayvchetf($editor_doczayvchetf->db(), 'CRT', $id, $values, $varFileArray, $__kodzayvchet);
		})
		//
		->on('postEdit', function ($editor_doczayvchetf, $id, $values, $row) use ($varFileArray, $__kodzayvchet) {
			updateFields_doczayvchetf($editor_doczayvchetf->db(), 'UPD', $id, $values, $varFileArray, $__kodzayvchet);
		})
		//
		->on('preRemove', function ($editor_doczayvchetf, $id, $values) use ($varFileArray, $__kodzayvchet) {
			delAttachment($editor_doczayvchetf->db(), $id);
			updateFields_doczayvchetf($editor_doczayvchetf->db(), 'DEL', $id, $values, null, $__kodzayvchet);
		})
		#
		#
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		#
		#
		->leftJoin('dognet_doczayvchet', 'dognet_doczayvchet.kodzayvchet', '=', 'dognet_doczayvchetf.kodzayvchet')
		->leftJoin('dognet_doczayv', 'dognet_doczayv.kodzayv', '=', 'dognet_doczayvchet.kodzayv')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_doczayv.koddoc')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->where('dognet_doczayvchetf.kodzayvchet', $__kodzayvchet)
		->process($_POST)
		->json();
}
