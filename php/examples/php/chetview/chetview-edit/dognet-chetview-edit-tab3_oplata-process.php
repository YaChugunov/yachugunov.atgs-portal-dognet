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
# Функция определения нового номера этапа (numberstage) 
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- ----- 
function nextKodkalplan() {
	$query = mysqlQuery("SELECT MAX(kodkalplan) as lastKod FROM dognet_dockalplan ORDER BY id DESC");
	$row = mysqli_fetch_assoc($query);
	$lastKod = $row['lastKod'];
	$nextKod = $lastKod + rand(3, 33);
	return $nextKod;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# Функция определения нового номера этапа (numberstage) 
# для таблицы этапов 'dognet_dockalplan'
# ----- ----- ----- 
function updateFields($db, $action, $id, $values) {
	$__nextKodkalplan = nextKodkalplan();
	$__koddoc = $_SESSION['uniqueID'];
	if ($action == 'CRT') {
		$db->update('dognet_dockalplan', array(
			'kodkalplan'			=>	$__nextKodkalplan,
			'koddoc'					=>	$__koddoc
		), array('id' => $id));
	}
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
$__startDateIn = $_SESSION['in_startTableDate'];
$__endDateIn = $_SESSION['in_endTableDate'];
$__uniqueID = $_SESSION['uniqueID'];
// $__uniqueID = "245847329098834";
# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
#  
# 
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
Editor::inst($db, 'dognet_dockalplan')
	->fields(
		Field::inst('dognet_docbase.koddel'),
		Field::inst('dognet_dockalplan.numberstage'),
		Field::inst('dognet_dockalplan.nameshotstage'),
		Field::inst('dognet_dockalplan.namefullstage'),
		Field::inst('dognet_dockalplan.summastage'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst('dognet_dockalplan.srokstage'),
		Field::inst('dognet_dockalplan.idsrokstage'),
		Field::inst('dognet_dockalplan.srokopl'),
		Field::inst('dognet_dockalplan.idsrokopl'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst('dognet_dockalplan.useav1plan'),
		Field::inst('dognet_dockalplan.pravplan1stage'),
		Field::inst('dognet_dockalplan.dateplanav1stage'),
		Field::inst('dognet_dockalplan.useav2plan'),
		Field::inst('dognet_dockalplan.pravplan2stage'),
		Field::inst('dognet_dockalplan.dateplanav2stage'),
		Field::inst('dognet_dockalplan.useav3plan'),
		Field::inst('dognet_dockalplan.pravplan3stage'),
		Field::inst('dognet_dockalplan.dateplanav3stage'),
		Field::inst('dognet_dockalplan.useav4plan'),
		Field::inst('dognet_dockalplan.pravplan4stage'),
		Field::inst('dognet_dockalplan.dateplanav4stage'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst('dognet_dockalplan.numberdayoplstage'),
		Field::inst('dognet_dockalplan.dateplan'),
		Field::inst('dognet_dockalplan.dateoplall'),
		Field::inst('dognet_dockalplan.usedocsubpodr'),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
		Field::inst('sp_objects.nameobjectshot'),
		Field::inst('dognet_dockalplan.kodobject')
			->options(
				Options::inst()
					->table('sp_objects')
					->value('kodobject')
					->order('nameobjectshot asc')
					->render(function ($row) {
						return $row['nameobjectshot'];
					})
					->where(function ($q) {
						$q->where('koddel', '99', '<>');
						$q->where('useindog', '1');
						$q->where('nameobjectshot', '', '<>');
					})
			)
			->validator(Validate::notEmpty(
				ValidateOptions::inst()
					->message('Объект обязателен')
			)),
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		


		Field::inst('dognet_docbase.koddened'),
		Field::inst('dognet_spdened.koddened'),
		Field::inst('dognet_spdened.html_code'),
		Field::inst('dognet_spdened.short_code')
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
	)
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	//
	->on('preGet', function ($editor, $id) use ($__uniqueID) {
		$editor->where(function ($q) use ($__uniqueID) {
			$q->where('dognet_dockalplan.koddoc', $__uniqueID);
			$q->and_where('dognet_dockalplan.koddel', '99', '!=');
		});
	})
	//
	->on('postCreate', function ($editor, $id, $values, $row) {
		updateFields($editor->db(), 'CRT', $id, $values);
	})
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	//
	->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
	->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_dockalplan.kodobject')
	->process($_POST)
	->json();
