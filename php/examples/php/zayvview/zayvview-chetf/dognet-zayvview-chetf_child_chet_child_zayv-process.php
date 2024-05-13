<?php
date_default_timezone_set('Europe/Moscow');

# Import PHPMailer classes into the global namespace
# These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
# Подключаем библиотеки
// require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/Exception.php";
// require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/PHPMailer.php";
// require $_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPMailer/src/SMTP.php";

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
#
# Включаем режим сессии
session_start();
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового ID заявки ( kodzayv)
# для таблицы заявок 'dognet_doczayv'
# ----- ----- -----
function nextKodzayv()
{
	$query = mysqlQuery("SELECT MAX(kodzayv) as lastKod FROM dognet_doczayv ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 13);
	return $nextKod;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового номера заявки (numberzayv)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextNumberzayv($tip, $year)
{
	$query = mysqlQuery("SELECT MAX(numberzayv) as lastNumber FROM dognet_doczayv WHERE kodtipzayvall=" . $tip . " AND YEAR(datezayv)=" . $year . " ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastNumber = $row['lastNumber'];
	$nextNumber = $lastNumber + 1;
	return $nextNumber;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция определения нового ID договора ( koddoc)
# для таблицы этапов 'dognet_docbase'
# ----- ----- -----
function nextKodzayvdopspec()
{
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
function nextNumberdopspec($kodzayv)
{
	$query = mysqlQuery("SELECT MAX(numberdopspec) as lastNumber FROM dognet_doczayvdopspec WHERE kodzayv=" . $kodzayv . " ORDER BY id DESC");
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
	$Const_Part_Of_PATH = "/STORAGEDOC/ZAYVCTZ/CTZ" . $__CURRENT_YEAR . "/";
	// $Const_Part_Of_PATH = "/STORAGEDOC/DOCZAYV/DOCZAYV" . $__CURRENT_YEAR . "/";
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
# Функция обновления полей основной таблицы (dognet_doczayv)
#
function updateFields_doczayv($db, $action_doczayv, $id, $values)
{
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВАЯ ЗАЯВКА"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_doczayv == 'CRT') {
		#
		#
		$_QRY = $db->sql("SELECT * FROM dognet_doczayv WHERE id=" . $id)->fetchAll();
		$__tip = $_QRY[0]['kodtipzayvall'];
		$__name = $_QRY[0]['namerabfilespec'];

		// Формируем новый идентификатор завки (kodzayv)
		$__nextKodzayv = nextKodzayv();
		$__nextNumberzayv = nextNumberzayv($__tip, date('Y'));

		$db->update('dognet_doczayv', array(
			'kodzayv'			=>	$__nextKodzayv,
			'numberzayv'		=>	$__nextNumberzayv,
			'docFileID' => ""
		), array('id' => $id));

		if (empty($__name)) {
			$db->update('dognet_doczayv', array(
				'namerabfilespec'		=>	"Заявка"
			), array('id' => $id));
		}

		if ($_QRY[0]['kodrabfile'] == 1) {
			$__nextKodzayvdopspec = nextKodzayvdopspec();
			$__date = date("Y-m-d");
			$_QRY_1 = $db->sql("INSERT INTO dognet_doczayvdopspec (koddel, kodzayv, kodzayvdopspec, kodmainspec, datedopspec, numberdopspec, namedopspec, docFileID, dopFileID) VALUES ('', {$__nextKodzayv}, {$__nextKodzayvdopspec}, '1', {$__date}, '1', 'Основной файл, прикрепленный к заявке', '', '')");
		}


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
	if ($action_doczayv == 'UPD') {
		#
		#
		// В papermemo храним номер договора, чтобы не создавать новое специальное поле
		$_QRY_1 = $db->sql("SELECT namerabfilespec, koddoc, kodzayv, docFileID FROM dognet_doczayv WHERE id=" . $id)->fetchAll();
		//
		if ($_QRY_1) {
			$_kodzayv = $_QRY_1[0]['kodzayv'];
			$_namerabfilespec = $_QRY_1[0]['namerabfilespec'];
			$_koddoc = $_QRY_1[0]['koddoc'];
			$_docFileID = $_QRY_1[0]['docFileID'];
			//
			$_QRY_docRowID = $db->sql("SELECT id FROM dognet_docbase WHERE koddoc=" . $_koddoc)->fetchAll();
			$__docRowID = $_QRY_docRowID[0]['id'];
			//
			$db->update('dognet_doczayv_files', array(
				'kodzayv' => $_kodzayv,
				'koddoc' => $_koddoc,
				'doc_rowid' => $__docRowID,
				'zayv_rowid' => $id,
			), array(
				'id' => $_docFileID
			));
			//
			$_QRY_specRowID = $db->sql("SELECT id FROM dognet_doczayvdopspec WHERE kodzayv=" . $_kodzayv . " AND kodmainspec='1'")->fetchAll();
			if ($_QRY_specRowID) {
				//
				$db->update('dognet_doczayvdopspec', array(
					'docFileID' => ""

					// При 'docFileID' => $_docFileID вставляется пустое значение вместо $_docFileID
					// Временное решение. Думаю пока...

				), array(
					'kodzayv' => $_kodzayv, 'kodmainspec' => 1
				));
				$_dopSpecID = $_QRY_specRowID[0]['id'];
				$db->update('dognet_doczayv', array(
					'dopSpecID' => $_dopSpecID
				), array(
					'id' => $id
				));
			} else {
				$_QRY = $db->sql("SELECT * FROM dognet_doczayv WHERE id=" . $id)->fetchAll();
				if ($_QRY[0]['kodrabfile'] == 1) {
					$__nextKodzayvdopspec = nextKodzayvdopspec();
					$__date = date("Y-m-d");
					$__docFileID = $_docFileID ? $_docFileID : "";

					$_QRY_1 = $db->sql("INSERT INTO dognet_doczayvdopspec (koddel, kodzayv, kodzayvdopspec, kodmainspec, datedopspec, numberdopspec, namedopspec, docFileID, dopFileID) VALUES ('', '{$_kodzayv}', '{$__nextKodzayvdopspec}', '1', '{$__date}', '1', 'Основной файл, прикрепленный к заявке', '', '')");

					// При INSERT в поле docFileID вставляется пустое значение вместо $_docFileID
					// Временное решение. Думаю пока...

					$_QRY_2 = $db->sql("SELECT id FROM dognet_doczayvdopspec WHERE kodzayv=" . $_kodzayv . " AND kodmainspec='1'")->fetchAll();
					$_dopSpecID = $_QRY_2[0]['id'];

					$db->update('dognet_doczayv', array(
						'dopSpecID' => $_dopSpecID
					), array(
						'id' => $id
					));
				}
			}
			#
			#
			if ($_docFileID != "") {

				// Переименовываем файл
				$_QRY_paperfiles = $db->sql("SELECT flag, file_truelocation, file_syspath, zayv_filetype, file_extension FROM dognet_doczayv_files WHERE id=" . $_docFileID)->fetchAll();
				if ($_QRY_paperfiles[0]['flag'] == "Just uploaded") {
					$__ext = $_QRY_paperfiles[0]['file_extension'];
					$__newFileName = "DOCZAYV{$_kodzayv}";
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
					$db->update('dognet_doczayv_files', array(
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
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		/*
		if ( json_encode($values['sendMessage'], JSON_NUMERIC_CHECK) == '[1]' ) {
			my_mail_function();
		}
*/
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
	if ($action_doczayv == 'DEL') {
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
function delAttachment($db, $id)
{
	#
	#
	$__rowFileID = $db->sql("SELECT docFileID FROM dognet_doczayv WHERE id=" . $id)->fetchAll();
	$row2delete = $__rowFileID[0]['docFileID'];
	if ($row2delete != "") {
		// Удаление оригинального файла ($__tmp2) и сим-ссылки ($__tmp1) с диска
		$__file = $db->sql("SELECT file_truelocation, file_syspath FROM dognet_doczayv_files WHERE id=" . $row2delete)->fetchAll();
		$__tmp1 = unlink($__file[0]['file_syspath']);
		$__tmp2 = unlink($__file[0]['file_truelocation']);
		// Удаление записи в таблице файлов
		if ($__tmp1 && $__tmp2) {
			$query = $db->sql("DELETE FROM dognet_doczayv_files WHERE id=" . $row2delete);
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
	Editor::inst($db, 'dognet_doczayv')
		->fields(
			Field::inst('dognet_docbase.koddel'),
			Field::inst('dognet_doczayv.kodzayv'),
			// ----- ----- -----
			Field::inst('dognet_doczayv.koddoc')
				->options(
					Options::inst()
						->table('dognet_docbase')
						->value('koddoc')
						->label(array('koddoc', 'yearnachdoc', 'docnumber', 'docnameshot'))
						->render(function ($row) {
							return ($row['yearnachdoc'] . " : " . "3-4/" . $row['docnumber'] . " : " . $row['docnameshot']);
						})
						->where(function ($q) {
							$q->where('koddel', '99', '!=');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Выберите договор либо "Без договора"')
				)),
			Field::inst('dognet_doczayv.kodispol'),
			// ----- ----- -----
			Field::inst('dognet_doczayv.kodzayvtel')
				->options(
					Options::inst()
						->table('dognet_spzayvtel')
						->value('kodzayvtel')
						->label(array('kodzayvtel', 'namezayvtelshot'))
						->render(function ($row) {
							return ($row['namezayvtelshot']);
						})
						->where(function ($q) {
							$q->where('koddel', '99', '!=');
							$q->where('kodzayvtel', '0000000000000000', '!=');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Заявитель обязателен')
				)),
			// ----- ----- -----
			Field::inst('dognet_doczayv.kodrabzayv'),
			Field::inst('dognet_doczayv.numberzayv'),
			// ----- ----- -----
			Field::inst('dognet_doczayv.datezayv')
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
			Field::inst('dognet_doczayv.namedoc'),
			Field::inst('dognet_doczayv.kodrabfile'),
			Field::inst('dognet_doczayv.namerabfilespec'),
			Field::inst('dognet_doczayv.rabfileexp'),
			Field::inst('dognet_doczayv.tipusezayv'),
			// ----- ----- -----
			Field::inst('dognet_doczayv.kodtipzayv'),
			// ----- ----- -----
			Field::inst('dognet_doczayv.kodusecht'),
			Field::inst('dognet_doczayv.rabzayvdoc'),
			Field::inst('dognet_doczayv.zayvchetcom'),
			// ----- ----- -----
			Field::inst('dognet_doczayv.kodtipzayvall')
				->options(
					Options::inst()
						->table('dognet_sptipzayvall')
						->value('kodtipzayvall')
						->label(array('kodtipzayvall', 'nametipzayvshotall'))
						->render(function ($row) {
							return ($row['nametipzayvshotall']);
						})
						->where(function ($q) {
							$q->where('koddel', '99', '!=');
						})
				)
				->validator(Validate::notEmpty(
					ValidateOptions::inst()
						->message('Тип обязателен')
				)),
			// ----- ----- -----
			Field::inst('dognet_doczayv.koduseobjwork'),
			Field::inst('dognet_doczayv.kodusepoligon'),
			Field::inst('dognet_doczayv.zayvchetcomall'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_doczayv.docFileID')
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
							'dognet_doczayv_files',
							[
								'flag' => 'Just uploaded',
								// ---
								'file_year' => $varFileArray['year'],
								'file_id' => $id,
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
							'dognet_doczayv_files',
							'id',
							array(
								'zayv_filetype' => Upload::DB_EXTN,
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
			Field::inst('dognet_docbase.koddoc'),
			Field::inst('dognet_docbase.docnumber'),
			Field::inst('dognet_docbase.docnameshot'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_spzayvtel.kodzayvtel'),
			Field::inst('dognet_spzayvtel.namezayvtel'),
			Field::inst('dognet_spzayvtel.namezayvtelshot'),
			Field::inst('dognet_spzayvtel.doljzayvtel'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_sptipzayv.kodtipzayv'),
			Field::inst('dognet_sptipzayv.namezayvshot'),
			Field::inst('dognet_sptipzayv.namezayvfull'),
			Field::inst('dognet_sptipzayv.shifrzayv'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_sptipzayvall.kodtipzayvall'),
			Field::inst('dognet_sptipzayvall.nametipzayvshotall'),
			Field::inst('dognet_sptipzayvall.nametipzayvfullall'),
			Field::inst('dognet_sptipzayvall.usesimple'),
			Field::inst('dognet_sptipzayvall.usespec'),
			Field::inst('dognet_sptipzayvall.koddoclim'),
			Field::inst('dognet_sptipzayvall.kodshab')
			# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			#
			#
		)
		#
		#
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('preGet', function ($editor_doczayv, $id) {
			$editor_doczayv->where(function ($q) {
				$q->where('dognet_doczayv.koddel', '99', '!=');
			});
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('postCreate', function ($editor_doczayv, $id, $values, $row) {
			updateFields_doczayv($editor_doczayv->db(), 'CRT', $id, $values);
		})
		->on('preEdit', function ($editor_doczayv, $id, $values) {
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('postEdit', function ($editor_doczayv, $id, $values, $row) {
			updateFields_doczayv($editor_doczayv->db(), 'UPD', $id, $values);
			if (json_encode($values['sendMessage'], JSON_NUMERIC_CHECK) == '[1]') {
				my_mail_function();
			}
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('preRemove', function ($editor_doczayv, $id, $values) {
			delAttachment($editor_doczayv->db(), $id);
			updateFields_doczayv($editor_doczayv->db(), 'DEL', $id, $values);
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('postUpload', function ($editor_doczayv, $id, $files, $data) {
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_doczayv.koddoc')
		->leftJoin('dognet_spzayvtel', 'dognet_spzayvtel.kodzayvtel', '=', 'dognet_doczayv.kodzayvtel')
		->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_doczayv.kodispol')
		->leftJoin('dognet_sptipzayv', 'dognet_sptipzayv.kodtipzayv', '=', 'dognet_doczayv.kodtipzayv')
		->leftJoin('dognet_sptipzayvall', 'dognet_sptipzayvall.kodtipzayvall', '=', 'dognet_doczayv.kodtipzayvall')
		->where('dognet_doczayv.kodzayv', $__kodzayv)
		->process($_POST)
		->json();
}
