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

if (!isset($_POST['start_date']) || !isset($_POST['end_date'])) {
    echo json_encode(["data" => []]);
} else {
    $start_date = date("Y-m-d", strtotime($_POST['start_date']));
    $end_date = date("Y-m-d", strtotime($_POST['end_date']));
    $query = "(SELECT koddoc FROM dognet_docavans WHERE ";
    $query .= "dateavans BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND ";
    $query .= "koddel<>'99')";
    $query2 = "(SELECT koddoc FROM dognet_docavans WHERE ";
    $query2 .= "dateavans BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND ";
    $query2 .= "koddel<>'99')";
    // 		$query3 = "(SELECT kodzakaz FROM sp_contragents WHERE nameshort LIKE '%".$_POST['zakname']."%')";
    # Build our Editor instance and process the data coming from _POST
    Editor::inst($db, 'dognet_docavans')
        ->fields(
            Field::inst('dognet_dockalplan.koddoc'),
            Field::inst('dognet_dockalplan.kodkalplan'),
            Field::inst('dognet_dockalplan.nameshotstage'),
            Field::inst('dognet_dockalplan.namefullstage'),
            Field::inst('dognet_dockalplan.numberstage'),
            Field::inst('dognet_dockalplan.summastage'),
            Field::inst('dognet_dockalplan.srokstage'),
            Field::inst('dognet_dockalplan.srokopl'),
            Field::inst('dognet_dockalplan.dateplan'),
            Field::inst('dognet_dockalplan.numberdayoplstage'),
            Field::inst('dognet_dockalplan.dateoplall'),
            // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
            Field::inst('dognet_docavans.koddoc'),
            Field::inst('dognet_docavans.kodavans'),
            Field::inst('dognet_docavans.nameavans'),
            Field::inst('dognet_docavans.dateavans'),
            Field::inst('dognet_docavans.summaavans'),
            Field::inst('dognet_docavans.ostatokavans'),
            Field::inst('dognet_docavans.comment'),
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
            Field::inst('dognet_sptipdog.kodtip'),
            Field::inst('dognet_sptipdog.nametip'),
            // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
            Field::inst('dognet_spdened.koddened'),
            Field::inst('dognet_spdened.html_code'),
            Field::inst('dognet_spdened.short_code')
        )
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        ->on('preGet', function ($editor, $id) use ($query, $query2) {
            $editor->where(function ($q1) use ($query, $query2) {
                // 		    $q1->where('dognet_dockalplan.kodkalplan', $query, "IN", false );
                // 		    $q1->or_where('dognet_docbase.koddoc', $query2, "IN", false );
            });
            /*
        $editor->where(function ($q2) use ($query2) {
		    $q2->where('dognet_docbase.kodtip', $query2, "IN", false );
        });
*/
        })
        // ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
        ->leftJoin('dognet_dockalplan', 'dognet_dockalplan.kodkalplan', '=', 'dognet_docavans.koddoc')
        ->leftJoin('dognet_docbase', 'dognet_docbase.koddoc', '=', 'dognet_dockalplan.koddoc')
        ->leftJoin('dognet_spispol', 'dognet_spispol.kodispol', '=', 'dognet_docbase.kodispol')
        ->leftJoin('sp_contragents', 'sp_contragents.kodcontragent', '=', 'dognet_docbase.kodzakaz')
        ->leftJoin('sp_objects', 'sp_objects.kodobject', '=', 'dognet_docbase.kodobject')
        ->leftJoin('dognet_sptipdog', 'dognet_sptipdog.kodtip', '=', 'dognet_docbase.kodtip')
        ->leftJoin('dognet_spdened', 'dognet_spdened.koddened', '=', 'dognet_docbase.koddened')
        ->where('dognet_dockalplan.koddel', '99', '!=')
        ->where('dognet_docavans.dateavans', $start_date, '>=')
        ->where('dognet_docavans.dateavans', $end_date, '<=')
        ->where('dognet_docavans.koddel', '99', '!=')
        ->process($_POST)
        ->json();
}
