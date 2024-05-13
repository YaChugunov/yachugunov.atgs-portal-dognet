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


$phpWord = new  \PhpOffice\PhpWord\PhpWord();

$phpWord->setDefaultFontName('Arial');
$phpWord->setDefaultFontSize(10);

$properties = $phpWord->getDocInfo();

$properties->setCreator("АТГС.Портал");
$properties->setCompany('АТГС');
$properties->setTitle('Справка о задолженности по счетам-фактурам');
$properties->setDescription('Справка о задолженности по счетам-фактурам');
$properties->setCategory('Отчеты');
$properties->setLastModifiedBy('АТГС.Портал');
$properties->setCreated(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setModified(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setSubject('Справка о задолженности по счетам-фактурам');
$properties->setKeywords('Портал, Договор, Отчеты');
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
$sectionStyle = array(
	'orientation' => 'landscape',
	'marginTop' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(90),
	'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(100),
	'marginLeft' => 600,
	'marginRight' => 600,
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
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ::::: ВЕРХНИЙ КОЛОНТИТУЛ (HEADER)
#
$headerStyle = array(
	'marginTop' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(50),
	'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(50)
);
$header = $section->addHeader();
// Вставляем таблицу в верхний колонтитул (header)
$table = $header->addTable(array('width' => 100 * 50, 'unit' => "pct", 'borderBottomSize' => 10, 'borderBottomColor' => "C0C0C0", 'cellMarginBottom' => 100, 'valign' => "top"));
$table->addRow();
$cell = $table->addCell();
$textrun = $cell->addTextRun();
// Оформляем содержимое таблицы в header
$textrun->addText('Справка о задолженности', array('name' => "Arial", 'size' => 12, 'color' => '333333', 'allCaps' => true, 'bold' => true));
//
$cell = $table->addCell();
$textrun = $cell->addTextRun(array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));
$textrun->addText('По счетам-фактурам', array('name' => "Arial", 'size' => 12, 'italic' => true));
#
# ::::: НИЖНИЙ КОЛОНТИТУЛ (FOOTER)
#
$footer = $section->addFooter();
// Вставляем таблицу в верхний колонтитул (header)
$table = $footer->addTable(array('width' => 100 * 50, 'unit' => "pct", 'borderTopSize' => 10, 'borderTopColor' => "C0C0C0", 'cellMarginTop' => 100));
$table->addRow();
$cell = $table->addCell();
$textrun = $cell->addTextRun();
// Оформляем содержимое таблицы в header
$textrun->addText($_SESSION["current_user_firstname"] . " " . $_SESSION["current_user_lastname"], array('name' => "Arial", 'size' => 8, 'color' => '333333', 'allCaps' => true));
$textrun->addTextBreak();
$textrun->addText(date('d.m.Y H:i:s'), array('name' => "Arial", 'size' => 8, 'color' => '333333'));
//
// Вставляем лого в среднюю ячейку
$cell = $table->addCell();
// $cell->addImage('logo_dognet.png', array('height' => 25, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
//
//
$table->addCell()->addPreserveText('Страница {PAGE} из {NUMPAGES}', array('name' => "Arial", 'size' => 8, 'color' => '333333', 'allCaps' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
#
#
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$phpWord->addTitleStyle(1, array('name' => "Arial", 'size' => 16, 'bold' => true), array('spaceAfter' => 240));
$phpWord->addTitleStyle(2, array('name' => "Arial", 'size' => 14, 'bold' => true), array('spaceAfter' => 200));
$section->addTitle('Справка о задолженностях по счетам-фактурам', 2);
//
//
$A1 = (!empty($_GET['zdl_1']) && isset($_GET['zdl_1']) && $_GET['zdl_1'] == 'yes');
$A2 = (!empty($_GET['zdl_2']) && isset($_GET['zdl_2']) && $_GET['zdl_2'] == 'yes');
$A3 = (!empty($_GET['zdl_3']) && isset($_GET['zdl_3']) && $_GET['zdl_3'] == 'yes');
//
//
$B1 = (!empty($_GET['doc']) && isset($_GET['doc']) && $_GET['doc'] == 'yes');
$B2 = (!empty($_GET['cht']) && isset($_GET['cht']) && $_GET['cht'] == 'yes');
//
//
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ОБЩИЙ СТИЛЬ ТАБЛИЦЫ
#
$_TBL_TABLEStyle = array(
	'cellMarginLeft' => 50,
	'cellMarginTop' => 10,
	'cellMarginRight' => 50,
	'cellMarginBottom' => 10,
	'borderTopColor' => "111111",
	'borderTopSize' => 10,
	'borderRightColor' => "111111",
	'borderRightSize' => 10,
	'borderLeftColor' => "111111",
	'borderLeftSize' => 10,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 10,
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ШАПКА ТАБЛИЦЫ
#
// Стиль TBL.HEADER.ROW
$_TBL_HEADERStyle_Row = array(
	'tblHeader' => true
);
// Стиль TBL.HEADER.CELL-LEFT
$_TBL_HEADERStyle_CellLeft = array(
	'valign' => 'center',
	'bgColor' => 'F1F1F1',
	'borderRightColor' => "999999",
	'borderRightSize' => 2,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 10
);
// Стиль TBL.HEADER.CELL
$_TBL_HEADERStyle_Cell = array(
	'valign' => 'center',
	'bgColor' => 'F1F1F1',
	'borderRightColor' => "999999",
	'borderRightSize' => 2,
	'borderBottomColor' => "111111",
	'borderBottomSize' => 10
);
// Стиль TBL.HEADER.CELL-LEFT
$_TBL_HEADERStyle_CellRight = array(
	'valign' => 'center',
	'bgColor' => 'F1F1F1',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 10
);
// FONT TBL.HEADER.CELL
$_TBL_HEADERFont = array('name' => "Arial Narrow", 'allCaps' => true, 'bold' => true, 'size' => 10);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ТЕЛО ТАБЛИЦЫ
#
// Стиль TBL.BODY.ROW
$_TBL_BODYStyle_Row = array(
	'exactHeight' => false
);
// Стиль TBL.BODY.CELLSPAN
$_TBL_BODYStyle_CellSpan8_1 = array(
	'valign' => 'center',
	'gridSpan' => 8,
	'bgColor' => 'F1F1F1',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan8_2 = array(
	'valign' => 'center',
	'gridSpan' => 8,
	'bgColor' => '111111',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan8_3 = array(
	'valign' => 'center',
	'gridSpan' => 8,
	'bgColor' => 'FAFAFA',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan8_4 = array(
	'valign' => 'center',
	'gridSpan' => 8,
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan7_1 = array(
	'valign' => 'center',
	'gridSpan' => 7,
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan6_1 = array(
	'valign' => 'center',
	'gridSpan' => 6,
	'bgColor' => 'E0E0E0',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan6_2 = array(
	'valign' => 'center',
	'gridSpan' => 6,
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan6_3 = array(
	'valign' => 'center',
	'gridSpan' => 6,
	'bgColor' => 'F1F1F1',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan2_1 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'bgColor' => 'E0E0E0',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan2_2 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_Cell_Itogo_1 = array(
	'valign' => 'center',
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2,
	'borderRightColor' => "999999",
	'borderRightSize' => 2
);
// Стиль TBL.BODY.CELL-LEFT
$_TBL_BODYStyle_CellLeft = array(
	'valign' => 'center',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2,
	'borderRightColor' => "999999",
	'borderRightSize' => 2
);
// Стиль TBL.BODY.CELL
$_TBL_BODYStyle_Cell = array(
	'valign' => 'center',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2,
	'borderRightColor' => "999999",
	'borderRightSize' => 2
);
$_TBL_BODYStyle_Cell_63 = array(
	'valign' => 'center',
	'bgColor' => 'F1F1F1',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
// Стиль TBL.BODY.CELL-RIGHT
$_TBL_BODYStyle_CellRight = array(
	'valign' => 'center',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
// FONTS TBL.BODY.CELL
$_TBL_BODYFont_H1_1 = array('name' => "Arial Narrow", 'allcaps' => true, 'bold' => true, 'size' => 11, 'color' => "111111");
$_TBL_BODYFont_H1_2 = array('name' => "Arial Narrow", 'allcaps' => true, 'bold' => true, 'size' => 11, 'color' => "FFFFFF");
$_TBL_BODYFont_H1_3 = array('name' => "Arial", 'bold' => true, 'size' => 11, 'color' => "111111");

$_TBL_BODYFont_H2_1 = array('name' => "Arial", 'bold' => true, 'size' => 9, 'color' => "111111");
$_TBL_BODYFont_H2_2 = array('name' => "Arial", 'bold' => true, 'size' => 9, 'color' => "D9534F");
$_TBL_BODYFont_H3_1 = array('name' => "Arial", 'italic' => false, 'size' => 9, 'color' => "111111");
$_TBL_BODYFont = array('name' => "Arial", 'bold' => false, 'size' => 8, 'color' => "666666");
$_TBL_BODYFont_2 = array('name' => "Arial", 'bold' => false, 'size' => 10, 'color' => "333333");

$_TBL_CELLAlign_H_Left = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT);
$_TBL_CELLAlign_H_Right = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT);
$_TBL_CELLAlign_H_Center = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
$_TBL_CELLAlign_V_Middle = array('valign' => 'center');
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$_TBL_BODYFont_Title_H1_1 = array('name' => "Arial Narrow", 'allcaps' => true, 'bold' => true, 'size' => 12, 'color' => "111111");
$_TBL_BODYFont_Title_H1_2 = array('name' => "Arial Narrow", 'bold' => true, 'size' => 12, 'color' => "111111");
$_TBL_BODYFont_Title_H2_1 = array('name' => "Arial Narrow", 'allcaps' => true, 'bold' => true, 'size' => 9, 'color' => "111111");
$_TBL_BODYFont_Title_H2_2 = array('name' => "Arial Narrow", 'bold' => true, 'size' => 9, 'color' => "111111");
$_TBL_BODYFont_Title_H3_1 = array('name' => "Arial", 'bold' => true, 'size' => 9, 'color' => "111111");
$_TBL_BODYFont_Title_H3_2 = array('name' => "Arial", 'bold' => true, 'size' => 9, 'color' => "111111");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----



// Текущая задолженность
$_QRY_DOC1 = mysqlQuery("SELECT SUM(summazadol) as SUM_1 FROM dognet_reports_zadolchf WHERE kodstatuszdl = '1' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet = '')");
$_ROW_DOC1 = mysqli_fetch_assoc($_QRY_DOC1);
$_sumzadol_doc1 = $_ROW_DOC1['SUM_1'];
$_QRY_CHT1 = mysqlQuery("SELECT SUM(summazadol) as SUM_1 FROM dognet_reports_zadolchf WHERE kodstatuszdl = '1' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet <> '')");
$_ROW_CHT1 = mysqli_fetch_assoc($_QRY_CHT1);
$_sumzadol_cht1 = $_ROW_CHT1['SUM_1'];

// Судебная задолженность
$_QRY_DOC2 = mysqlQuery("SELECT SUM(summazadol) as SUM_2 FROM dognet_reports_zadolchf WHERE kodstatuszdl = '2' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet = '')");
$_ROW_DOC2 = mysqli_fetch_assoc($_QRY_DOC2);
$_sumzadol_doc2 = $_ROW_DOC2['SUM_2'];
$_QRY_CHT2 = mysqlQuery("SELECT SUM(summazadol) as SUM_2 FROM dognet_reports_zadolchf WHERE kodstatuszdl = '2' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet <> '')");
$_ROW_CHT2 = mysqli_fetch_assoc($_QRY_CHT2);
$_sumzadol_cht2 = $_ROW_CHT2['SUM_2'];

// Невозвратная задолженность
$_QRY_DOC3 = mysqlQuery("SELECT SUM(summazadol) as SUM_3 FROM dognet_reports_zadolchf WHERE kodstatuszdl = '3' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet = '')");
$_ROW_DOC3 = mysqli_fetch_assoc($_QRY_DOC3);
$_sumzadol_doc3 = $_ROW_DOC3['SUM_3'];
$_QRY_CHT3 = mysqlQuery("SELECT SUM(summazadol) as SUM_3 FROM dognet_reports_zadolchf WHERE kodstatuszdl = '3' AND koddel <> '99' AND koddoc IN (SELECT koddoc FROM dognet_docbase WHERE numberchet <> '')");
$_ROW_CHT3 = mysqli_fetch_assoc($_QRY_CHT3);
$_sumzadol_cht3 = $_ROW_CHT3['SUM_3'];

$TableStyleName_Common = 'Common Table';
$phpWord->addTableStyle($TableStyleName_Common, $_TBL_TABLEStyle, $_TBL_HEADERStyle_Row);
$table = $section->addTable($TableStyleName_Common);
$table->addRow(600, $_TBL_HEADERStyle_Row);
$table->addCell(9000, $_TBL_HEADERStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Вид задолженности', $_TBL_HEADERFont);
$table->addCell(4000, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Итого по договорам', $_TBL_HEADERFont);
$table->addCell(4000, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Итого по счетам', $_TBL_HEADERFont);

$table->addRow(450, $_TBL_BODYStyle_Row);
$table->addCell(9000, $_TBL_BODYStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Текущая', $_TBL_BODYFont_2);
$table->addCell(4000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_sumzadol_doc1, 2, '.', ' '), $_TBL_BODYFont_2);
$table->addCell(4000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_sumzadol_cht1, 2, '.', ' '), $_TBL_BODYFont_2);

$table->addRow(450, $_TBL_BODYStyle_Row);
$table->addCell(9000, $_TBL_BODYStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Судебная', $_TBL_BODYFont_2);
$table->addCell(4000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_sumzadol_doc2, 2, '.', ' '), $_TBL_BODYFont_2);
$table->addCell(4000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_sumzadol_cht2, 2, '.', ' '), $_TBL_BODYFont_2);

$table->addRow(450, $_TBL_BODYStyle_Row);
$table->addCell(9000, $_TBL_BODYStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Невозвратная', $_TBL_BODYFont_2);
$table->addCell(2000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_sumzadol_doc3, 2, '.', ' '), $_TBL_BODYFont_2);
$table->addCell(2000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_sumzadol_cht3, 2, '.', ' '), $_TBL_BODYFont_2);

$table->addRow(450, $_TBL_BODYStyle_Row);
$table->addCell(9000, $_TBL_BODYStyle_Cell_Itogo_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('ИТОГО ВСЕГО', $_TBL_BODYFont_H1_1);
$table->addCell(2000, $_TBL_BODYStyle_Cell_Itogo_1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_sumzadol_doc1 + $_sumzadol_doc2 + $_sumzadol_doc3, 2, '.', ' '), $_TBL_BODYFont_H1_1);
$table->addCell(2000, $_TBL_BODYStyle_Cell_Itogo_1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_sumzadol_cht1 + $_sumzadol_cht2 + $_sumzadol_cht3, 2, '.', ' '), $_TBL_BODYFont_H1_1);
//
//
$section->addText("", null, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'spaceBefore' => 90, 'spaceAfter' => 240));
//
//
$section->addText(
	"Далее приведен список компаний-плательщиков, со стороны которых по выставленным счетам-фактурам имеются задолженности.",
	null,
	array('widowControl' => false, 'indentation' => array('left' => 240, 'right' => 0), 'spaceBefore' => 90, 'spaceAfter' => 90)
);
//
//
$section->addText(
	"В этом списке определены для вывода следующие виды задолженностей:",
	null,
	array('widowControl' => false, 'indentation' => array('left' => 240, 'right' => 0), 'spaceBefore' => 90, 'spaceAfter' => 90)
);
if ($A1) {
	$section->addText(
		"- текущая",
		array('bold' => true, 'size' => 8),
		array('widowControl' => false, 'indentation' => array('left' => 480, 'right' => 0), 'spaceBefore' => 0, 'spaceAfter' => 60)
	);
}
if ($A2) {
	$section->addText(
		"- судебная",
		array('bold' => true, 'size' => 8),
		array('widowControl' => false, 'indentation' => array('left' => 480, 'right' => 0), 'spaceBefore' => 0, 'spaceAfter' => 60)
	);
}
if ($A3) {
	$section->addText(
		"- невозвратная",
		array('bold' => true, 'size' => 8),
		array('widowControl' => false, 'indentation' => array('left' => 480, 'right' => 0), 'spaceBefore' => 0, 'spaceAfter' => 60)
	);
}
if (!($A1 or $A2 or $A3)) {
	$section->addText(
		"виды задолженностей не определены",
		array('bold' => true, 'size' => 8),
		array('widowControl' => false, 'indentation' => array('left' => 480, 'right' => 0), 'spaceBefore' => 0, 'spaceAfter' => 60)
	);
}
//
//
$section->addText(
	"В этом списке определены для вывода следующие типы документов:",
	null,
	array('widowControl' => false, 'indentation' => array('left' => 240, 'right' => 0), 'spaceBefore' => 90, 'spaceAfter' => 90)
);
if ($B1) {
	$section->addText(
		"- договор",
		array('bold' => true, 'size' => 8),
		array('widowControl' => false, 'indentation' => array('left' => 480, 'right' => 0), 'spaceBefore' => 0, 'spaceAfter' => 60)
	);
}
if ($B2) {
	$section->addText(
		"- счет",
		array('bold' => true, 'size' => 8),
		array('widowControl' => false, 'indentation' => array('left' => 480, 'right' => 0), 'spaceBefore' => 0, 'spaceAfter' => 60)
	);
}
if (!($B1 or $B2)) {
	$section->addText(
		"типы документов не определены",
		array('bold' => true, 'size' => 8),
		array('widowControl' => false, 'indentation' => array('left' => 480, 'right' => 0), 'spaceBefore' => 0, 'spaceAfter' => 60)
	);
}
//
//
$section->addPageBreak();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
#
#
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$_queryStr = "SELECT * FROM sp_contragents WHERE kodzakaz IN (SELECT kodzakaz FROM dognet_docbase WHERE ";
//
$B1 = (!empty($_GET['doc']) && isset($_GET['doc']) && $_GET['doc'] == 'yes') ? "1" : "0";
$B2 = (!empty($_GET['cht']) && isset($_GET['cht']) && $_GET['cht'] == 'yes') ? "1" : "0";
$BB = $B1 . $B2;
if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
	echo "Выборка документов: ";
	echo $BB;
	echo "<br>";
}
switch ($BB) {
	case "00":
		$_queryStr .= "numberchet='-999' AND ";
		break;
	case "01":
		$_queryStr .= "(kodshab=0 AND numberchet<>'') AND ";
		break;
	case "10":
		$_queryStr .= "numberchet='' AND ";
		break;
	case "11":
		$_queryStr .= "(numberchet='' OR numberchet<>'') AND ";
		break;
	default:
		$_queryStr .= "(numberchet='' OR numberchet<>'') AND ";
}
//
$A1 = (!empty($_GET['zdl_1']) && isset($_GET['zdl_1']) && $_GET['zdl_1'] == 'yes') ? "1" : "0";
$A2 = (!empty($_GET['zdl_2']) && isset($_GET['zdl_2']) && $_GET['zdl_2'] == 'yes') ? "1" : "0";
$A3 = (!empty($_GET['zdl_3']) && isset($_GET['zdl_3']) && $_GET['zdl_3'] == 'yes') ? "1" : "0";
$AAA = $A1 . $A2 . $A3;
if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
	echo "Выборка задолженностей: ";
	echo $AAA;
	echo "<br>";
}
switch ($AAA) {
	case "000":
		$_queryStr .= "(kodstatuszdl='-999') AND "; // Запрос точно выдаст пустой список
		break;
	case "001":
		$_queryStr .= "(kodstatuszdl='3') AND ";
		break;
	case "010":
		$_queryStr .= "(kodstatuszdl='2') AND ";
		break;
	case "100":
		$_queryStr .= "(kodstatuszdl='1') AND ";
		break;
	case "110":
		$_queryStr .= "(kodstatuszdl='1' OR kodstatuszdl='2') AND ";
		break;
	case "101":
		$_queryStr .= "(kodstatuszdl='1' OR kodstatuszdl='3') AND ";
		break;
	case "011":
		$_queryStr .= "(kodstatuszdl='2' OR kodstatuszdl='3') AND ";
		break;
	case "111":
		$_queryStr .= "(kodstatuszdl='1' OR kodstatuszdl='2' OR kodstatuszdl='3') AND ";
		break;
	default:
		$_queryStr .= "(kodstatuszdl='-999') AND "; // Запрос точно выдаст пустой список
}
$_queryStr .= "koddoc IN (SELECT koddoc FROM dognet_reports_zadolchf)) ORDER BY namezakshot ASC";
if (checkUserRestrictions($_SESSION['id'], 'dognet', 5, 1) == 1) {
	echo "SQL-запрос (организация): ";
	echo $_queryStr;
	echo "<br>";
}
$_QRY = mysqlQuery($_queryStr);


$fancyTableStyleName1 = 'Main Table';
$phpWord->addTableStyle($fancyTableStyleName1, $_TBL_TABLEStyle, $_TBL_HEADERStyle_Row);
$table = $section->addTable($fancyTableStyleName1);
$table->addRow(450, $_TBL_HEADERStyle_Row);
$table->addCell(8000, $_TBL_HEADERStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Организация / Договор / Этап', $_TBL_HEADERFont);
$table->addCell(1000, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('С/Ф №', $_TBL_HEADERFont);
$table->addCell(2500, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Дата С/Ф', $_TBL_HEADERFont);
$table->addCell(2500, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Сумма', $_TBL_HEADERFont);
$table->addCell(2500, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Авансы', $_TBL_HEADERFont);
$table->addCell(2500, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Оплаты', $_TBL_HEADERFont);
$table->addCell(2500, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Задолженность', $_TBL_HEADERFont);
$table->addCell(2000, $_TBL_HEADERStyle_CellRight)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Срок оплаты', $_TBL_HEADERFont);

while ($_ROW = mysqli_fetch_assoc($_QRY)) {


	$table->addRow(450, $_TBL_BODYStyle_Row);
	$table->addCell(8000, $_TBL_BODYStyle_CellSpan8_2)->addTextRun($_TBL_CELLAlign_H_Left)->addText($_ROW['namezakshot'], $_TBL_BODYFont_H1_2);

	$_queryStr = "SELECT * FROM dognet_docbase WHERE kodzakaz='" . $_ROW['kodzakaz'] . "' AND ";
	//
	$B1 = (!empty($_GET['doc']) && isset($_GET['doc']) && $_GET['doc'] == 'yes') ? "1" : "0";
	$B2 = (!empty($_GET['cht']) && isset($_GET['cht']) && $_GET['cht'] == 'yes') ? "1" : "0";
	$BB = $B1 . $B2;
	switch ($BB) {
		case "00":
			$_queryStr .= "numberchet='-999' AND ";
			break;
		case "01":
			$_queryStr .= "(kodshab=0 AND numberchet<>'') AND ";
			break;
		case "10":
			$_queryStr .= "numberchet='' AND ";
			break;
		case "11":
			$_queryStr .= "(numberchet='' OR numberchet<>'') AND ";
			break;
		default:
			$_queryStr .= "(numberchet='' OR numberchet<>'') AND ";
	}
	//
	$A1 = (!empty($_GET['zdl_1']) && isset($_GET['zdl_1']) && $_GET['zdl_1'] == 'yes') ? "1" : "0";
	$A2 = (!empty($_GET['zdl_2']) && isset($_GET['zdl_2']) && $_GET['zdl_2'] == 'yes') ? "1" : "0";
	$A3 = (!empty($_GET['zdl_3']) && isset($_GET['zdl_3']) && $_GET['zdl_3'] == 'yes') ? "1" : "0";
	$AAA = $A1 . $A2 . $A3;
	switch ($AAA) {
		case "000":
			$_queryStr .= "(kodstatuszdl='-999') AND "; // Запрос точно выдаст пустой список
			break;
		case "001":
			$_queryStr .= "(kodstatuszdl='3') AND ";
			break;
		case "010":
			$_queryStr .= "(kodstatuszdl='2') AND ";
			break;
		case "100":
			$_queryStr .= "(kodstatuszdl='1') AND ";
			break;
		case "110":
			$_queryStr .= "(kodstatuszdl='1' OR kodstatuszdl='2') AND ";
			break;
		case "101":
			$_queryStr .= "(kodstatuszdl='1' OR kodstatuszdl='3') AND ";
			break;
		case "011":
			$_queryStr .= "(kodstatuszdl='2' OR kodstatuszdl='3') AND ";
			break;
		case "111":
			$_queryStr .= "(kodstatuszdl='1' OR kodstatuszdl='2' OR kodstatuszdl='3') AND ";
			break;
		default:
			$_queryStr .= "(kodstatuszdl='1' OR kodstatuszdl='2' OR kodstatuszdl='3') AND ";
	}
	$_queryStr .= "koddoc IN (SELECT koddoc FROM dognet_reports_zadolchf)";
	$_QRY_docbase = mysqlQuery($_queryStr);

	$_SUM_summazadol_zakaz = 0.00;
	$_DENED = "";

	while ($_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase)) {

		$kodstatuszdl = $_ROW_docbase['kodstatuszdl'];
		switch ($kodstatuszdl) {
			case "1":
				$_ZDLSTR = "Текущая";
				break;
			case "2":
				$_ZDLSTR = "Судебная";
				break;
			case "3":
				$_ZDLSTR = "Невозвратная";
				break;
			default:
				$_ZDLSTR = "???";
		}
		$_QRY_dened = mysqlQuery("SELECT * FROM dognet_spdened WHERE koddened='" . $_ROW_docbase['koddened'] . "'");
		$_ROW_dened = mysqli_fetch_assoc($_QRY_dened);
		// 		$_DENED = $_ROW_dened['short_code'];
		if ($_QRY_dened) {
			$_DENED = html_entity_decode($_ROW_dened['short_code']);
		} else {
			$_DENED = " -.";
		}

		$_SUM_chetfsumma = 0.00;
		$_SUM_summaoplav = 0.00;
		$_SUM_summaopl = 0.00;
		$_SUM_summazadol_doc = 0.00;

		$table->addRow(300, $_TBL_BODYStyle_Row);
		if ($_ROW_docbase['kodshab'] == 0) {
			$table->addCell(8000, $_TBL_BODYStyle_CellSpan6_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Счет №' . $_ROW_docbase['docnumber'], $_TBL_BODYFont_H2_1);
		} else {
			$table->addCell(8000, $_TBL_BODYStyle_CellSpan6_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Договор №3-4/' . $_ROW_docbase['docnumber'], $_TBL_BODYFont_H2_1);
		}
		$table->addCell(2500, $_TBL_BODYStyle_Cell_63)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ZDLSTR, $_TBL_BODYFont_H2_1);
		$table->addCell(2000, $_TBL_BODYStyle_Cell_63)->addTextRun($_TBL_CELLAlign_H_Center)->addText("", $_TBL_BODYFont_H2_1);


		if (($_ROW_docbase['kodshab'] == 1) or ($_ROW_docbase['kodshab'] == 3)) {
			$_QRY_dockalplan_Str = "SELECT * FROM dognet_dockalplan WHERE koddel<>'99' AND koddoc='" . $_ROW_docbase['koddoc'] . "' AND kodkalplan IN (SELECT kodkalplan FROM dognet_reports_zadolchf)";
		}
		if (($_ROW_docbase['kodshab'] == 2) or ($_ROW_docbase['kodshab'] == 4)) {
			$_QRY_dockalplan_Str = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND numberchet='' AND koddoc='" . $_ROW_docbase['koddoc'] . "' AND (kodshab='2' OR kodshab='4') AND koddoc IN (SELECT koddoc FROM dognet_reports_zadolchf)";
		}
		if ($_ROW_docbase['kodshab'] == 0) {
			$_QRY_dockalplan_Str = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND numberchet<>'' AND koddoc='" . $_ROW_docbase['koddoc'] . "' AND kodshab='0' AND koddoc IN (SELECT koddoc FROM dognet_reports_zadolchf)";
		}


		$_QRY_dockalplan = mysqlQuery($_QRY_dockalplan_Str);


		while ($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {

			if (($_ROW_docbase['kodshab'] == 1) or ($_ROW_docbase['kodshab'] == 3)) {
				$_SROKOPL = $_ROW_dockalplan['srokopl'];
			} elseif (($_ROW_docbase['kodshab'] == 0) or ($_ROW_docbase['kodshab'] == 2) or ($_ROW_docbase['kodshab'] == 4)) {
				$_SROKOPL = $_ROW_docbase['srokdoc'];
			}


			$table->addRow(300, $_TBL_BODYStyle_Row);
			if (($_ROW_docbase['kodshab'] == 1) or ($_ROW_docbase['kodshab'] == 3)) {
				$table->addCell(8000, $_TBL_BODYStyle_CellSpan8_3)->addText('Этап ' . $_ROW_dockalplan['numberstage'] . " : " . $_ROW_dockalplan['nameshotstage'], $_TBL_BODYFont_H3_1);
			} elseif (($_ROW_docbase['kodshab'] == 0) or ($_ROW_docbase['kodshab'] == 2) or ($_ROW_docbase['kodshab'] == 4)) {
				$table->addCell(8000, $_TBL_BODYStyle_CellSpan8_3)->addText('Без этапа', $_TBL_BODYFont_H3_1);
			}

			// 			$_QRY_kalplanchf = mysqlQuery( "SELECT * FROM dognet_kalplanchf WHERE kodkalplan='".$_ROW_dockalplan['kodkalplan']."' AND kodchfact IN (SELECT kodchfact FROM dognet_reports_zadolchf)" );

			if (($_ROW_docbase['kodshab'] == 1) or ($_ROW_docbase['kodshab'] == 3)) {
				$_QRY_kalplanchf = mysqlQuery("SELECT dognet_kalplanchf.chetfnumber, dognet_kalplanchf.chetfdate, dognet_kalplanchf.chetfsumma, dognet_reports_zadolchf.summaoplav, dognet_reports_zadolchf.summaopl, dognet_reports_zadolchf.summazadol FROM dognet_kalplanchf INNER JOIN dognet_reports_zadolchf ON dognet_kalplanchf.kodchfact = dognet_reports_zadolchf.kodchfact WHERE dognet_kalplanchf.kodkalplan='" . $_ROW_dockalplan['kodkalplan'] . "'");
			} elseif (($_ROW_docbase['kodshab'] == 0) or ($_ROW_docbase['kodshab'] == 2) or ($_ROW_docbase['kodshab'] == 4)) {
				$_QRY_kalplanchf = mysqlQuery("SELECT dognet_kalplanchf.chetfnumber, dognet_kalplanchf.chetfdate, dognet_kalplanchf.chetfsumma, dognet_reports_zadolchf.summaoplav, dognet_reports_zadolchf.summaopl, dognet_reports_zadolchf.summazadol FROM dognet_kalplanchf INNER JOIN dognet_reports_zadolchf ON dognet_kalplanchf.kodchfact = dognet_reports_zadolchf.kodchfact WHERE dognet_kalplanchf.kodkalplan='" . $_ROW_docbase['koddoc'] . "'");
			}

			while ($_ROW_kalplanchf = mysqli_fetch_assoc($_QRY_kalplanchf)) {

				//
				$_CHFDATE = $_ROW_kalplanchf['chetfdate'];

				$chetfsumma = $_ROW_kalplanchf['chetfsumma'];
				$summaoplav = $_ROW_kalplanchf['summaoplav'];
				$summaopl = $_ROW_kalplanchf['summaopl'];
				$summazadol = $_ROW_kalplanchf['summazadol'];
				$tmp = $chetfsumma + $summaoplav + $summaopl + $summazadol;


				$string = $_ROW_kalplanchf['chetfdate']; // Наша дата в string
				$format = 'd.m.Y'; // формат даты (все: https://www.php.net/manual/ru/function.date.php)
				$date = new DateTime($string);
				$chfdate = $date->format($format);
				// Прибавить дни или оставить ПКЗ
				if (($_ROW_docbase['kodshab'] == 1) or ($_ROW_docbase['kodshab'] == 3)) {
					if ($_SROKOPL != "ПКЗ") {
						$date->modify('+' . $_SROKOPL . ' days');
						$srokopl = $date->format($format);
					} else {
						$srokopl = $_SROKOPL;
					}
				}
				if (($_ROW_docbase['kodshab'] == 0) or ($_ROW_docbase['kodshab'] == 2) or ($_ROW_docbase['kodshab'] == 4)) {
					if ($_ROW_docbase['idsrokdoc'] == 0) {
						if ($_ROW_docbase['srokdoc'] != "") {
							$date->modify('+' . $_SROKOPL . ' days');
							$srokopl = $date->format($format);
						} else {
							$srokopl = "Не указан";
						}
					}
					if ($_ROW_docbase['idsrokdoc'] == 1) {
						if ($_ROW_docbase['srokdoc'] != "") {
							$srokopl = str_replace('/', '.', $_SROKOPL);
						} else {
							$srokopl = "Не указан";
						}
					} else {
						$srokopl = "Не указан";
					}
				}


				$table->addRow(300, $_TBL_BODYStyle_Row);
				$table->addCell(8000, $_TBL_BODYStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('');
				$table->addCell(1000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_kalplanchf['chetfnumber'], $_TBL_BODYFont);
				$table->addCell(2000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(date("d.m.Y", strtotime($_ROW_kalplanchf['chetfdate'])), $_TBL_BODYFont);
				$table->addCell(2500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($chetfsumma, 2, '.', ' ') . $_DENED, $_TBL_BODYFont);
				$table->addCell(2500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($summaoplav, 2, '.', ' ') . $_DENED, $_TBL_BODYFont);
				$table->addCell(2500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($summaopl, 2, '.', ' ') . $_DENED, $_TBL_BODYFont);
				$table->addCell(2500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($summazadol, 2, '.', ' ') . $_DENED, $_TBL_BODYFont);
				$table->addCell(2000, $_TBL_BODYStyle_CellRight)->addTextRun($_TBL_CELLAlign_H_Center)->addText($srokopl, $_TBL_BODYFont);

				// Суммируем суммы счето-фактур
				$_SUM_chetfsumma += $chetfsumma;
				$_SUM_summaoplav += $summaoplav;
				$_SUM_summaopl += $summaopl;
				$_SUM_summazadol_doc += $summazadol;
			}
		}


		$table->addRow(350, $_TBL_BODYStyle_Row);
		if ($_ROW_docbase['kodshab'] == 0) {
			$table->addCell(8000, $_TBL_BODYStyle_CellSpan6_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по счету', $_TBL_BODYFont_Title_H2_1);
		} else {
			$table->addCell(8000, $_TBL_BODYStyle_CellSpan6_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по договору', $_TBL_BODYFont_Title_H2_1);
		}
		$table->addCell(2000, $_TBL_BODYStyle_CellSpan2_1)->addTextRun($_TBL_CELLAlign_H_Right)->addText(number_format($_SUM_summazadol_doc, 2, '.', ' ') . $_DENED, $_TBL_BODYFont_Title_H2_2);

		$_SUM_summazadol_zakaz += $_SUM_summazadol_doc;
	}

	$table->addRow(450, $_TBL_BODYStyle_Row);
	$table->addCell(6000, $_TBL_BODYStyle_CellSpan6_2)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по Заказчику', $_TBL_BODYFont_Title_H1_1);
	$table->addCell(4000, $_TBL_BODYStyle_CellSpan2_2)->addTextRun($_TBL_CELLAlign_H_Right)->addText(number_format($_SUM_summazadol_zakaz, 2, '.', ' ') . $_DENED, $_TBL_BODYFont_Title_H1_2);
}








//$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord,'Word2007');
//$objWriter->save('doc.docx');

/*
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="first.docx"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
*/


$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
// $xmlWriter->save("php://output");
$filepath = $_SERVER['DOCUMENT_ROOT'] . "/dognet/tmp/";
$filename = "SPRAVKA-ZADOLCHF_" . $_SESSION['id'] . "_" . date('YmdHis') . ".DOCX";
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
		i = 5;
		document.getElementById("time").innerHTML = i;
		timer = setInterval(function() {
			document.getElementById("time").innerHTML = i--;

			host = '<?php echo $_SERVER["HTTP_HOST"]; ?>';
			url1 = 'http://' + host + '/dognet/dognet-report.php';
			url2 = 'http://' + host + '/dognet/dognet-report.php?reportview=zadolchf&export=yes';
			if (i < 0) {
				clearInterval(timer);
				document.getElementById("link").innerHTML = "<div class='space20'><span style='padding:0 15px'><a class='return-link' href=" + url1 + ">Вернуться в Отчеты</a></span></div><div class='space20'><span style='padding:0 15px'><a class='return-link' href=" + url2 + ">Новый экспорт</a></span></div>";
			}
		}, 1000);
	}
	countDown();
</script>