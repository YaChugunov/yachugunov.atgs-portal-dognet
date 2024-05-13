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
$properties->setTitle('Письмо о направлении акта выполненных работ');
$properties->setDescription('Письмо о направлении акта выполненных работ');
$properties->setCategory('Письма');
$properties->setLastModifiedBy('АТГС.Портал');
$properties->setCreated(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setModified(mktime(Date('H'), Date('i'), Date('s'), Date('m'), Date('d'), Date('Y')));
$properties->setSubject('Письмо о направлении акта выполненных работ');
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
require($_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/actview/actview-current/restr_5/export-letter/_docx/export2docx_styles.inc.php");
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
#
$textrun->addText("Исполнитель: " . $_ISP_IOF, $_FONT_P7);
$textrun->addTextBreak();
$textrun->addText("Телефон: " . $_ISP_TEL, $_FONT_P7);
$textrun->addTextBreak();
$textrun->addText("Email: " . $_ISP_EMAIL, $_FONT_P7);
#
# Вставляем лого в среднюю ячейку
$cell = $table->addCell(12000, $_TBL_Body_Cell_Clear);
$src = $_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/actview/actview-current/restr_5/export-letter/_docx/logo_footer_cert.png";
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
$cell = $tableCmn->addCell(10000, $_TBL_Body_Cell_Clear);
$src = $_SERVER['DOCUMENT_ROOT'] . "/dognet/php/examples/simple/actview/actview-current/restr_5/export-letter/_docx/logo_header_atgs.png";
$cell->addImage($src, array('width' => 280, 'height' => 143, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
#
$innerTable = $cell->addTable($innerTable_styleName);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(10000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Center)->addText('', $_FONT_P9);
#
$innerTable->addRow(350, $_TBL_Body_Row);
$textrun = $innerTable->addCell(10000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Left);
$textrun->addText('№ ', $_FONT_P9);
$textrun->addText('_______________', $_FONT_P9_U);
$textrun->addText(' / ', $_FONT_P9);
$textrun->addText('_______________', $_FONT_P9_U);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(10000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Center)->addText('', $_FONT_P10_I);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(10000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Left)->addText('О подписании акта', $_FONT_P12_I);
#
#
#
// В шапке письма справа
$_QRY_docbase = mysqlQuery("SELECT * FROM dognet_docbase WHERE koddoc = '" . $_GET['uniqueID1'] . "'");
$_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase);
if ($_QRY_docbase) {
	$_DOC_NUMBER = $_ROW_docbase['docnumber'];
	$_DOC_DAYNACH = $_ROW_docbase['daynachdoc'];
	$_DOC_MONTHNACH = $_ROW_docbase['monthnachdoc'];
	$_DOC_YEARNACH = $_ROW_docbase['yearnachdoc'];
	$_DOC_DATE = numberFormat($_DOC_DAYNACH, 2) . "." . numberFormat($_DOC_MONTHNACH, 2) . "." . $_DOC_YEARNACH;
} else {
	$_DOC_NUMBER = "---";
}
if (!empty($_GET['fio_manual']) && isset($_GET['fio_manual']) && $_GET['fio_manual'] == "yes") {
	$_ZAK_HELLO = $_GET['zak_lastname'];
	$_ZAK_FIRSTNAME = $_GET['zak_firstname'];
	$_ZAK_MIDNAME = $_GET['zak_midname'];
	$_ZAK_LASTNAME = $_GET['zak_lastname'];
	$_ZAK_ORG = $_GET['zak_org'];
	$_ZAK_DOLG = $_GET['zak_dolg'];

	$_ZAK_IOF = ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_LASTNAME)) ? $_ZAK_LASTNAME : "");
	$_ZAK_FIO = ((!empty($_ZAK_LASTNAME)) ? $_ZAK_LASTNAME : "") . " " . ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ");
	$_ZAK_IO = ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ");
} else {
	$_QRY_ZAK_SP = mysqlQuery("SELECT * FROM sp_contragents WHERE kodzakaz = '" . $_GET['zak'] . "'");
	$_ROW_ZAK_SP = mysqli_fetch_assoc($_QRY_ZAK_SP);

	$_ZAK_HELLO = "";
	$_ZAK_FIRSTNAME = (!empty($_ROW_ZAK_SP['zakfistname'])) ? $_ROW_ZAK_SP['zakfistname'] : "";
	$_ZAK_MIDNAME = (!empty($_ROW_ZAK_SP['zakmidname'])) ? $_ROW_ZAK_SP['zakmidname'] : "";
	$_ZAK_LASTNAME = (!empty($_ROW_ZAK_SP['zaklastname'])) ? $_ROW_ZAK_SP['zaklastname'] : "";
	$_ZAK_ORG = (!empty($_ROW_ZAK_SP['namezaklong'])) ? $_ROW_ZAK_SP['namezaklong'] : "";
	$_ZAK_DOLG = (!empty($_ROW_ZAK_SP['zakdolg'])) ? $_ROW_ZAK_SP['zakdolg'] : "";

	$_ZAK_IOF = ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_LASTNAME)) ? $_ZAK_LASTNAME : "");
	$_ZAK_FIO = ((!empty($_ZAK_LASTNAME)) ? $_ZAK_LASTNAME : "") . " " . ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ");
	$_ZAK_IO = ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ");
}
#
$cell = $tableCmn->addCell(10000, $_TBL_Body_Cell_Clear);
#
$innerTable = $cell->addTable($innerTable_styleName);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(10000, $_InnerTBL_Body_Cell)->addTitle($_ZAK_DOLG, 2);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(10000, $_InnerTBL_Body_Cell)->addTitle($_ZAK_ORG, 2);
#
$innerTable->addRow(250, $_TBL_Body_Row);
$innerTable->addCell(10000, $_InnerTBL_Body_Cell)->addTitle($_ZAK_FIO, 2);
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----


