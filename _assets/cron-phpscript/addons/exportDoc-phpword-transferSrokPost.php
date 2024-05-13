<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('Europe/Moscow');
setlocale(LC_ALL, 'rus');
#
#
require("/var/www/html/atgs-portal.local/www/dognet/_assets/_PHPOffice/vendor/autoload.php");
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
include("/var/www/html/atgs-portal.local/www/dognet/_assets/cron-phpscript/addons/exportDocStyles-phpword-transferSrokPost.php");
#
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
$_ISP_IOF = (!empty($_ispName)) ? $_ispName : "";
$_ISP_TEL = (!empty($_ispTel)) ? $_ispTel : "";
$_ISP_EMAIL = (!empty($_ispEmail)) ? $_ispEmail : "";
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
$src = "/var/www/html/atgs-portal.local/www/dognet/_assets/cron-phpscript/addons/logo_footer_cert.png";
$cell->addImage($src, array('width' => 320, 'height' => 46, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
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
$src = "/var/www/html/atgs-portal.local/www/dognet/_assets/cron-phpscript/addons/logo_header_atgs.png";
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
$_QRY_docbase = mysqlQuery("SELECT * FROM dognet_docbase WHERE koddoc = '{$_koddoc}'");
$_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase);

$_QRY_ZAK_SP = mysqlQuery("SELECT * FROM sp_contragents WHERE kodcontragent = '{$_kodzakaz}'");
$_ROW_ZAK_SP = mysqli_fetch_assoc($_QRY_ZAK_SP);
#
$_ZAK_HELLO = (!empty($_zakHello)) ? $_zakHello : "Уважаемый";
$_ZAK_FIRSTNAME = !empty($_zakFirstName_D) ? $_zakFirstName_D : (!empty($_ROW_ZAK_SP['director_firstname']) ? $_ROW_ZAK_SP['director_firstname'] : "");
$_ZAK_MIDNAME = !empty($_zakMidName_D) ? $_zakMidName_D : (!empty($_ROW_ZAK_SP['director_middlename']) ? $_ROW_ZAK_SP['director_middlename'] : "");
$_ZAK_FIRSTNAME_HELLO = !empty($_zakFirstName) ? $_zakFirstName : (!empty($_ROW_ZAK_SP['director_firstname']) ? $_ROW_ZAK_SP['director_firstname'] : "");
$_ZAK_MIDNAME_HELLO = !empty($_zakMidName) ? $_zakMidName : (!empty($_ROW_ZAK_SP['director_middlename']) ? $_ROW_ZAK_SP['director_middlename'] : "");
$_ZAK_LASTNAME = !empty($_zakLastName_D) ? $_zakLastName_D : (!empty($_ROW_ZAK_SP['director_lastname']) ? $_ROW_ZAK_SP['director_lastname'] : "");
$_ZAK_ORG = !empty($_zakOrg) ? $_zakOrg : (!empty($_ROW_ZAK_SP['namefull']) ? $_ROW_ZAK_SP['namefull'] : "");
$_ZAK_DOLJ = !empty($_zakDolj_D) ? $_zakDolj_D : (!empty($_ROW_ZAK_SP['director_post']) ? $_ROW_ZAK_SP['director_post'] : "");
#
$_ZAK_IOF = ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_LASTNAME)) ? $_ZAK_LASTNAME : "");
$_ZAK_FIO = ((!empty($_ZAK_LASTNAME)) ? $_ZAK_LASTNAME : "") . " " . ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ");
$_ZAK_IO = ((!empty($_ZAK_FIRSTNAME)) ? mb_substr($_ZAK_FIRSTNAME, 0, 1, 'utf-8') . ". " : " ") . ((!empty($_ZAK_MIDNAME)) ? mb_substr($_ZAK_MIDNAME, 0, 1, 'utf-8') . ". " : " ");
#
$_NEWSROK = (isset($_docSrok) && !empty($_docSrok)) ? $_docSrok : "[ не указана ]";
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
$textrun->addText('Сообщаю Вам, что по договору поставки №', $_FONT_P12);
$textrun->addText($doc_partnernumber, $_FONT_P12);
$textrun->addText($doc_number . ' от ', $_FONT_P12);
$textrun->addText($doc_date . 'г. ', $_FONT_P12);
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
#
# СОХРАНЯЕМ ФАЙЛ
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
// $xmlWriter->save("php://output");
$filepath = "/var/www/html/atgs-portal.local/www/dognet/filestosend/";
$filename = "Письмо-Дог." . $_ROW_docbase['docnumberSTR'] . "-ПереносСроковПоставки-" . date('YmdHis') . ".docx";
$xmlWriter->save($filepath . $filename);
