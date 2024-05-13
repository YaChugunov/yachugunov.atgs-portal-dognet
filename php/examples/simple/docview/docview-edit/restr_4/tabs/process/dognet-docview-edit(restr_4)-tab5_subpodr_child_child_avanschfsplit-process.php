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
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-edit/restr_4/tabs/process/functions/funcDognet-AvSplit.Inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
$__uniqueID = $_SESSION['uniqueID'];
$__koddocsubpodr = !empty($_POST['koddocsubpodr']) ? $_POST['koddocsubpodr'] : "";
$__kodavsubpodr = !empty($_POST['kodavsubpodr']) ? $_POST['kodavsubpodr'] : "";
$__kodchfsubpodr_selected = !empty($_POST['kodchfsubpodr_selected']) ? $_POST['kodchfsubpodr_selected'] : "";
$__kodchfsubpodr_field = !empty($_POST['kodchfsubpodr_field']) ? $_POST['kodchfsubpodr_field'] : "";
$__sumavsplit_selected = !empty($_POST['sumavsplit_selected']) ? $_POST['sumavsplit_selected'] : "";
$__sumavsplit_field = !empty($_POST['sumavsplit_field']) ? $_POST['sumavsplit_field'] : "";
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция формирования нового ID аванса (kodavsubpodr) для таблицы авансов субподряда 'dognet_docavsubpodr'
#
function nextKodavsplit() {
	$query = mysqlQuery("SELECT MAX(kodavsplit) as lastKod FROM dognet_docavsplitsubpodr ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 9);
	return $nextKod;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
function MAIN($db, $action, $id, $values, $row) {
	if ($action != 'DEL') {
		$_QRY_AV_SPLIT = $db->sql("SELECT * FROM dognet_docavsplitsubpodr WHERE id='{$id}'")->fetchAll();
		$koddocsubpodr = $_QRY_AV_SPLIT[0]['koddocsubpodr'];
		$kodavsubpodr = $_QRY_AV_SPLIT[0]['kodavsubpodr'];
		$kodchfsubpodr = $_QRY_AV_SPLIT[0]['kodchfsubpodr'];

		if (!empty($kodavsubpodr)) {
			$_QRY_AV = $db->sql("SELECT * FROM dognet_docavsubpodr WHERE kodavsubpodr='{$kodavsubpodr}'")->fetchAll();
		}
		$useavans = !empty($_QRY_AV) ? $_QRY_AV[0]['useavans'] : '1';

		$sumAvSplit = !empty($kodavsubpodr) ? CALC_SUMAV_SPLIT($db, $action, $id, $kodavsubpodr) : 0;
		$sumAvChfSplit = (!empty($kodavsubpodr) && !empty($kodchfsubpodr)) ? CALC_SUMAVCHF_SPLIT($db, $action, $id, $kodavsubpodr, $kodchfsubpodr) : 0;
		$sumAvOst = (!empty($kodavsubpodr) && !empty($useavans)) ? CALC_SUMAVOST($db, $action, $id, $useavans, $kodavsubpodr) : 0;
		$sumAvChf = (!empty($kodavsubpodr) && !empty($useavans)) ? CALC_SUMAVCHF($db, $action, $id, $useavans, $kodavsubpodr) : 0;

		$_QRY = $db->sql("UPDATE dognet_docavsubpodr SET sumsplitsubpodr = '{$sumAvSplit}', sumostsubpodr = '{$sumAvOst}', sumchfavsubpodr = '{$sumAvChf}' WHERE kodavsubpodr=" . $kodavsubpodr);
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'CRT') {
		$__nextKodavsplit = nextKodavsplit();
		$db->update('dognet_docavsplitsubpodr', array(
			'kodavsplit'			=>	$__nextKodavsplit
		), array('id' => $id));
		DOCSUB_PR_ZADOLG_DOC($db, "docavsplitsubpodr", $id, $action);
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'UPD') {
		DOCSUB_PR_ZADOLG_DOC($db, "docavsplitsubpodr", $id, $action);
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'PREDEL') {
		DOCSUB_PR_ZADOLG_DOC($db, "docavsplitsubpodr", $id, $action);
	}
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
if (!isset($_POST['kodavsubpodr']) || !is_numeric($_POST['kodavsubpodr'])) {
	echo json_encode(["data" => []]);
} else {
	// Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_docavsplitsubpodr')
		->fields(
			Field::inst('dognet_docavsplitsubpodr.kodchfsubpodr')
				->options(
					Options::inst()
						->table('dognet_docchfsubpodr')
						->value('kodchfsubpodr')
						->label(array('koddocsubpodr', 'kodchfsubpodr', 'numberchfsubpodr', 'datechfsubpodr'))
						->render(function ($row) use ($__koddocsubpodr) {
							return ("Счет-фактура № : " . $row['numberchfsubpodr'] . " от " . date('d.m.Y', strtotime($row['datechfsubpodr'])));
						})
						->where(function ($q) use ($__koddocsubpodr) {
							$q->where('koddocsubpodr', $__koddocsubpodr, '=');
						})
				),
			Field::inst('dognet_docavsplitsubpodr.dateavsplit')
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
			Field::inst('dognet_docavsplitsubpodr.sumavsplit'),
			Field::inst('dognet_docavsplitsubpodr.koddocsubpodr'),
			Field::inst('dognet_docavsplitsubpodr.kodavsubpodr'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
			UPDATE_CHFZADOL($editor->db(), 'CRT', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field'], $_POST['sumavsplit_selected'], $_POST['sumavsplit_field']);
			UPDATE_CHFZADOL_OTH($editor->db(), 'CRT', $id, $_POST['koddocsubpodr'], $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
		})
		->on('postEdit', function ($editor, $id, $values, $row) {
			MAIN($editor->db(), 'UPD', $id, $values, $row);
			UPDATE_CHFZADOL($editor->db(), 'UPD', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field'], $_POST['sumavsplit_selected'], $_POST['sumavsplit_field']);
			UPDATE_CHFZADOL_OTH($editor->db(), 'UPD', $id, $_POST['koddocsubpodr'], $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
		})
		->on('preRemove', function ($editor, $id, $values) {
			MAIN($editor->db(), 'PREDEL', $id, $values, null);
			UPDATE_CHFZADOL($editor->db(), 'PREDEL', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field'], $_POST['sumavsplit_selected'], $_POST['sumavsplit_field']);
		})
		->on('postRemove', function ($editor, $id, $values) {
			MAIN($editor->db(), 'DEL', $id, $values, null);
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin('dognet_docchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr', '=', 'dognet_docavsplitsubpodr.kodchfsubpodr')
		->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docavsplitsubpodr.koddocsubpodr')
		->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->where('dognet_docavsplitsubpodr.kodavsubpodr', $__kodavsubpodr)
		->process($_POST)
		->json();
}
