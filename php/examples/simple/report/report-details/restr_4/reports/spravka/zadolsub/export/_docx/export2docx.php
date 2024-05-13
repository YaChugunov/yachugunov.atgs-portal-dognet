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
$textrun->addText('Справка о задолженности', array('name' => "Arial", 'size' => 10, 'color' => '333333', 'allCaps' => true, 'bold' => true));
//
$cell = $table->addCell();
$textrun = $cell->addTextRun(array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));
$textrun->addText('По субподрядчикам', array('name' => "Arial", 'size' => 10, 'italic' => true));
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
$textrun->addText($_SESSION["current_user_firstname"]." ".$_SESSION["current_user_lastname"], array('name' => "Arial", 'size' => 6, 'color' => '333333', 'allCaps' => true));
$textrun->addTextBreak();
$textrun->addText(date('d.m.Y H:i:s'), array('name' => "Arial", 'size' => 6, 'color' => '333333'));
//
// Вставляем лого в среднюю ячейку
$cell = $table->addCell();
// $cell->addImage('logo_dognet.png', array('height' => 25, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
//
//
$table->addCell()->addPreserveText('Страница {PAGE} из {NUMPAGES}', array('name' => "Arial", 'size' => 6, 'color' => '333333', 'allCaps' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$phpWord->addTitleStyle(1, array('name' => "Arial", 'size' => 16, 'bold' => true), array('spaceAfter' => 320));
$phpWord->addTitleStyle(2, array('name' => "Arial", 'size' => 14, 'bold' => true), array('spaceAfter' => 320));
$phpWord->addTitleStyle(3, array('name' => "Arial", 'size' => 12, 'bold' => true), array('spaceAfter' => 240));
$section->addTitle('Справка о задолженностях по субподрядчикам', 2);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ПОДКЛЮЧАЕМ СТИЛИ ОФОРМЛЕНИЯ
#
require ($_SERVER['DOCUMENT_ROOT']."/dognet/php/examples/simple/report/report-details/restr_5/reports/spravka/zadolsub/export/_docx/export2docx_styles.inc.php");
#
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
$fancyTableStyleName = 'Common Table';
$phpWord->addTableStyle($fancyTableStyleName, $_TBL_TABLEStyle_Common, $_TBL_HEADERStyle_Row);
$fancyTableStyleName_Inner = 'Inner Table';
$phpWord->addTableStyle($fancyTableStyleName_Inner, $_TBL_TABLEStyle_Inner, $_TBL_HEADERStyle_Row);
#
$tableCmn = $section->addTable($fancyTableStyleName);
#
$tableCmn->addRow(550, $_TBL_HEADERStyle_Row);
#
#
#
$tableCmn->addCell(10000, $_TBL_HEADERStyle_Cell_Common)->addTextRun($_TBL_CELLAlign_H_Center)->addText('ДОГОВОРА', $_TBL_HEADERFont_Common);
$tableCmn->addCell(10000, $_TBL_HEADERStyle_Cell_Common)->addTextRun($_TBL_CELLAlign_H_Center)->addText('СЧЕТА И ОПЛАТА', $_TBL_HEADERFont_Common);
#
#
#
$cell = $tableCmn->addRow(450, $_TBL_BODYStyle_Row)->addCell();
#
$innerTable = $cell->addTable($fancyTableStyleName_Inner);
#
$innerTable->addRow(350, $_TBL_BODYStyle_Row);
$innerTable->addCell(9000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Общее количество субподрядных организаций', $_TBL_BODYFont_Common);
$innerTable->addCell(1000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_qty_subdocA, $_TBL_BODYFont_Common_B);
#
$innerTable->addRow(350, $_TBL_BODYStyle_Row);
$innerTable->addCell(9000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText('- из них с задолженностью', $_TBL_BODYFont_Common_Small);
$innerTable->addCell(1000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_qty_subdocB, $_TBL_BODYFont_Common_Small);
#
$innerTable->addRow(350, $_TBL_BODYStyle_Row);
$innerTable->addCell(9000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Общее количество договоров', $_TBL_BODYFont_Common);
$innerTable->addCell(1000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_qty_subdoc1, $_TBL_BODYFont_Common_B);
#
$innerTable->addRow(350, $_TBL_BODYStyle_Row);
$innerTable->addCell(9000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText('- из них с задолженностью', $_TBL_BODYFont_Common_Small);
$innerTable->addCell(1000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_qty_subdoc2, $_TBL_BODYFont_Common_Small);
#
$innerTable->addRow(350, $_TBL_BODYStyle_Row);
$innerTable->addCell(9000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText('- из них незакрытых', $_TBL_BODYFont_Common_Small);
$innerTable->addCell(1000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_qty_nezakr, $_TBL_BODYFont_Common_Small);


$cell = $tableCmn->addCell();

$innerTable = $cell->addTable($fancyTableStyleName_Inner);
#
$innerTable->addRow(350, $_TBL_BODYStyle_Row);
$innerTable->addCell(7000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Всего выставлено счетов на сумму', $_TBL_BODYFont_Common);
$innerTable->addCell(3000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText(number_format($_total_sumchf, 2, '.', ' '), $_TBL_BODYFont_Common_B);
#
$innerTable->addRow(350, $_TBL_BODYStyle_Row);
$innerTable->addCell(7000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Всего оплачено счетов на сумму', $_TBL_BODYFont_Common);
$innerTable->addCell(3000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText(number_format($_total_sumoplchf, 2, '.', ' '), $_TBL_BODYFont_Common_B);
#
$innerTable->addRow(350, $_TBL_BODYStyle_Row);
$innerTable->addCell(7000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Всего выплачено авансов на сумму', $_TBL_BODYFont_Common);
$innerTable->addCell(3000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText(number_format($_total_sumavchf, 2, '.', ' '), $_TBL_BODYFont_Common_B);
#
$innerTable->addRow(350, $_TBL_BODYStyle_Row);
$innerTable->addCell(7000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText('- из нее зачтено', $_TBL_BODYFont_Common_Small);
$innerTable->addCell(3000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText(number_format($_total_sumavoplchf, 2, '.', ' '), $_TBL_BODYFont_Common_Small);
#
$innerTable->addRow(350, $_TBL_BODYStyle_Row);
$innerTable->addCell(7000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого закрыто по счетам', $_TBL_BODYFont_Common);
$innerTable->addCell(3000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Left)->addText(number_format($_total_oplavchf, 2, '.', ' '), $_TBL_BODYFont_Common_B);
#
#
#
$section->addText("", null, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'spaceBefore' => 90, 'spaceAfter' => 240));
$section->addTitle('Итоговая задолженность (расчетная): '.number_format($_itogo_calc, 2, '.', ' '), 3);
#
$section->addTitle('Итоговая задолженность (табличная): '.number_format($_itogo_table, 2, '.', ' '), 3);
# number_format($_itogo_calc, 2, '.', ' ')
# number_format($_itogo_table, 2, '.', ' ')
#
$section->addText("Далее приведен список компаний-плательщиков, со стороны которых по выставленным счетам-фактурам имеются задолженности.",
    null,
    array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'spaceBefore' => 90, 'spaceAfter' => 90)
);
#
#
#
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

$table->addCell(9000, $_TBL_BODYStyle_CellLeft_Grid5_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Организация / Договор / Этап / Субподряд / Счет-фактура', $_TBL_HEADERFont);
$table->addCell(2000, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Дата', $_TBL_HEADERFont);
$table->addCell(3000, $_TBL_HEADERStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Сумма ( Договор / Счёт )', $_TBL_HEADERFont);
$table->addCell(3000, $_TBL_HEADERStyle_CellRight)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Сумма ( Аванс / Оплата )', $_TBL_HEADERFont);
$table->addCell(3000, $_TBL_HEADERStyle_CellRight)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Задолженность', $_TBL_HEADERFont);
#
$_ZADOL_SUB = 0.00;
$_SUM_SUB_CHF = 0.00;
$_SUM_SUB_INCOMING = 0.00;
#
# Запускаем цикл LVL 1
while($_ROW = mysqli_fetch_assoc($_QRY)) {
#
# ::: Выводим название компании-субподрядчика
  $table->addRow(450, $_TBL_BODYStyle_Row);
  $table->addCell(20000, $_TBL_BODYStyle_Cell_Grid9_2)->addTextRun($_TBL_CELLAlign_H_Left)->addText($_ROW['namesubpodrshot'], $_TBL_BODYFont_H1_2);
#
# ::::: LVL 2
#
# ЗАПРОС : Определяем набор основных договоров для которых имеются этапы (koddoc IN dognet_dockalplan), для выполнения которых заключались договора-субподряда (kodkalplan IN dognet_docsubpodr) с организациями выбранными в запросе LVL 1 (kodsubpodr='".$_ROW['kodsubpodr']), по которым имеются задолженности (sumzadolsubpodr<>'0.00')
#
$_MAINDOC_EXIST=0;
	$_queryStr = "SELECT * FROM dognet_docbase WHERE koddoc IN (SELECT koddoc FROM dognet_dockalplan WHERE kodkalplan IN (SELECT koddoc FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."'))";
	$_QRY_docbase = mysqlQuery($_queryStr);
	if (mysqli_num_rows($_QRY_docbase)>0) { $_MAINDOC_EXIST=1; }
	else { $_MAINDOC_EXIST=0; }





# --- ЕСЛИ СУЩЕСТВУЕТ ОСНОВНОЙ ДОГОВОР
if ( $_MAINDOC_EXIST == 1 ) {
#
# Обнуляем счетчики и локальные переменные
	$_ZADOL_DOC = 0.0;
	$_SUM_DOCS_CHF = 0.0;
	$_SUM_DOCS_INCOMING = 0.0;
	$_DENED = "";
#
#
# Запускаем цикл LVL 2
	while($_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase)) {
#
# Определяем валюту договора
		$_QRY_dened = mysqlQuery( "SELECT * FROM dognet_spdened WHERE koddened='".$_ROW_docbase['koddened']."'" );
		$_ROW_dened = mysqli_fetch_assoc($_QRY_dened);
		if ($_QRY_dened) {
			$_DENED = html_entity_decode($_ROW_dened['short_code']);
		}
		else {
			$_DENED = " -.";
		}
#
# ::: Выводим номер и название договора/счета
    $table->addRow(300, $_TBL_BODYStyle_Row);
//
		if ($_ROW_docbase['kodshab']==0) {
	    $table->addCell(20000, $_TBL_BODYStyle_Cell_Grid9_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Счет №'.$_ROW_docbase['docnumber'], $_TBL_BODYFont_H2_1);
	  }
	  else {
	    $table->addCell(20000, $_TBL_BODYStyle_Cell_Grid9_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Договор № 3-4/'.$_ROW_docbase['docnumber']." : ".$_ROW_docbase['docnameshot'], $_TBL_BODYFont_H2_1);
	  }
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
# Если шаблон документа предполагает договор с календарным планом, то обращаемся к таблице календарных планов по идентификатору этапа
if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) {
		$_QRY_dockalplan_Str = "SELECT * FROM dognet_dockalplan WHERE koddel<>'99' AND koddoc='".$_ROW_docbase['koddoc']."' AND kodkalplan IN (SELECT koddoc FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."')";
}
# Если шаблон документа предполагает договор без календарного плана, то обращаемся к таблице основных договоров по идентификатору основного договора
if (($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) {
		$_QRY_dockalplan_Str = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND numberchet='' AND koddoc='".$_ROW_docbase['koddoc']."' AND (kodshab='2' OR kodshab='4') AND koddoc IN (SELECT koddoc FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."')";
}
# Если шаблон документа это счет (numberchet<>''), то обращаемся к таблице основных договоров также по идентификатору основного договора
if ($_ROW_docbase['kodshab']==0) {
		$_QRY_dockalplan_Str = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND numberchet<>'' AND koddoc='".$_ROW_docbase['koddoc']."' AND kodshab='0' AND koddoc IN (SELECT koddoc FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."')";
}
$_QRY_dockalplan = mysqlQuery($_QRY_dockalplan_Str);
#
#
# Обнуляем счетчик
	// Сумма всех выставленных счетов-фактур по этапу
		$_ZADOL_DOCSSUB = 0.0;
		$_SUM_DOC_CHF = 0.0;
		$_SUM_DOC_INCOMING = 0.0;
#
#
# Запускаем цикл LVL 3
		while($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {
#
# ::: Выводим номер и название этапа (либо запись о том, что этап не создавался)
	    $table->addRow(300, $_TBL_BODYStyle_Row);
			if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) {
				$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
		    $table->addCell(19750, $_TBL_BODYStyle_Cell_Grid8_0)->addText('Этап '.$_ROW_dockalplan['numberstage']." : ".$_ROW_dockalplan['nameshotstage'], $_TBL_BODYFont_S8_111111);
			}
			elseif (($_ROW_docbase['kodshab']==0)OR($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) {
				$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
		    $table->addCell(19750, $_TBL_BODYStyle_Cell_Grid8_0)->addText('Без этапа', $_TBL_BODYFont_S8I_999999);
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
#
#
# Обнуляем счетчик
		// Сумма всех выставленных счетов-фактур по всем договорам субподряда данного этапа
			$_ZADOL_DOCSUB = 0.0;
			$_SUM_DOCSSUB_CHF = 0.0;
			$_SUM_DOCSSUB_INCOMING = 0.0;
#
#
# Запускаем цикл LVL 4
			while($_ROW_docsubpodr = mysqli_fetch_assoc($_QRY_docsubpodr)) {
			// Формируем строку
		    $table->addRow(300, $_TBL_BODYStyle_Row);
			// Выводим запись
				if ($_ROW_docsubpodr['numberdocsubpodr']!="") {
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(19500, $_TBL_BODYStyle_Cell_Grid7_3)->addText('Договор субподряда № '.$_ROW_docsubpodr['numberdocsubpodr'], $_TBL_BODYFont_S8_111111);
				}
				else {
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(19500, $_TBL_BODYStyle_Cell_Grid7_0)->addText('Номер договора субподряда отсутствует или не задан', $_TBL_BODYFont_S8I_999999);
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
#
#
# Обнуляем счетчик
		// Сумма всех выставленных счетов-фактур по отдельному договору субподряда
			$_ZADOL_CHF = 0.0;
			$_SUM_DOCSUB_CHF = 0.0;
			$_SUM_DOCSUB_INCOMING = 0.0;
#
#
# Запускаем цикл LVL 5
				while($_ROW_docchfsubpodr = mysqli_fetch_assoc($_QRY_docchfsubpodr)) {
// Формируем строку
			    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(8250, $_TBL_BODYStyle_Cell_Grid2_3)->addText('Счет-фактура №'.$_ROW_docchfsubpodr['numberchfsubpodr'], $_TBL_BODYFont_S8_111111);
					$table->addCell(2000, $_TBL_BODYStyle_Cell_Date)->addTextRun($_TBL_CELLAlign_H_Center)->addText(date("d.m.Y", strtotime($_ROW_docchfsubpodr['datechfsubpodr'])), $_TBL_BODYFont);
					$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ROW_docchfsubpodr['sumchfsubpodr'], 2, '.', ' ').$_DENED, $_TBL_BODYFont);
					$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);
					$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);

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
						$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
						$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
						$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
						$table->addCell(19250, $_TBL_BODYStyle_Cell_Grid6_0)->addText('Оплат и авансов не поступало', $_TBL_BODYFont_S8I_999999);
					}
#
# Обнуляем счетчик
				// Сумма всех выставленных счетов-фактур по отдельному договору субподряда
					$_SUM_CHF_INCOMING = 0.0;
#
# Запускаем цикл LVL 6
					while($_ROW_chfincoming = mysqli_fetch_assoc($_QRY_chfincoming)) {
						if ($_ROW_chfincoming['type_incoming']=='1') {
// Формируем строку
					    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(8250, $_TBL_BODYStyle_Cell_Grid2_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Оплата', $_TBL_BODYFont);
							$table->addCell(2000, $_TBL_BODYStyle_Cell_Date)->addTextRun($_TBL_CELLAlign_H_Center)->addText(date("d.m.Y", strtotime($_ROW_chfincoming['date_incoming'])), $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('', $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ROW_chfincoming['sum_incoming'], 2, '.', ' ').$_DENED, $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);
						}
						elseif ($_ROW_chfincoming['type_incoming']=='2') {
// Формируем строку
					    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(9250, $_TBL_BODYStyle_Cell_Grid2_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Аванс', $_TBL_BODYFont);
							$table->addCell(2000, $_TBL_BODYStyle_Cell_Date)->addTextRun($_TBL_CELLAlign_H_Center)->addText(date("d.m.Y", strtotime($_ROW_chfincoming['date_incoming'])), $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('', $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ROW_chfincoming['sum_incoming'], 2, '.', ' ').$_DENED, $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);
						}
// +++ Суммируем оплаты и авансы по счету
						$_SUM_CHF_INCOMING += $_ROW_chfincoming['sum_incoming'];
					}
# LVL6 ::: END
					#
					# --- Задолженность по счету-фактуре (разность суммы счета и поступлений - авансов и оплат)
						$_ZADOL_CHF = $_ROW_docchfsubpodr['sumchfsubpodr'] - $_SUM_CHF_INCOMING;
					# +++ Суммируем все счета-фактуры по отдельному договору субподряда
						$_SUM_DOCSUB_CHF+= $_ROW_docchfsubpodr['sumchfsubpodr'];
					# +++ Суммируем поступления по всем счетам-фактурам по отдельному договору субподряда
						$_SUM_DOCSUB_INCOMING += $_SUM_CHF_INCOMING;
					#
				// Формируем строку итого для счета
			    $table->addRow(300, $_TBL_BODYStyle_Row);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(8500, $_TBL_BODYStyle_Cell_Grid3_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по счету', $_TBL_BODYFont_S8B_111111);
					$table->addCell(2000, $_TBL_BODYStyle_Cell_Date)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);
					if ($_ZADOL_CHF == 0) {
						$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
						$textrun->addText(number_format($_ROW_docchfsubpodr['sumchfsubpodr'], 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
					}
					else {
						$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
						$textrun->addText(number_format($_ROW_docchfsubpodr['sumchfsubpodr'], 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
					}
					$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_SUM_CHF_INCOMING, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
					$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ZADOL_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_C20607);
				}
# LVL5 ::: END
				#
				# --- Задолженность по отдельному договору субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат)
				$_ZADOL_DOCSUB = $_SUM_DOCSUB_CHF - $_SUM_DOCSUB_INCOMING;
				# +++ Суммируем счета-фактуры по всем договорам субподряда отдельного этапа
				$_SUM_DOCSSUB_CHF += $_SUM_DOCSUB_CHF;
				# +++ Суммируем поступления по всем договорам субподряда отдельного этапа
				$_SUM_DOCSSUB_INCOMING += $_SUM_DOCSUB_INCOMING;
				#
			// Формируем строку итого для договора субподряда
		    $table->addRow(300, $_TBL_BODYStyle_Row);
				$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
				$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
				$table->addCell(8500, $_TBL_BODYStyle_Cell_Grid3_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по договору субподряда', $_TBL_BODYFont_S8B_111111);
				$table->addCell(2000, $_TBL_BODYStyle_Cell_Date)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);
				if ($_ZADOL_DOCSUB == 0) {
					$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
					$textrun->addText(number_format($_SUM_DOCSUB_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
				}
				else {
					$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
					$textrun->addText(number_format($_SUM_DOCSUB_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
				}
				$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_SUM_DOCSUB_INCOMING, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
				$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ZADOL_DOCSUB, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_C20607);
			}
# LVL4 ::: END
			#
			# --- Задолженность по всем договорам субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат) отдельного этапа
			$_ZADOL_DOCSSUB = $_SUM_DOCSSUB_CHF - $_SUM_DOCSSUB_INCOMING;
			# +++ Суммируем счета-фактуры по всем договорам субподряда отдельного основного договора
			$_SUM_DOC_CHF += $_SUM_DOCSSUB_CHF;
			# +++ Суммируем поступления по всем договорам субподряда отдельного основного договора
			$_SUM_DOC_INCOMING += $_SUM_DOCSSUB_INCOMING;
			#
		}
# LVL3 ::: END
		#
		# --- Задолженность по всем договорам субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат) отдельного основного договора
		$_ZADOL_DOC = $_SUM_DOC_CHF - $_SUM_DOC_INCOMING;
		# +++ Суммируем счета-фактуры по всем договорам отдельного субподрядчика
		$_SUM_DOCS_CHF += $_SUM_DOC_CHF;
		# +++ Суммируем поступления по всем договорам отдельного субподрядчика
		$_SUM_DOCS_INCOMING += $_SUM_DOC_INCOMING;
		#
		$table->addRow(350, $_TBL_BODYStyle_Row);
		if ($_ROW_docbase['kodshab']==0) {
			$table->addCell(11000, $_TBL_BODYStyle_Cell_Grid6_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по счету', $_TBL_BODYFont_Title_H2_2);
	  }
	  else {
	    $table->addCell(11000, $_TBL_BODYStyle_Cell_Grid6_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по основному договору', $_TBL_BODYFont_Title_H2_2);
	  }
		$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
		$textrun->addText(number_format($_SUM_DOC_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H2_2);
		$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_SUM_DOC_INCOMING, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H2_2);
		$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ZADOL_DOC, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H2_2_C20607);
	}
# LVL2 ::: END
}
# --- ЕСЛИ СУЩЕСТВУЕТ ОСНОВНОЙ ДОГОВОР

















# --- ЕСЛИ НЕ СУЩЕСТВУЕТ ОСНОВНОЙ ДОГОВОР
if ( $_MAINDOC_EXIST == 0 ) {
#
# Обнуляем счетчики и локальные переменные
	$_ZADOL_DOC = 0.0;
	$_SUM_DOCS_CHF = 0.0;
	$_SUM_DOCS_INCOMING = 0.0;
	$_DENED = " р.";
#
#
# ::: Выводим номер и название договора/счета
    $table->addRow(300, $_TBL_BODYStyle_Row);
    $table->addCell(20000, $_TBL_BODYStyle_Cell_Grid9_1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Основной договор не найден либо отсутствует', $_TBL_BODYFont_H2_1);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# Обнуляем счетчик
	// Сумма всех выставленных счетов-фактур по этапу
		$_ZADOL_DOCSSUB = 0.0;
		$_SUM_DOC_CHF = 0.0;
		$_SUM_DOC_INCOMING = 0.0;
#
#
#
# ::: Выводим номер и название этапа (либо запись о том, что этап не создавался)
	    $table->addRow(300, $_TBL_BODYStyle_Row);
			$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
	    $table->addCell(19750, $_TBL_BODYStyle_Cell_Grid8_0)->addText('Без этапа', $_TBL_BODYFont_S8I_999999);
#
#
# ДОГОВОРА СУБПОДРЯДА
# LVL 4 ::: BEGIN
# Договор субподряда выбираем только по идентификатору Подрядчика и наличию задолженности
#
#
			$_QRY_docsubpodr_Str = "SELECT * FROM dognet_docsubpodr WHERE sumzadolsubpodr<>'0.00' AND koddel<>'99' AND kodsubpodr='".$_ROW['kodsubpodr']."'";
			$_QRY_docsubpodr = mysqlQuery($_QRY_docsubpodr_Str);
#
#
# Обнуляем счетчик
		// Сумма всех выставленных счетов-фактур по всем договорам субподряда данного этапа
			$_ZADOL_DOCSUB = 0.0;
			$_SUM_DOCSSUB_CHF = 0.0;
			$_SUM_DOCSSUB_INCOMING = 0.0;
#
#
# Запускаем цикл LVL 4
			while($_ROW_docsubpodr = mysqli_fetch_assoc($_QRY_docsubpodr)) {
			// Формируем строку
		    $table->addRow(300, $_TBL_BODYStyle_Row);
			// Выводим запись
				if ($_ROW_docsubpodr['numberdocsubpodr']!="") {
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(19500, $_TBL_BODYStyle_Cell_Grid7_3)->addText('Договор субподряда № '.$_ROW_docsubpodr['numberdocsubpodr'], $_TBL_BODYFont_S8_111111);
				}
				else {
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(19500, $_TBL_BODYStyle_Cell_Grid7_0)->addText('Номер договора субподряда отсутствует или не задан', $_TBL_BODYFont_S8I_999999);
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
#
#
# Обнуляем счетчик
		// Сумма всех выставленных счетов-фактур по отдельному договору субподряда
			$_ZADOL_CHF = 0.0;
			$_SUM_DOCSUB_CHF = 0.0;
			$_SUM_DOCSUB_INCOMING = 0.0;
#
#
# Запускаем цикл LVL 5
				while($_ROW_docchfsubpodr = mysqli_fetch_assoc($_QRY_docchfsubpodr)) {
// Формируем строку
			    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(8250, $_TBL_BODYStyle_Cell_Grid2_3)->addText('Счет-фактура №'.$_ROW_docchfsubpodr['numberchfsubpodr'], $_TBL_BODYFont_S8_111111);
					$table->addCell(2000, $_TBL_BODYStyle_Cell_Date)->addTextRun($_TBL_CELLAlign_H_Center)->addText(date("d.m.Y", strtotime($_ROW_docchfsubpodr['datechfsubpodr'])), $_TBL_BODYFont);
					$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ROW_docchfsubpodr['sumchfsubpodr'], 2, '.', ' ').$_DENED, $_TBL_BODYFont);
					$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);
					$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);

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
						$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
						$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
						$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
						$table->addCell(19250, $_TBL_BODYStyle_Cell_Grid6_0)->addText('Оплат и авансов не поступало', $_TBL_BODYFont_S8I_999999);
					}
#
# Обнуляем счетчик
				// Сумма всех выставленных счетов-фактур по отдельному договору субподряда
					$_SUM_CHF_INCOMING = 0.0;
#
# Запускаем цикл LVL 6
					while($_ROW_chfincoming = mysqli_fetch_assoc($_QRY_chfincoming)) {
						if ($_ROW_chfincoming['type_incoming']=='1') {
// Формируем строку
					    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(8250, $_TBL_BODYStyle_Cell_Grid2_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Оплата', $_TBL_BODYFont);
							$table->addCell(2000, $_TBL_BODYStyle_Cell_Date)->addTextRun($_TBL_CELLAlign_H_Center)->addText(date("d.m.Y", strtotime($_ROW_chfincoming['date_incoming'])), $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('', $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ROW_chfincoming['sum_incoming'], 2, '.', ' ').$_DENED, $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Left)->addText('', $_TBL_BODYFont);
						}
						elseif ($_ROW_chfincoming['type_incoming']=='2') {
// Формируем строку
					    $table->addRow(300, $_TBL_BODYStyle_Row);
// Выводим запись
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
							$table->addCell(8250, $_TBL_BODYStyle_Cell_Grid2_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Аванс', $_TBL_BODYFont);
							$table->addCell(2000, $_TBL_BODYStyle_Cell_Date)->addTextRun($_TBL_CELLAlign_H_Center)->addText(date("d.m.Y", strtotime($_ROW_chfincoming['date_incoming'])), $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Left)->addText('', $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ROW_chfincoming['sum_incoming'], 2, '.', ' ').$_DENED, $_TBL_BODYFont);
							$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Left)->addText('', $_TBL_BODYFont);
						}
// +++ Суммируем оплаты и авансы по счету
						$_SUM_CHF_INCOMING += $_ROW_chfincoming['sum_incoming'];
					}
# LVL6 ::: END
					#
					# --- Задолженность по счету-фактуре (разность суммы счета и поступлений - авансов и оплат)
						$_ZADOL_CHF = $_ROW_docchfsubpodr['sumchfsubpodr'] - $_SUM_CHF_INCOMING;
					# +++ Суммируем все счета-фактуры по отдельному договору субподряда
						$_SUM_DOCSUB_CHF+= $_ROW_docchfsubpodr['sumchfsubpodr'];
					# +++ Суммируем поступления по всем счетам-фактурам по отдельному договору субподряда
						$_SUM_DOCSUB_INCOMING += $_SUM_CHF_INCOMING;
					#
				// Формируем строку итого для счета
			    $table->addRow(300, $_TBL_BODYStyle_Row);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
					$table->addCell(8500, $_TBL_BODYStyle_Cell_Grid3_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по счету', $_TBL_BODYFont_S8B_111111);
					$table->addCell(2000, $_TBL_BODYStyle_Cell_Date)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);
					if ($_ZADOL_CHF == 0) {
						$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
						$textrun->addText(number_format($_ROW_docchfsubpodr['sumchfsubpodr'], 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
					}
					else {
						$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
						$textrun->addText(number_format($_ROW_docchfsubpodr['sumchfsubpodr'], 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
					}
					$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_SUM_CHF_INCOMING, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
					$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ZADOL_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_C20607);
				}
# LVL5 ::: END
				#
				# --- Задолженность по отдельному договору субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат)
				$_ZADOL_DOCSUB = $_SUM_DOCSUB_CHF - $_SUM_DOCSUB_INCOMING;
				# +++ Суммируем счета-фактуры по всем договорам субподряда отдельного этапа
				$_SUM_DOCSSUB_CHF += $_SUM_DOCSUB_CHF;
				# +++ Суммируем поступления по всем договорам субподряда отдельного этапа
				$_SUM_DOCSSUB_INCOMING += $_SUM_DOCSUB_INCOMING;
				#
			// Формируем строку итого для договора субподряда
		    $table->addRow(300, $_TBL_BODYStyle_Row);
				$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
				$table->addCell(250, $_TBL_BODYStyle_Cell_ClearEmpty)->addText('', $_TBL_BODYFont);
				$table->addCell(8500, $_TBL_BODYStyle_Cell_Grid3_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по договору субподряда', $_TBL_BODYFont_S8B_111111);
				$table->addCell(2000, $_TBL_BODYStyle_Cell_Date)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_TBL_BODYFont);
				if ($_ZADOL_DOCSUB == 0) {
					$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
					$textrun->addText(number_format($_SUM_DOCSUB_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
				}
				else {
					$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
					$textrun->addText(number_format($_SUM_DOCSUB_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
				}
				$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_SUM_DOCSUB_INCOMING, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_111111);
				$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ZADOL_DOCSUB, 2, '.', ' ').$_DENED, $_TBL_BODYFont_S8B_C20607);
			}
# LVL4 ::: END
			#
			# --- Задолженность по всем договорам субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат) отдельного этапа
			$_ZADOL_DOCSSUB = $_SUM_DOCSSUB_CHF - $_SUM_DOCSSUB_INCOMING;
			# +++ Суммируем счета-фактуры по всем договорам субподряда отдельного основного договора
			$_SUM_DOC_CHF += $_SUM_DOCSSUB_CHF;
			# +++ Суммируем поступления по всем договорам субподряда отдельного основного договора
			$_SUM_DOC_INCOMING += $_SUM_DOCSSUB_INCOMING;
			#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		#
		# --- Задолженность по всем договорам субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат) отдельного основного договора
		$_ZADOL_DOC = $_SUM_DOC_CHF - $_SUM_DOC_INCOMING;
		# +++ Суммируем счета-фактуры по всем договорам отдельного субподрядчика
		$_SUM_DOCS_CHF += $_SUM_DOC_CHF;
		# +++ Суммируем поступления по всем договорам отдельного субподрядчика
		$_SUM_DOCS_INCOMING += $_SUM_DOC_INCOMING;
		#
		$table->addRow(350, $_TBL_BODYStyle_Row);
    $table->addCell(11000, $_TBL_BODYStyle_Cell_Grid6_3)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого (без основного договора)', $_TBL_BODYFont_Title_H2_2);
		$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
		$textrun->addText(number_format($_SUM_DOC_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H2_2);
		$table->addCell(3000, $_TBL_BODYStyle_Cell_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_SUM_DOC_INCOMING, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H2_2);
		$table->addCell(3000, $_TBL_BODYStyle_Cell)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ZADOL_DOC, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H2_2_C20607);
}
# --- ЕСЛИ НЕ СУЩЕСТВУЕТ ОСНОВНОЙ ДОГОВОР











	#
	# --- Задолженность по всем договорам субподряда (разность суммы счетов-фактур и поступлений - авансов и оплат) отдельного основного договора
	$_ZADOL_SUB = $_SUM_DOCS_CHF - $_SUM_DOCS_INCOMING;
	# +++ Суммируем счета-фактуры по всем договорам отдельного субподрядчика
	$_SUM_SUB_CHF += $_SUM_DOCS_CHF;
	# +++ Суммируем поступления по всем договорам отдельного субподрядчика
	$_SUM_SUB_INCOMING += $_SUM_DOCS_INCOMING;
	#
  $table->addRow(450, $_TBL_BODYStyle_Row);
  $table->addCell(11000, $_TBL_BODYStyle_Cell_Grid6_ItogoSub)->addTextRun($_TBL_CELLAlign_H_Left)->addText('Итого по Субподрядчику', $_TBL_BODYFont_Title_H1_1);
	$textrun = $table->addCell(3000, $_TBL_BODYStyle_Cell_ItogoSub_Sum1)->addTextRun($_TBL_CELLAlign_H_Center);
	$textrun->addText(number_format($_SUM_DOCS_CHF, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H1_2);
	$table->addCell(3000, $_TBL_BODYStyle_Cell_ItogoSub_Sum1)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_SUM_DOCS_INCOMING, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H1_2);
	$table->addCell(3000, $_TBL_BODYStyle_Cell_ItogoSub)->addTextRun($_TBL_CELLAlign_H_Center)->addText(number_format($_ZADOL_SUB, 2, '.', ' ').$_DENED, $_TBL_BODYFont_Title_H1_2_C20607);
# LVL1 ::: END

}

$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
// $xmlWriter->save("php://output");
$filepath = $_SERVER['DOCUMENT_ROOT']."/dognet/tmp/";
$filename = "SPRAVKA-ZADOLCHF_".$_SESSION['id']."_".date('YmdHis').".DOCX";
$xmlWriter->save($filepath.$filename);

// Делаем запись в системный лог
// Все параметры в таблице portal_log_messages
	PORTAL_SYSLOG('99942200', '0000002', null, $_GET['reportview'], "Справка о задолженности по субподрядчикам", "WORD");

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
		i = 15;
		document.getElementById("time").innerHTML = i;
		timer = setInterval(function(){
			document.getElementById("time").innerHTML = i--;

			host = '<?php echo $_SERVER["HTTP_HOST"]; ?>';
			url1 = 'http://'+host+'/dognet/dognet-report.php';
			url2 = 'http://'+host+'/dognet/dognet-report.php?reportview=zadolsub&export=yes';
			if (i < 0) {
				clearInterval(timer);
				document.getElementById("link").innerHTML = "<div class='space20'><span style='padding:0 15px'><a class='return-link' href="+url1+">Вернуться в Отчеты</a></span></div><div class='space20'><span style='padding:0 15px'><a class='return-link' href="+url2+">Новый экспорт</a></span></div>";
			}
		}, 1000);
}
countDown();

</script>


