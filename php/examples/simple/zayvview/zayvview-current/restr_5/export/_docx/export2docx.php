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
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$phpWord = new  \PhpOffice\PhpWord\PhpWord();

$phpWord->setDefaultFontName('Arial');
$phpWord->setDefaultFontSize(10);

$properties = $phpWord->getDocInfo();

$properties->setCreator("АТГС.Портал");
$properties->setCompany('АТГС');
$properties->setTitle('Акт сдачи-приемки выполненных работ');
$properties->setDescription('Акт сдачи-приемки выполненных работ');
$properties->setCategory('Акты');
$properties->setLastModifiedBy('АТГС.Портал');
$properties->setCreated(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setModified(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setSubject('Акт сдачи-приемки выполненных работ');
$properties->setKeywords('Портал, Договор, Акты');
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
$sectionStyle = array(
	'orientation' => 'portrait',
	'marginTop' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(40),
	'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::pixelToTwip(40),
	'marginLeft' => 800,
	'marginRight' => 800,
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
#
#
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$phpWord->addTitleStyle(1, array('name' => "Arial", 'size' => 14, 'bold' => true), array('spaceAfter' => 240, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$phpWord->addTitleStyle(2, array('name' => "Arial", 'size' => 12, 'bold' => true), array('spaceAfter' => 180, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$phpWord->addTitleStyle(3, array('name' => "Arial", 'size' => 11, 'bold' => true), array('spaceAfter' => 180, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ПОДКЛЮЧАЕМ СТИЛИ ОФОРМЛЕНИЯ
#
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/actview/actview-current/restr_5/export/_docx/export2docx_styles.inc.php");
#
$paragraphStyleName1 = 'pStyle1';
$phpWord->addParagraphStyle($paragraphStyleName1, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spacing' => 120, 'spaceBefore' => 240, 'spaceAfter' => 360));
$paragraphStyleName2 = 'pStyle2';
$phpWord->addParagraphStyle($paragraphStyleName2, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spacing' => 120, 'spaceBefore' => 240, 'spaceAfter' => 360));
$paragraphStyleName3 = 'pStyle3';
$phpWord->addParagraphStyle($paragraphStyleName3, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spacing' => 90, 'spaceBefore' => 210, 'spaceAfter' => 330));
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::::
# ::::: ШАПКА АКТА
# :::::
#
#
$commonTable_styleName = 'Common Table';
$phpWord->addTableStyle($commonTable_styleName, $_TBL_TABLEStyle_DocHeader, $_TBL_HEADERStyle_Row);
$innerTable_styleName = 'Inner Table';
$phpWord->addTableStyle($innerTable_styleName, $_TBL_TABLEStyle_Inner, $_TBL_HEADERStyle_Row);
#
$tableCmn = $section->addTable($commonTable_styleName);
#
$tableCmn->addRow(350, $_TBL_HEADERStyle_Row);
#
# -- + -- + -- + -- + -- + -- + -- + --
# Запрашиваем и выводим статус контрагентов
// В шапке акта слева
$_QRY_ORG1_STATUS = mysqlQuery("SELECT * FROM dognet_shablactdoc WHERE kodshabact = '" . $_GET['org1'] . "'");
$_ROW_ORG1_STATUS = mysqli_fetch_assoc($_QRY_ORG1_STATUS);
// В шапке акта справа
$_QRY_ORG2_STATUS = mysqlQuery("SELECT * FROM dognet_shablactdoc WHERE kodshabact = '" . $_GET['org2'] . "'");
$_ROW_ORG2_STATUS = mysqli_fetch_assoc($_QRY_ORG2_STATUS);
//
$tableCmn->addCell(10000, $_TBL_HEADERStyle_Cell_DocHeader)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_ORG1_STATUS['nameshabact_i'], $_FontStyle_DocHeader_H2);
$tableCmn->addCell(10000, $_TBL_HEADERStyle_Cell_DocHeader)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_ORG2_STATUS['nameshabact_i'], $_FontStyle_DocHeader_H2);
#
#
# -- + -- + -- + -- + -- + -- + -- + --
# Запрашиваем и выводим реквизиты контрагентов

// В шапке акта реквизиты слева (это АТГС)

# -- + -- + -- + -- + -- + -- + -- + --
#
#
$cell = $tableCmn->addRow(350, $_TBL_BODYStyle_Row)->addCell();
#
$innerTable = $cell->addTable($innerTable_styleName);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('АО "АтлантикТрансгазСистема"', $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('ИНН 7723011060', $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('КПП 772301001', $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Р/С 40702810000000009183 в Банке ГПБ (АО) г. Москва', $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('К/С 30101810200000000823', $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('БИК 044525823', $_FontStyle_Doc_P9);
# -- + -- + -- + -- + -- + -- + -- + --
# Запрашиваем и выводим реквизиты контрагентов (kodzakaz)
// В шапке акта реквизиты справа
$_QRY_docbase = mysqlQuery("SELECT * FROM dognet_docbase WHERE koddoc = '" . $_GET['uniqueID1'] . "'");
$_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase);
$_QRY_ORG2_KONTR = mysqlQuery("SELECT * FROM sp_contragents WHERE kodzakaz = '" . $_ROW_docbase['kodzakaz'] . "'");
$_ROW_ORG2_KONTR = mysqli_fetch_assoc($_QRY_ORG2_KONTR);
# -- + -- + -- + -- + -- + -- + -- + --
#
#
#
#
$cell = $tableCmn->addCell();
#
$innerTable = $cell->addTable($innerTable_styleName);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_ORG2_KONTR['namezaklong'], $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText("ИНН " . $_ROW_ORG2_KONTR['zakinn'], $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText("КПП " . $_ROW_ORG2_KONTR['zakkpp'], $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_ORG2_KONTR['zakbankch'], $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_FontStyle_Doc_P9);
#
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('', $_FontStyle_Doc_P9);
#
#
#
// $section->addText("", null, array('widowControl' => false, 'indentation' => array('left' => 0, 'right' => 0), 'spaceBefore' => 90, 'spaceAfter' => 90));
#
#
#
# Запрашиваем данные по этапу (kodkalplan)
//
$_QRY_dockalplan = mysqlQuery("SELECT * FROM dognet_dockalplan WHERE kodkalplan = '" . $_GET['uniqueID2'] . "'");
$_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan);
# -- + -- + -- + -- + -- + -- + -- + --
#
#
#
if ($_ROW_docbase['kodshab'] == 0) {
	$section->addTitle("АКТ № " . $_ROW_docbase['docnumber'] . " / ___", 1);
	$section->addTitle('от " _____ " ____________________ 202 ___ г.', 2);
	$section->addTitle("сдачи-приемки выполненных работ по счету № " . $_ROW_docbase['numberchet'] . " от " . numberFormat($_ROW_docbase['daynachdoc'], 2) . "." . numberFormat($_ROW_docbase['monthnachdoc'], 2) . "." . numberFormat($_ROW_docbase['yearnachdoc'], 4), 3);
} elseif (($_ROW_docbase['kodshab'] == 1) or ($_ROW_docbase['kodshab'] == 3)) {
	$section->addTitle("АКТ № " . $_ROW_docbase['docnumber'] . " / " . $_ROW_dockalplan['numberstage'], 1);
	$section->addTitle('от " _____ " ____________________ 202 ___ г.', 2);
	$section->addTitle("сдачи-приемки выполненных работ по договору № 3-4/" . $_ROW_docbase['docnumber'] . " от " . numberFormat($_ROW_docbase['daynachdoc'], 2) . "." . numberFormat($_ROW_docbase['monthnachdoc'], 2) . "." . numberFormat($_ROW_docbase['yearnachdoc'], 4), 3);
} elseif (($_ROW_docbase['kodshab'] == 2) or ($_ROW_docbase['kodshab'] == 4)) {
	$section->addTitle("АКТ № " . $_ROW_docbase['docnumber'] . " / ___", 1);
	$section->addTitle('от " _____ " ____________________ 202 ___ г.', 2);
	$section->addTitle("сдачи-приемки выполненных работ по договору № 3-4/" . $_ROW_docbase['docnumber'] . " от " . numberFormat($_ROW_docbase['daynachdoc'], 2) . "." . numberFormat($_ROW_docbase['monthnachdoc'], 2) . "." . numberFormat($_ROW_docbase['yearnachdoc'], 4), 3);
}
#
#
# Выводим полное название договора
$_DOCNAME_FULL = ($_ROW_docbase['docnamefull'] != "") ? $_ROW_docbase['docnamefull'] : ($_ROW_docbase['docnamefullm'] != "") ? $_ROW_docbase['docnamefullm'] : $_ROW_docbase['docnameshot'];
$textrun = $section->addTextRun($paragraphStyleName3);
$textrun->addText($_DOCNAME_FULL, $_FontStyle_Doc_P10_UI);
#
#
# Выводим текст акта
mb_internal_encoding("UTF-8");
// Определяем валюту договора
$_QRY_dened = mysqlQuery("SELECT * FROM dognet_spdened WHERE koddened='" . $_ROW_docbase['koddened'] . "'");
$_ROW_dened = mysqli_fetch_assoc($_QRY_dened);
if ($_QRY_dened) {
	$_DENED = html_entity_decode($_ROW_dened['short_code']);
} else {
	$_DENED = " -.";
}
//
#
# ВЫВОДИМ НАЗВАНИЕ ЭТАПА
#
$textrun = $section->addTextRun($paragraphStyleName1);
if (($_ROW_docbase['kodshab'] == 1) or ($_ROW_docbase['kodshab'] == 3)) {
	$textrun->addText('Этап ' . $_ROW_dockalplan['numberstage'] . '. "' . $_ROW_dockalplan['nameshotstage'] . '"', $_FontStyle_Doc_P10_UI);
} elseif (($_ROW_docbase['kodshab'] == 0) or ($_ROW_docbase['kodshab'] == 2) or ($_ROW_docbase['kodshab'] == 4)) {
	$textrun->addText('Без этапа', $_FontStyle_Doc_P10_UI);
}
$textrun->addTextBreak();
#
# ВЫВОДИМ ОСНОВНОЙ ТЕКСТ
#
$textrun->addText("Мы, нижеподписавшиеся, с одной стороны представитель ", $_FontStyle_Doc_P9);
$textrun->addText($_ROW_ORG1_STATUS['nameshabact_r'] . " ", $_FontStyle_Doc_P9);
$textrun->addText("Бернер Л.И.", $_FontStyle_Doc_P9_U);
$textrun->addText(" и с другой стороны представитель ", $_FontStyle_Doc_P9);
$textrun->addText($_ROW_ORG2_STATUS['nameshabact_r'] . " ", $_FontStyle_Doc_P9);
$textrun->addText($_ROW_ORG2_KONTR['zakfio'] . " " . mb_substr($_ROW_ORG2_KONTR['zakfistname'], 0, 1) . "." . mb_substr($_ROW_ORG2_KONTR['zaklastname'], 0, 1) . ".", $_FontStyle_Doc_P9_U);
$textrun->addText(" составили АКТ о том, что согласно договору № 3-4/", $_FontStyle_Doc_P9);
$textrun->addText($_ROW_docbase['docnumber'] . " от " . numberFormat($_ROW_docbase['daynachdoc'], 2) . "." . numberFormat($_ROW_docbase['monthnachdoc'], 2) . "." . numberFormat($_ROW_docbase['yearnachdoc'] . " ", 4), $_FontStyle_Doc_P9);
$textrun->addText($_ROW_ORG1_STATUS['nameshabact_t'] . " ", $_FontStyle_Doc_P9);
$textrun->addText("выполнена работа стоимостью ", $_FontStyle_Doc_P9);
//
if (isset($_GET['sum_type'])) {
	switch ($_GET['sum_type']) {
		case "1":
			if (isset($_GET['sum_val'])) {
				$_ACT_SUMMA = (float)($_GET['sum_val']);
				$_ACT_SUMMA_T = number_format((float)($_ACT_SUMMA), 2, '.', ' ') . $_DENED;
				// Сумма прописью
			} else {
				$_ACT_SUMMA = 0.0;
				$_ACT_SUMMA_T = number_format((float)($_ACT_SUMMA), 2, '.', ' ') . $_DENED;
			}
			$_ACT_SUMMA_STR = num2str($_ACT_SUMMA);
			break;
		case "2":
			if (($_ROW_docbase['kodshab'] == 1) or ($_ROW_docbase['kodshab'] == 3)) {
				$_ACT_SUMMA = (float)($_ROW_dockalplan['summastage']);
			} elseif (($_ROW_docbase['kodshab'] == 0) or ($_ROW_docbase['kodshab'] == 2) or ($_ROW_docbase['kodshab'] == 4)) {
				$_ACT_SUMMA = (float)($_ROW_docbase['docsumma']);
			}
			$_ACT_SUMMA_T = number_format((float)($_ACT_SUMMA), 2, '.', ' ') . $_DENED;
			// Сумма прописью
			$_ACT_SUMMA_STR = num2str($_ACT_SUMMA);
			break;
		case "3":
			if (($_ROW_docbase['kodshab'] == 1) or ($_ROW_docbase['kodshab'] == 3)) {
				$_STAGE_NEZAKR = $_ROW_dockalplan['summastage'] - DOCBASE_FN_SUM_CHF_STAGE($_GET['uniqueID2']);
			} elseif (($_ROW_docbase['kodshab'] == 0) or ($_ROW_docbase['kodshab'] == 2) or ($_ROW_docbase['kodshab'] == 4)) {
				$_STAGE_NEZAKR = $_ROW_docbase['docsumma'] - DOCBASE_FN_SUM_CHF_STAGE($_GET['uniqueID1']);
			}
			$_ACT_SUMMA = (float)($_STAGE_NEZAKR);
			$_ACT_SUMMA_T = number_format((float)($_ACT_SUMMA), 2, '.', ' ') . $_DENED;
			// Сумма прописью
			$_ACT_SUMMA_STR = num2str($_ACT_SUMMA);
			break;
		default:
			$_ACT_SUMMA = "";
			$_ACT_SUMMA_T = "(не указана)";
			$_ACT_SUMMA_STR = "(не указана)";
	}
} else {
	$_ACT_SUMMA = "";
	$_ACT_SUMMA_T = "(не указана)";
	$_ACT_SUMMA_STR = "(не указана)";
}
$textrun->addText($_ACT_SUMMA_T, $_FontStyle_Doc_P9_U);
#
# ВЫВОДИМ СУММУ АКТА ПРОПИСЬЮ
#
$textrun = $section->addTextRun($paragraphStyleName3);
$textrun->addText('(' . $_ACT_SUMMA_STR . '), вкл. НДС', $_FontStyle_Doc_P9_UI);
$textrun->addTextBreak();
$textrun->addText("(сумма прописью)", $_FontStyle_Doc_P7_I);
#
# ВЫВОДИМ НДС
#
$textrun = $section->addTextRun($paragraphStyleName1);
$textrun->addText("В том числе НДС (20%) составляет: ", $_FontStyle_Doc_P9);
// Считаем НДС
$_ACT_NDS = ($_ACT_SUMMA != "") ? ($_ACT_SUMMA / (1 + 0.2)) * 0.2 : 0.0;
$_ACT_NDS_T = number_format((float)($_ACT_NDS), 2, '.', ' ') . $_DENED;
$textrun->addText($_ACT_NDS_T, $_FontStyle_Doc_P9_U);
#
# ВЫВОДИМ НДС ПРОПИСЬЮ
#
$_ACT_NDS_STR = num2str($_ACT_NDS);
$textrun = $section->addTextRun($paragraphStyleName3);
$textrun->addText('(' . $_ACT_NDS_STR . ')', $_FontStyle_Doc_P9_UI);
$textrun->addTextBreak();
$textrun->addText("(сумма прописью)", $_FontStyle_Doc_P7_I);
#
# ВЫВОДИМ СУММУ К ПЕРЕЧИСЛЕНИЮ
#
$textrun = $section->addTextRun($paragraphStyleName1);
$textrun->addText("Следует к перечислению: ", $_FontStyle_Doc_P9_UB);
$textrun->addText($_ACT_SUMMA_T, $_FontStyle_Doc_P9_UB);
#
# ВЫВОДИМ СУММУ К ПЕРЕЧИСЛЕНИЮ ПРОПИСЬЮ
#
$textrun = $section->addTextRun($paragraphStyleName3);
$textrun->addText('(' . $_ACT_SUMMA_STR . '), вкл. НДС', $_FontStyle_Doc_P9_UBI);
$textrun->addTextBreak();
$textrun->addText("(сумма прописью)", $_FontStyle_Doc_P7_I);
#
# ВЫВОДИМ ОНСОВАНИЕ ДЛЯ ОПЛАТЫ
#
$textrun = $section->addTextRun($paragraphStyleName1);
$textrun->addText("Настоящий акт является основанием для оплаты.", $_FontStyle_Doc_P9);
// $textrun->addTextBreak(2);
#
# ФУТЕР С ПОДПИСЯМИ
#
$tableCmn = $section->addTable($commonTable_styleName);
//
$tableCmn->addRow(350, $_TBL_HEADERStyle_Row);
//
$tableCmn->addCell(10000, $_TBL_HEADERStyle_Cell_DocHeader)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_ORG1_STATUS['nameshabact_i'], $_FontStyle_DocHeader_H2);
$tableCmn->addCell(10000, $_TBL_HEADERStyle_Cell_DocHeader)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_ORG2_STATUS['nameshabact_i'], $_FontStyle_DocHeader_H2);
#
# ПОДПИСЬ СЛЕВА
$cell = $tableCmn->addRow(350, $_TBL_BODYStyle_Row)->addCell();
//
$innerTable = $cell->addTable($innerTable_styleName);
// Должность
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('Генеральный директор АО "АтлантикТрансгазСистема"', $_FontStyle_Doc_P9);
$innerTable->addRow(750, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('_______________' . ' Л.И. Бернер', $_FontStyle_Doc_P9);
#
# ПОДПИСЬ СПРАВА
$cell = $tableCmn->addCell();
//
$innerTable = $cell->addTable($innerTable_styleName);
// Должность
$innerTable->addRow(250, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText($_ROW_ORG2_KONTR['zakdolg'] . " " . $_ROW_ORG2_KONTR['namezaklong'], $_FontStyle_Doc_P9);
$innerTable->addRow(750, $_TBL_BODYStyle_Row);
$innerTable->addCell(10000, $_TBL_BODYStyle_Cell_Inner)->addTextRun($_TBL_CELLAlign_H_Center)->addText('_______________' . ' ' . mb_substr($_ROW_ORG2_KONTR['zakfistname'], 0, 1) . '.' . mb_substr($_ROW_ORG2_KONTR['zaklastname'], 0, 1) . '. ' . $_ROW_ORG2_KONTR['zakfio'], $_FontStyle_Doc_P9);
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
#
#
#
#
#
#
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
// $xmlWriter->save("php://output");
$filepath = $_SERVER['DOCUMENT_ROOT'] . "/dognet/tmp/";
$filename = "ACT-EXECUTEDWORKS_" . $_SESSION['id'] . "_" . date('YmdHis') . ".DOCX";
$xmlWriter->save($filepath . $filename);

# Делаем запись в Журнале актов
if (isset($_GET['log']) && $_GET['log'] == 'yes') {

	$koddocjurnal = nextKoddocjurnal();
	$koddoc = $_GET['uniqueID1'];
	$koddockalplan = $_GET['uniqueID2'];
	$datecreateact = date('Y-m-d');
	if (($_ROW_docbase['kodshab'] == 1) or ($_ROW_docbase['kodshab'] == 3)) {
		$numberdocact = "3-4/" . $_ROW_docbase['docnumber'] . "спец. " . $_ROW_dockalplan['numberstage'];
	} elseif (($_ROW_docbase['kodshab'] == 2) or ($_ROW_docbase['kodshab'] == 4)) {
		$numberdocact = "3-4/" . $_ROW_docbase['docnumber'];
	} elseif ($_ROW_docbase['kodshab'] == 0) {
		$numberdocact = $_ROW_docbase['docnumber'];
	}
	$summadocact = $_ACT_SUMMA;
	$docactcreater = $_SESSION['lastname'] . " " . mb_substr($_SESSION['firstname'], 0, 1) . "." . mb_substr($_SESSION['middlename'], 0, 1) . ".";
	$nameactcreate = "АКТ";

	$_QRY_LOG = mysqlQuery("INSERT INTO dognet_docjurnalact (`koddel`, `koddocjurnal`, `koddoc`, `koddockalplan`, `datecreateact`, `numberdocact`, `summadocact`, `docactcreater`, `nameactcreate`) VALUES ('', '$koddocjurnal', '$koddoc', '$koddockalplan', '$datecreateact', '$numberdocact', '$summadocact', '$docactcreater', '$nameactcreate')");
}

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
			uniqueID2 = '<?php echo $_GET["uniqueID2"]; ?>';
			url1 = 'http://' + host + '/dognet/dognet-actview.php?actview_type=list';
			url2 = 'http://' + host + '/dognet/dognet-actview.php?actview_type=list&export=yes&uniqueID1=' + uniqueID1 + '&uniqueID2=' + uniqueID2;
			if (i < 0) {
				clearInterval(timer);
				document.getElementById("link").innerHTML = "<div class='space20'><span style='padding:0 15px'><a class='return-link' href=" + url1 + ">Вернуться в Отчеты</a></span></div><div class='space20'><span style='padding:0 15px'><a class='return-link' href=" + url2 + ">Новый экспорт</a></span></div>";
			}
		}, 1000);
	}
	countDown();
</script>