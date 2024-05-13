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
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
#
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Функция определения нового кода документа/записи (koddocmail) для таблицы заказчиков
//
function newKodcontact() {
	$query = mysqlQuery("SELECT MAX(kodcontact) as lastKod FROM dognet_spcontact ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$newKod = $lastKod + rand(3, 13);
	return $newKod;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
function updateFields($db, $action, $id, $values) {
	#
	#
	$__shortname = $db->sql("SELECT namecontactfist, namecontactsecond, namecontactend FROM dognet_spcontact WHERE id=" . $id)->fetchAll();
	$partFIO1 = !empty($__shortname[0]['namecontactend']) ? $__shortname[0]['namecontactend'] . " " : "";
	$partFIO2 = !empty($__shortname[0]['namecontactfist']) ? mb_substr($__shortname[0]['namecontactfist'], 0, 1) . ". " : "";
	$partFIO3 = !empty($__shortname[0]['namecontactsecond']) ? mb_substr($__shortname[0]['namecontactsecond'], 0, 1) . ". " : "";
	#
	#
	if ($action == 'CRT') {
		$newKodcontact = newKodcontact();
		$db->update('dognet_spcontact', array(
			'kodcontact' => $newKodcontact
		), array(
			'id' => $id
		));
	}
	#
	#
	$db->update('dognet_spcontact', array(
		'namecontactshot' => $partFIO1 . $partFIO2 . $partFIO3
	), array(
		'id' => $id
	));
	#
	#
}


#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
Editor::inst($db, 'dognet_spcontact')
	->fields(
		//
		Field::inst('dognet_spcontact.koddel'),
		Field::inst('dognet_spcontact.kodcontact'),
		Field::inst('dognet_spcontact.kodblankwork'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('sp_contragents.nameshort'),
		Field::inst('sp_contragents.namefull'),
		Field::inst('dognet_spcontact.kodzakaz')
			->options(
				Options::inst()
					->table('sp_contragents')
					->value('kodcontragent')
					->label(array('kodcontragent', 'nameshort', 'namefull'))
					->order('nameshort asc')
					->render(function ($row) {
						return $row['nameshort'];
					})
			)
			->setFormatter(Format::ifEmpty("")),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_docbase.docnumber'),
		Field::inst('dognet_docbase.docnameshot'),
		Field::inst('dognet_docbase.docnamefullm'),
		Field::inst('dognet_spcontact.koddoc')
			->options(
				Options::inst()
					->table('dognet_docbase')
					->value('koddoc')
					->label(array('koddoc', 'docnameshot', 'docnumber'))
					->render(function ($row) {
						return "№ 3-4/" . $row['docnumber'] . " (" . $row['docnameshot'] . ")";
					})
			)
			->setFormatter(Format::ifEmpty("")),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		Field::inst('dognet_spcontact.namecontactend'),
		Field::inst('dognet_spcontact.namecontactfist'),
		Field::inst('dognet_spcontact.namecontactsecond'),
		Field::inst('dognet_spcontact.namecontactshot'),
		Field::inst('dognet_spcontact.telcontact1'),
		Field::inst('dognet_spcontact.telcontact2'),
		Field::inst('dognet_spcontact.telcontact3'),
		Field::inst('dognet_spcontact.telcontactmobi'),
		Field::inst('dognet_spcontact.emailcontact'),
		Field::inst('dognet_spcontact.faxcontact'),
		Field::inst('dognet_spcontact.doljcontact'),
		Field::inst('dognet_spcontact.contactprim')
	)
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	//
	->on('postCreate', function ($editor, $id, $values, $row) {
		updateFields($editor->db(), 'CRT', $id, $values);
	})
	->on('postEdit', function ($editor, $id, $values, $row) {
		updateFields($editor->db(), 'CRT', $id, $values);
	})
	->on('preRemove', function ($editor, $id, $values) {
	})
	//
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_spcontact.koddoc')
	->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_spcontact.kodzakaz')
	->process($_POST)
	->json();
