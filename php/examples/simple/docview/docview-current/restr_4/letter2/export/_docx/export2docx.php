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
$properties->setTitle('Письмо о продлении срока поставки');
$properties->setDescription('Письмо о продлении срока поставки');
$properties->setCategory('Письма');
$properties->setLastModifiedBy('АТГС.Портал');
$properties->setCreated(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setModified(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setSubject('Письмо о продлении срока поставки');
$properties->setKeywords('Портал, Договор, Письма');
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
# ПОДКЛЮЧАЕМ СТИЛИ ОФОРМЛЕНИЯ
#
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_4/letter2/export/_docx/export2docx_styles.inc.php");
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ::::: НИЖНИЙ КОЛОНТИТУЛ (FOOTER)
#
$footer = $section->addFooter();
# Вставляем таблицу в верхний колонтитул (header)
$table = $footer->addTable(array('width' => 100 * 50, 'unit' => "pct", 'borderTopSize' => 10, 'borderTopColor' => "C0C0C0", 'cellMarginTop' => 100));
$table->addRow();
$cell = $table->addCell(8000, $_TBL_Body_Cell_Clear);
$textrun = $cell->addTextRun($_TXTRUN_Align_Left);
#
$_ISP_IOF = (!empty($_GET['isp_name'])) ? $_GET['isp_name'] : "";
$_ISP_TEL = (!empty($_GET['isp_tel'])) ? $_GET['isp_tel'] : "";
$_ISP_EMAIL = (!empty($_GET['isp_email'])) ? $_GET['isp_email'] : "";
$_NEWSROK = "";
#
$textrun->addText("Исполнитель: " . $_ISP_IOF, $_FONT_P7);
$textrun->addTextBreak();
$textrun->addText("Телефон: " . $_ISP_TEL, $_FONT_P7);
$textrun->addTextBreak();
$textrun->addText("Email: " . $_ISP_EMAIL, $_FONT_P7);
#
# Вставляем лого в среднюю ячейку
$cell = $table->addCell(12000, $_TBL_Body_Cell_Clear);
$src = $_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_4/letter2/export/_docx/logo_footer_cert.png";
$cell->addImage($src, array('width' => 320, 'height' => 46, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));
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
	//
	if ($pStyle == 0) {
		$section->addTextRun($_PARAGRAF_B);
	}
	if ($pStyle == 1) {
		$section->addTextRun($_PARAGRAF_1B);
	}
	if ($pStyle == 2) {
		$section->addTextRun($_PARAGRAF_2B);
	}
	if ($pStyle == 3) {
		$section->addTextRun($_PARAGRAF_3B);
	}
}
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# :::::
# ::::: ШАПКА ПИСЬМА
# :::::
#
#
$commonTable_styleName = 'Common Table';
$phpWord->addTableStyle($commonTable_styleName, $_TBL_Common_0, $_TBL_Header);
$innerTable_styleName = 'Inner Table';
$phpWord->addTableStyle($innerTable_styleName, $_InnerTBL_Common_0, $_InnerTBL_Header);
#
$tableCmn = $section->addTable($commonTable_styleName);
#
$tableCmn->addRow(350, $_TBL_Body_Row);
#
# -- + -- + -- + -- + -- + -- + -- + --
# Запрашиваем и выводим статус контрагентов
#
#
#
// В шапке письма слева
$cell = $tableCmn->addCell(5500, $_TBL_Body_Cell_Clear);
$src = $_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/docview/docview-current/restr_4/letter2/export/_docx/logo_header_atgs.png";
$cell->addImage($src, array('width' => 280, 'height' => 143, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
#
$innerTable = $cell->addTable($innerTable_styleName);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(11000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Center)->addText('', $_FONT_P9);
#
$innerTable->addRow(350, $_TBL_Body_Row);
$textrun = $innerTable->addCell(10000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Left);
$textrun->addText('№ ', $_FONT_P9);
$textrun->addText('_______________', $_FONT_P9_U);
$textrun->addText(' / ', $_FONT_P9);
$textrun->addText('_______________', $_FONT_P9_U);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(11000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Center)->addText('', $_FONT_P10_I);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(11000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Left)->addText('О переносе срока поставки', $_FONT_P12_I);
#
#
#
// В шапке письма справа
$_QRY_docbase = mysqlQuery("SELECT * FROM dognet_docbase WHERE koddoc = '" . $_GET['uniqueID1'] . "'");
$_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase);

$_QRY_ZAK_SP = mysqlQuery("SELECT * FROM sp_contragents WHERE kodcontragent = '" . $_GET['zak'] . "'");
$_ROW_ZAK_SP = mysqli_fetch_assoc($_QRY_ZAK_SP);
#
$_ZAK_HELLO = (!empty($_GET['zak_hello'])) ? $_GET['zak_hello'] : "Уважаемый";
$_ZAK_FIRSTNAME = !empty($_GET['zak_firstname']) ? $_GET['zak_firstname'] : (!empty($_ROW_ZAK_SP['director_firstname']) ? $_ROW_ZAK_SP['director_firstname'] : "");
$_ZAK_MIDNAME = !empty($_GET['zak_midname']) ? $_GET['zak_midname'] : (!empty($_ROW_ZAK_SP['director_middlename']) ? $_ROW_ZAK_SP['director_middlename'] : "");
$_ZAK_FIRSTNAME_HELLO = !empty($_GET['zak_firstname_hello']) ? $_GET['zak_firstname_hello'] : (!empty($_ROW_ZAK_SP['director_firstname']) ? $_ROW_ZAK_SP['director_firstname'] : "");
$_ZAK_MIDNAME_HELLO = !empty($_GET['zak_midname_hello']) ? $_GET['zak_midname_hello'] : (!empty($_ROW_ZAK_SP['director_middlename']) ? $_ROW_ZAK_SP['director_middlename'] : "");
$_ZAK_LASTNAME = !empty($_GET['zak_lastname']) ? $_GET['zak_lastname'] : (!empty($_ROW_ZAK_SP['director_lastname']) ? $_ROW_ZAK_SP['director_lastname'] : "");
$_ZAK_ORG = !empty($_GET['zak_org']) ? $_GET['zak_org'] : (!empty($_ROW_ZAK_SP['namefull']) ? $_ROW_ZAK_SP['namefull'] : "");
$_ZAK_DOLJ = !empty($_GET['zak_dolj']) ? $_GET['zak_dolj'] : (!empty($_ROW_ZAK_SP['director_post']) ? $_ROW_ZAK_SP['director_post'] : "");
#
$_ZAK_IOF = ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_LASTNAME)) ? $_ZAK_LASTNAME : "");
$_ZAK_FIO = ((!empty($_ZAK_LASTNAME)) ? $_ZAK_LASTNAME : "") . " " . ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ");
$_ZAK_IO = ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ");
#
$_NEWSROK = (isset($_GET['ondate']) && !empty($_GET['ondate'])) ? date("d.m.Y", strtotime($_GET['ondate'])) : "[ не указана ]";
#
$cell = $tableCmn->addCell(5500, $_TBL_Body_Cell_Clear);
#
$innerTable = $cell->addTable($innerTable_styleName);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(11000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right)->addText($_ZAK_DOLJ, $_FONT_P12_B);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(11000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right)->addText($_ZAK_ORG, $_FONT_P12_B);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(11000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right)->addText($_ZAK_FIO, $_FONT_P12_B);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----


