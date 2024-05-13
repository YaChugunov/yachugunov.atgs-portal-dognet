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
# Подключаем собственные функции сервиса
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/functions/funcDognet.inc.php");
# Включаем режим сессии
session_start();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Example PHP implementation used for the index.html example
#
# DataTables PHP library
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_datatables-php-api-editor/DataTables.php");
# Alias Editor classes so they are easy to use
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Format;
use DataTables\Editor\Mjoin;
use DataTables\Editor\Options;
use DataTables\Editor\Upload;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
#
#
$query = "";
$query2 = "";
$query3 = "";

if (!isset($_POST['on_date'])) {
	echo json_encode(["data" => []]);
} else {
	$on_date = date("Y-m-d", strtotime($_POST['on_date']));
	$query = "(SELECT kodkalplan FROM dognet_dockalplan_progress ";
	$query .= "WHERE srokstage_date <= '" . $on_date . "' AND srokstage_date != '0000-00-00' AND srokstage_date != 'NULL' AND srokstage_date != '')";
	// 		$query2 = "(SELECT kodtip FROM dognet_sptipdog WHERE nametip LIKE '%".$_POST['tipdog']."%')";
	// 		$query3 = "(SELECT kodcontragent FROM sp_contragents WHERE nameshort LIKE '%".$_POST['zakname']."%')";
	# Build our Editor instance and process the data coming from _POST
	Editor::inst($db, 'dognet_dockalplan_progress')
		->fields(
			Field::inst('dognet_dockalplan.koddoc'),
			Field::inst('dognet_dockalplan.kodkalplan'),
			Field::inst('dognet_dockalplan.nameshotstage'),
			Field::inst('dognet_dockalplan.namefullstage'),
			Field::inst('dognet_dockalplan.numberstage'),
			Field::inst('dognet_dockalplan.summastage'),
			Field::inst('dognet_dockalplan.idsrokstage'),
			Field::inst('dognet_dockalplan.srokstage'),
			Field::inst('dognet_dockalplan.srokopl'),
			Field::inst('dognet_dockalplan.dateplan'),
			Field::inst('dognet_dockalplan.numberdayoplstage'),
			Field::inst('dognet_dockalplan.dateoplall'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_dockalplan_progress.firstdateavans'),
			Field::inst('dognet_dockalplan_progress.idsrokstage'),
			Field::inst('dognet_dockalplan_progress.srokstage'),
			Field::inst('dognet_dockalplan_progress.srokstage_date'),
			Field::inst('dognet_dockalplan_progress.idsrokopl'),
			Field::inst('dognet_dockalplan_progress.srokopl'),
			Field::inst('dognet_dockalplan_progress.dateplan'),
			Field::inst('dognet_dockalplan_progress.numberdayoplstage'),
			Field::inst('dognet_dockalplan_progress.dateoplall'),
			Field::inst('dognet_dockalplan_progress.summastage'),
			Field::inst('dognet_dockalplan_progress.sumchfstage'),
			Field::inst('dognet_dockalplan_progress.zadolsum_chf'),
			Field::inst('dognet_dockalplan_progress.zadolsum_stage'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_docbase.koddoc'),
			Field::inst('dognet_docbase.yearnachdoc'),
			Field::inst('dognet_docbase.kodobject'),
			Field::inst('dognet_docbase.kodzakaz'),
			Field::inst('dognet_docbase.docnameshot'),
			Field::inst('dognet_docbase.docnamefullm'),
			Field::inst('dognet_docbase.koddened'),
			Field::inst('dognet_docbase.kodshab'),
			Field::inst('dognet_docbase.docnumber'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_spispol.kodispol'),
			Field::inst('dognet_spispol.ispolnameshot'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('sp_objects.kodobject'),
			Field::inst('sp_objects.nameobjectshot'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('sp_contragents.kodcontragent'),
			Field::inst('sp_contragents.nameshort'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_spstatus.kodstatus'),
			Field::inst('dognet_spstatus.statusnameshot'),
			// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
			Field::inst('dognet_spdened.koddened'),
			Field::inst('dognet_spdened.html_code'),
			Field::inst('dognet_spdened.short_code')
		)
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->on('preGet', function ($editor, $id) use ($query, $query2) {
			$editor->where(function ($q1) use ($query) {
				$q1->where('dognet_dockalplan_progress.kodkalplan', $query, "IN", false);
				$q1->where(function ($r1) {
					// Статус договора "Текущий"
					$r1->where('dognet_docbase.kodstatus', '245381842747296');
					// Статус договора "Проект"
					$r1->or_where('dognet_docbase.kodstatus', '245381842145343');
					// Статус договора "Подписание"
					$r1->or_where('dognet_docbase.kodstatus', '245267756667430');
					// Статус договора "Есть скан"
					$r1->or_where('dognet_docbase.kodstatus', '245597345680479');
				});
				$q1->where(function ($r2) {
					// Тип договора "Поставка"
					$r2->where('dognet_docbase.kodtip', '245287841608965');
					// Статус договора "Поставка+Работы"
					$r2->or_where('dognet_docbase.kodtip', '245287841599652');
				});
				$q1->where('dognet_dockalplan_progress.zadolsum_stage', 0, ">");
			});
			/*
        $editor->where(function ($q2) use ($query2) {
		    $q2->where('dognet_docbase.kodtip', $query2, "IN", false );
        });
*/
		})
		// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_dockalplan_progress.kodkalplan')
		->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
		->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_docbase.kodispol')
		->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
		->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_docbase.kodobject')
		->leftJoin('dognet_spstatus', 'dognet_spstatus.kodstatus', '=', 'dognet_docbase.kodstatus')
		->leftJoin('dognet_sptipdog', 'dognet_sptipdog.kodtip', '=', 'dognet_docbase.kodtip')
		->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
		->where('dognet_dockalplan.koddel', '99', '!=')
		->process($_POST)
		->json();
}