printParagraphSeparator($phpWord, $section, 0);


# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# ВЫВОДИМ ОБРАЩЕНИЕ
#
$section->addTitle("Уважаемый " . $_ZAK_FIRSTNAME . " " . $_ZAK_MIDNAME . "!", 1);
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
#
$textrun = $section->addTextRun($_PARAGRAF_3L);
$textrun->addText('Направляю Вам на подписание акт сдачи-приемки выполненных работ по договору ', $_FONT_P12);
$textrun->addText('№3-4/' . $_DOC_NUMBER . ' от ' . $_DOC_DATE . ".", $_FONT_P12);
$textrun = $section->addTextRun($_PARAGRAF_3L);
$textrun->addText('После подписания прошу Вас направить скан-копию подписанного акта по электронной почте на адрес ' . $_ISP_EMAIL . ' для выставления счета-фактуры. Два экземпляра оригинала акта прошу Вас выслать по адресу: РФ, 109388, г.Москва, ул.Полбина, д.11.', $_FONT_P12);
#
# Дополнительная фраза
# ----- ----- -----
$textrun = $section->addTextRun($_PARAGRAF_3L);
$textrun->addText('Приложение к письму: Акт сдачи-приемки выполненных работ по договору №3-4/' . $_DOC_NUMBER . ' от ' . $_DOC_DATE . ' в 4-х экземплярах.', $_FONT_P12_I);


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
$innerTable->addCell(7000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Left)->addText('Генеральный директор', $_FONT_H14_B);
#
# ПОДПИСЬ СПРАВА
$cell = $tableCmn->addCell();
//
$innerTable = $cell->addTable($innerTable_styleName);
// Должность
$innerTable->addRow(350, $_TBL_Body_Row);
$textrun = $innerTable->addCell(7000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right);
$textrun->addText('Л.И. Бернер', $_FONT_H14_B);
$innerTable->addCell(1000, $_InnerTBL_Body_Cell)->addTextRun($_TXTRUN_Align_Right)->addText('', $_FONT_H14_B);





$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
// $xmlWriter->save("php://output");
$filepath = $_SERVER['DOCUMENT_ROOT'] . "/dognet/tmp/";
$filename = "LETTER-ABOUTACT_" . date('YmdHis') . ".DOCX";
$xmlWriter->save($filepath . $filename);

# Делаем запись в Журнале актов
if (isset($_GET['log']) && $_GET['log'] == 'yes') {

	$koddocjurnal = nextKoddocjurnal_letter();
	$kodzakaz = $_GET['zak'];
	$datecreateletter = date('Y-m-d H:i:s');
	$numberdocletter = $_ROW_docbase['docnumber'];
	$summadocletter = "";
	$docactcreater = $_SESSION['lastname'] . " " . mb_substr($_SESSION['firstname'], 0, 1, 'utf-8') . "." . mb_substr($_SESSION['middlename'], 0, 1, 'utf-8') . ".";
	$nameactcreate = "Письмо об акте";

	$_QRY_LOG = mysqlQuery("INSERT INTO dognet_docjurnallet (`koddel`, `koddocjurnal`, `kodzakaz`, `typeletter`, `datecreateletter`, `numberdocletter`, `sum_field1`, `sum_field2`, `text_field1`, `text_field2`, `docactcreater`, `nameactcreate`) VALUES ('', '$koddocjurnal', '$kodzakaz', 'ACT', '$datecreateletter', '$numberdocletter', '$summadocletter', '', '', '', '$docactcreater', '$nameactcreate')");

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
	}
}

// Делаем запись в системный лог
// Все параметры в таблице portal_log_messages
PORTAL_SYSLOG('99944200', '0000002', null, $_GET['uniqueID1'], "Письмо о направлении акта", "WORD");

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
		<a class="format-selected" href="<?php echo $__URL; ?>">Скачать документ</a>
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