printParagraphSeparator($phpWord, $section, 0);


# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ВЫВОДИМ ОБРАЩЕНИЕ
#
$section->addTitle($_ZAK_HELLO . " " . $_ZAK_FIRSTNAME_HELLO . " " . $_ZAK_MIDNAME_HELLO . "!", 1);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ВЫВОДИМ ТЕКСТ АКТА
#
mb_internal_encoding("UTF-8");
#
# Определяем валюту договора
# ----- ----- -----
$_QRY_dened = mysqlQuery("SELECT * FROM dognet_spdened WHERE koddened='" . $_ROW_docbase['koddened'] . "'");
$_ROW_dened = mysqli_fetch_assoc($_QRY_dened);
if ($_QRY_dened) {
	$_DENED = html_entity_decode($_ROW_dened['short_code']);
} else {
	$_DENED = " -.";
}
#
// Номер и дата договора
$doc_number = $_ROW_docbase['docnumberSTR'] != "" ? "3-4/" . $_ROW_docbase['docnumberSTR'] : "";
$doc_partnernumber = $_ROW_docbase['docpartnernumberSTR'] != "" ? $_ROW_docbase['docpartnernumberSTR'] . " / " : "";
$var1 = $_ROW_docbase['daynachdoc'];
$var2 = $_ROW_docbase['monthnachdoc'];
$var3 = $_ROW_docbase['yearnachdoc'];
$doc_date = numberFormat($var1, 2) . "." . numberFormat($var2, 2) . "." . $var3;
#
#
$textrun = $section->addTextRun($_PARAGRAF_3L);
$textrun->addText('Сообщаю Вам, что по договору поставки № ', $_FONT_P12);
$textrun->addText($doc_partnernumber, $_FONT_P12);
$textrun->addText($doc_number . ' от ', $_FONT_P12);
$textrun->addText($doc_date . ' г. ', $_FONT_P12);
#
$textrun->addText('задержка от поставщиков ряда комплектующих не позволяет завершить изготовление оборудования системы телемеханики СТН-3000-Р в установленные договором сроки.', $_FONT_P12);
$textrun = $section->addTextRun($_PARAGRAF_3L);
$textrun->addText('Исходя из вышеизложенного прошу Вас продлить срок поставки оборудования по договору до ', $_FONT_P12);
$textrun->addText($_NEWSROK . '.', $_FONT_P12_B);

