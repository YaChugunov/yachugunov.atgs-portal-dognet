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
function nextKoddoc() {
	$query = mysqlQuery("SELECT MAX(koddoc) as lastKod FROM dognet_docbase ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция обновления полей основной таблицы (dognet_kalplanchf)
#
function updateFields_docbase($db, $action_docbase, $id, $values) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "НОВЫЙ ДОГОВОР"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_docbase == 'CRT') {
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
	if ($action_docbase == 'UPD') {
		#
		#

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
	if ($action_docbase == 'DEL') {
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
function doc_block_for_edit($db, $action_docbase, $id, $values) {
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	#
	# :::
	# ::: Если была нажата кнопка "ИЗМЕНИТЬ"
	# :::
	#
	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	if ($action_docbase == 'UPD') {
		#
		#
		// 			DOCBASE_PR_DOC_BLOCK_FOR_EDIT( $db, "docbase", $id, $action_docbase );
		#
		#
	}
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
function delAttachment($db, $id) {
	#
	#
	$__rowFileID = $db->sql("SELECT docFileID FROM dognet_docjurnallet WHERE id=" . $id)->fetchAll();
	if (!empty($__rowFileID)) {
		$row2delete = $__rowFileID[0]['docFileID'];
		if ($row2delete != "") {
			// Удаление оригинального файла ($__tmp2) и сим-ссылки ($__tmp1) с диска
			$__file = $db->sql("SELECT file_truelocation, file_syspath FROM dognet_docjurnallet_files WHERE id=" . $row2delete)->fetchAll();
			if ($__file[0]['file_syspath'] != "" && file_exists($__file[0]['file_syspath'])) {
				$__tmp1 = unlink($__file[0]['file_syspath']);
			}
			if ($__file[0]['file_truelocation'] != "" && $__file[0]['file_truelocation']) {
				$__tmp2 = unlink($__file[0]['file_truelocation']);
			}
			// Удаление записи в таблице файлов
			// 			if ( $__tmp1 && $__tmp2 ) {
			$query = $db->sql("DELETE FROM dognet_docjurnallet_files WHERE id=" . $row2delete);
			// 			}
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
// Build our Editor instance and process the data coming from _POST
Editor::inst($db, 'dognet_docjurnallet')
	->fields(
		Field::inst('dognet_docjurnallet.koddel'),
		Field::inst('dognet_docjurnallet.koddocjurnal'),
		Field::inst('dognet_docjurnallet.kodzakaz'),
		Field::inst('dognet_docjurnallet.typeletter'),
		Field::inst('dognet_docjurnallet.datecreateletter')
			->validator(Validate::dateFormat(
				'd.m.Y H:i:s',
				ValidateOptions::inst()
					->allowEmpty(true)
			))
			->getFormatter(Format::datetime(
				'Y-m-d H:i:s',
				'd.m.Y H:i:s'
			))
			->setFormatter(Format::datetime(
				'd.m.Y H:i:s',
				'Y-m-d H:i:s'
			)),
		Field::inst('dognet_docjurnallet.numberdocletter'),
		Field::inst('dognet_docjurnallet.sum_field1'),
		Field::inst('dognet_docjurnallet.sum_field2'),
		Field::inst('dognet_docjurnallet.text_field1'),
		Field::inst('dognet_docjurnallet.text_field2'),
		Field::inst('dognet_docjurnallet.docactcreater'),
		Field::inst('dognet_docjurnallet.nameactcreate'),
		Field::inst('dognet_docjurnallet.docFileID'),
		// ----- ----- ----- -----
		Field::inst('dognet_docjurnallet_files.id'),
		Field::inst('dognet_docjurnallet_files.flag'),
		Field::inst('dognet_docjurnallet_files.koddocjurnal'),
		Field::inst('dognet_docjurnallet_files.kodzakaz'),
		Field::inst('dognet_docjurnallet_files.doc_rowid'),
		Field::inst('dognet_docjurnallet_files.file_year'),
		Field::inst('dognet_docjurnallet_files.file_id'),
		Field::inst('dognet_docjurnallet_files.file_name'),
		Field::inst('dognet_docjurnallet_files.file_originalname'),
		Field::inst('dognet_docjurnallet_files.file_extension'),
		Field::inst('dognet_docjurnallet_files.file_symname'),
		Field::inst('dognet_docjurnallet_files.file_size'),
		Field::inst('dognet_docjurnallet_files.file_truelocation'),
		Field::inst('dognet_docjurnallet_files.file_syspath'),
		Field::inst('dognet_docjurnallet_files.file_webpath'),
		Field::inst('dognet_docjurnallet_files.file_url'),
		// ----- ----- ----- -----
		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.director_fio')
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		#
		#
	)
	#
	#
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('preGet', function ($editor_docbase, $id) {
		$editor_docbase->where(function ($q) {
		});
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('postCreate', function ($editor_docbase, $id, $values, $row) {
		updateFields_docbase($editor_docbase->db(), 'CRT', $id, $values);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('postEdit', function ($editor_docbase, $id, $values, $row) {
		updateFields_docbase($editor_docbase->db(), 'UPD', $id, $values);
	})
	/*
	->on( 'preEdit', function ( $editor_docbase, $id, $values ) {
		doc_block_for_edit( $editor_docbase->db(), 'UPD', $id, $values );
	} )
*/
	->on('preRemove', function ($editor_docbase, $id, $values) {
		delAttachment($editor_docbase->db(), $id);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin('dognet_docjurnallet_files', 'dognet_docjurnallet_files.id', '=', 'dognet_docjurnallet.docFileID')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docjurnallet.kodzakaz')
	->where('dognet_docjurnallet.typeletter', 'ACT', '=')
	->process($_POST)
	->json();
