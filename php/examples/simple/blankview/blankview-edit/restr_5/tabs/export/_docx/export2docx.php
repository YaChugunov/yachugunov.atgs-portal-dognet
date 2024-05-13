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
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
function numberFormat($digit, $width) {
	while (strlen($digit) < $width)
		$digit = '0' . $digit;
	return $digit;
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$phpWord = new  \PhpOffice\PhpWord\PhpWord();

$phpWord->setDefaultFontName('Arial');
$phpWord->setDefaultFontSize(10);

$properties = $phpWord->getDocInfo();

$properties->setCreator("АТГС.Портал");
$properties->setCompany('АТГС');
$properties->setTitle('Бланк требований к заявке на договор');
$properties->setDescription('Бланк требований к заявке на договор');
$properties->setCategory('Бланки');
$properties->setLastModifiedBy('АТГС.Портал');
$properties->setCreated(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setModified(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setSubject('Бланк требований к заявке на договор');
$properties->setKeywords('Портал, Договор, Бланки');
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
$sectionStyle = array(
	'orientation' => 'portrait',
	'marginTop' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(40),
	'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(40),
	'marginLeft' => 800,
	'marginRight' => 400,
	'colsNum' => 1,
	'pageNumberingStart' => 1
);
$sectionStyle_col2 = array(
	'orientation' => 'landscape',
	'marginTop' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(90),
	'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(100),
	'marginLeft' => 600,
	'marginRight' => 600,
	'colsNum' => 2,
	'breakType' => 'continuous'
);
$section = $phpWord->addSection($sectionStyle);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ПОДКЛЮЧАЕМ СТИЛИ ОФОРМЛЕНИЯ
#
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/blankview/blankview-edit/restr_5/tabs/export/_docx/export2docx_styles.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ::::: ВЕРХНИЙ КОЛОНТИТУЛ (HEADER)
#
$headerStyle = array(
	'marginTop' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(50),
	'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(100)
);
$header = $section->addHeader();
// Вставляем таблицу в верхний колонтитул (header)
$table = $header->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(5000);
$textrun = $cell->addTextRun();
// Оформляем содержимое таблицы в header
$textrun->addText('Ф ИСМ-34', $_FONT_P10_CAPS);
//
$cell = $table->addCell(10000);
//
$cell = $table->addCell(5000);
$textrun = $cell->addTextRun(array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));
$textrun->addText('', array('name' => "Arial", 'size' => 12));
#
# ::::: НИЖНИЙ КОЛОНТИТУЛ (FOOTER)
#
$footer = $section->addFooter();
// Вставляем таблицу в верхний колонтитул (header)
$table = $footer->addTable(array('width' => 100 * 50, 'unit' => "pct", 'cellMarginTop' => 100));
$table->addRow();
$cell = $table->addCell();
$textrun = $cell->addTextRun();
// Оформляем содержимое таблицы в header
$textrun->addText("", array('name' => "Arial", 'size' => 8, 'color' => '333333', 'allCaps' => true));
//
// Вставляем лого в среднюю ячейку
$cell = $table->addCell();
// $cell->addImage('logo_dognet.png', array('height' => 25, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
//
//
$table->addCell()->addPreserveText('Стр. {PAGE} из {NUMPAGES}', $_FONT_P8, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$phpWord->addTitleStyle(1, array('name' => "Arial", 'size' => 14, 'bold' => true), array('spaceAfter' => 840, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$phpWord->addTitleStyle(2, array('name' => "Arial", 'size' => 12, 'bold' => true), array('spaceAfter' => 180, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$phpWord->addTitleStyle(3, array('name' => "Arial", 'size' => 11, 'bold' => true), array('spaceAfter' => 180, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$_PARAGRAF_B = 'pStyleB';
$phpWord->addParagraphStyle($_PARAGRAF_B, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 120, 'spaceBefore' => 420, 'spaceAfter' => 420));
$_PARAGRAF_1L = 'pStyle1L';
$phpWord->addParagraphStyle($_PARAGRAF_1L, array('widowControl' => false, 'indentation' => array('firstLine' => 600, 'left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spacing' => 120, 'spaceBefore' => 240, 'spaceAfter' => 360));
$_PARAGRAF_1B = 'pStyle1B';
$phpWord->addParagraphStyle($_PARAGRAF_1B, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 120, 'spaceBefore' => 240, 'spaceAfter' => 360));
$_PARAGRAF_2L = 'pStyle2L';
$phpWord->addParagraphStyle($_PARAGRAF_2L, array('widowControl' => false, 'indentation' => array('firstLine' => 600, 'left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spacing' => 120, 'spaceBefore' => 240, 'spaceAfter' => 360));
$_PARAGRAF_2B = 'pStyle2B';
$phpWord->addParagraphStyle($_PARAGRAF_2B, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 120, 'spaceBefore' => 240, 'spaceAfter' => 360));
$_PARAGRAF_3L = 'pStyle3L';
$phpWord->addParagraphStyle($_PARAGRAF_3L, array('widowControl' => false, 'indentation' => array('firstLine' => 600, 'left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spacing' => 60, 'spaceBefore' => 150, 'spaceAfter' => 150));
$_PARAGRAF_3B = 'pStyle3B';
$phpWord->addParagraphStyle($_PARAGRAF_3B, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 60, 'spaceBefore' => 150, 'spaceAfter' => 150));
$_PARAGRAF_3R = 'pStyle3R';
$phpWord->addParagraphStyle($_PARAGRAF_3R, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT, 'spacing' => 60, 'spaceBefore' => 150, 'spaceAfter' => 150));
$_PARAGRAF_0 = 'pStyle0';
$phpWord->addParagraphStyle($_PARAGRAF_0, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 0, 'spaceBefore' => 0, 'spaceAfter' => 0));
#
#
function printLineSeparator($section) {
	$section->addTextBreak();
	$lineStyle = array('weight' => 0.2, 'width' => 150, 'height' => 0, 'align' => 'center');
	$section->addLine($lineStyle);
	$section->addTextBreak(2);
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
function printParagraphSeparator($phpWord, $section, $pStyle) {
	$_PARAGRAF_B = 'pStyleB';
	$phpWord->addParagraphStyle($_PARAGRAF_B, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 120, 'spaceBefore' => 420, 'spaceAfter' => 420));
	$_PARAGRAF_1L = 'pStyle1L';
	$phpWord->addParagraphStyle($_PARAGRAF_1L, array('widowControl' => false, 'indentation' => array('firstLine' => 360, 'left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spacing' => 120, 'spaceBefore' => 240, 'spaceAfter' => 360));
	$_PARAGRAF_1B = 'pStyle1B';
	$phpWord->addParagraphStyle($_PARAGRAF_1B, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 120, 'spaceBefore' => 240, 'spaceAfter' => 360));
	$_PARAGRAF_2L = 'pStyle2L';
	$phpWord->addParagraphStyle($_PARAGRAF_2L, array('widowControl' => false, 'indentation' => array('firstLine' => 360, 'left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spacing' => 120, 'spaceBefore' => 240, 'spaceAfter' => 360));
	$_PARAGRAF_2B = 'pStyle2B';
	$phpWord->addParagraphStyle($_PARAGRAF_2B, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 120, 'spaceBefore' => 240, 'spaceAfter' => 360));
	$_PARAGRAF_3L = 'pStyle3L';
	$phpWord->addParagraphStyle($_PARAGRAF_3L, array('widowControl' => false, 'indentation' => array('firstLine' => 360, 'left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spacing' => 60, 'spaceBefore' => 150, 'spaceAfter' => 150));
	$_PARAGRAF_3B = 'pStyle3B';
	$phpWord->addParagraphStyle($_PARAGRAF_3B, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 60, 'spaceBefore' => 150, 'spaceAfter' => 150));
	$_PARAGRAF_3R = 'pStyle3R';
	$phpWord->addParagraphStyle($_PARAGRAF_3R, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT, 'spacing' => 60, 'spaceBefore' => 150, 'spaceAfter' => 150));
	$_PARAGRAF_0 = 'pStyle0';
	$phpWord->addParagraphStyle($_PARAGRAF_0, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 0, 'spaceBefore' => 0, 'spaceAfter' => 0));
	//
	if ($pStyle == 1) {
		$textrun = $section->addTextRun($_PARAGRAF_1B);
	}
	if ($pStyle == 2) {
		$textrun = $section->addTextRun($_PARAGRAF_2B);
	}
	if ($pStyle == 3) {
		$textrun = $section->addTextRun($_PARAGRAF_3B);
	}
	if ($pStyle == 4) {
		$textrun = $section->addTextRun($_PARAGRAF_B);
	}
	if ($pStyle == 0) {
		$textrun = $section->addTextRun($_PARAGRAF_0);
	}
}
#
#
$cmnTable_0 = 'Common Table';
$phpWord->addTableStyle($cmnTable_0, $_TBL_Common_Fixed);
$innTable_0 = 'Inner Table (no borders)';
$phpWord->addTableStyle($innTable_0, $_InnerTBL_Common_0, $_InnerTBL_Header);
$innTable_0L = 'Inner Table (no borders)';
$phpWord->addTableStyle($innTable_0L, $_InnerTBL_Common_0L, $_InnerTBL_Header);
$innTable_1 = 'Inner Table (with borders)';
$phpWord->addTableStyle($innTable_1, $_InnerTBL_Common_1, $_InnerTBL_Header);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$_QRY_DOCBLANK = mysqlQuery("SELECT * FROM dognet_docblankwork WHERE kodblankwork = '" . $_GET['blankID'] . "' AND kodstatusblank='DO'");
$_ROW_DOCBLANK = mysqli_fetch_assoc($_QRY_DOCBLANK);
$_BlankRowID = $_ROW_DOCBLANK['blank_rowID'];
//
$_QRY_ZAKAZ = mysqlQuery("SELECT nameshort FROM sp_contragents WHERE kodzakaz = '" . $_ROW_DOCBLANK['kodzakaz'] . "'");
$_ROW_ZAKAZ = mysqli_fetch_assoc($_QRY_ZAKAZ);
$_ZAKNAME = $_ROW_ZAKAZ['nameshort'];
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::::
# SECTION_1
# НАЗВАНИЕ БЛАНКА И ШТАМП
# :::::
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$table_S1 = $section->addTable($_TBL_Common_Fixed);
$table_S1->addRow(950, $_TBL_Body_Row);
# ----- ----- -----
# Название и номер бланка
#
$_NumberBlank = $_ROW_DOCBLANK['yearblankwork'] . "-" . numberFormat($_ROW_DOCBLANK['numberblankwork'], 3);
$cell_S1 = $table_S1->addCell(11000, $_TBL_Body_Cell_Clear);
switch ($_GET['blankType']) {
	case "POS":
		$cell_S1->addTextRun($_TXTRUN_Align_Left)->addText("Бланк требований на поставку № " . $_NumberBlank, $_FONT_H13_UB);
		$_QRY_BLANKWORK = mysqlQuery("SELECT * FROM dognet_blankdocpost WHERE id = '" . $_BlankRowID . "' AND kodblankwork='" . $_GET['blankID'] . "' AND kodtipblank='DO'");
		$_ROW_BLANKWORK = mysqli_fetch_assoc($_QRY_BLANKWORK);
		break;
	case "PNR":
		$cell_S1->addTextRun($_TXTRUN_Align_Left)->addText("Бланк требований на ПНР № " . $_NumberBlank, $_FONT_H13_UB);
		$_QRY_BLANKWORK = mysqlQuery("SELECT * FROM dognet_blankdocpnr WHERE id = '" . $_BlankRowID . "' AND kodblankwork='" . $_GET['blankID'] . "' AND kodtipblank='DO'");
		$_ROW_BLANKWORK = mysqli_fetch_assoc($_QRY_BLANKWORK);
		break;
	case "SUB":
		$cell_S1->addTextRun($_TXTRUN_Align_Left)->addText("Бланк требований на субподряд № " . $_NumberBlank, $_FONT_H13_UB);
		$_QRY_BLANKWORK = mysqlQuery("SELECT * FROM dognet_blankdocsub WHERE id = '" . $_BlankRowID . "' AND kodblankwork='" . $_GET['blankID'] . "' AND kodtipblank='DO'");
		$_ROW_BLANKWORK = mysqli_fetch_assoc($_QRY_BLANKWORK);
		break;
	default:
		$cell_S1->addTextRun($_TXTRUN_Align_Left)->addText("Бланк требований № " . $_NumberBlank, $_FONT_H13_UB);
		$_QRY_BLANKWORK = mysqlQuery("SELECT * FROM dognet_blankdocpost WHERE id = '" . $_BlankRowID . "' AND kodblankwork='" . $_GET['blankID'] . "' AND kodtipblank='DO'");
		$_ROW_BLANKWORK = mysqli_fetch_assoc($_QRY_BLANKWORK);
}
# ----- ----- -----
# Штамп ИСО
#
$cell_S1 = $table_S1->addCell(9000, $_TBL_Body_Cell_Clear);
$innTable_S1 = $cell_S1->addTable($_InnerTBL_Common_1);
#
$innTable_S1->addRow(350, $_TBL_Header_Row);
$innTable_S1->addCell(6000, $_TBL_Header_Cell_Left)->addText('Дата', $_FONT_H10_BI, $_TXTRUN_Align_Center);
$innTable_S1->addCell(11000, $_TBL_Header_Cell)->addText('Код ДПК', $_FONT_H10_BI, $_TXTRUN_Align_Center);
$innTable_S1->addCell(1500, $_TBL_Header_Cell)->addText('СП', $_FONT_H10_BI, $_TXTRUN_Align_Center);
$innTable_S1->addCell(1500, $_TBL_Header_Cell_Right)->addText('', $_FONT_H10_BI, $_TXTRUN_Align_Center);
#
$innTable_S1->addRow(350, $_TBL_Header_Row);
$innTable_S1->addCell(6000, $_TBL_Body_Cell_Left)->addText(date("d.m.Y", strtotime($_ROW_DOCBLANK['dateblankwork'])), $_FONT_P10, $_TXTRUN_Align_Center);
$innTable_S1->addCell(11000, $_TBL_Body_Cell)->addText('---', $_FONT_P10, $_TXTRUN_Align_Center);
$innTable_S1->addCell(1500, $_TBL_Body_Cell)->addText('---', $_FONT_P10, $_TXTRUN_Align_Center);
$innTable_S1->addCell(1500, $_TBL_Body_Cell_Right)->addText('Д', $_FONT_P10_CAPS_B, $_TXTRUN_Align_Center);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_2
# 1. Ответственный руководитель
# 2. ГИП по договору
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$table = $section->addTable($_TBL_Common_Fixed);
# ----- ----- -----
# Ответственный руководитель
#
$table->addRow(450, $_TBL_Body_Row);
$_QRY_IspolRuk = mysqlQuery("SELECT * FROM dognet_spispolruk WHERE kodispolruk = '" . $_ROW_DOCBLANK['kodispolruk'] . "'");
$_ROW_IspolRuk = mysqli_fetch_assoc($_QRY_IspolRuk);

$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("I", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(7500, $_TBL_Body_Cell_Clear);
$cell->addText("Ответственный руководитель", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(11000, $_TBL_Body_Cell_B);
$cell->addText($_ROW_IspolRuk['ispolruknamefull'], $_FONT_P11_B, $_TXT_INCELL_1L);
# ----- ----- -----
# ГИП по договору
#
$table->addRow(450, $_TBL_Body_Row);
$_QRY_Ispol = mysqlQuery("SELECT * FROM dognet_spispol WHERE kodispol = '" . $_ROW_DOCBLANK['kodispol'] . "'");
$_ROW_Ispol = mysqli_fetch_assoc($_QRY_Ispol);

$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("II", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(7500, $_TBL_Body_Cell_Clear);
$cell->addText("ГИП по договору", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(11000, $_TBL_Body_Cell_B);
$cell->addText($_ROW_Ispol['ispolnamefull'], $_FONT_P11_B, $_TXT_INCELL_1L);
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_3
# 3. Наименование организации
# 3.1 Заказчик (Покупатель)
# 3.2 Исполнитель (Поставщик)
# 3.3 Объект ГИПа
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 3. Наименование организации
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("III", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Наименование организации", $_FONT_P11_B, $_TXT_INCELL_1L);
# ----- ----- -----
# 3.1 Заказчик (покупатель)
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(7500, $_TBL_Body_Cell_Clear);
$cell->addText("Заказчик (Покупатель)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(11000, $_TBL_Body_Cell_B);
$cell->addText($_ROW_DOCBLANK['kodzakaz'], $_FONT_P10_B, $_TXT_INCELL_1L);
# ----- ----- -----
# 3.2 Исполнитель (поставщик)
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("2)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(7500, $_TBL_Body_Cell_Clear);
$cell->addText("Исполнитель (Поставщик)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(11000, $_TBL_Body_Cell_B);
$cell->addText('АО "АтлантикТрансгазСистема"', $_FONT_P10_B, $_TXT_INCELL_1L);
# ----- ----- -----
# 3.3 Объект (ГИПа) / Только для ПНР !!
#
if ($_GET['blankType'] == "PNR") {
	$_QRY_Object = mysqlQuery("SELECT * FROM sp_objects WHERE kodobject = '" . $_ROW_BLANKWORK['kodobject'] . "'");
	$_ROW_Object = mysqli_fetch_assoc($_QRY_Object);
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("3)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(7500, $_TBL_Body_Cell_Clear);
	$cell->addText("Объект (ГИПа)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(11000, $_TBL_Body_Cell_B);
	$cell->addText($_ROW_Object['nameobjectshot'], $_FONT_P10_B, $_TXT_INCELL_1L);
}
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_4
# 4. Предмет договора
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 4. Предмет договора
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("IV", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Предмет договора", $_FONT_P11_B, $_TXT_INCELL_1L);
# ----- ----- -----
# Название договора
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell = $table->addCell(18500, $_TBL_Body_Cell_B);
$cell->addText($_ROW_DOCBLANK['nameblankwork'], $_FONT_P10_B, $_TXT_INCELL_1L);
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_5
# 5. Сумма договора
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 5. Сумма договора
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear)->addText("V", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(7500, $_TBL_Body_Cell_Clear)->addText("Сумма договора", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(6000, $_TBL_Body_Cell_B)->addText($_ROW_BLANKWORK['csummadocopl'], $_FONT_P11_B, $_TXT_INCELL_1C);
$cell = $table->addCell(5000, $_TBL_Body_Cell_Clear)->addText("руб.", $_FONT_P11, $_TXT_INCELL_1L);
#
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell = $table->addCell(7500, $_TBL_Body_Cell_Clear);
$cell = $table->addCell(5500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['kodusendsopl'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" с учетом НДС", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" с учетом НДС", $_FONT_P10, $_TXT_INCELL_1L);
}
$cell = $table->addCell(5500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['kodusespechopl'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" по спецификации", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" по спецификации", $_FONT_P10, $_TXT_INCELL_1L);
}
#
# Разбиение суммы договора
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);

$_QRY_SUMMADOP = mysqlQuery("SELECT * FROM dognet_blanksummadop WHERE kodblankwork = '" . $_GET['blankID'] . "' AND kodtipblank = 'RD'");
if (mysqli_num_rows($_QRY_SUMMADOP) >= 1) {
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear)->addText("В том числе", $_FONT_P10, $_TXT_INCELL_1L);
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	$table = $section->addTable($_TBL_Common_Fixed);
	while ($_ROW_SUMMADOP = mysqli_fetch_assoc($_QRY_SUMMADOP)) {
		$table->addRow(350, $_TBL_Body_Row);
		$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
		$cell = $table->addCell(4000, $_TBL_Body_Cell_B)->addText($_ROW_SUMMADOP['summadopblank'], $_FONT_P10_B, $_TXT_INCELL_1C);
		$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear)->addText("руб.", $_FONT_P10, $_TXT_INCELL_1L);
		$cell = $table->addCell(13000, $_TBL_Body_Cell_B)->addText($_ROW_SUMMADOP['namesummadop'], $_FONT_P10, $_TXT_INCELL_1L);
	}
} else {
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear)->addText("Без разбиения по этапам", $_FONT_P10, $_TXT_INCELL_1L);
}
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_6
# 6. Порядок оплаты
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 6. Порядок оплаты
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("VI", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Порядок оплаты", $_FONT_P11_B, $_TXT_INCELL_1L);
#
$table = $section->addTable($_TBL_Common_Fixed);
# ----- ----- -----
# 6.1 Аванс
#
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
$cell->addText("Аванс", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(1000, $_TBL_Body_Cell_B);
$cell->addText(($_ROW_BLANKWORK['csummaopl1usl'] != "0") ? $_ROW_BLANKWORK['csummaopl1usl'] : "", $_FONT_P10_B, $_TXT_INCELL_1C);
$cell = $table->addCell(1000, $_TBL_Body_Cell_Clear);
$cell->addText("%", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(13000, $_TBL_Body_Cell_Clear);
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
# ----- ----- -----
# 6.2 Окончательная оплата
#
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("2)", $_FONT_P11, $_TXT_INCELL_1L);
$cell = $table->addCell(7000, $_TBL_Body_Cell_Clear);
$cell->addText("Окончательная оплата в размере", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(1000, $_TBL_Body_Cell_B);
$cell->addText(($_ROW_BLANKWORK['csummaopl2usl'] != "0") ? $_ROW_BLANKWORK['csummaopl2usl'] : "", $_FONT_P10_B, $_TXT_INCELL_1C);
$cell = $table->addCell(1000, $_TBL_Body_Cell_Clear);
$cell->addText("%", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(2500, $_TBL_Body_Cell_Clear);
$cell->addText("в течение", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(1000, $_TBL_Body_Cell_B);
$cell->addText(($_ROW_BLANKWORK['cnumberoplday2usl'] != "0") ? $_ROW_BLANKWORK['cnumberoplday2usl'] : "", $_FONT_P10_B, $_TXT_INCELL_1C);
$cell = $table->addCell(6000, $_TBL_Body_Cell_Clear);
$cell->addText("дней после подписания акта", $_FONT_P10, $_TXT_INCELL_1L);
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
# ----- ----- -----
# 6.3 В течение...
#
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("3)", $_FONT_P11, $_TXT_INCELL_1L);
$cell = $table->addCell(2500, $_TBL_Body_Cell_Clear);
$cell->addText("В течение", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(1000, $_TBL_Body_Cell_B);
$cell->addText(($_ROW_BLANKWORK['cnumberoplday3usl'] != "0") ? $_ROW_BLANKWORK['cnumberoplday3usl'] : "", $_FONT_P10_B, $_TXT_INCELL_1C);
$cell = $table->addCell(15000, $_TBL_Body_Cell_Clear);
$cell->addText("дней после получения соответствующего финансирования от конечного Заказчика", $_FONT_P10, $_TXT_INCELL_1L);
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
# ----- ----- -----
# 6.4 В течение...
#
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("4)", $_FONT_P11, $_TXT_INCELL_1L);
$cell = $table->addCell(2500, $_TBL_Body_Cell_Clear);
$cell->addText("Иная", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(16000, $_TBL_Body_Cell_B);
$cell->addText(($_ROW_BLANKWORK['ctextoplotherusl'] != "") ? $_ROW_BLANKWORK['ctextoplotherusl'] : "", $_FONT_P10_B, $_TXT_INCELL_1L);
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_7
# 7. Перечень приложений к договору (отметить нужное)
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 7. Перечень приложений к договору
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("VII", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Перечень приложений к договору", $_FONT_P11_B, $_TXT_INCELL_1L);
#
$table = $section->addTable($_TBL_Common_Fixed);
#
$table->addRow(350, $_TBL_Body_Row);
# ----- ----- -----
# 7.1 Технические требования
#
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(8500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['kodusepril1'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" технические требования", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" технические требования", $_FONT_P10, $_TXT_INCELL_1L);
}
# ----- ----- -----
# 7.4 Протокол соглашения о договорной цене
#
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("4)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(8500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['kodusepril4'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" протокол соглашения о договорной цене", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" протокол соглашения о договорной цене", $_FONT_P10, $_TXT_INCELL_1L);
}
#
$table->addRow(350, $_TBL_Body_Row);
# ----- ----- -----
# 7.2 Календарный план
#
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("2)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(8500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['kodusepril2'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" календарный план", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" календарный план", $_FONT_P10, $_TXT_INCELL_1L);
}
# ----- ----- -----
# 7.5 Календарный план
#
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("5)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(8500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['kodusepril5'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" сметный расчет", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" сметный расчет", $_FONT_P10, $_TXT_INCELL_1L);
}
#
$table->addRow(350, $_TBL_Body_Row);
# ----- ----- -----
# 7.3 Спецификация
#
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("3)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(8500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['kodusepril3'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" спецификация", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" спецификация", $_FONT_P10, $_TXT_INCELL_1L);
}
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell = $table->addCell(8500, $_TBL_Body_Cell_Clear);
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_8
# 8. Особые условия (определяются ГИПом)
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 8. Особые условия (заголовок)
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("VIII", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Особые условия (определяются ГИПом)", $_FONT_P11_B, $_TXT_INCELL_1L);
# ----- ----- -----
# Особые условия (текст)
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell = $table->addCell(18500, $_TBL_Body_Cell_B);
$cell->addText($_ROW_BLANKWORK['defuslgiptext'], $_FONT_P10_B, $_TXT_INCELL_1L);
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_9
# 9. Сроки исполнения договорных обязательств
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 9. Сроки исполнения договорных обязательств (заголовок)
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("IX", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Особые условия (определяются ГИПом)", $_FONT_P11_B, $_TXT_INCELL_1L);
# ----- ----- -----
# 9.1 Дата
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['koduseispoldoc1'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" дата", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" дата", $_FONT_P10, $_TXT_INCELL_1L);
}
$cell = $table->addCell(5000, $_TBL_Body_Cell_B);
$cell->addText(($_ROW_BLANKWORK['koduseispoldoc1'] != "0") ? $_ROW_BLANKWORK['cdateispoldoc1'] : "", $_FONT_P10_B, $_TXT_INCELL_1L);
$cell = $table->addCell(10000, $_TBL_Body_Cell_Clear);
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
# ----- ----- -----
# 9.2 ... дней от аванса
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("2)", $_FONT_P11, $_TXT_INCELL_1L);
$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['koduseispoldoc2'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" дней от аванса", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" дней от аванса", $_FONT_P10, $_TXT_INCELL_1L);
}
$cell = $table->addCell(1000, $_TBL_Body_Cell_B);
$cell->addText(($_ROW_BLANKWORK['cdaysispoldoc2'] != "0") ? $_ROW_BLANKWORK['cdaysispoldoc2'] : "", $_FONT_P10_B, $_TXT_INCELL_1C);
$cell = $table->addCell(14000, $_TBL_Body_Cell_Clear);
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
# ----- ----- -----
# 9.3 Автоматическая пролонгация
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("3)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['koduseispoldoc3'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" автоматическая пролонгация", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" автоматическая пролонгация", $_FONT_P10, $_TXT_INCELL_1L);
}
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
# ----- ----- -----
# 9.4 *Конец года
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("4)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['koduseispoldoc4'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" *конец года", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" *конец года", $_FONT_P10, $_TXT_INCELL_1L);
}
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_10
# 10. Контактное лицо партнера
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 10. Сроки исполнения договорных обязательств (заголовок)
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("X", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Контактное лицо партнера", $_FONT_P11_B, $_TXT_INCELL_1L);
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
#
$table = $section->addTable($_TBL_Common_Fixed);
#
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
$cell->addText("Фамилия", $_FONT_P10_B, $_TXT_INCELL_1L);
$cell = $table->addCell(7000, $_TBL_Body_Cell_B);
$textrun = $cell->addTextRun();
$textrun->addText($_ROW_BLANKWORK['nameendcontact'], $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(500, $_TBL_Body_Cell_Clear);
$cell = $table->addCell(3000, $_TBL_Body_Cell_Clear);
$cell->addText("Телефон раб.", $_FONT_P10_B, $_TXT_INCELL_1L);
$cell = $table->addCell(6000, $_TBL_Body_Cell_B);
$textrun = $cell->addTextRun();
$textrun->addText($_ROW_BLANKWORK['numbertelrab'], $_FONT_P10, $_TXT_INCELL_1L);
#
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
$cell->addText("Имя", $_FONT_P10_B, $_TXT_INCELL_1L);
$cell = $table->addCell(7000, $_TBL_Body_Cell_B);
$textrun = $cell->addTextRun();
$textrun->addText($_ROW_BLANKWORK['namefistcontact'], $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(500, $_TBL_Body_Cell_Clear);
$cell = $table->addCell(3000, $_TBL_Body_Cell_Clear);
$cell->addText("Телефон моб.", $_FONT_P10_B, $_TXT_INCELL_1L);
$cell = $table->addCell(6000, $_TBL_Body_Cell_B);
$textrun = $cell->addTextRun();
$textrun->addText($_ROW_BLANKWORK['numbertelmob'], $_FONT_P10, $_TXT_INCELL_1L);
#
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
$cell->addText("Отчество", $_FONT_P10_B, $_TXT_INCELL_1L);
$cell = $table->addCell(7000, $_TBL_Body_Cell_B);
$textrun = $cell->addTextRun();
$textrun->addText($_ROW_BLANKWORK['namesecondcontact'], $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(500, $_TBL_Body_Cell_Clear);
$cell = $table->addCell(3000, $_TBL_Body_Cell_Clear);
$cell->addText("Телефон моб.", $_FONT_P10_B, $_TXT_INCELL_1L);
$cell = $table->addCell(6000, $_TBL_Body_Cell_B);
$textrun = $cell->addTextRun();
$textrun->addText($_ROW_BLANKWORK['numbertelfax'], $_FONT_P10, $_TXT_INCELL_1L);
#
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
$cell->addText("Должность", $_FONT_P10_B, $_TXT_INCELL_1L);
$cell = $table->addCell(7000, $_TBL_Body_Cell_B);
$textrun = $cell->addTextRun();
$textrun->addText($_ROW_BLANKWORK['namedoljcontact'], $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(500, $_TBL_Body_Cell_Clear);
$cell = $table->addCell(3000, $_TBL_Body_Cell_Clear);
$cell->addText("Email", $_FONT_P10_B, $_TXT_INCELL_1L);
$cell = $table->addCell(6000, $_TBL_Body_Cell_B);
$textrun = $cell->addTextRun();
$textrun->addText($_ROW_BLANKWORK['nameemail'], $_FONT_P10, $_TXT_INCELL_1L);
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_11
# 11. Командировочные расходы
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 11. Командировочные расходы (заголовок)
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("XI", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Командировочные расходы (отметить нужное)", $_FONT_P11_B, $_TXT_INCELL_1L);
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
#
##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
# ДЛЯ БЛАНКА НА ПНР ($_GET['blankType']=="PNR"
#
if ($_GET['blankType'] == "PNR") {
	#
	# ----- ----- -----
	# 11.1 Входят в стоимость договора
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx1'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" входят в стоимость договора", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" входят в стоимость договора", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 11.2 Оплачиваются отдельно по фактическим затратам
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("2)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx2'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" оплачиваются отдельно по фактическим затратам", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" оплачиваются отдельно по фактическим затратам", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 11.3 Входят в стоимость с установленным лимитом
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("3)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(9500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx3'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" входят в стоимость с установленным лимитом", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" входят в стоимость с установленным лимитом", $_FONT_P10, $_TXT_INCELL_1L);
	}
	$cell = $table->addCell(3000, $_TBL_Body_Cell_B);
	$cell->addText(($_ROW_BLANKWORK['summalimitmis'] != 0.0) ? $_ROW_BLANKWORK['summalimitmis'] : "", $_FONT_P10_B, $_TXT_INCELL_1C);
	$cell = $table->addCell(6000, $_TBL_Body_Cell_Clear);
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 11.4 Примечание
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("4)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx4'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" примечание", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" примечание", $_FONT_P10, $_TXT_INCELL_1L);
	}
	$cell = $table->addCell(15000, $_TBL_Body_Cell_B);
	$cell->addText(($_ROW_BLANKWORK['komrasxprim'] != "") ? $_ROW_BLANKWORK['komrasxprim'] : "", $_FONT_P10_B, $_TXT_INCELL_1L);
	#
}
#
##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
# ДЛЯ БЛАНКА НА ПОСТАВКУ ($_GET['blankType']=="POS"
#
elseif ($_GET['blankType'] == "POS") {
	#
	# ----- ----- -----
	# 11.1 Наличие командировок
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx1'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" наличие командировок", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" наличие командировок", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 11.2 Входят в стоимость договора
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("2)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx2'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" входят в стоимость договора", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" входят в стоимость договора", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 11.3 Оплачиваются отдельно по фактическим затратам
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("3)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx3'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" оплачиваются отдельно по фактическим затратам", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" оплачиваются отдельно по фактическим затратам", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 11.4 Примечание
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("4)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
	$cell->addText("Примечание", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(15000, $_TBL_Body_Cell_B);
	$cell->addText(($_ROW_BLANKWORK['komrasxprim'] != "") ? $_ROW_BLANKWORK['komrasxprim'] : "", $_FONT_P10_B, $_TXT_INCELL_1L);
	#
}
#
##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
# ДЛЯ БЛАНКА НА СУБПОДРЯД ($_GET['blankType']=="SUB"
#
elseif ($_GET['blankType'] == "SUB") {
	#
	# ----- ----- -----
	# 11.1 Входят в стоимость договора
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx1'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" входят в стоимость договора", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" входят в стоимость договора", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 11.2 Оплачиваются отдельно по фактическим затратам
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("2)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx2'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" оплачиваются отдельно по фактическим затратам", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" оплачиваются отдельно по фактическим затратам", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 11.3 Входят в стоимость с установленным лимитом
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("3)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(9500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx3'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" входят в стоимость с установленным лимитом", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" входят в стоимость с установленным лимитом", $_FONT_P10, $_TXT_INCELL_1L);
	}
	$cell = $table->addCell(3000, $_TBL_Body_Cell_B);
	$cell->addText(($_ROW_BLANKWORK['summalimitmis'] != 0.0) ? $_ROW_BLANKWORK['summalimitmis'] : "", $_FONT_P10_B, $_TXT_INCELL_1C);
	$cell = $table->addCell(6000, $_TBL_Body_Cell_Clear);
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 11.4 Примечание
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("4)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['kodusekomrasx4'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" примечание", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" примечание", $_FONT_P10, $_TXT_INCELL_1L);
	}
	$cell = $table->addCell(15000, $_TBL_Body_Cell_B);
	$cell->addText(($_ROW_BLANKWORK['komrasxprim'] != "") ? $_ROW_BLANKWORK['komrasxprim'] : "", $_FONT_P10_B, $_TXT_INCELL_1L);
	#
}
#
##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_12
# 12. Транспортные расходы
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 12. Транспортные расходы (заголовок)
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("XII", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Транспортные расходы (отметить нужное)", $_FONT_P11_B, $_TXT_INCELL_1L);
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
#
# ----- ----- -----
# 12.1 Входят в стоимость
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['kodusetrans1'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" входят в стоимость", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" входят в стоимость", $_FONT_P10, $_TXT_INCELL_1L);
}
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
#
# ----- ----- -----
# 12.2 Оплачиваются отдельно по фактическим затратам
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("2)", $_FONT_P11, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['kodusetrans2'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" оплачиваются отдельно по фактическим затратам", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" оплачиваются отдельно по фактическим затратам", $_FONT_P10, $_TXT_INCELL_1L);
}
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
#
# ----- ----- -----
# 12.3 Иное
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(350, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("4)", $_FONT_P10, $_TXT_INCELL_1L);
$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun();
if ($_ROW_BLANKWORK['kodusetrans3'] == "1") {
	$textrun->addFormField('checkbox')->setDefault(true);
	$textrun->addText(" иное", $_FONT_P10, $_TXT_INCELL_1L);
} else {
	$textrun->addFormField('checkbox');
	$textrun->addText(" иное", $_FONT_P10, $_TXT_INCELL_1L);
}
$cell = $table->addCell(15000, $_TBL_Body_Cell_B);
$cell->addText(($_ROW_BLANKWORK['transprim'] != "") ? $_ROW_BLANKWORK['transprim'] : "", $_FONT_P10_B, $_TXT_INCELL_1L);
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_13
# 13. Условия поставки
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# 13. Условия поставки
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("XIII", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Условия поставки (куда поставляется оборудование)", $_FONT_P11_B, $_TXT_INCELL_1L);
# ----- ----- -----
# Условия поставки
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell = $table->addCell(18500, $_TBL_Body_Cell_B);
$cell->addText($_ROW_BLANKWORK['transplaceobor'], $_FONT_P10_B, $_TXT_INCELL_1L);
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_14
# 14. Номер основного договора
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Номер основного договора
#
if ($_GET['blankType'] == "SUB") {

	$_QRY_DOC = mysqlQuery("SELECT docnumber FROM dognet_docbase WHERE koddoc = '" . $_ROW_BLANKWORK['koddoc'] . "'");
	$_ROW_DOC = mysqli_fetch_assoc($_QRY_DOC);

	$_QRY_STAGE = mysqlQuery("SELECT numberstage FROM dognet_dockalplan WHERE kodkalplan = '" . $_ROW_BLANKWORK['kodkalplan'] . "'");
	$_ROW_STAGE = mysqli_fetch_assoc($_QRY_STAGE);

	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(450, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_ClearT);
	$cell->addText("XIV", $_FONT_P11_B, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$cell->addText("Номер основного договора Заказчика и договора Исполнителя", $_FONT_P11_B, $_TXT_INCELL_1L);
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	if ($_ROW_BLANKWORK['kodusedocnumber'] == "1") {
		$table = $section->addTable($_TBL_Common_Fixed);
		$table->addRow(350, $_TBL_Body_Row);
		$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
		$cell = $table->addCell(7500, $_TBL_Body_Cell_Clear);
		$cell->addText("Номер основного договора", $_FONT_P10, $_TXT_INCELL_1L);
		$cell = $table->addCell(7000, $_TBL_Body_Cell_B);
		$doctxt = (!empty($_ROW_DOC['docnumber'])) ? "3-4/" . $_ROW_DOC['docnumber'] : "";
		$cell->addText($doctxt, $_FONT_P11_B, $_TXT_INCELL_1C);
		$cell = $table->addCell(6000, $_TBL_Body_Cell_Clear);
	} elseif ($_ROW_BLANKWORK['kodusedocstage'] == "1") {
		$table = $section->addTable($_TBL_Common_Fixed);
		$table->addRow(350, $_TBL_Body_Row);
		$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
		$cell = $table->addCell(7500, $_TBL_Body_Cell_Clear);
		$cell->addText("Номер основного договора и этапа", $_FONT_P10, $_TXT_INCELL_1L);
		$cell = $table->addCell(5000, $_TBL_Body_Cell_B);
		$doctxt = (!empty($_ROW_DOC['docnumber'])) ? "3-4/" . $_ROW_DOC['docnumber'] : "";
		$docstage = (!empty($_ROW_STAGE['numberstage'])) ? " этап " . $_ROW_STAGE['numberstage'] : "";
		$cell->addText($doctxt . $docstage, $_FONT_P11_B, $_TXT_INCELL_1C);
		$cell = $table->addCell(6000, $_TBL_Body_Cell_Clear);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(450, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell = $table->addCell(8500, $_TBL_Body_Cell_Clear)->addText("Номер и дата договора Исполнителя", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(4500, $_TBL_Body_Cell_B)->addText($_ROW_BLANKWORK['numberdocisp'], $_FONT_P10, $_TXT_INCELL_1C);
	$cell = $table->addCell(1000, $_TBL_Body_Cell_Clear)->addText("от", $_FONT_P10, $_TXT_INCELL_1C);
	$cell = $table->addCell(4500, $_TBL_Body_Cell_B)->addText($_ROW_BLANKWORK['datedocisp'], $_FONT_P10, $_TXT_INCELL_1C);
} else {
	$table->addRow(450, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_ClearT);
	$cell->addText("XIV", $_FONT_P11_B, $_TXT_INCELL_1L);
	$cell = $table->addCell(14500, $_TBL_Body_Cell_Clear);
	$cell->addText("Если АТГС заказчик, необходимо указать к какому номеру основного договора/этапа относится данный договор", $_FONT_P11_B, $_TXT_INCELL_1L);
	$cell = $table->addCell(1000, $_TBL_Body_Cell_ClearB);
	$cell->addText("№", $_FONT_P11_B, $_TXT_INCELL_1R);
	$cell = $table->addCell(3000, $_TBL_Body_Cell_B);
	$cell->addText($_ROW_BLANKWORK['numberdocmain'], $_FONT_P11_B, $_TXT_INCELL_1C);
}
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_15
# 15. Ограничение по сроку оформления
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$table = $section->addTable($_TBL_Common_Fixed);
# ----- ----- -----
# Номер основного договора
#
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("XV", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(8500, $_TBL_Body_Cell_Clear);
$cell->addText("Ограничение по сроку оформления", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(1000, $_TBL_Body_Cell_B);
$cell->addText($_ROW_BLANKWORK['climitdays'], $_FONT_P11_B, $_TXT_INCELL_1C);
$cell = $table->addCell(9000, $_TBL_Body_Cell_Clear);
$cell->addText("дней", $_FONT_P11_B, $_TXT_INCELL_1L);
#
#
printParagraphSeparator($phpWord, $section, 0);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# SECTION_16
# 16. Результаты оценки рисков/производственной осуществимости
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# 16. Транспортные расходы (заголовок)
#
$table = $section->addTable($_TBL_Common_Fixed);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
$cell->addText("XVI", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
$cell->addText("Результаты оценки рисков/производственной осуществимости (отметить нужное)", $_FONT_P11_B, $_TXT_INCELL_1L);
#
$textrun->addText('', array('name' => "Arial", 'size' => 1));
#
##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
# ДЛЯ БЛАНКА НА ПНР ($_GET['blankType']=="PNR"
#
if ($_GET['blankType'] == "PNR") {
	#
	# ----- ----- -----
	# 16.1 Соблюдение сроков выполнения монтажных работ
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk1'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" соблюдение сроков выполнения монтажных работ", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" соблюдение сроков выполнения монтажных работ", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.2 Соблюдение сроков выполнения пуско-наладочных работ (для ПНР)
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("2)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk2'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" соблюдение сроков выполнения пуско-наладочных работ", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" соблюдение сроков выполнения пуско-наладочных работ", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.3 Соблюдение сроков оплаты
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("3)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk3'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" соблюдение сроков оплаты", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" соблюдение сроков оплаты", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.4 Соблюдение сроков оплаты
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("4)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk4'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" обеспечение ресурсами", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" обеспечение ресурсами", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.5 Иное
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("5)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk5'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" иное", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" иное", $_FONT_P10, $_TXT_INCELL_1L);
	}
	$cell = $table->addCell(15000, $_TBL_Body_Cell_B);
	$cell->addText(($_ROW_BLANKWORK['riskprim'] != "") ? $_ROW_BLANKWORK['riskprim'] : "", $_FONT_P10_B, $_TXT_INCELL_1L);
}
#
##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
# ДЛЯ БЛАНКА НА ПОСТАВКУ ($_GET['blankType']=="POS"
#
elseif ($_GET['blankType'] == "POS") {
	#
	# ----- ----- -----
	# 16.1 Соблюдение сроков выполнения монтажных работ
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk1'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" соблюдение сроков поставки", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" соблюдение сроков поставки", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.2 Соблюдение сроков оплаты
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("2)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk2'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" соблюдение сроков оплаты", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" соблюдение сроков оплаты", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.3 Соблюдение сроков оплаты
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("3)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk3'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" обеспечение ресурсами", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" обеспечение ресурсами", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.4 Иное
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("4)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk4'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" иное", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" иное", $_FONT_P10, $_TXT_INCELL_1L);
	}
	$cell = $table->addCell(15000, $_TBL_Body_Cell_B);
	$cell->addText(($_ROW_BLANKWORK['riskprim'] != "") ? $_ROW_BLANKWORK['riskprim'] : "", $_FONT_P10_B, $_TXT_INCELL_1L);
}
#
##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
# ДЛЯ БЛАНКА НА СУБПОДРЯД ($_GET['blankType']=="SUB"
#
elseif ($_GET['blankType'] == "SUB") {
	#
	# ----- ----- -----
	# 16.1 Соблюдение сроков выполнения монтажных работ
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("1)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk1'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" соблюдение сроков выполнения монтажных работ", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" соблюдение сроков выполнения монтажных работ", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.2 Соблюдение сроков выполнения пуско-наладочных работ (для ПНР)
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("2)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk2'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" соблюдение сроков выполнения пуско-наладочных работ", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" соблюдение сроков выполнения пуско-наладочных работ", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.3 Соблюдение сроков оплаты
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("3)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk3'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" соблюдение сроков оплаты", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" соблюдение сроков оплаты", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.4 Соблюдение сроков оплаты
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("4)", $_FONT_P11, $_TXT_INCELL_1L);
	$cell = $table->addCell(18500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk4'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" обеспечение ресурсами", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" обеспечение ресурсами", $_FONT_P10, $_TXT_INCELL_1L);
	}
	#
	$textrun->addText('', array('name' => "Arial", 'size' => 1));
	#
	# ----- ----- -----
	# 16.5 Иное
	#
	$table = $section->addTable($_TBL_Common_Fixed);
	$table->addRow(350, $_TBL_Body_Row);
	$cell = $table->addCell(1500, $_TBL_Body_Cell_Clear);
	$cell->addText("5)", $_FONT_P10, $_TXT_INCELL_1L);
	$cell = $table->addCell(3500, $_TBL_Body_Cell_Clear);
	$textrun = $cell->addTextRun();
	if ($_ROW_BLANKWORK['koduserisk5'] == "1") {
		$textrun->addFormField('checkbox')->setDefault(true);
		$textrun->addText(" иное", $_FONT_P10, $_TXT_INCELL_1L);
	} else {
		$textrun->addFormField('checkbox');
		$textrun->addText(" иное", $_FONT_P10, $_TXT_INCELL_1L);
	}
	$cell = $table->addCell(15000, $_TBL_Body_Cell_B);
	$cell->addText(($_ROW_BLANKWORK['riskprim'] != "") ? $_ROW_BLANKWORK['riskprim'] : "", $_FONT_P10_B, $_TXT_INCELL_1L);
}
#
##### ##### ##### ##### ##### ##### ##### ##### ##### #####
#
#
printParagraphSeparator($phpWord, $section, 1);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ПОДПИСЬ ГИПА
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$tableS = $section->addTable($_TBL_Common_Fixed);
$tableS->addRow(750, $_TBL_Body_Row);
$cellS = $tableS->addCell(1000, $_TBL_Body_Cell_ClearB);
$cellS = $tableS->addCell(4000, $_TBL_Body_Cell_ClearB)->addText("Подпись ГИПа", $_FONT_H12_B, $_TXT_INCELL_1R);
$cellS = $tableS->addCell(3000, $_TBL_Body_Cell_B);
$cellS = $tableS->addCell(500, $_TBL_Body_Cell_ClearB)->addText("/", $_FONT_H12, $_TXT_INCELL_1C);
$cellS = $tableS->addCell(3000, $_TBL_Body_Cell_B);
$cellS = $tableS->addCell(500, $_TBL_Body_Cell_ClearB)->addText("/", $_FONT_H12, $_TXT_INCELL_1C);
$cellS = $tableS->addCell(1000, $_TBL_Body_Cell_Clear);
$cellS = $tableS->addCell(3000, $_TBL_Body_Cell_ClearB)->addText("Дата", $_FONT_H12_B, $_TXT_INCELL_1R);
$cellS = $tableS->addCell(3000, $_TBL_Body_Cell_B);
$cellS = $tableS->addCell(1000, $_TBL_Body_Cell_ClearB);
#
#
printParagraphSeparator($phpWord, $section, 1);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ПРИМЕЧАНИЯ ОТДЕЛА ДОГОВОРОВ
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$section->addTitle("Примечания отдела договоров", 2);
#
$table = $section->addTable($_InnerTBL_Common_1);
$table->addRow(650, $_TBL_Header_Row);
$cell = $table->addCell(3000, $_TBL_Body_Cell);
$cell->addText("Дата", $_FONT_P11_B, $_TXT_INCELL_1L);
$cell = $table->addCell(17000, $_TBL_Body_Cell);
$cell->addText("Содержание примечания", $_FONT_P11_B, $_TXT_INCELL_1L);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(3000, $_TBL_Body_Cell);
$cell->addText("", $_FONT_P11, $_TXT_INCELL_1L);
$cell = $table->addCell(17000, $_TBL_Body_Cell);
$cell->addText("", $_FONT_P11, $_TXT_INCELL_1L);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(3000, $_TBL_Body_Cell);
$cell->addText("", $_FONT_P11, $_TXT_INCELL_1L);
$cell = $table->addCell(17000, $_TBL_Body_Cell);
$cell->addText("", $_FONT_P11, $_TXT_INCELL_1L);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(3000, $_TBL_Body_Cell);
$cell->addText("", $_FONT_P11, $_TXT_INCELL_1L);
$cell = $table->addCell(17000, $_TBL_Body_Cell);
$cell->addText("", $_FONT_P11, $_TXT_INCELL_1L);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(3000, $_TBL_Body_Cell);
$cell->addText("", $_FONT_P11, $_TXT_INCELL_1L);
$cell = $table->addCell(17000, $_TBL_Body_Cell);
$cell->addText("", $_FONT_P11, $_TXT_INCELL_1L);
$table->addRow(450, $_TBL_Body_Row);
$cell = $table->addCell(3000, $_TBL_Body_Cell);
$cell->addText("", $_FONT_P11, $_TXT_INCELL_1L);
$cell = $table->addCell(17000, $_TBL_Body_Cell);
$cell->addText("", $_FONT_P11, $_TXT_INCELL_1L);
#
#
printParagraphSeparator($phpWord, $section, 1);
#
#
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
// $xmlWriter->save("php://output");
$filepath = $_SERVER['DOCUMENT_ROOT'] . "/dognet/tmp/";
$filename = "BLANK_" . $_SESSION['id'] . "_" . date('YmdHis') . ".DOCX";
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
		<a class="format-selected" href="http://<?php echo $_SERVER['HTTP_HOST'] . '/dognet/tmp/' . $filename; ?>"><?php echo $filename; ?></a>
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
		i = 15;
		document.getElementById("time").innerHTML = i;
		timer = setInterval(function() {
			document.getElementById("time").innerHTML = i--;

			host = '<?php echo $_SERVER["HTTP_HOST"]; ?>';
			uniqueID1 = '<?php echo $_GET["uniqueID1"]; ?>';
			zak = '<?php echo $_GET["zak"]; ?>';
			url1 = 'http://' + host + '/dognet/dognet-report.php';
			url2 = 'http://' + host + '/dognet/dognet-report.php?reportview_type=zadolchf&export=yes&uniqueID1=' + uniqueID1 + '&zak=' + zak;
			if (i < 0) {
				clearInterval(timer);
				document.getElementById("link").innerHTML = "<div class='space20'><span style='padding:0 15px'><a class='return-link' href=" + url1 + ">Вернуться в Отчеты</a></span></div><div class='space20'><span style='padding:0 15px'><a class='return-link' href=" + url2 + ">Новый экспорт</a></span></div>";
			}
		}, 1000);
	}
	countDown();
</script>