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
// $__uniqueID = "245847329098834";

# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
# 
// Вытаскиваем идентификатор календарного плана 
// 	$query = mysqlQuery("SELECT inbox_docID FROM mailbox_incoming WHERE id=".$currID);
// 	$row = mysqli_fetch_assoc($query);
// 	$currDocID = $row['inbox_docID'];
// 	$_SESSION['editedInboxDocID'] = $currDocID;
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
		Field::inst('dognet_dockalplan.kodkalplan'),
		Field::inst('dognet_dockalplan.numberstage'),
		Field::inst('dognet_dockalplan.nameshotstage'),
		Field::inst('dognet_dockalplan.namefullstage'),
		Field::inst('dognet_dockalplan.dateplan'),
		Field::inst('dognet_dockalplan.summastage'),
		Field::inst('dognet_kalplanchf.chetfnumber'),
		Field::inst('dognet_kalplanchf.chetfsumma'),
		Field::inst('sp_objects.nameobjectshot')
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 
	)
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	//
	->on('preGet', function ($editor, $id) use ($__uniqueID) {
		$editor->where(function ($q) use ($__uniqueID) {
			$q->where('dognet_dockalplan.koddoc', $__uniqueID);
		});
	})
	//
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- 		
	//
	->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_dockalplan.kodobject')
	->leftJoin('dognet_kalplanchf', 'dognet_kalplanchf.kodkalplan', '=', 'dognet_dockalplan.kodkalplan')
	// 	->leftJoin( 'dognet_chfavans', 'dognet_chfavans.kodchfact', '=', 'dognet_kalplanchf.kodchfact' )
	->join(
		Mjoin::inst('dognet_chfavans')
			->link('dognet_dockalplan.kodkalplan', 'dognet_kalplanchf.kodkalplan')
			->link('dognet_chfavans.kodchfact', 'dognet_kalplanchf.kodchfact')
			->fields(
				Field::inst('kodchfact')
					->options(
						Options::inst()
							->table('dognet_chfavans')
							->value('kodchfact')
							->label('summaoplav')
					),
				Field::inst('summaoplav')
			)
	)
	->process($_POST)
	->json();
