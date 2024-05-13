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
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/process/functions/funcDognet-AvChf.Inc.php");
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
$_KODSHAB = !empty($_ROW_KODSHAB['kodshab']) ? $_ROW_KODSHAB['kodshab'] : "";
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
$__uniqueID = $_SESSION['uniqueID'];
$__koddocsubpodr = !empty($_POST['koddocsubpodr']) ? $_POST['koddocsubpodr'] : "";
$__kodavsubpodr = !empty($_POST['kodavsubpodr']) ? $_POST['kodavsubpodr'] : "";
$__kodchfsubpodr_selected = !empty($_POST['kodchfsubpodr_selected']) ? $_POST['kodchfsubpodr_selected'] : "";
$__kodchfsubpodr_field = !empty($_POST['kodchfsubpodr_field']) ? $_POST['kodchfsubpodr_field'] : "";
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция формирования нового ID аванса (kodavsubpodr) для таблицы авансов субподряда 'dognet_docavsubpodr'
#
function nextKodavsubpodr() {
	$query = mysqlQuery("SELECT MAX(kodavsubpodr) as lastKod FROM dognet_docavsubpodr ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
function MAIN($db, $action, $id, $values, $row) {
	if ($action != 'DEL') {
		$_QRY_AV = $db->sql("SELECT * FROM dognet_docavsubpodr WHERE id='{$id}'")->fetchAll();
		$koddocsubpodr = $_QRY_AV[0]['koddocsubpodr'];
		$kodavsubpodr = $_QRY_AV[0]['kodavsubpodr'];
		$kodchfsubpodr = $_QRY_AV[0]['kodchfsubpodr'];
		$useavans = !empty($_QRY_AV[0]['useavans']) ? $_QRY_AV[0]['useavans'] : "";
		$sumavsubpodr = !empty($_QRY_AV[0]['sumavsubpodr']) ? $_QRY_AV[0]['sumavsubpodr'] : "";

		$sumAvSplit = !empty($kodavsubpodr) ? CALC_AV_SUM_SPLIT($db, $action, $id, $kodavsubpodr) : 0;
		$sumAvChfSplit = (!empty($kodavsubpodr) && !empty($kodchfsubpodr)) ? CALC_AV_SUMCHF_SPLIT($db, $action, $id, $kodavsubpodr, $kodchfsubpodr) : 0;
		$sumAvOst = (!empty($kodavsubpodr) && !empty($useavans)) ? CALC_AV_SUMOST($db, $action, $id, $useavans, $kodavsubpodr) : 0;
		$sumAvChf = (!empty($kodavsubpodr) && !empty($useavans)) ? CALC_AV_SUMCHF($db, $action, $id, $useavans, $kodavsubpodr) : 0;

		if (empty($useavans)) {
			if (!empty($kodavsubpodr)) {
				$_QRY_DEL_SPLIT = $db->sql("DELETE FROM dognet_docavsplitsubpodr WHERE kodavsubpodr='{$kodavsubpodr}' AND id<>'1'");
			}
			$db->update('dognet_docavsubpodr', array(
				'sumchfavsubpodr'			=>	'0',
				'sumostsubpodr'				=>	$sumAvOst,
				'sumsplitsubpodr'			=>	'0',
			), array('id' => $id));
		} elseif (!empty($useavans) && $useavans == '1') {
			$db->update('dognet_docavsubpodr', array(
				'sumchfavsubpodr'			=>	$sumAvChf,
				'sumostsubpodr'				=>	$sumAvOst,
				'sumsplitsubpodr'			=>	$sumAvSplit,
			), array('id' => $id));
		} elseif (!empty($useavans) && $useavans == '2') {
			if (!empty($kodavsubpodr)) {
				$_QRY_DEL_SPLIT = $db->sql("DELETE FROM dognet_docavsplitsubpodr WHERE kodavsubpodr='{$kodavsubpodr}' AND id<>'1'");
			}
			$db->update('dognet_docavsubpodr', array(
				'sumchfavsubpodr'			=>	$sumavsubpodr,
				'sumostsubpodr'				=>	'0',
				'sumsplitsubpodr'			=>	'0',
			), array('id' => $id));
		}
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'CRT') {
		$__nextKodavsubpodr = nextKodavsubpodr();
		$db->update('dognet_docavsubpodr', array(
			'kodavsubpodr'			=>	$__nextKodavsubpodr,
		), array('id' => $id));
		DOCSUB_PR_ZADOLG_DOC($db, "docavsubpodr", $id, $action);
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'UPD') {
		DOCSUB_PR_ZADOLG_DOC($db, "docavsubpodr", $id, $action);
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'PREDEL') {
		$_QRY_DEL_SPLIT = $db->sql("DELETE FROM dognet_docavsplitsubpodr WHERE kodavsubpodr='{$kodavsubpodr}'");
		DOCSUB_PR_ZADOLG_DOC($db, "docavsubpodr", $id, $action);
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'DEL') {
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
	if (!isset($_POST['koddocsubpodr']) || !is_numeric($_POST['koddocsubpodr'])) {
		echo json_encode(["data" => []]);
	} else {
		$_SESSION['tmp_SelectedKodchfsubpodr'] = $_POST['kodavsubpodr'];
		// Build our Editor instance and process the data coming from _POST
		Editor::inst($db, 'dognet_docavsubpodr')
			->fields(
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docavsubpodr.kodchfsubpodr')
					->options(
						Options::inst()
							->table('dognet_docchfsubpodr')
							->value('kodchfsubpodr')
							->label(array('koddocsubpodr', 'kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr'))
							->render(function ($row) {
								return ("Счет-фактура № : " . $row['numberchfsubpodr'] . " от " . date('d.m.Y', strtotime($row['datechfsubpodr'])));
							})
							->where(function ($q) use ($__koddocsubpodr) {
								$q->where('koddocsubpodr', $__koddocsubpodr, '=');
							})
					),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docavsubpodr.koddocsubpodr')
					->options(
						Options::inst()
							->table('dognet_docsubpodr')
							->value('koddocsubpodr')
							->label(array('koddocsubpodr', 'numberdocsubpodr', 'kodsubpodr'))
							->render(function ($row) use ($__koddocsubpodr) {
								return ("Договор № " . $row['numberdocsubpodr']);
							})
							->where(function ($q) use ($__koddocsubpodr) {
								$q->where('koddocsubpodr', $__koddocsubpodr, '=');
							})
					)
					->validator(Validate::notEmpty(
						ValidateOptions::inst()
							->message('Выберите договор')
					)),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docavsubpodr.kodavsubpodr'),
				Field::inst('dognet_docavsubpodr.dateavsubpodr')
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
				Field::inst('dognet_docavsubpodr.useavans'),
				Field::inst('dognet_docavsubpodr.sumavsubpodr'),
				Field::inst('dognet_docavsubpodr.sumsplitsubpodr'),
				Field::inst('dognet_docavsubpodr.sumchfavsubpodr'),
				Field::inst('dognet_docavsubpodr.sumostsubpodr'),
				Field::inst('dognet_docchfsubpodr.koddocsubpodr'),
				Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
				Field::inst('dognet_dockalplan.kodkalplan'),
				Field::inst('dognet_docbase.koddoc'),
				Field::inst('dognet_docbase.koddened'),
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
			->leftJoin('dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsubpodr.kodchfsubpodr')
			->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docavsubpodr.koddocsubpodr')
			->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc')
			->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
			->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
			->where('dognet_docavsubpodr.koddocsubpodr', $__koddocsubpodr)
			//   ->where( 'dognet_docavsubpodr.kodchfsubpodr', $__kodchfsubpodr )
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
	if (!isset($_POST['koddocsubpodr']) || !is_numeric($_POST['koddocsubpodr'])) {
		echo json_encode(["data" => []]);
	} else {
		if (!isset($_POST['kodavsubpodr']) || !is_numeric($_POST['kodavsubpodr'])) {
			// Build our Editor instance and process the data coming from _POST
			Editor::inst($db, 'dognet_docavsubpodr')
				->fields(
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodchfsubpodr')
						->options(
							Options::inst()
								->table('dognet_docchfsubpodr')
								->value('kodchfsubpodr')
								->label(array('koddocsubpodr', 'kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr'))
								->render(function ($row) use ($__koddocsubpodr) {
									return ("Счет № " . $row['numberchfsubpodr']);
								})
								->where(function ($q) use ($__koddocsubpodr) {
									$q->where('koddocsubpodr', $__koddocsubpodr, '=');
								})
						),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.koddocsubpodr')
						->options(
							Options::inst()
								->table('dognet_docsubpodr')
								->value('koddocsubpodr')
								->label(array('koddocsubpodr', 'numberdocsubpodr', 'kodsubpodr'))
								->render(function ($row) use ($__koddocsubpodr) {
									return ("Договор № " . $row['numberdocsubpodr']);
								})
								->where(function ($q) use ($__koddocsubpodr) {
									$q->where('koddocsubpodr', $__koddocsubpodr, '=');
								})
						)
						->validator(Validate::notEmpty(
							ValidateOptions::inst()
								->message('Объект обязателен')
						)),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodavsubpodr'),
					Field::inst('dognet_docavsubpodr.dateavsubpodr')
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
					Field::inst('dognet_docavsubpodr.useavans'),
					Field::inst('dognet_docavsubpodr.sumavsubpodr'),
					Field::inst('dognet_docavsubpodr.sumsplitsubpodr'),
					Field::inst('dognet_docavsubpodr.sumchfavsubpodr'),
					Field::inst('dognet_docavsubpodr.sumostsubpodr'),
					Field::inst('dognet_docchfsubpodr.koddocsubpodr'),
					Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
					Field::inst('dognet_docbase.koddoc'),
					Field::inst('dognet_docbase.koddened'),
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
				->leftJoin('dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsubpodr.kodchfsubpodr')
				->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docavsubpodr.koddocsubpodr')
				->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docsubpodr.koddoc')
				->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
				->where('dognet_docavsubpodr.koddocsubpodr', $__koddocsubpodr)
				//   ->where( 'dognet_docavsubpodr.kodchfsubpodr', $__kodchfsubpodr )
				->process($_POST)
				->json();
		} else {
			$_SESSION['tmp_SelectedKodchfsubpodr'] = $_POST['kodavsubpodr'];
			// Build our Editor instance and process the data coming from _POST
			Editor::inst($db, 'dognet_docavsubpodr')
				->fields(
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodchfsubpodr')
						->options(
							Options::inst()
								->table('dognet_docchfsubpodr')
								->value('kodchfsubpodr')
								->label(array('koddocsubpodr', 'kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr'))
								->render(function ($row) use ($__kodchfsubpodr) {
									return ("Счет № " . $row['numberchfsubpodr']);
								})
								->where(function ($q) use ($__kodchfsubpodr) {
									$q->where('kodchfsubpodr', $__kodchfsubpodr, '=');
								})
						),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.koddocsubpodr')
						->options(
							Options::inst()
								->table('dognet_docsubpodr')
								->value('koddocsubpodr')
								->label(array('koddocsubpodr', 'numberdocsubpodr', 'kodsubpodr'))
								->render(function ($row) use ($__koddocsubpodr) {
									return ("Договор № " . $row['numberdocsubpodr']);
								})
								->where(function ($q) use ($__koddocsubpodr) {
									$q->where('koddocsubpodr', $__koddocsubpodr, '=');
								})
						)
						->validator(Validate::notEmpty(
							ValidateOptions::inst()
								->message('Выберите договор')
						)),
					// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
					Field::inst('dognet_docavsubpodr.kodavsubpodr'),
					Field::inst('dognet_docavsubpodr.dateavsubpodr')
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
					Field::inst('dognet_docavsubpodr.useavans'),
					Field::inst('dognet_docavsubpodr.sumavsubpodr'),
					Field::inst('dognet_docavsubpodr.sumsplitsubpodr'),
					Field::inst('dognet_docavsubpodr.sumchfavsubpodr'),
					Field::inst('dognet_docavsubpodr.sumostsubpodr'),
					Field::inst('dognet_docchfsubpodr.koddocsubpodr'),
					Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
					Field::inst('dognet_docbase.koddoc'),
					Field::inst('dognet_docbase.koddened'),
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
				->leftJoin('dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsubpodr.kodchfsubpodr')
				->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docavsubpodr.koddocsubpodr')
				->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docsubpodr.koddoc')
				->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
				->where('dognet_docavsubpodr.koddocsubpodr', $__koddocsubpodr)
				//   ->where( 'dognet_docavsubpodr.kodchfsubpodr', $__kodchfsubpodr )
				->process($_POST)
				->json();
		}
	}
	#
	#
}
