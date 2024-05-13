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
require($_SERVER['DOCUMENT_ROOT'] . "/mail/_assets/functions/funcMail.inc.php");
# Включаем режим сессии
session_start();
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Функция определения нового кода документа/записи (koddocmail) для таблицы заказчиков
//
function newKodzakaz() {
	$query = mysqlQuery("SELECT MAX(kodzakaz) as lastKod FROM sp_contragents ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$newKod = $lastKod + rand(13, 33);
	return $newKod;
}
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
function updateFields($db, $action, $id, $values) {
	#
	#
	$__zakname = $db->sql("SELECT zakfistname, zakmidname, zaklastname FROM sp_contragents WHERE id=" . $id)->fetchAll();
	$zakFIO1 = !empty($__zakname[0]['zaklastname']) ? $__zakname[0]['zaklastname'] . " " : "";
	$zakFIO2 = !empty($__zakname[0]['zakfistname']) ? mb_substr($__zakname[0]['zakfistname'], 0, 1) . ". " : "";
	$zakFIO3 = !empty($__zakname[0]['zakmidname']) ? mb_substr($__zakname[0]['zakmidname'], 0, 1) . ". " : "";
	#
	#
	if ($action == 'CRT') {
		$newKodZakaz = newKodzakaz();
		$db->update('sp_contragents', array(
			'kodzakaz'			=> $newKodZakaz,
			'koddel'			=> ""
		), array(
			'id' => $id
		));
	}
	#
	#
	$db->update('sp_contragents', array(
		'zakfio'			=> $zakFIO1 . $zakFIO2 . $zakFIO3
	), array(
		'id' => $id
	));
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
		Field::inst('ID'),
		Field::inst('kodzakaz'),
		Field::inst('koddel'),
		Field::inst('namezakshot')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Краткое наименование Заказчика обязательно')
			)),
		Field::inst('namezaklong')
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Полное наименование Заказчика обязательно')
			)),
		Field::inst('zakuraddress'),
		Field::inst('zakaddressfact'),
		Field::inst('zakbankch'),
		Field::inst('zakinn'),
		Field::inst('zakkpp'),
		Field::inst('zakdolg'),
		Field::inst('zakfio'),
		Field::inst('zakfistname'),
		Field::inst('zakmidname'),
		Field::inst('zaklastname'),
		Field::inst('zaktelnumber')
	)
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	//
	//
	->on('postCreate', function ($editor, $id, $values, $row) {
		updateFields($editor->db(), 'CRT', $id, $values);
	})
	->on('postEdit', function ($editor, $id, $values, $row) {
		updateFields($editor->db(), 'UPD', $id, $values);
	})
	->on('preRemove', function ($editor, $id, $values) {
	})
	//
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	->where("koddel", "99", "!=")
	->process($_POST)
	->json();