printParagraphSeparator($phpWord, $section, 0);


# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ФУТЕР С ПОДПИСЯМИ
#
$tableCmn = $section->addTable($commonTable_styleName);
#
# ПОДПИСЬ СЛЕВА
$cell = $tableCmn->addRow(350, $_TBL_Body_Row)->addCell();
//
$innerTable = $cell->addTable($innerTable_styleName);
// Должность
$innerTable->addRow(350, $_TBL_Body_Row);
$innerTable->addCell(1000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right)->addText('', $_FONT_H14_B);
$innerTable->addCell(7000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Left)->addText('Искренне Ваш, ', $_FONT_H14_B);
$innerTable->addRow(350, $_TBL_Body_Row);
$innerTable->addCell(1000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right)->addText('', $_FONT_H14_B);
$innerTable->addCell(7000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Left)->addText('Первый заместитель генерального директора', $_FONT_H14_B);
#
# ПОДПИСЬ СПРАВА
$cell = $tableCmn->addCell();
//
$innerTable = $cell->addTable($innerTable_styleName);
// Должность
$innerTable->addRow(350, $_TBL_Body_Row);
$innerTable->addCell(7000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right)->addText("", $_FONT_P11);
$innerTable->addCell(1000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right)->addText('', $_FONT_H14_B);
$innerTable->addRow(350, $_TBL_Body_Row);
$textrun = $innerTable->addCell(7000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right);
$textrun->addText('А.В. Рощин', $_FONT_H14_B);
$innerTable->addCell(1000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right)->addText('', $_FONT_H14_B);





$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
// $xmlWriter->save("php://output");
$filepath = $_SERVER['DOCUMENT_ROOT'] . "/dognet/filestosend/";
$filename = "Письмо-Дог." . $_ROW_docbase['docnumberSTR'] . "-ПереносСроковПоставки-" . date('YmdHis') . ".docx";
$xmlWriter->save($filepath . $filename);

