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
function nextKodzayvchet() {
	$query = mysqlQuery("SELECT MAX(koddoc) as lastKod FROM dognet_doczayvchet ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
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
	$Const_Part_Of_PATH = "/STORAGEDOC/ZAYVCTZ/CTZ" . $__CURRENT_YEAR . "/";
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
function updateFields_doczayvchet($db, $action_doczayvchet, $id, $values, $varFileArray, $kodzayvchet) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВЫЙ ДОГОВОР"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_doczayvchet == 'CRT') {
		#
		#
		// Формируем новый идентификатор договора (koddoc)
		$__nextKodzayvchet = nextKodzayvchet();

		$db->update('dognet_doczayvchet', array(
			'kodzayvchet'			=>	$__nextKodzayvchet
		), array('id' => $id));
		// .....
		// Считаем процент закрытия счета
		$_QRY = $db->sql("SELECT kodzayvchet, zayvchetsumma FROM dognet_doczayvchet WHERE id=" . $id)->fetchAll();
		$kod = $_QRY[0]['kodzayvchet'];
		$_QRY1 = $db->sql("SELECT zayvchetsumma FROM dognet_doczayvchet WHERE kodzayvchet=" . $kod)->fetchAll();
		$sumch = $_QRY1[0]['zayvchetsumma'];
		//
		$_QRY2 = $db->sql("SELECT SUM(zayvchetfsumma) as SummaChf FROM dognet_doczayvchetf WHERE kodzayvchet=" . $kod)->fetchAll();
		$sumallchf = $_QRY2[0]['SummaChf'];
		$perc = ($sumallchf / $sumch) * 100;
		$zadol = $sumch - $sumallchf;
		$controlzadol = ($perc != 100.00) ? 1 : 0;
		//
		$db->update('dognet_doczayvchet', array(
			'zayvchetpr' => $perc,
			'zayvchetzadol' => $zadol,
			'controlzadol' => $controlzadol
		), array(
			'kodzayvchet' => $kod
		));
		// .....
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
	if ($action_doczayvchet == 'UPD') {
		#
		#
		// В papermemo храним номер договора, чтобы не создавать новое специальное поле
		$_QRY_1 = $db->sql("SELECT kodpost, kodzayv, zayvchetsumma FROM dognet_doczayvchet WHERE id=" . $id)->fetchAll();
		$_QRY_2 = $db->sql("SELECT koddoc FROM dognet_doczayv WHERE kodzayv=" . $_QRY_1[0]['kodzayv'])->fetchAll();
		//
		// Выбираем идентификаторы создаваемого документа
		$_QRY_3 = $db->sql("SELECT kodzayv, kodzayvchet, docFileID FROM dognet_doczayvchet WHERE id=" . $id)->fetchAll();
		if ($_QRY_3) {
			$_kodzayvchet = $_QRY_3[0]['kodzayvchet'];
			$_kodpost = $_QRY_1[0]['kodpost'];
			$_kodzayv = $_QRY_1[0]['kodzayv'];
			$_koddoc = $_QRY_2[0]['koddoc'];
			$_docFileID = $_QRY_3[0]['docFileID'];
			//
			$_QRY_zayvRowID = $db->sql("SELECT id FROM dognet_doczayv WHERE kodzayv=" . $_kodzayv)->fetchAll();
			$__zayvRowID = $_QRY_zayvRowID[0]['id'];
			//
			$_QRY_docRowID = $db->sql("SELECT id FROM dognet_docbase WHERE koddoc=" . $_koddoc)->fetchAll();
			$__docRowID = $_QRY_docRowID[0]['id'];
			//
			$db->update('dognet_doczayvchet_files', array(
				'kodpost' => $_kodpost,
				'kodzayv' => $_kodzayv,
				'kodzayvchet' => $_kodzayvchet,
				'doc_rowid' => $__docRowID,
				'zayv_rowid' => $__zayvRowID,
				'zayvchet_rowid' => $id
			), array(
				'id' => $_docFileID
			));
			// Считаем выполнение и задолженность по счету и обновляем значения в таблице счетов
			$_QRY_4 = $db->sql("SELECT zayvchetsumma FROM dognet_doczayvchet WHERE kodzayvchet=" . $_kodzayvchet)->fetchAll();
			$sumch = $_QRY_4[0]['zayvchetsumma'];
			//
			$_QRY2 = $db->sql("SELECT SUM(zayvchetfsumma) as SummaChf FROM dognet_doczayvchetf WHERE kodzayvchet=" . $_kodzayvchet)->fetchAll();
			$sumallchf = $_QRY2[0]['SummaChf'];
			$perc = ($sumallchf / $sumch) * 100;
			$zadol = $sumch - $sumallchf;
			$controlzadol = ($perc != 100.00) ? 1 : 0;
			//
			$db->update('dognet_doczayvchet', array(
				'zayvchetpr' => $perc,
				'zayvchetzadol' => $zadol,
				'controlzadol' => $controlzadol
			), array(
				'kodzayvchet' => $_kodzayvchet
			));
			#
			#
			if ($_docFileID != "") {

				// Переименовываем файл
				$_QRY_paperfiles = $db->sql("SELECT flag, file_truelocation, file_syspath, zayvchet_filetype, file_extension FROM dognet_doczayvchet_files WHERE id=" . $_docFileID)->fetchAll();
				if ($_QRY_paperfiles[0]['flag'] == "Just uploaded") {
					$__ext = $_QRY_paperfiles[0]['file_extension'];
					$__newFileName = "CTZ{$_kodzayvchet}";
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
					$db->update('dognet_doczayvchet_files', array(
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
	if ($action_doczayvchet == 'DEL') {
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
function delAttachment($db, $id) {
	#
	#
	$__rowFileID = $db->sql("SELECT docFileID FROM dognet_doczayvchet WHERE id=" . $id)->fetchAll();
	$row2delete = $__rowFileID[0]['docFileID'];
	if ($row2delete != "") {
		// Удаление оригинального файла ($__tmp2) и сим-ссылки ($__tmp1) с диска
		$__file = $db->sql("SELECT file_truelocation, file_syspath FROM dognet_doczayvchet_files WHERE id=" . $row2delete)->fetchAll();
		$__tmp1 = unlink($__file[0]['file_syspath']);
		$__tmp2 = unlink($__file[0]['file_truelocation']);
		// Удаление записи в таблице файлов
		if ($__tmp1 && $__tmp2) {
			$query = $db->sql("DELETE FROM dognet_doczayvchet_files WHERE id=" . $row2delete);
		}
	}
	#
	#
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция удаления файлов и записи в таблице файлов счетов-фактур (dognet_doczayvchetf)
#
function delLinked_Chf_and_Files($db, $id) {
	#
	#
	$__chetToDelete = $db->sql("SELECT kodzayvchet FROM dognet_doczayvchet WHERE id=" . $id)->fetchAll();
	if ($__chetToDelete) {
		$_QRY_CHF = mysqlQuery("SELECT * FROM dognet_doczayvchetf WHERE kodzayvchet=" . $__chetToDelete[0]['kodzayvchet']);
		while ($_ROW_CHF = mysqli_fetch_assoc($_QRY_CHF)) {
			$_id = $_ROW_CHF['ID'];
			$_row2delete = $_ROW_CHF['docFileID'];
			if ($_row2delete != "") {
				// Удаление оригинального файла ($__tmp2) и сим-ссылки ($__tmp1) с диска
				$__file = $db->sql("SELECT file_truelocation, file_syspath FROM dognet_doczayvchetf_files WHERE id=" . $_row2delete)->fetchAll();
				$__tmp1 = unlink($__file[0]['file_syspath']);
				$__tmp2 = unlink($__file[0]['file_truelocation']);
				// Удаление записи в таблице файлов
				if ($__tmp1 && $__tmp2) {
					$query = $db->sql("DELETE FROM dognet_doczayvchetf_files WHERE id=" . $_row2delete);
				}
			}
		}
		$_QRY_DELCHF = mysqlQuery("DELETE FROM dognet_doczayvchetf WHERE kodzayvchet=" . $__chetToDelete[0]['kodzayvchet']);
	}
	#
	#
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

if (!isset($_POST['kodzayvchet']) || !is_numeric($_POST['kodzayvchet'])) {
	echo json_encode(["data" => []]);
} else {
	$__kodzayvchet = $_POST['kodzayvchet'];

	// Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_doczayvchet')
		->fields(
			Field::inst('dognet_doczayvchet.ID'),
			Field::inst('dognet_doczayvchet.koddel'),
			Field::inst('dognet_doczayvchet.kodpost')
				->options(
					Options::inst()
						->table('sp_contragents')
						->value('kodcontragent')
						->label(array('kodcontragent', 'nameshort', 'namefull'))
						->order('nameshort asc')
						->render(function ($row) {
							return $row['nameshort'];
						})
						->where(function ($q) {
							$q->where('koddel', '99', '<>');
							$q->where('useinzayv', '1');
							$q->where('nameshort', '', '<>');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Поставщик обязателен')
				)),
			Field::inst('dognet_doczayvchet.kodzayv')
				->options(
					Options::inst()
						->table('dognet_doczayv')
						->value('kodzayv')
						->label(array('kodzayv', 'kodtipzayvall', 'numberzayv', 'datezayv'))
						->render(function ($row) {
							$date = date('d.m.Y', strtotime($row['datezayv']));
							$year = date('Y', strtotime($row['datezayv']));
							switch ($row['kodtipzayvall']) {
								case "245534362471017":
									$tipzayv = "РБД";
									break;
								case "245534367403934":
									$tipzayv = "АСУТП";
									break;
								case "245534367447461":
									$tipzayv = "ИУС";
									break;
								case "245534367475039":
									$tipzayv = "РКП";
									break;
								case "245534442970720":
									$tipzayv = "ИТиТО";
									break;
								case "245534455408158":
									$tipzayv = "ЗИП";
									break;
								case "245535642326675":
									$tipzayv = "РМТ";
									break;
								default:
									$tipzayv = "---";
							}
							return $year . " : заявка № " . $tipzayv . "-" . $row['numberzayv'] . " от " . $date;
						})
						->where(function ($q) {
							$q->where('dognet_doczayv.koddel', '99', '!=');
							$q->where('YEAR(datezayv)', (date("Y") - 1), '>=');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Заявка обязательна')
				)),
			Field::inst('dognet_doczayvchet.kodzayvchet'),
			Field::inst('dognet_doczayvchet.zayvchetnumber'),
			Field::inst('dognet_doczayvchet.zayvchetdate')
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
			Field::inst('dognet_doczayvchet.zayvchetsumma'),
			Field::inst('dognet_doczayvchet.zayvchetpr'),
			Field::inst('dognet_doczayvchet.zayvchetzadol'),
			Field::inst('dognet_doczayvchet.controlzadol'),
			Field::inst('dognet_doczayvchet.zayvchetcomment'),
			Field::inst('dognet_doczayvchet.controlrab'),
			Field::inst('dognet_doczayvchet.zayvchetchetfcom'),
			Field::inst('dognet_doczayvchet.kodpokup')
				->options(
					Options::inst()
						->table('dognet_sppokup')
						->value('kodpokup')
						->label(array('kodpokup', 'namepokupshot'))
						->render(function ($row) {
							return $row['namepokupshot'];
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Покупатель обязателен')
				)),
			Field::inst('dognet_doczayvchet.controlrab1'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_doczayvchet.docFileID')
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
							'dognet_doczayvchet_files',
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
							'dognet_doczayvchet_files',
							'id',
							array(
								'zayvchet_filetype' => Upload::DB_EXTN,
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
			Field::inst('dognet_doczayv.kodzayv'),
			Field::inst('dognet_doczayv.koddoc'),
			Field::inst('dognet_doczayv.kodispol'),
			Field::inst('dognet_doczayv.kodzayvtel'),
			Field::inst('dognet_doczayv.kodrabzayv'),
			Field::inst('dognet_doczayv.datezayv'),
			Field::inst('dognet_doczayv.numberzayv'),
			Field::inst('dognet_doczayv.namedoc'),
			Field::inst('dognet_doczayv.kodrabfile'),
			Field::inst('dognet_doczayv.namerabfilespec'),
			Field::inst('dognet_doczayv.rabfileexp'),
			Field::inst('dognet_doczayv.tipusezayv'),
			Field::inst('dognet_doczayv.kodtipzayv'),
			Field::inst('dognet_doczayv.kodusecht'),
			Field::inst('dognet_doczayv.rabzayvdoc'),
			Field::inst('dognet_doczayv.zayvchetcom'),
			Field::inst('dognet_doczayv.kodtipzayvall'),
			Field::inst('dognet_doczayv.koduseobjwork'),
			Field::inst('dognet_doczayv.kodusepoligon'),
			Field::inst('dognet_doczayv.zayvchetcomall'),
			// ----- ----- -----
			Field::inst('dognet_spzayvtel.kodzayvtel'),
			Field::inst('dognet_spzayvtel.namezayvtel'),
			Field::inst('dognet_spzayvtel.namezayvtelshot'),
			// ----- ----- -----
			Field::inst('dognet_sptipzayvall.kodtipzayvall'),
			Field::inst('dognet_sptipzayvall.nametipzayvshotall'),
			Field::inst('dognet_sptipzayvall.nametipzayvfullall'),
			// ----- ----- -----
			Field::inst('dognet_docbase.koddoc'),
			Field::inst('dognet_docbase.docnumber'),
			Field::inst('dognet_docbase.docnameshot'),
			// ----- ----- -----
			Field::inst('sp_contragents.kodcontragent'),
			Field::inst('sp_contragents.nameshort'),
			Field::inst('sp_contragents.namefull'),
			// ----- ----- -----
			Field::inst('dognet_sppokup.kodpokup'),
			Field::inst('dognet_sppokup.namepokupshot'),
			Field::inst('dognet_sppokup.namepokupfull'),
			// ----- ----- -----
			Field::inst('dognet_spdened.koddened'),
			Field::inst('dognet_spdened.html_code'),
			Field::inst('dognet_spdened.short_code')
			# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			#
			#
		)
		#
		#
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('preGet', function ($editor_doczayvchet, $id) {
			$editor_doczayvchet->where(function ($q) {
				$q->where('dognet_doczayvchet.koddel', '99', '!=');
			});
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('postCreate', function ($editor_doczayvchet, $id, $values, $row) use ($varFileArray, $__kodzayvchet) {
			updateFields_doczayvchet($editor_doczayvchet->db(), 'CRT', $id, $values, $varFileArray, $__kodzayvchet);
		})
		//
		->on('postEdit', function ($editor_doczayvchet, $id, $values, $row) use ($varFileArray, $__kodzayvchet) {
			updateFields_doczayvchet($editor_doczayvchet->db(), 'UPD', $id, $values, $varFileArray, $__kodzayvchet);
		})
		//
		->on('preRemove', function ($editor_doczayvchet, $id, $values) use ($varFileArray, $__kodzayvchet) {
			delAttachment($editor_doczayvchet->db(), $id);
			delLinked_Chf_and_Files($editor_doczayvchet->db(), $id);
			updateFields_doczayvchet($editor_doczayvchet->db(), 'DEL', $id, $values, null, $__kodzayvchet);
		})

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin('dognet_doczayv', 'dognet_doczayv.kodzayv', '=', 'dognet_doczayvchet.kodzayv')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_doczayv.koddoc')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_doczayvchet.kodpost')
		->leftJoin('dognet_sppokup', 'dognet_sppokup.kodpokup', '=', 'dognet_doczayvchet.kodpokup')
		->leftJoin('dognet_spzayvtel', 'dognet_spzayvtel.kodzayvtel', '=', 'dognet_doczayv.kodzayvtel')
		->leftJoin('dognet_sptipzayv', 'dognet_sptipzayv.kodtipzayv', '=', 'dognet_doczayv.kodtipzayv')
		->leftJoin('dognet_sptipzayvall', 'dognet_sptipzayvall.kodtipzayvall', '=', 'dognet_doczayv.kodtipzayvall')
		->where('dognet_doczayvchet.kodzayvchet', $__kodzayvchet)
		->process($_POST)
		->json();
}
