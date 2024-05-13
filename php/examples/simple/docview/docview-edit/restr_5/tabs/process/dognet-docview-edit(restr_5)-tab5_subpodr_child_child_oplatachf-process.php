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
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_5/tabs/process/functions/funcDognet-OplChf.Inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = $_GET['uniqueID'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ВАЖНО!!!
# Определяем создан ли договор по шаблону с календарным планом (kodshab=1)
# или без плана (kodshab=2)
# Это определяет будет ли идти привязка в таблицах счетов, оплат и авансов привязка по
# коду этапа (kodkalplan) или по коду договора (koddoc) соответственно
#
$_QRY_KODSHAB = mysqlQuery("SELECT kodshab FROM dognet_docbase WHERE koddoc=" . $__uniqueID);
$_ROW_KODSHAB = mysqli_fetch_assoc($_QRY_KODSHAB);
$_KODSHAB = $_ROW_KODSHAB['kodshab'];
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
$__uniqueID = $_SESSION['uniqueID'];
$__koddocsubpodr = !empty($_POST['koddocsubpodr']) ? $_POST['koddocsubpodr'] : "";
$__kodchfsubpodr = !empty($_POST['kodchfsubpodr']) ? $_POST['kodchfsubpodr'] : "";
$__kodoplchfsubpodr = !empty($_POST['kodoplchfsubpodr']) ? $_POST['kodoplchfsubpodr'] : "";
$__kodchfsubpodr_selected = !empty($_POST['kodchfsubpodr_selected']) ? $_POST['kodchfsubpodr_selected'] : "";
$__kodchfsubpodr_field = !empty($_POST['kodchfsubpodr_field']) ? $_POST['kodchfsubpodr_field'] : "";
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция формирования нового ID оплаты счеты-фактуры (kodoplchfsubpodr)
# для таблицы оплат счетов-фактур субподряда 'dognet_docoplchfsubpodr'
# ----- ----- -----
function nextKodoplchfsubpodr() {
	$query = mysqlQuery("SELECT MAX(kodoplchfsubpodr) as lastKod FROM dognet_docoplchfsubpodr ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 13);
	return $nextKod;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
function MAIN($db, $action, $id, $values) {
	if ($action != 'DEL') {
		$_QRY_OPL = $db->sql("SELECT * FROM dognet_docoplchfsubpodr WHERE id='{$id}'")->fetchAll();
		$koddocsubpodr = $_QRY_OPL[0]['koddocsubpodr'];
		$kodoplchfsubpodr = $_QRY_OPL[0]['kodoplchfsubpodr'];
		$kodchfsubpodr = $_QRY_OPL[0]['kodchfsubpodr'];
		$sumoplchfsubpodr = !empty($_QRY_OPL[0]['sumoplchfsubpodr']) ? $_QRY_OPL[0]['sumoplchfsubpodr'] : "";
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'CRT') {
		$__nextKodoplchfsubpodr = nextKodoplchfsubpodr();
		$db->update('dognet_docoplchfsubpodr', array(
			'kodoplchfsubpodr'		=>	$__nextKodoplchfsubpodr
		), array('id' => $id));
		DOCSUB_PR_ZADOLG_DOC($db, "docoplchfsubpodr", $id, $action);
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'UPD') {
		DOCSUB_PR_ZADOLG_DOC($db, "docoplchfsubpodr", $id, $action);
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'PREDEL') {
		DOCSUB_PR_ZADOLG_DOC($db, "docoplchfsubpodr", $id, $action);
	}
	#
	#
}
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
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
#
#
if ($_KODSHAB == "1" or $_KODSHAB == "3") {
	#
	#
	if (!isset($_POST['kodchfsubpodr']) || !is_numeric($_POST['kodchfsubpodr'])) {
		echo json_encode(["data" => []]);
	} else {
		// Build our Editor instance and process the data coming from _POST
		Editor::inst($db, 'dognet_docoplchfsubpodr')
			->fields(
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docoplchfsubpodr.kodchfsubpodr')
					->options(
						Options::inst()
							->table('dognet_docchfsubpodr')
							->value('kodchfsubpodr')
							->label(array('kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr'))
							->render(function ($row) use ($__koddocsubpodr) {
								return ("Счет-фактура № : " . $row['numberchfsubpodr'] . " от " . date('d.m.Y', strtotime($row['datechfsubpodr'])));
							})
							->where(function ($q) use ($__koddocsubpodr) {
								$q->where('koddocsubpodr', $__koddocsubpodr, '=');
							})
					)
					->validator(Validate::notEmpty(
						ValidateOptions::inst()
							->message('Выберите счет-фактуру')
					)),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docoplchfsubpodr.koddocsubpodr'),
				Field::inst('dognet_docoplchfsubpodr.kodoplchfsubpodr'),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docoplchfsubpodr.dateoplchfsubpodr')
					->validator(Validate::dateFormat(
						'd.m.Y',
						ValidateOptions::inst()
							->allowEmpty(false)
					))
					->getFormatter(Format::datetime(
						'Y-m-d',
						'd.m.Y'
					))
					->setFormatter(Format::datetime(
						'd.m.Y',
						'Y-m-d'
					)),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docoplchfsubpodr.sumoplchfsubpodr'),
				Field::inst('dognet_docchfsubpodr.koddocsubpodr'),
				Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docbase.koddoc'),
				Field::inst('dognet_docbase.koddened'),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_spdened.koddened'),
				Field::inst('dognet_spdened.html_code'),
				Field::inst('dognet_spdened.short_code')
			)
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->on('preEdit', function ($editor, $id, $values) {
			})
			->on('postCreate', function ($editor, $id, $values, $row) {
				MAIN($editor->db(), 'CRT', $id, $values, $row);
				UPDATE_CHFZADOL($editor->db(), 'CRT', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
				UPDATE_CHFZADOL_OTH($editor->db(), 'CRT', $id, $_POST['koddocsubpodr'], $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
			})
			->on('postEdit', function ($editor, $id, $values, $row) {
				MAIN($editor->db(), 'UPD', $id, $values, $row);
				UPDATE_CHFZADOL($editor->db(), 'UPD', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
				UPDATE_CHFZADOL_OTH($editor->db(), 'UPD', $id, $_POST['koddocsubpodr'], $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
			})
			->on('preRemove', function ($editor, $id, $values) {
				MAIN($editor->db(), 'PREDEL', $id, $values, null);
				UPDATE_CHFZADOL($editor->db(), 'PREDEL', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
			})
			->on('postRemove', function ($editor, $id, $values) {
				MAIN($editor->db(), 'DEL', $id, $values, null);
			})
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->leftJoin('dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docoplchfsubpodr.kodchfsubpodr')
			->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docchfsubpodr.koddocsubpodr')
			->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc')
			->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docsubpodr.koddoc')
			->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
			->where('dognet_docoplchfsubpodr.kodchfsubpodr', $__kodchfsubpodr)
			->process($_POST)
			->json();
	}
	#
	#
}
#
#
if ($_KODSHAB == "2" or $_KODSHAB == "4") {
	#
	#
	if (!isset($_POST['kodchfsubpodr']) || !is_numeric($_POST['kodchfsubpodr'])) {
		echo json_encode(["data" => []]);
	} else {
		// Build our Editor instance and process the data coming from _POST
		Editor::inst($db, 'dognet_docoplchfsubpodr')
			->fields(
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docoplchfsubpodr.kodchfsubpodr')
					->options(
						Options::inst()
							->table('dognet_docchfsubpodr')
							->value('kodchfsubpodr')
							->label(array('kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr'))
							->render(function ($row) use ($__koddocsubpodr) {
								return ("Счет-фактура № : " . $row['numberchfsubpodr'] . " от " . date('d.m.Y', strtotime($row['datechfsubpodr'])));
							})
							->where(function ($q) use ($__koddocsubpodr) {
								$q->where('koddocsubpodr', $__koddocsubpodr, '=');
							})
							->order('datechfsubpodr desc')
					)
					->validator(Validate::notEmpty(
						ValidateOptions::inst()
							->message('Выберите счет-фактуру')
					)),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docoplchfsubpodr.koddocsubpodr'),
				Field::inst('dognet_docoplchfsubpodr.kodoplchfsubpodr'),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docoplchfsubpodr.dateoplchfsubpodr')
					->validator(Validate::dateFormat(
						'd.m.Y',
						ValidateOptions::inst()
							->allowEmpty(false)
					))
					->getFormatter(Format::datetime(
						'Y-m-d',
						'd.m.Y'
					))
					->setFormatter(Format::datetime(
						'd.m.Y',
						'Y-m-d'
					)),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docoplchfsubpodr.sumoplchfsubpodr'),
				Field::inst('dognet_docchfsubpodr.koddocsubpodr'),
				Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docbase.koddoc'),
				Field::inst('dognet_docbase.koddened'),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_spdened.koddened'),
				Field::inst('dognet_spdened.html_code'),
				Field::inst('dognet_spdened.short_code')
			)
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->on('preEdit', function ($editor, $id, $values) {
			})
			->on('postCreate', function ($editor, $id, $values, $row) {
				MAIN($editor->db(), 'CRT', $id, $values, $row);
				UPDATE_CHFZADOL($editor->db(), 'CRT', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
				UPDATE_CHFZADOL_OTH($editor->db(), 'CRT', $id, $_POST['koddocsubpodr'], $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
			})
			->on('postEdit', function ($editor, $id, $values, $row) {
				MAIN($editor->db(), 'UPD', $id, $values, $row);
				UPDATE_CHFZADOL($editor->db(), 'UPD', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
				UPDATE_CHFZADOL_OTH($editor->db(), 'UPD', $id, $_POST['koddocsubpodr'], $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
			})
			->on('preRemove', function ($editor, $id, $values) {
				MAIN($editor->db(), 'PREDEL', $id, $values, null);
				UPDATE_CHFZADOL($editor->db(), 'PREDEL', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
			})
			->on('postRemove', function ($editor, $id, $values) {
				MAIN($editor->db(), 'DEL', $id, $values, null);
			})
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->leftJoin('dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docoplchfsubpodr.kodchfsubpodr')
			->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docchfsubpodr.koddocsubpodr')
			->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docsubpodr.koddoc')
			->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
			->where('dognet_docoplchfsubpodr.kodchfsubpodr', $__kodchfsubpodr)
			->process($_POST)
			->json();
	}
	#
	#
}