# Делаем запись в Журнале актов
if (isset($_GET['log']) && $_GET['log'] == 'yes') {

	$koddocjurnal = nextKoddocjurnal_letter();
	$kodzakaz = $_GET['zak'];
	$datecreateletter = date('Y-m-d');
	$numberdocletter = $_ROW_docbase['docnumber'];
	$summadocletter = "";
	$docactcreater = $_SESSION['lastname'] . " " . mb_substr($_SESSION['firstname'], 0, 1, 'utf-8') . "." . mb_substr($_SESSION['middlename'], 0, 1, 'utf-8') . ".";
	$nameactcreate = "Письмо о переносе сроков поставки";

	$_QRY_LOG = mysqlQuery("INSERT INTO dognet_docjurnallet (`koddel`, `koddocjurnal`, `kodzakaz`, `typeletter`, `datecreateletter`, `numberdocletter`, `sum_field1`, `sum_field2`, `text_field1`, `text_field2`, `docactcreater`, `nameactcreate`) VALUES ('', '$koddocjurnal', '$kodzakaz', 'ZDL', '$datecreateletter', '$numberdocletter', '', '', '', '', '$docactcreater', '$nameactcreate')");

	# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	# Сохраняем файл на сервере и прописываем ID в журнале
	if (isset($_GET['save']) && $_GET['save'] == 'yes') {
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		# :::
		# ::: О Б Р А Б О Т Ч И К   З А Г Р У З К И   Ф А Й Л А
		# :::
		$__CURRENT_YEAR = date('Y');
		# ----- --- ----- --- ----- ---
		# !!! ОЧЕНЬ ВАЖНЫЕ СТРОКИ !!!
		# ----- --- ----- --- ----- ---
		# Постоянная часть пути
		$Const_Part_Of_PATH = "/STORAGEDOC/DOCREPORTS/DREXP" . $__CURRENT_YEAR . "/";
		# Имя столбца в таблице файлов: file_truelocation
		# Путь, где распологается оригинальный файл
		$_QRY_GetStorageFolder = mysqlQuery("SELECT storagefolder_name FROM dognet_settings_storagefolders WHERE storagefolder_use = '1'");
		#
		$_ROW_GetStorageFolder = mysqli_fetch_assoc($_QRY_GetStorageFolder);
		if ($_QRY_GetStorageFolder) {
			$StorageName = $_ROW_GetStorageFolder['storagefolder_name'];
		}

		$d = dir($StorageName . $Const_Part_Of_PATH);
		$__DOCPATH = $d->path;
		# Имя столбца в таблице файлов: file_webpath
		# Формируем часть URL (без http://, имени хоста и сервиса) симлинка на оригинальный файл
		$__WEBPATH = $Const_Part_Of_PATH;
		# Имя столбца в таблице файлов: file_syspath
		# Серверный путь (PATH) к симлинку на оригинальный файл
		$__SYSPATH = $_SERVER['DOCUMENT_ROOT'] . "/dognet" . $Const_Part_Of_PATH;
		# Определяем расширение сохраняемого файла
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		# Формируем симлинк
		$md5 = md5(uniqid());
		$symname = "{$md5}.{$ext}";
		# Переименовываем реальный файл
		rename($filepath . $filename, $__DOCPATH . "{$filename}");
		# Формируем новый симлинк
		symlink($__DOCPATH . "{$filename}", $__SYSPATH . "{$symname}");
		# ----- --- ----- --- ----- ---
		#
		$__URL = "http://" . $_SERVER['HTTP_HOST'] . "/dognet" . $__WEBPATH . $symname;
		#
		#
		# ----- --- ----- --- ----- ---
		$docpath_filename = $__DOCPATH . $filename;
		$webpath_filename = $__WEBPATH . $filename;
		$syspath_filename = $__SYSPATH . $filename;
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		$_QRY_SAVE = mysqlQuery("INSERT INTO dognet_docjurnallet_files (`flag`, `koddocjurnal`, `kodzakaz`, `doc_rowid`, `file_year`, `file_id`, `file_name`, `file_originalname`, `file_extension`, `file_symname`, `file_size`, `file_truelocation`, `file_syspath`, `file_webpath`, `file_url`) VALUES ('', '$koddocjurnal', '$kodzakaz', '', '$__CURRENT_YEAR', '', '$filename', '$filename', '', '', '', '$docpath_filename', '$syspath_filename', '$webpath_filename', '$__URL')");
		# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
		$_QRY = mysqlQuery("SELECT id FROM dognet_docjurnallet_files WHERE koddocjurnal = " . $koddocjurnal);
		$_ROW = mysqli_fetch_assoc($_QRY);
		if ($_QRY) {
			$_QRY_UPD = mysqlQuery("UPDATE dognet_docjurnallet SET docFileID = " . $_ROW['id'] . " WHERE koddocjurnal = " . $koddocjurnal);
		}
	} else {
		$__URL = "http://" . $_SERVER['HTTP_HOST'] . "/dognet/filestosend/" . $filename;
	}
} else {
	$__URL = "http://" . $_SERVER['HTTP_HOST'] . "/dognet/filestosend/" . $filename;
}
/**
 * // Делаем запись в системный лог
 * // Все параметры в таблице portal_log_messages
 * // PORTAL_SYSLOG('99944200', '0000002', null, $_GET['docview_type'], "Письмо о возможном переносе сроков поставки", "WORD");
 */
?>


<script type="text/javascript" language="javascript" class="init">
	var reqField_sendMail = {
		sendMail: function(response) {}
	};

	function ajaxRequest_sendMail(filepath, koddoc, responseHandler) {
		// Fire off the request_addItem to /form.php
		request_sendMail = $.ajax({
			type: "post",
			url: '<?php echo __ROOT; ?>/dognet/php/examples/simple/docview/docview-current/restr_4/letter2/mailer/mailer-sendMessage-transferSrokPost-tip1.php',
			cache: false,
			data: {
				filepath: filepath,
				koddoc: koddoc,
			},
			success: reqField_sendMail[responseHandler]
		});
		// Callback handler that will be called on success
		request_sendMail.done(function(response, textStatus, jqXHR) {
			if (response === 'ok') {
				console.log('request_sendMail >> Sended! >>', response);
				$('#sendingStatus').html(
					'<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Письмо успешно отправлено.</div>'
				);
			} else {
				console.log('request_sendMail >> Error! >> \n', response);
				$('#sendingStatus').html(
					'<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Что-то при отправке письма пошло не так...</div>'
				);
			}
		});
		// Callback handler that will be called on failure
		request_sendMail.fail(function(jqXHR, textStatus, errorThrown) {
			console.error(
				"The following error occurred: " +
				textStatus, errorThrown
			);
		});
		// Callback handler that will be called regardless
		// if the request_addItem failed or succeeded
		request_sendMail.always(function() {});
	}
