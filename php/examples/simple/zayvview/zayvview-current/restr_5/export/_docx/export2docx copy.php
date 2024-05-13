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
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_connection.php");
require_once($_SERVER['DOCUMENT_ROOT']."/_assets/drivers/db_controller.php");
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
require ($_SERVER['DOCUMENT_ROOT']."/dognet/_assets/_PHPOffice/vendor/autoload.php");


$phpWord = new  \PhpOffice\PhpWord\PhpWord();

$phpWord->setDefaultFontName('Arial');
$phpWord->setDefaultFontSize(10);

$properties = $phpWord->getDocInfo();

$properties->setCreator("АТГС.Портал");
$properties->setCompany('АТГС');
$properties->setTitle('Справка о задолженности по субподрядчикам');
$properties->setDescription('Справка о задолженности по субподрядчикам');
$properties->setCategory('Отчеты');
$properties->setLastModifiedBy('АТГС.Портал');
$properties->setCreated(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setModified(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setSubject('Справка о задолженности по субподрядчикам');
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
$table = $header->addTable(array( 'width' => 100 * 50, 'unit' => "pct", 'borderBottomSize'=>10, 'borderBottomColor'=>"C0C0C0", 'cellMarginBottom' => 100, 'valign' => "top" ));
$table->addRow();
$cell = $table->addCell();
$textrun = $cell->addTextRun();
// Оформляем содержимое таблицы в header
$textrun->addText('Справка о задолженности', array('name' => "Arial", 'size' => 12, 'color' => '333333', 'allCaps' => true, 'bold' => true));
//
$cell = $table->addCell();
$textrun = $cell->addTextRun(array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));
$textrun->addText('по субподрядчикам', array('name' => "Arial", 'size' => 12, 'italic' => true));
#
# ::::: НИЖНИЙ КОЛОНТИТУЛ (FOOTER)
#
$footer = $section->addFooter();
// Вставляем таблицу в верхний колонтитул (header)
$table = $footer->addTable(array( 'width' => 100 * 50, 'unit' => "pct", 'borderTopSize'=>10, 'borderTopColor'=>"C0C0C0", 'cellMarginTop' => 100 ));
$table->addRow();
$cell = $table->addCell();
$textrun = $cell->addTextRun();
// Оформляем содержимое таблицы в header
$textrun->addText($_SESSION["current_user_firstname"]." ".$_SESSION["current_user_lastname"], array('name' => "Arial", 'size' => 8, 'color' => '333333', 'allCaps' => true));
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
$section->addTitle('Справка о задолженностях по субподрядчикам', 2);
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
$_TBL_BODYStyle_CellSpan4_1 = array(
	'valign' => 'center',
	'gridSpan' => 4,
	'bgColor' => 'F1F1F1',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan4_2 = array(
	'valign' => 'center',
	'gridSpan' => 4,
	'bgColor' => '111111',
	'borderBottomColor' => "111111",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan4_3 = array(
	'valign' => 'center',
	'gridSpan' => 4,
	'bgColor' => 'FAFAFA',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan4_4 = array(
	'valign' => 'center',
	'gridSpan' => 4,
	'bgColor' => 'D0D0D0',
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2
);
$_TBL_BODYStyle_CellSpan3_1 = array(
	'valign' => 'center',
	'gridSpan' => 3,
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
$_TBL_BODYStyle_CellSpan2_3 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'bgColor' => 'F1F1F1',
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
// -----
// Оформляем строку ИТОГО ПО СЧЕТУ
$_TBL_BODYStyle_CellItogo_1 = array(
	'valign' => 'center',
	'gridSpan' => 2,
	'borderBottomColor' => "999999",
	'borderBottomSize' => 2,
	'borderRightColor' => "999999",
	'borderRightSize' => 2
);
$_TBL_BODYFont_Itogo_8 = array('name' => "Arial", 'allcaps' => true, 'bold' => true, 'size' => 8, 'color' => "333333");
$_TBL_BODYFont_Itogo_8_Red = array('name' => "Arial", 'bold' => true, 'size' => 8, 'color' => "c30606");
$_TBL_BODYFont_Itogo_8_Green = array('name' => "Arial", 'bold' => true, 'size' => 8, 'color' => "369803");
$_TBL_BODYFont_Itogo_9 = array('name' => "Arial", 'allcaps' => true, 'bold' => true, 'size' => 9, 'color' => "333333");
$_TBL_BODYFont_Itogo_10 = array('name' => "Arial", 'allcaps' => true, 'bold' => true, 'size' => 10, 'color' => "333333");
// -----
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
#
#
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Общее количество субподрядных организаций
	$_QRY_SUBDOC_A = mysqlQuery( "SELECT DISTINCT kodsubpodr FROM dognet_docsubpodr WHERE koddel <> '99'" );
	$_ROW_SUBDOC_A = mysqli_fetch_assoc($_QRY_SUBDOC_A);
	$_qty_subdocA = mysqli_num_rows($_QRY_SUBDOC_A);

// Общее количество субподрядных организаций, перед которыми есть задолженность
	$_QRY_SUBDOC_B = mysqlQuery( "SELECT DISTINCT kodsubpodr FROM dognet_docsubpodr WHERE koddel <> '99' AND sumzadolsubpodr > 0.00" );
	$_ROW_SUBDOC_B = mysqli_fetch_assoc($_QRY_SUBDOC_B);
	$_qty_subdocB = mysqli_num_rows($_QRY_SUBDOC_B);

// Общее количество договоров
	$_QRY_SUBDOC1 = mysqlQuery( "SELECT * FROM dognet_docsubpodr WHERE koddel <> '99'" );
	$_ROW_SUBDOC1 = mysqli_fetch_assoc($_QRY_SUBDOC1);
	$_qty_subdoc1 = mysqli_num_rows($_QRY_SUBDOC1);

// Из них с задолженностью
	$_QRY_SUBDOC2 = mysqlQuery( "SELECT * FROM dognet_docsubpodr WHERE koddel <> '99' AND sumzadolsubpodr > 0.00" );
	$_ROW_SUBDOC2 = mysqli_fetch_assoc($_QRY_SUBDOC2);
	$_qty_subdoc2 = mysqli_num_rows($_QRY_SUBDOC2);

// Из них не закрытых
	$_QRY_SUBDOC3 = mysqlQuery( "SELECT koddocsubpodr, sumdocsubpodr FROM dognet_docsubpodr WHERE koddel <> '99'" );
	$_qty_subdoc3 = mysqli_num_rows($_QRY_SUBDOC3);
	$_cnt = 0;
	while ($_ROW_SUBDOC3 = mysqli_fetch_assoc($_QRY_SUBDOC3)) {
		$_koddocsubpodr = $_ROW_SUBDOC3['koddocsubpodr'];
		$_sumdocsubpodr = $_ROW_SUBDOC3['sumdocsubpodr'];
		$_QRY_SUBDOC3_1 = mysqlQuery( "SELECT SUM(sumchfsubpodr) as SUM_CHF FROM dognet_docchfsubpodr WHERE koddocsubpodr = ".$_koddocsubpodr." AND koddel <> '99'" );
		$_ROW_SUBDOC3_1 = mysqli_fetch_assoc($_QRY_SUBDOC3_1);
		$_sumchf = $_ROW_SUBDOC3_1['SUM_CHF'];
		if ( ($_sumdocsubpodr != '') && ($_sumdocsubpodr != 0.00) && $_sumdocsubpodr > $_sumchf ) { $_cnt++; }
	}
	$_qty_nezakr = $_cnt;

// Сумма выставленных счетов по всем договорам
	$_QRY_SUBDOC4 = mysqlQuery( "SELECT SUM(sumchfsubpodr) as TOTAL_CHF FROM dognet_docchfsubpodr WHERE koddel <> '99'" );
	$_ROW_SUBDOC4 = mysqli_fetch_assoc($_QRY_SUBDOC4);
	$_total_sumchf = $_ROW_SUBDOC4['TOTAL_CHF'];

// Сумма оплаченных счетов по всем договорам
	$_QRY_SUBDOC5 = mysqlQuery( "SELECT SUM(sumoplchfsubpodr) as TOTAL_OPLCHF FROM dognet_docoplchfsubpodr WHERE koddel <> '99'" );
	$_ROW_SUBDOC5 = mysqli_fetch_assoc($_QRY_SUBDOC5);
	$_total_sumoplchf = $_ROW_SUBDOC5['TOTAL_OPLCHF'];
	$_QRY_SUBDOC6_1 = mysqlQuery( "SELECT SUM(sumavsubpodr) as TOTAL_AVCHF FROM dognet_docavsubpodr WHERE koddel <> '99'" );
	$_ROW_SUBDOC6_1 = mysqli_fetch_assoc($_QRY_SUBDOC6_1);
	$_total_sumavchf = $_ROW_SUBDOC6_1['TOTAL_AVCHF'];
	$_QRY_SUBDOC6_2 = mysqlQuery( "SELECT SUM(sumavsubpodr) as TOTAL_AVOPLCHF FROM dognet_docavsubpodr WHERE koddel <> '99' AND kodchfsubpodr <> ''" );
	$_ROW_SUBDOC6_2 = mysqli_fetch_assoc($_QRY_SUBDOC6_2);
	$_total_sumavoplchf = $_ROW_SUBDOC6_2['TOTAL_AVOPLCHF'];

// Сумма задолженностей по договорам субподряда по столбцу sumzadolsubpodr
	$_QRY_SUBDOC7 = mysqlQuery( "SELECT SUM(sumzadolsubpodr) as TOTAL_ZADOL FROM dognet_docsubpodr WHERE koddel <> '99'" );
	$_ROW_SUBDOC7 = mysqli_fetch_assoc($_QRY_SUBDOC7);
	$_total_zadol_table = $_ROW_SUBDOC7['TOTAL_ZADOL'];

	// Сумма выплаченных авансов и совершенных оплат
	$_total_oplav = $_total_sumoplchf + $_total_sumavchf;
	// Сумма зачтенных авансов и совершенных оплат
	$_total_oplavchf = $_total_sumoplchf + $_total_sumavoplchf;

// Расчетная общая задолженность по счетам
	$_total_zadol_calc = $_total_sumchf - $_total_oplavchf;
	$_itogo_calc = $_total_zadol_calc;

// Табличная общая задолженность по счетам
	$_itogo_table = $_total_zadol_table;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$TableStyleName_Common = 'Common Table';
$phpWord->addTableStyle($TableStyleName_Common, $_TBL_TABLEStyle, $_TBL_HEADERStyle_Row);
$table = $section->addTable($TableStyleName_Common);
$table->addRow(600, $_TBL_HEADERStyle_Row);
$table->addCell(9000, $_TBL_HEADERStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Вид задолженности', $_TBL_HEADERFont);
$table->addCell(4000, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Итого по договорам', $_TBL_HEADERFont);
$table->addCell(4000, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Итого по счетам', $_TBL_HEADERFont);

		    $table->addRow(450, $_TBL_BODYStyle_Row);
				$table->addCell(9000, $_TBL_BODYStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Текущая', $_TBL_BODYFont_2);
				$table->addCell(4000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText("---", $_TBL_BODYFont_2);
				$table->addCell(4000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText("---", $_TBL_BODYFont_2);

		    $table->addRow(450, $_TBL_BODYStyle_Row);
				$table->addCell(9000, $_TBL_BODYStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Судебная', $_TBL_BODYFont_2);
				$table->addCell(4000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText("---", $_TBL_BODYFont_2);
				$table->addCell(4000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText("---", $_TBL_BODYFont_2);

		    $table->addRow(450, $_TBL_BODYStyle_Row);
				$table->addCell(9000, $_TBL_BODYStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Невозвратная', $_TBL_BODYFont_2);
				$table->addCell(2000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText("---", $_TBL_BODYFont_2);
				$table->addCell(2000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText("---", $_TBL_BODYFont_2);

		    $table->addRow(450, $_TBL_BODYStyle_Row);
				$table->addCell(9000, $_TBL_BODYStyle_Cell_Itogo_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('ИТОГО ВСЕГО', $_TBL_BODYFont_H1_1);
				$table->addCell(2000, $_TBL_BODYStyle_Cell_Itogo_1)->addTextRun($_TBL_CELLAlign_H_Center)->addText("---", $_TBL_BODYFont_H1_1);
				$table->addCell(2000, $_TBL_BODYStyle_Cell_Itogo_1)->addTextRun($_TBL_CELLAlign_H_Center)->addText("---", $_TBL_BODYFont_H1_1);
//
//
$section->addText("", null, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'spaceBefore' => 90, 'spaceAfter' => 240));
//
//
$section->addText("Далее приведен список компаний-плательщиков, со стороны которых по выставленным счетам-фактурам имеются задолженности.",
    null,
    array('widowControl' => false, 'indentation' => array('left' => 240, 'right' => 0), 'spaceBefore' => 90, 'spaceAfter' => 90)
);
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
$_queryStr = "SELECT * FROM dognet_spsubpodr WHERE kodsubpodr IN (SELECT kodsubpodr FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99') ORDER BY namesubpodrshot ASC";
	if (checkUserRestrictions($_SESSION['id'],'dognet',5,1)==1) {
		echo "SQL-запрос (субподрядчик): ";
		echo $_queryStr;
		echo "<br>";
	}
	$_QRY = mysqlQuery($_queryStr);
#
#
#
$fancyTableStyleName1 = 'Main Table';
$phpWord->addTableStyle($fancyTableStyleName1, $_TBL_TABLEStyle, $_TBL_HEADERStyle_Row);
$table = $section->addTable($fancyTableStyleName1);
$table->addRow(450, $_TBL_HEADERStyle_Row);
$table->addCell(6000, $_TBL_HEADERStyle_CellLeft)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Организация / Договор / Этап / Субподряд / Счет-фактура', $_TBL_HEADERFont);
$table->addCell(500, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Дата', $_TBL_HEADERFont);
$table->addCell(1750, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Сумма договора / счета', $_TBL_HEADERFont);
$table->addCell(1750, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Сумма аванса / оплаты', $_TBL_HEADERFont);
#
#
#
while($_ROW = mysqli_fetch_assoc($_QRY)) {
#
#
#
    $table->addRow(450, $_TBL_BODYStyle_Row);
    $table->addCell(10000, $_TBL_BODYStyle_CellSpan4_2)->addTextRun($_TBL_CELLAlign_H_Left)->addText($_ROW['namesubpodrshot'], $_TBL_BODYFont_H1_2);




	$_queryStr = "SELECT * FROM dognet_docbase WHERE koddoc IN (SELECT koddoc FROM dognet_dockalplan WHERE kodkalplan IN (SELECT koddoc FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."'))";




	$_QRY_docbase = mysqlQuery($_queryStr);








$_SUM_summazadol_zakaz = 0.00;
$_DENED = "";





	while($_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase)) {

		$_QRY_dened = mysqlQuery( "SELECT * FROM dognet_spdened WHERE koddened='".$_ROW_docbase['koddened']."'" );
		$_ROW_dened = mysqli_fetch_assoc($_QRY_dened);
// 		$_DENED = $_ROW_dened['short_code'];
		if ($_QRY_dened) {
			$_DENED = html_entity_decode($_ROW_dened['short_code']);
		}
		else {
			$_DENED = " -.";
		}

$_SUM_chetfsumma = 0.00;
$_SUM_summaoplav = 0.00;
$_SUM_summaopl = 0.00;
$_SUM_summazadol_doc = 0.00;

    $table->addRow(300, $_TBL_BODYStyle_Row);
		if ($_ROW_docbase['kodshab']==0) {
	    $table->addCell(6500, $_TBL_BODYStyle_CellSpan2_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Счет №'.$_ROW_docbase['docnumber'], $_TBL_BODYFont_H2_1);
	  }
	  else {
	    $table->addCell(6500, $_TBL_BODYStyle_CellSpan2_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Договор №3-4/'.$_ROW_docbase['docnumber'], $_TBL_BODYFont_H2_1);
	  }
		$table->addCell(1750, $_TBL_BODYStyle_Cell_63)->addTextRun($_TBL_CELLAlign_H_Center)->addText("", $_TBL_BODYFont_H2_1);
		$table->addCell(1750, $_TBL_BODYStyle_Cell_63)->addTextRun($_TBL_CELLAlign_H_Center)->addText("", $_TBL_BODYFont_H2_1);


if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) {
		$_QRY_dockalplan_Str = "SELECT * FROM dognet_dockalplan WHERE koddel<>'99' AND koddoc='".$_ROW_docbase['koddoc']."' AND kodkalplan IN (SELECT koddoc FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."')";
}
if (($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) {
		$_QRY_dockalplan_Str = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND numberchet='' AND koddoc='".$_ROW_docbase['koddoc']."' AND (kodshab='2' OR kodshab='4')";
}
if ($_ROW_docbase['kodshab']==0) {
		$_QRY_dockalplan_Str = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND numberchet<>'' AND koddoc='".$_ROW_docbase['koddoc']."' AND kodshab='0'";
}


$_QRY_dockalplan = mysqlQuery($_QRY_dockalplan_Str);


		while($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {

			if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) { $_SROKOPL = $_ROW_dockalplan['srokopl']; }
			elseif (($_ROW_docbase['kodshab']==0)OR($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) { $_SROKOPL = $_ROW_docbase['srokdoc']; }


    $table->addRow(300, $_TBL_BODYStyle_Row);
			if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) {
		    $table->addCell(10000, $_TBL_BODYStyle_CellSpan4_3)->addText('Этап '.$_ROW_dockalplan['numberstage']." : ".$_ROW_dockalplan['nameshotstage'], $_TBL_BODYFont);
			}
			elseif (($_ROW_docbase['kodshab']==0)OR($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) {
		    $table->addCell(10000, $_TBL_BODYStyle_CellSpan4_3)->addText('Без этапа', $_TBL_BODYFont);
			}
#
#
# ДОГОВОРА СУБПОДРЯДА
# LVL 4 ::: BEGIN
# Эстафетный параметр - идентификатор этапа (kodkalplan)
#
/*
!!!!!
В таблице договоров субподряда поле koddoc может содержать как идентификатор договора (koddoc) из таблицы dognet_docbase (для договоров без календарного плана), так и идентификатор этапа (kodkalplan) из таблицы dognet_dockalplan (для договоров с календарным планом).
!!!!!
*/
#
# Все договора субподряда из таблицы 'dognet_docsubpodr', в которых
# 	- есть задолженность (sumzadolsubpodr<>'0.00')
#		- не исключены из выборки (koddel<>'99')
# 	- в которых идентификатор попадает в выборку данного этапа - $_ROW_dockalplan['kodkalplan']
#
#			>
			$_QRY_docsubpodr_Str = "SELECT * FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND koddoc='".$_ROW_dockalplan['kodkalplan']."' AND kodsubpodr='".$_ROW['kodsubpodr']."'";
			$_QRY_docsubpodr = mysqlQuery($_QRY_docsubpodr_Str);
// Запускаем цикл
			while($_ROW_docsubpodr = mysqli_fetch_assoc($_QRY_docsubpodr)) {
// Формируем строку
		    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
				if ($_ROW_docsubpodr['numberdocsubpodr']!="") {
					$table->addCell(10000, $_TBL_BODYStyle_CellSpan4_3)->addText('Договор субподряда № '.$_ROW_docsubpodr['numberdocsubpodr'], $_TBL_BODYFont);
				}
				else {
					$table->addCell(10000, $_TBL_BODYStyle_CellSpan4_3)->addText('Номер договора субподряда отсутствует или не задан', $_TBL_BODYFont);
				}
#
#
# СЧЕТА-ФАКТУРЫ
# LVL 5 ::: BEGIN
# Эстафетный параметр - идентификатор договора субподряда (koddocsubpodr)
# Все счета-фатуры к договорам субподряда из таблицы 'dognet_docchfsubpodr', в которых
# 	- есть задолженность (sumzadolsubpodr<>'0.00')
#		- не исключены из выборки (koddel<>'99')
# 	- в которых идентификатор попадает в выборку данного этапа - $_ROW_dockalplan['kodkalplan']
#
#				>
				$_QRY_docchfsubpodr_Str = "SELECT * FROM dognet_docchfsubpodr WHERE koddel<>'99' AND koddocsubpodr='".$_ROW_docsubpodr['koddocsubpodr']."' AND sumzadolchfsubpodr<>'0.00'";
				$_QRY_docchfsubpodr = mysqlQuery($_QRY_docchfsubpodr_Str);
// Обнуляем счетчик сумм выставленных счетов-фактур по договору субподряда
					$_SUM_sumchfsubpodr = 0.0;
// Запускаем цикл
				while($_ROW_docchfsubpodr = mysqli_fetch_assoc($_QRY_docchfsubpodr)) {
// Формируем строку
			    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
					$table->addCell(6000, $_TBL_BODYStyle_Cell)->addText('Счет-фактура №'.$_ROW_docchfsubpodr['numberchfsubpodr'], $_TBL_BODYFont);
					$table->addCell(500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_docchfsubpodr['datechfsubpodr'], $_TBL_BODYFont);
					$table->addCell(1750, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_docchfsubpodr['sumchfsubpodr'], $_TBL_BODYFont);
					$table->addCell(1750, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);

#
#
# ОПЛАТЫ И АВАНСЫ
# LVL 6 ::: BEGIN
# Эстафетный параметр - идентификатор счета-фактуры (kodchfsubpodr)
# Все оплаты и авансы по счетам-фатурам из таблицы 'dognet_reports_zadolsub_chfincoming', в которых
#
#
#
#
#					>
					$_QRY_chfincoming_Str = "SELECT * FROM dognet_reports_zadolsub_chfincoming WHERE kodchfsubpodr='".$_ROW_docchfsubpodr['kodchfsubpodr']."' AND (type_incoming='1' OR type_incoming='2')";
					$_QRY_chfincoming = mysqlQuery($_QRY_chfincoming_Str);
					if (mysqli_num_rows($_QRY_chfincoming) <= 0) {
// Формируем строку
				    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
						$table->addCell(10000, $_TBL_BODYStyle_CellSpan4_3)->addText('Оплат и авансов не поступало', $_TBL_BODYFont);
					}
// Обнуляем счетчик суммы оплат и авансов по счетам-фактурам
					$_SUM_incoming = 0.0;
// Запускаем цикл
					while($_ROW_chfincoming = mysqli_fetch_assoc($_QRY_chfincoming)) {
						if ($_ROW_chfincoming['type_incoming']=='1') {
// Формируем строку
					    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
							$table->addCell(6000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Left)->addText('', $_TBL_BODYFont);
							$table->addCell(2500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_chfincoming['date_incoming'], $_TBL_BODYFont);
							$table->addCell(2500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Оплата', $_TBL_BODYFont);
							$table->addCell(2500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_chfincoming['sum_incoming'], $_TBL_BODYFont);
						}
						elseif ($_ROW_chfincoming['type_incoming']=='2') {
// Формируем строку
					    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
							$table->addCell(6000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Left)->addText('', $_TBL_BODYFont);
							$table->addCell(2500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_chfincoming['date_incoming'], $_TBL_BODYFont);
							$table->addCell(2500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Оплата', $_TBL_BODYFont);
							$table->addCell(2500, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_chfincoming['sum_incoming'], $_TBL_BODYFont);
						}
// Суммируем оплаты и авансы по счету
						$_SUM_incoming += $_ROW_chfincoming['sum_incoming'];
					}
# LVL6 ::: END
// Задолженность по счету-фактуре (разность суммы счета и поступлений - авансов и оплат)
					$_ZADOL_CHF = $_ROW_docchfsubpodr['sumchfsubpodr'] - $_SUM_incoming;
//
// Формируем строку итого для счета
			    $table->addRow(300, $_TBL_BODYStyle_Row);
					$table->addCell(6500, $_TBL_BODYStyle_CellItogo_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по счету', $_TBL_BODYFont_Itogo_8);
					if ($_ZADOL_CHF == 0) {
						$table->addCell(1750, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ZADOL_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Itogo_8);
					}
					else {
						$table->addCell(1750, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ZADOL_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Itogo_8_Red);
					}
					$table->addCell(1750, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_SUM_incoming, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Itogo_8);
// Суммируем счета-фактуры по договору субподряда
					$_SUM_sumchfsubpodr += $_ROW_docchfsubpodr['sumchfsubpodr'];
				}
# LVL5 ::: END
// Задолженность по договору субподряда
				$_ZADOL_DOCSUB = $_ROW_docsubpodr['sumdocsubpodr'] - $_SUM_sumchfsubpodr;
//
// Формируем строку итого для договора субподряда
			    $table->addRow(300, $_TBL_BODYStyle_Row);
					$table->addCell(6500, $_TBL_BODYStyle_CellItogo_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по договору субподряда', $_TBL_BODYFont_Itogo_8);
					$table->addCell(1750, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_SUM_sumchfsubpodr, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Itogo_8);
					$table->addCell(1750, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ZADOL_DOCSUB, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Itogo_8);
			}
# LVL4 ::: END

		}


	    $table->addRow(350, $_TBL_BODYStyle_Row);
		if ($_ROW_docbase['kodshab']==0) {
	    $table->addCell(6500, $_TBL_BODYStyle_CellSpan2_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по счету', $_TBL_BODYFont_Title_H2_1);
	  }
	  else {
	    $table->addCell(6500, $_TBL_BODYStyle_CellSpan2_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по основному договору', $_TBL_BODYFont_Title_H2_1);
	  }
			$table->addCell(3500, $_TBL_BODYStyle_CellSpan2_1)->addTextRun($_TBL_CELLAlign_H_Right)->addText(number_format($_SUM_summazadol_doc, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H2_2);

			$_SUM_summazadol_zakaz += $_SUM_summazadol_doc;

	}

	    $table->addRow(450, $_TBL_BODYStyle_Row);
	    $table->addCell(6500, $_TBL_BODYStyle_CellSpan2_2)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по Субподрядчику', $_TBL_BODYFont_Title_H1_1);
			$table->addCell(3500, $_TBL_BODYStyle_CellSpan2_2)->addTextRun($_TBL_CELLAlign_H_Right)->addText(number_format($_SUM_summazadol_zakaz, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H1_2);

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
$filepath = $_SERVER['DOCUMENT_ROOT']."/dognet/tmp/";
$filename = "SPRAVKA-ZADOLCHF_".$_SESSION['id']."_".date('YmdHis').".DOCX";
$xmlWriter->save($filepath.$filename);
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
.return-link, .format-selected { font-family:'Oswald', sans-serif; font-size:1.0em; font-weight:300; text-transform:uppercase }
.return-link { color:#999 }
a.return-link, a.format-selected { text-decoration:underline }
a.return-link:hover, a.format-selected:hover { text-decoration:none }
</style>

<div id="link">
	<div class="">
		<a class="format-selected" href="http://<?php echo $_SERVER['HTTP_HOST'].'/dognet/tmp/'.$filename; ?>"><?php echo $filename; ?></a>
	</div>
	<div class="circles">
		<div class="circle">
			<div class="circle_number"><span id="time"></span></div>
		</div>
	</div>
</div>

<script type="text/javascript">
var timer;
function countDown(){
	//время в сек.
		i = 5;
		document.getElementById("time").innerHTML = i;
		timer = setInterval(function(){
			document.getElementById("time").innerHTML = i--;

			host = '<?php echo $_SERVER["HTTP_HOST"]; ?>';
			url1 = 'http://'+host+'/dognet/dognet-report.php';
			url2 = 'http://'+host+'/dognet/dognet-report.php?reportview=zadolchf&export=yes';
			if (i < 0) {
				clearInterval(timer);
				document.getElementById("link").innerHTML = "<div class='space20'><span style='padding:0 15px'><a class='return-link' href="+url1+">Вернуться в Отчеты</a></span></div><div class='space20'><span style='padding:0 15px'><a class='return-link' href="+url2+">Новый экспорт</a></span></div>";
			}
		}, 1000);
}
countDown();

</script>


