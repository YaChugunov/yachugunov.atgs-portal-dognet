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
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Функция определения нового кода документа/записи (koddocmail) для таблицы заказчиков
//
function newkodpost() {
	$query = mysqlQuery("SELECT MAX(kodpost) as lastKod FROM dognet_sppostav ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
function updateFields($db, $action, $id, $values) {
	#
	#
	if ($action == 'CRT') {
		$newkodpost = newkodpost();
		$db->update('sp_contragents', array(
			'kodpost' => $newkodpost
		), array(
			'id' => $id
		));
	}
	#
	#
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
Editor::inst($db, 'sp_contragents')
	->fields(
		Field::inst('sp_contragents.id'),
		Field::inst('sp_contragents.kodcontragent'),
		Field::inst('sp_contragents.koddel'),
		Field::inst('sp_contragents.nameshort')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Краткое наименование Заказчика обязательно')
			)),
		Field::inst('sp_contragents.namefull'),
		Field::inst('sp_contragents.address_postal'),
		Field::inst('sp_contragents.web_official'),
		Field::inst('sp_contragents.tel_official'),
		Field::inst('sp_contragents.fax_official'),
		Field::inst('sp_contragents.postcontactfax'),
		Field::inst('sp_contragents.postcontactmore'),
		Field::inst('sp_contragents.postcontactone'),
		Field::inst('sp_contragents.postcontactmail'),
		Field::inst('sp_contragents.postcontacttel'),
		Field::inst('sp_contragents.postcontacticq'),
		Field::inst('sp_contragents.cont1_name'),
		Field::inst('sp_contragents.cont1_email'),
		Field::inst('sp_contragents.cont1_tels'),
		Field::inst('sp_contragents.cont1_telm'),
		Field::inst('sp_contragents.cont1_name'),
		Field::inst('sp_contragents.cont1_email'),
		Field::inst('sp_contragents.cont1_tels'),
		Field::inst('sp_contragents.cont1_telm'),
		Field::inst('sp_contragents.cont3_name'),
		Field::inst('sp_contragents.cont3_email'),
		Field::inst('sp_contragents.cont3_tels'),
		Field::inst('sp_contragents.cont3_telm'),
		Field::inst('sp_contragents.kodmaster')
	)
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('preGet', function ($editor_docbase, $id) {
		$editor_docbase->where(function ($q) {
			$q->where('sp_contragents.koddel', '99', '!=');
		});
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->on('postCreate', function ($editor, $id, $values, $row) {
		updateFields($editor->db(), 'CRT', $id, $values);
	})
	->on('postEdit', function ($editor, $id, $values, $row) {
		updateFields($editor->db(), 'UPD', $id, $values);
	})
	->on('preRemove', function ($editor, $id, $values) {
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// 	->leftJoin( 'dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_spzayvtel.kodispol' )
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->process($_POST)
	->json();
