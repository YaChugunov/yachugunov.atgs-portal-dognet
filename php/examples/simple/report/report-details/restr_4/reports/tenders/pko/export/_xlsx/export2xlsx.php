<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('Europe/Moscow');
setlocale(LC_ALL, 'rus');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Включаем режим сессии
// session_start();
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
// require($_SERVER['DOCUMENT_ROOT']."/_assets/functions/funcSecure.inc.php");
# Подключаем собственные функции сервиса Почта
// require($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/functions/funcDognet.inc.php");
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/_assets/_PHPOffice/vendor/autoload.php");
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
// СОЗДАЕМ И НАСТРАИВАЕМ ОБЪЕКТ PHPExcel
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
// Создаем новый объект PHPExcel
$objPHPExcel = new PHPExcel;
#
// Устанавливаем свойства документа
$properties = $objPHPExcel->getProperties();
#
$properties->setCreator("АТГС.Портал");
$properties->setCompany('АТГС');
$properties->setTitle('Перечень договоров');
$properties->setDescription('Перечень договоров');
$properties->setCategory('Отчеты');
$properties->setLastModifiedBy('АТГС.Портал');
$properties->setCreated(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setModified(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setSubject('Перечень договоров');
$properties->setKeywords('Портал, Договор, Отчеты');
#
#
$A1 = (!empty($_GET['zdl_1']) && isset($_GET['zdl_1']) && $_GET['zdl_1'] == 'yes');
$A2 = (!empty($_GET['zdl_2']) && isset($_GET['zdl_2']) && $_GET['zdl_2'] == 'yes');
$A3 = (!empty($_GET['zdl_3']) && isset($_GET['zdl_3']) && $_GET['zdl_3'] == 'yes');
//
//
$B1 = (!empty($_GET['doc']) && isset($_GET['doc']) && $_GET['doc'] == 'yes');
$B2 = (!empty($_GET['cht']) && isset($_GET['cht']) && $_GET['cht'] == 'yes');
#
#
include($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/report/report-details/restr_4/reports/tenders/pko/export/_xlsx/export2xlsx_pko.php");
if ($A1) {
	//	include ($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/export/_xlsx/export2xlsx_kodstatuszdl_1.php");
}
if ($A2) {
	//	include ($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/export/_xlsx/export2xlsx_kodstatuszdl_2.php");
}
if ($A3) {
	// 	include ($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/export/_xlsx/export2xlsx_kodstatuszdl_3.php");
	//	include ($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/report/report-details/restr_4/reports/spravka/zadolchf/export/_xlsx/export2xlsx_docprogress.php");
}



#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
/*
	СОЗДАЕМ И СВОЙ ФОРМАТ ДЛЯ ЯЧЕЕК : ХХХ.ХХ р.
	Данный формат позволяет вести дальнейшие расчеты в Excel с ячейками как с денежными единицами

	Пример задания стиля ячейки пользовательским форматом
	$sheet->setCellValue("C" . $cnt, floatval($item["price"]));
	$sheet->getStyle("C" . $cnt)->getNumberFormat()->setFormatCode(PRICE_FORMAT);
*/
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем свой формат
define("PRICE_FORMAT", PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 . "[\$ р.-419]");
#
#
#
#
#
// Устанавливаем индекс активного листа
// 		$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->setActiveSheetIndexByName('Worksheet');
$sheetIndex = $objPHPExcel->getActiveSheetIndex();
$objPHPExcel->removeSheetByIndex($sheetIndex);
//
//
//
//
//
//
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
//
//
//
//
// ФАЙЛ ГОТОВ
//
// Отдаем его браузеру на скачивание
//
//
//
//
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

$xmlWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $xmlWriter->save('php://output');
$filepath = $_SERVER['DOCUMENT_ROOT'] . "/dognet/tmp/";
$filename = "LIST-ALLDOCS_" . $_SESSION['id'] . "_" . date('YmdHis') . ".XLSX";
$xmlWriter->save($filepath . $filename);
?>

<style>
.circles {
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: sans-serif;
    color: #111;
}

.circle {
    background: #FAFAFA;
    padding: 15px;
    margin: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 2px #111 solid;
    border-radius: 50%;
    width: 10px;
    height: 10px;
    max-width: 10px;
    max-height: 10px;
}

.circle_number {
    font-size: 2rem;
}

.return-link,
.format-selected {
    font-family: 'Oswald', sans-serif;
    font-size: 1.0em;
    font-weight: 300;
    text-transform: uppercase
}

.return-link {
    color: #999
}

a.return-link,
a.format-selected {
    text-decoration: underline
}

a.return-link:hover,
a.format-selected:hover {
    text-decoration: none
}
</style>

<div id="link">
    <div class="">
        <a class="format-selected"
            href="http://<?php echo $_SERVER['HTTP_HOST'] . '/dognet/tmp/' . $filename; ?>"><?php echo $filename; ?></a>
    </div>
    <div class="circles">
        <div class="circle">
            <div class="circle_number"><span id="time"></span></div>
        </div>
    </div>
</div>

<script type="text/javascript">
var timer;

function countDown() {
    //время в сек.
    i = 60;
    document.getElementById("time").innerHTML = i;
    timer = setInterval(function() {
        document.getElementById("time").innerHTML = i--;

        host = '<?php echo $_SERVER["HTTP_HOST"]; ?>';
        url1 = 'http://' + host + '/dognet/dognet-report.php';
        url2 = 'http://' + host + '/dognet/dognet-report.php?reportview=pko&export=yes';
        if (i < 0) {
            clearInterval(timer);
            document.getElementById("link").innerHTML =
                "<div class='space20'><span style='padding:0 15px'><a class='return-link' href=" + url1 +
                ">Вернуться в Отчеты</a></span></div><div class='space20'><span style='padding:0 15px'><a class='return-link' href=" +
                url2 + ">Новый экспорт</a></span></div>";
        }
    }, 1000);
}
countDown();
</script>