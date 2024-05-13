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
	$query = mysqlQuery("SELECT MAX(kodzayvchet) as lastKod FROM dognet_doczayvchet ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 13);
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
	// 	$Const_Part_Of_PATH = "/STORAGEDOC/ZAYVCTZ/CTZ".$__CURRENT_YEAR."/";
	$Const_Part_Of_PATH = "/STORAGEDOC/ZAYVCTZ/CTZ" . $__CURRENT_YEAR . "/TMP_TEST/";
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
	// 			$d = dir("/mnt/docNET".$Const_Part_Of_PATH);
	# Отладочный путь
	$d = dir("/mnt/__docNET" . $Const_Part_Of_PATH);

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
function updateFields_doczayvchet($db, $action_doczayvchet, $id, $values) {
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
			'kodzayvchet'			=>	$__nextKodzayvchet,
			'docFileID' => ""
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
			//
			$_QRY_4 = $db->sql("SELECT zayvchetsumma FROM dognet_doczayvchet WHERE kodzayvchet=" . $_kodzayvchet)->fetchAll();
			$sumch = $_QRY_4[0]['zayvchetsumma'];
			//
			$_QRY2 = $db->sql("SELECT SUM(zayvchetfsumma) as SummaChf FROM dognet_doczayvchetf WHERE kodzayvchet=" . $_kodzayvchet)->fetchAll();
			$sumallchf = $_QRY2[0]['SummaChf'];
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
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function doc_block_for_edit($db, $action_doczayvchet, $id, $values) {
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

if (!isset($_POST['kodzayv']) || !is_numeric($_POST['kodzayv'])) {
	echo json_encode(["data" => []]);
} else {
	$__kodzayv = $_POST['kodzayv'];

	// Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_doczayvchet')
		->fields(
			Field::inst('dognet_doczayvchet.koddel'),
			Field::inst('dognet_doczayvchet.kodpost'),
			Field::inst('dognet_doczayvchet.kodzayv')
				->options(
					Options::inst()
						->table('dognet_doczayv')
						->value('kodzayv')
						->label(array('kodzayv', 'numberzayv', 'datezayv'))
						->render(function ($row) use ($__kodzayv) {
							return ("Заявка " . $row['numberzayv']);
						})
						->where(function ($q) use ($__kodzayv) {
							$q->where('kodzayv', $__kodzayv, '=');
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
			Field::inst('dognet_doczayvchet.zayvchetcomment'),
			Field::inst('dognet_doczayvchet.controlrab'),
			Field::inst('dognet_doczayvchet.zayvchetchetfcom'),
			Field::inst('dognet_doczayvchet.kodpokup'),
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
			Field::inst('dognet_doczayv.koddoc'),
			Field::inst('dognet_doczayv.kodispol'),
			Field::inst('dognet_doczayv.kodzayvtel'),
			Field::inst('dognet_doczayv.kodrabzayv'),
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
		->on('preGet', function ($editor_docbase, $id) {
			$editor_docbase->where(function ($q) {
				$q->where('dognet_doczayvchet.koddel', '99', '!=');
			});
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('postCreate', function ($editor_docbase, $id, $values, $row) {
			updateFields_doczayvchet($editor_docbase->db(), 'CRT', $id, $values);
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('postEdit', function ($editor_docbase, $id, $values, $row) {
			updateFields_doczayvchet($editor_docbase->db(), 'UPD', $id, $values);
		})
		/*
	->on( 'preEdit', function ( $editor_docbase, $id, $values ) {
		doc_block_for_edit( $editor_docbase->db(), 'UPD', $id, $values );
	} )
*/
		->on('preRemove', function ($editor_docbase, $id, $values) {
			updateFields_doczayvchet($editor_docbase->db(), 'DEL', $id, $values);
		})

		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin('dognet_doczayv', 'dognet_doczayv.kodzayv', '=', 'dognet_doczayvchet.kodzayv')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_doczayv.koddoc')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_doczayvchet.kodpost')
		->leftJoin('dognet_sppokup', 'dognet_sppokup.kodpokup', '=', 'dognet_doczayvchet.kodpokup')
		->leftJoin('dognet_sptipzayv', 'dognet_sptipzayv.kodtipzayv', '=', 'dognet_doczayv.kodtipzayv')
		->leftJoin('dognet_sptipzayvall', 'dognet_sptipzayvall.kodtipzayvall', '=', 'dognet_doczayv.kodtipzayvall')
		->where('dognet_doczayvchet.kodzayv', $__kodzayv)
		->process($_POST)
		->json();
}