</script>

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
		font-family: "Stolzl Book", Arial, Helvetica Neue, Helvetica, sans-serif;
	}

	.return-link {
		color: #999;
		font-size: 1.0em;
		font-weight: 300;
	}

	.format-selected {
		color: #111;
		font-size: 1.35em;
		font-weight: 400;
		text-transform: uppercase
	}

	a.format-btn-selected {
		font-family: "Stolzl Book", Arial, Helvetica Neue, Helvetica, sans-serif;
		font-size: 1.5rem;
	}

	.senddoc-selected {
		color: #111;
		font-size: 1.15rem;
		font-weight: 400;
		text-transform: none
	}

	a.return-link,
	a.format-selected,
	a.senddoc-selected {
		text-decoration: underline
	}

	a.return-link:hover,
	a.format-selected:hover,
	a.senddoc-selected:hover {
		text-decoration: none
	}

	#exportControlLinks .btn {
		display: inline-block;
		padding: 6px 12px;
		margin-bottom: 0;
		font-size: 14px;
		background-image: none;
		border-radius: 4px;
	}

	#exportControlLinks .btn-download {
		font-family: "Stolzl Book", Arial, Helvetica Neue, Helvetica, sans-serif;
		color: #FFFFFF;
		background-color: #FF7707;
		border: 1px solid #FF7707;
	}

	#exportControlLinks .btn-download:hover {
		box-shadow: 0 0 0 2px #F44336 inset, 0 0 0 4px white inset;
	}

	#exportControlLinks .btn-send {
		font-family: "Stolzl Book", Arial, Helvetica Neue, Helvetica, sans-serif;
		color: #FFFFFF;
		background-color: #F44336;
		border: 1px solid #F44336;
	}

	#exportControlLinks .btn-send:hover {
		box-shadow: 0 0 0 2px #FF7707 inset, 0 0 0 4px white inset;
	}

	#report-info {
		font-family: "Stolzl Book", Arial, Helvetica Neue, Helvetica, sans-serif;
		color: #111;
		text-align: left;
		font-size: 0.9em;
		padding: 15px;
		margin-top: 10px;
		margin-bottom: 20px;
		line-height: 1.3em;
		background-color: #fafafa;
	}

	#report-info ol li {
		padding-left: 10px;
		margin-bottom: 5px;
	}
</style>

<div id="exportControlLinks" class="space30">
	<a href="<?php echo $__URL; ?>" class="btn btn-download btn-block format-btn-selected">Скачать/посмотреть
		сформированный
		документ</a>
	<a href="#noanchor" class="btn btn-send btn-block format-btn-selected">Отправить на email
		сформированный
		документ</a>
</div>
<div id="report-info" class="" style="text-align:center !important">
	<span class="text-danger">Письмо будет отправлено на email Романа Тимофеева (tim@atgs.ru)</span>
</div>
<div id="sendingStatus" class=""></div>
<div id="linksTo" class=""></div>

<script type="text/javascript">
	host = '<?php echo $_SERVER["HTTP_HOST"]; ?>';
	uniqueID1 = '<?php echo $_GET["uniqueID1"]; ?>';
	zak = '<?php echo $_GET["zak"]; ?>';
	url1 = 'http://' + host + '/dognet/dognet-docview.php?docview_type=current';
	url2 = 'http://' + host +
		'/dognet/dognet-docview.php?docview_type=current&export=yes&tip=letter_transfer&uniqueID1=' +
		uniqueID1 + '&zak=' + zak;
	document.getElementById("linksTo").innerHTML =
		"<div class='space10'><span style='padding:0 15px'><a class='return-link' href=" +
		url2 + ">Сформировать документ снова</a></span></div>";


	$('a.btn-send').on('click', function(e) {
		var filepath = "<?php echo $filepath . $filename; ?>";
		var fileurl = "<?php echo $__URL; ?>";
		ajaxRequest_sendMail(filepath, "<?php echo $_GET['uniqueID1']; ?>", "sendMail");
	});
</script>