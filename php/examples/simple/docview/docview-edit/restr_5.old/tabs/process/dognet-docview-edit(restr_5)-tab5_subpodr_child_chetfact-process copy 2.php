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
$__kodchfsubpodr_selected = !empty($_POST['kodchfsubpodr_selected']) ? $_POST['kodchfsubpodr_selected'] : "";
$__kodchfsubpodr_field = !empty($_POST['kodchfsubpodr_field']) ? $_POST['kodchfsubpodr_field'] : "";
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Функция формирования нового ID оплаты счеты-фактуры (kodoplchfsubpodr)
# для таблицы оплат счетов-фактур субподряда 'dognet_docoplchfsubpodr'
# ----- ----- -----
function nextKodchfsubpodr() {
	$query = mysqlQuery("SELECT MAX(kodchfsubpodr) as lastKod FROM dognet_docchfsubpodr ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
# ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
#
function MAIN($db, $action, $id, $values) {

	// ID счета фактуры
	$_QRY_1 = $db->sql("SELECT kodchfsubpodr FROM dognet_docchfsubpodr WHERE id=" . $id)->fetchAll();
	if ($_QRY_1) {
		$__kodchfsubpodr = $_QRY_1[0]['kodchfsubpodr'];
	}
	// -----
	// Сумма счета-фактуры
	$_QRY_2 = $db->sql("SELECT sumchfsubpodr FROM dognet_docchfsubpodr WHERE id=" . $id)->fetchAll();
	if ($_QRY_2) {
		$__sumchfsubpodr = $_QRY_2[0]['sumchfsubpodr'];
	}
	// -----
	// Сумма задолженности счета-фактуры (из таблицы)
	$_QRY_3 = $db->sql("SELECT sumzadolchfsubpodr FROM dognet_docchfsubpodr WHERE id=" . $id)->fetchAll();
	if ($_QRY_3) {
		$__sumzadolchfsubpodr = $_QRY_3[0]['sumzadolchfsubpodr'];
	}




	if ($action != 'DEL') {
		$_QRY_CHF = $db->sql("SELECT * FROM dognet_docchfsubpodr WHERE id='{$id}'")->fetchAll();
		$koddocsubpodr = $_QRY_CHF[0]['koddocsubpodr'];
		$kodchfsubpodr = $_QRY_CHF[0]['kodchfsubpodr'];
		$sumchfsubpodr = !empty($_QRY_CHF[0]['sumchfsubpodr']) ? $_QRY_CHF[0]['sumchfsubpodr'] : "";
		$sumzadolchfsubpodr = !empty($_QRY_CHF[0]['sumzadolchfsubpodr']) ? $_QRY_CHF[0]['sumzadolchfsubpodr'] : "";
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'CRT') {
		$__nextKodchfsubpodr = nextKodchfsubpodr();
		$db->update('dognet_docchfsubpodr', array(
			'kodchfsubpodr'					=>	$__nextKodchfsubpodr,
			'sumzadolchfsubpodr'		=>	$__sumchfsubpodr
		), array('id' => $id));
		DOCSUB_PR_ZADOLG_DOC($db, "docchfsubpodr", $id, $action);
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'UPD') {
		$_NEW_sumzadolchfsubpodr = $__sumchfsubpodr - (CALC_SUMOPLCHF($db, $action, $id, $kodCHF_field) + CALC_SUMAVCHF($kodchfsubpodr));
		$db->update('dognet_docchfsubpodr', array(
			'sumzadolchfsubpodr'		=>	$_NEW_sumzadolchfsubpodr
		), array('id' => $id));
		DOCSUB_PR_ZADOLG_DOC($db, "docchfsubpodr", $id, $action);
	}
	#
	# -- -- -- -- -- -- -- -- -- --
	#
	if ($action == 'PREDEL') {
		$_QRY_DEL2 = $db->sql("DELETE FROM dognet_docoplchfsubpodr WHERE kodchfsubpodr=" . $kodchfsubpodr);
		$_QRY_DEL3 = $db->sql("UPDATE dognet_docavsubpodr SET kodchfsubpodr='' WHERE kodchfsubpodr=" . $kodchfsubpodr);
		$_QRY_DEL4 = $db->sql("UPDATE dognet_docavsplitsubpodr SET kodchfsubpodr='' WHERE kodchfsubpodr=" . $kodchfsubpodr);
		DOCSUB_PR_ZADOLG_DOC($db, "docchfsubpodr", $id, $action);
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


if (!isset($_POST['koddocsubpodr']) || !is_numeric($_POST['koddocsubpodr'])) {
	echo json_encode(["data" => []]);
} else {
	#
	#
	if ($_KODSHAB == "1" or $_KODSHAB == "3") {
		#
		#
		$__koddocsubpodr = $_POST['koddocsubpodr'];
		// $_SESSION['tmp_SelectedKodchfsubpodr'] = $_POST['kodchfsubpodr'];
		// Build our Editor instance and process the data coming from _POST
		Editor::inst($db, 'dognet_docchfsubpodr')
			->fields(
				Field::inst('dognet_docchfsubpodr.numberchfsubpodr'),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docchfsubpodr.koddocsubpodr')
					->options(
						Options::inst()
							->table('dognet_docsubpodr')
							->value('koddocsubpodr')
							->label(array('koddoc', 'koddocsubpodr', 'numberdocsubpodr', 'datedocsubpodr'))
							->render(function ($row) use ($__koddocsubpodr) {
								return ("Договор : " . $row['numberdocsubpodr']);
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
				//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
				Field::inst('dognet_docchfsubpodr.datechfsubpodr')
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
				Field::inst('dognet_docchfsubpodr.sumchfsubpodr'),
				Field::inst('dognet_docchfsubpodr.sumzadolchfsubpodr'),
				Field::inst('dognet_docsubpodr.koddoc'),
				Field::inst('dognet_docsubpodr.koddocsubpodr'),
				Field::inst('dognet_dockalplan.kodkalplan'),
				Field::inst('dognet_docbase.koddoc'),
				Field::inst('dognet_docbase.koddened'),
				Field::inst('dognet_spdened.html_code'),
				Field::inst('dognet_spdened.short_code')
			)
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->on('postCreate', function ($editor, $id, $values, $row) {
				MAIN($editor->db(), 'CRT', $id, $values);
				// UPDATE_CHFZADOL($editor->db(), 'CRT', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
				// UPDATE_CHFZADOL_OTH($editor->db(), 'CRT', $id, $_POST['koddocsubpodr'], $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
			})
			->on('postEdit', function ($editor, $id, $values, $row) {
				MAIN($editor->db(), 'UPD', $id, $values);
				// UPDATE_CHFZADOL($editor->db(), 'UPD', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
				// UPDATE_CHFZADOL_OTH($editor->db(), 'UPD', $id, $_POST['koddocsubpodr'], $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
			})
			->on('preRemove', function ($editor, $id, $values) {
				MAIN($editor->db(), 'PREDEL', $id, $values);
				// UPDATE_CHFZADOL($editor->db(), 'PREDEL', $id, $_POST['kodchfsubpodr_selected'], $_POST['kodchfsubpodr_field']);
			})
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docchfsubpodr.koddocsubpodr')
			->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docsubpodr.koddoc')
			->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
			->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
			->join(
				Mjoin::inst('dognet_docoplchfsubpodr')
					->link('dognet_docoplchfsubpodr.kodchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr')
					->field(
						Field::inst('kodchfsubpodr')
					)
			)
			->where('dognet_docchfsubpodr.koddocsubpodr', $__koddocsubpodr)
			->process($_POST)
			->json();
	}
	#
	#
	if ($_KODSHAB == "2" or $_KODSHAB == "4") {
		$__koddocsubpodr = $_POST['koddocsubpodr'];
		// $_SESSION['tmp_SelectedKodchfsubpodr'] = $_POST['kodchfsubpodr'];
		// Build our Editor instance and process the data coming from _POST
		Editor::inst($db, 'dognet_docchfsubpodr')
			->fields(
				Field::inst('dognet_docchfsubpodr.numberchfsubpodr'),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docchfsubpodr.koddocsubpodr')
					->options(
						Options::inst()
							->table('dognet_docsubpodr')
							->value('koddocsubpodr')
							->label(array('koddoc', 'koddocsubpodr', 'numberdocsubpodr', 'datedocsubpodr'))
							->render(function ($row) use ($__koddocsubpodr) {
								return ("Договор : " . $row['numberdocsubpodr']);
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
				//       Field::inst( 'dognet_kalplanchf.chetfnumber' ),
				// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
				Field::inst('dognet_docchfsubpodr.kodchfsubpodr'),
				Field::inst('dognet_docchfsubpodr.datechfsubpodr')
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
				Field::inst('dognet_docchfsubpodr.sumchfsubpodr'),
				Field::inst('dognet_docchfsubpodr.sumzadolchfsubpodr'),
				Field::inst('dognet_docsubpodr.koddoc'),
				Field::inst('dognet_docsubpodr.koddocsubpodr'),
				Field::inst('dognet_docbase.koddoc'),
				Field::inst('dognet_docbase.koddened'),
				Field::inst('dognet_spdened.html_code'),
				Field::inst('dognet_spdened.short_code')
			)
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->on('postCreate', function ($editor, $id, $values, $row) {
				MAIN($editor->db(), 'CRT', $id, $values);
			})
			->on('postEdit', function ($editor, $id, $values, $row) {
				MAIN($editor->db(), 'UPD', $id, $values);
			})
			->on('preRemove', function ($editor, $id, $values) {
				MAIN($editor->db(), 'PREDEL', $id, $values);
			})
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			->leftJoin('dognet_docsubpodr', 'dognet_docsubpodr.koddocsubpodr', '=', 'dognet_docchfsubpodr.koddocsubpodr')
			->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_docsubpodr.koddoc')
			->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
			->join(
				Mjoin::inst('dognet_docoplchfsubpodr')
					->link('dognet_docoplchfsubpodr.kodchfsubpodr', 'dognet_docchfsubpodr.kodchfsubpodr')
					->field(
						Field::inst('kodchfsubpodr')
					)
			)
			->where('dognet_docchfsubpodr.koddocsubpodr', $__koddocsubpodr)
			->process($_POST)
			->json();
	}
	#
	#
}