<?php

# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# Создаем страницу
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// Создаем новый лист
		$objPHPExcel->createSheet();
// Устанавливаем индекс активного листа
		$cntsheets = $objPHPExcel->getSheetCount();
		$objPHPExcel->setActiveSheetIndex($cntsheets-1);
// Получаем активный лист
		$activeSheet = $objPHPExcel->getActiveSheet();
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# Подготавляваем страницу
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Вставляем лого в колонтитул
$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
$objDrawing->setName('АТГС.Договор');
// $objDrawing->setPath('logo_dognet.png');
// $objDrawing->setHeight(36);
// $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
#
// Ориентация страницы и  размер листа
$activeSheet->getPageSetup()
       ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$activeSheet->getPageSetup()
       ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
#
// $activeSheet->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
// Задаем повторяющиеся строки листа
$activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 3);
#
// Задаем область печати
$activeSheet->getPageSetup()->setFitToWidth(1);
$activeSheet->getPageSetup()->setFitToHeight(0);
// $activeSheet->getPageSetup()->setPrintArea('A1:E100');
#
// Поля документа
$activeSheet->getPageMargins()->setTop(1);
$activeSheet->getPageMargins()->setRight(0.75);
$activeSheet->getPageMargins()->setLeft(0.75);
$activeSheet->getPageMargins()->setBottom(1);
#
// Название листа
$activeSheet->setTitle('Судебная');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12СПРАВКА О ЗАДОЛЖЕННОСТИ&R&G&B&12По счетам-фактурам для договоров');
$activeSheet->getHeaderFooter()->setOddFooter('&11&L&B'.$_SESSION["current_user_firstname"].' '.$_SESSION["current_user_lastname"].' / '.date('d.m.Y H:i:s').'&R&11Страница &P из &N');
#
// Настройки шрифта
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
// Задаем свой формат
define("PRICE_FORMAT_2", PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1. "[\$ р.-419]");
// Предопределим массивы оформления границы ячеек
$_BORDER_RIGHT = array('borders'=>array('right'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_RIGHT_NONE = array('borders'=>array('right'=>array('style'=>PHPExcel_Style_Border::BORDER_NONE)));
$_BORDER_LEFT = array('borders'=>array('left'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_LEFT_NONE = array('borders'=>array('left'=>array('style'=>PHPExcel_Style_Border::BORDER_NONE)));
// Внешняя рамка, тонкая
$_BORDER_OUTSIDE_THIN = array('borders'=>array('outline'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
// Внешняя рамка, толстая
$_BORDER_OUTSIDE_THICK = array('borders'=>array('outline'=>array('style'=>PHPExcel_Style_Border::BORDER_THICK,'color'=>array('rgb'=>'000000'))));
// Внутренние разделители
$_BORDER_INSIDE = array('borders'=>array('inside'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_INSIDE_NONE = array('borders'=>array('inside'=>array('style'=>PHPExcel_Style_Border::BORDER_NONE)));
$_BORDER_TOP = array('borders'=>array('top'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_BOTTOM_THIN = array('borders'=>array('bottom'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN,'color'=>array('rgb'=>'000000'))));
$_BORDER_BOTTOM_THICK = array('borders'=>array('bottom'=>array('style'=>PHPExcel_Style_Border::BORDER_THICK,'color'=>array('rgb'=>'000000'))));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(50); // Организация / Договор / Этап
$activeSheet->getColumnDimension('B')->setWidth(10); // С/Ф №
$activeSheet->getColumnDimension('C')->setWidth(20); // Дата С/Ф
$activeSheet->getColumnDimension('D')->setWidth(20); // Сумма
$activeSheet->getColumnDimension('E')->setWidth(20); // Авансы
$activeSheet->getColumnDimension('F')->setWidth(20); // Оплаты
$activeSheet->getColumnDimension('G')->setWidth(25); // Задолженность
$activeSheet->getColumnDimension('H')->setWidth(20); // Срок оплаты
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'Судебная задолженность');
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(32);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:H{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(20);
# ----- ----- ----- ----- -----
# СТРОКА 2
# ----- ----- ----- ----- -----
// Пропускаем строку
$line++;
$activeSheet->setCellValue("A{$line}", '');
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$line++;
$start_table = $line;
// Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'ОРГАНИЗАЦИЯ / ДОГОВОР / ЭТАП');
$activeSheet->setCellValue("B{$line}", 'С/Ф №');
$activeSheet->setCellValue("C{$line}", 'ДАТА');
$activeSheet->setCellValue("D{$line}", 'СУММА');
$activeSheet->setCellValue("E{$line}", 'АВАНСЫ');
$activeSheet->setCellValue("F{$line}", 'ОПЛАТЫ');
$activeSheet->setCellValue("G{$line}", 'ЗАДОЛЖЕННОСТЬ');
$activeSheet->setCellValue("H{$line}", 'СРОК ОПЛАТЫ');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(32); // высота строки
$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setSize(12); // размер шрифта
$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:H{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // выравнивание по горизонтали - лево
$activeSheet->getStyle("B{$line}:H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // выравнивание по горизонтали - центр
$activeSheet->getStyle("A{$line}:H{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // вырванивание по вертикали - середина
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->getStartColor()->setRGB("F1F1F1");
// Оформляем границы
		$activeSheet->getStyle("A{$line}:H{$line}")->applyFromArray($_BORDER_INSIDE);
		$activeSheet->getStyle("A{$line}:H{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$_queryStr = "SELECT * FROM sp_contragents WHERE kodzakaz IN (SELECT kodzakaz FROM dognet_docbase WHERE ";
//
	$B1 = (!empty($_GET['doc'])&&isset($_GET['doc'])&&$_GET['doc']=='yes') ? "1" : "0";
	$B2 = (!empty($_GET['cht'])&&isset($_GET['cht'])&&$_GET['cht']=='yes') ? "1" : "0";
	$BB = $B1.$B2;
	if (checkUserRestrictions($_SESSION['id'],'dognet',5,1)==1) {
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
$_queryStr .= "kodstatuszdl='2' AND koddoc IN (SELECT koddoc FROM dognet_reports_zadolchf)) ORDER BY namezakshot ASC";
//
$_QRY = mysqlQuery($_queryStr);
#
#
$_SUM_summazadol_total = 0.00;
while($_ROW = mysqli_fetch_assoc($_QRY)) {
#
#
// Задаем высоту строки и шрифт ( ФИО пользователя )
	$activeSheet->getRowDimension($line)->setRowHeight(32);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setSize(13);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setBold(true);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setName('Arial Narrow');
// Задаем цвет заливки строки ( ФИО пользователя )
	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->getStartColor()->setRGB("111111");
// Задаем цвет текста строки ( ФИО пользователя )
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->getColor()->setRGB('FAFAFA');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:H{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:H{$line}");
// Вывод данных
	$activeSheet->setCellValue("A{$line}", $_ROW['namezakshot']);
// Оформляем границы
	$activeSheet->getStyle("A{$line}:H{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	$_queryStr = "SELECT * FROM dognet_docbase WHERE kodzakaz='".$_ROW['kodzakaz']."' AND ";
//
$B1 = (!empty($_GET['doc'])&&isset($_GET['doc'])&&$_GET['doc']=='yes') ? "1" : "0";
$B2 = (!empty($_GET['cht'])&&isset($_GET['cht'])&&$_GET['cht']=='yes') ? "1" : "0";
$BB = $B1.$B2;
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
	$_queryStr .= "kodstatuszdl='2' AND koddoc IN (SELECT koddoc FROM dognet_reports_zadolchf)";
//
	$_QRY_docbase = mysqlQuery($_queryStr);
	$_SUM_summazadol_zakaz = 0.00;
#
#
	while($_ROW_docbase = mysqli_fetch_assoc($_QRY_docbase)) {
		$_QRY_dened = mysqlQuery( "SELECT * FROM dognet_spdened WHERE koddened='".$_ROW_docbase['koddened']."'" );
		$_ROW_dened = mysqli_fetch_assoc($_QRY_dened);
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
#
#
// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(28);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setSize(12);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setBold(true); // делаем шрифт жирным
// Задаем цвет заливки строки
// 	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
// 	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->getStartColor()->setRGB("F1F1F1");
// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:H{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:H{$line}");
// Вывод данных
if ($_ROW_docbase['kodshab']==0) {
	$activeSheet->setCellValue("A{$line}", 'Счет №'.$_ROW_docbase['docnumber']);
}
else {
	$activeSheet->setCellValue("A{$line}", 'Договор №3-4/'.$_ROW_docbase['docnumber']);
}
// Оформляем границы
	$activeSheet->getStyle("A{$line}:H{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) {
		$_QRY_dockalplan_Str = "SELECT * FROM dognet_dockalplan WHERE koddel<>'99' AND koddoc='".$_ROW_docbase['koddoc']."' AND kodkalplan IN (SELECT kodkalplan FROM dognet_reports_zadolchf)";
}
if (($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) {
		$_QRY_dockalplan_Str = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND numberchet='' AND koddoc='".$_ROW_docbase['koddoc']."' AND (kodshab='2' OR kodshab='4') AND koddoc IN (SELECT koddoc FROM dognet_reports_zadolchf)";
}
if ($_ROW_docbase['kodshab']==0) {
		$_QRY_dockalplan_Str = "SELECT * FROM dognet_docbase WHERE koddel<>'99' AND numberchet<>'' AND koddoc='".$_ROW_docbase['koddoc']."' AND kodshab='0' AND koddoc IN (SELECT koddoc FROM dognet_reports_zadolchf)";
}
#
#
$_QRY_dockalplan = mysqlQuery($_QRY_dockalplan_Str);
#
#
		while($_ROW_dockalplan = mysqli_fetch_assoc($_QRY_dockalplan)) {

			if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) { $_SROKOPL = $_ROW_dockalplan['srokopl']; }
			elseif (($_ROW_docbase['kodshab']==0)OR($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) { $_SROKOPL = $_ROW_docbase['srokdoc']; }
#
#
// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(28);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setSize(11);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setBold(false);
// Задаем цвет заливки строки ( ФИО пользователя )
// 	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
// 	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->getStartColor()->setRGB("FAFAFA");
// Задаем цвет текста строки ( ФИО пользователя )
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->getColor()->setRGB('333333');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:H{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:H{$line}");
// Вывод данных
if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) {
	$activeSheet->setCellValue("A{$line}", 'Этап '.$_ROW_dockalplan['numberstage']." : ".$_ROW_dockalplan['nameshotstage']);
}
elseif (($_ROW_docbase['kodshab']==0)OR($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) {
	$activeSheet->setCellValue("A{$line}", 'Без этапа');
}
// Оформляем границы
		$activeSheet->getStyle("A{$line}:H{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) {
			$_QRY_kalplanchf = mysqlQuery( "SELECT dognet_kalplanchf.chetfnumber, dognet_kalplanchf.chetfdate, dognet_kalplanchf.chetfsumma, dognet_reports_zadolchf.summaoplav, dognet_reports_zadolchf.summaopl, dognet_reports_zadolchf.summazadol FROM dognet_kalplanchf INNER JOIN dognet_reports_zadolchf ON dognet_kalplanchf.kodchfact = dognet_reports_zadolchf.kodchfact WHERE dognet_kalplanchf.kodkalplan='".$_ROW_dockalplan['kodkalplan']."'");
}
elseif (($_ROW_docbase['kodshab']==0)OR($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) {
			$_QRY_kalplanchf = mysqlQuery( "SELECT dognet_kalplanchf.chetfnumber, dognet_kalplanchf.chetfdate, dognet_kalplanchf.chetfsumma, dognet_reports_zadolchf.summaoplav, dognet_reports_zadolchf.summaopl, dognet_reports_zadolchf.summazadol FROM dognet_kalplanchf INNER JOIN dognet_reports_zadolchf ON dognet_kalplanchf.kodchfact = dognet_reports_zadolchf.kodchfact WHERE dognet_kalplanchf.kodkalplan='".$_ROW_docbase['koddoc']."'");
}

			while($_ROW_kalplanchf = mysqli_fetch_assoc($_QRY_kalplanchf)) {
			//
				$_CHFDATE = $_ROW_kalplanchf['chetfdate'];
			//
				$chetfsumma = $_ROW_kalplanchf['chetfsumma'];
				$summaoplav = $_ROW_kalplanchf['summaoplav'];
				$summaopl = $_ROW_kalplanchf['summaopl'];
				$summazadol = $_ROW_kalplanchf['summazadol'];
				$tmp = $chetfsumma+$summaoplav+$summaopl+$summazadol;
			//
				$string = $_ROW_kalplanchf['chetfdate']; // Наша дата в string
				$format = 'd.m.Y'; // формат даты (все: https://www.php.net/manual/ru/function.date.php)
				$date = new DateTime($string);
				$chfdate = $date->format($format);
			// Прибавить дни или оставить ПКЗ
				if (($_ROW_docbase['kodshab']==1)OR($_ROW_docbase['kodshab']==3)) {
					if ($_SROKOPL != "ПКЗ") {
						$date->modify('+'.$_SROKOPL.' days');
						$srokopl = $date->format($format);
					}
					else {
						$srokopl = $_SROKOPL;
					}
				}
				if (($_ROW_docbase['kodshab']==0)OR($_ROW_docbase['kodshab']==2)OR($_ROW_docbase['kodshab']==4)) {
					if ($_ROW_docbase['idsrokdoc']==0) {
						if ($_ROW_docbase['srokdoc']!="") {
							$date->modify('+'.$_SROKOPL.' days');
							$srokopl = $date->format($format);
						}
						else {
							$srokopl = "Не указан";
						}
					}
					if ($_ROW_docbase['idsrokdoc']==1) {
						if ($_ROW_docbase['srokdoc']!="") {
							$srokopl = str_replace('/', '.', $_SROKOPL);
						}
						else {
							$srokopl = "Не указан";
						}
					}
					else {
						$srokopl = "Не указан";
					}
				}
#
#
// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(20);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setSize(10);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setBold(false);
// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->getColor()->setRGB('666666');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:H{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("B{$line}:H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->setCellValue("A{$line}", '');
	$activeSheet->setCellValue("B{$line}", $_ROW_kalplanchf['chetfnumber']);
	$activeSheet->setCellValue("C{$line}", $chfdate);
	$activeSheet->setCellValue("D{$line}", $chetfsumma);
		$activeSheet->getStyle("D{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_2);
	$activeSheet->setCellValue("E{$line}", $summaoplav);
		$activeSheet->getStyle("E{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_2);
	$activeSheet->setCellValue("F{$line}", $summaopl);
		$activeSheet->getStyle("F{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_2);
	$activeSheet->setCellValue("G{$line}", $summazadol);
		$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_2);
	$activeSheet->setCellValue("H{$line}", $srokopl);
// Оформляем границы
		$activeSheet->getStyle("A{$line}:H{$line}")->applyFromArray($_BORDER_INSIDE);
		$activeSheet->getStyle("A{$line}:H{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
			// Суммируем суммы счето-фактур
				$_SUM_chetfsumma += $chetfsumma;
				$_SUM_summaoplav += $summaoplav;
				$_SUM_summaopl += $summaopl;
				$_SUM_summazadol_doc += $summazadol;
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
			}
		}
		$_SUM_summazadol_zakaz += $_SUM_summazadol_doc;
#
#
// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(28);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setName('Arial');
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setSize(12);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setBold(true); // делаем шрифт жирным
// Задаем цвет заливки строки ( ФИО пользователя )
	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->getStartColor()->setRGB("E0E0E0");
// Задаем цвет текста строки ( ФИО пользователя )
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:H{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Объединяем ячейки по горизонтали
	$activeSheet->mergeCells("A{$line}:G{$line}");
// Вывод данных
	$activeSheet->setCellValue("A{$line}", 'ИТОГО ПО ДОГОВОРУ');
	$activeSheet->setCellValue("H{$line}", $_SUM_summazadol_doc);
	$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_2);
// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Оформляем границы
		$activeSheet->getStyle("A{$line}:H{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
	}
	$_SUM_summazadol_total += $_SUM_summazadol_zakaz;
#
#
// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(32);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setName('Arial');
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setSize(13);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setBold(true); // делаем шрифт жирным
// Задаем цвет заливки строки ( ФИО пользователя )
	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->getStartColor()->setRGB("D0D0D0");
// Задаем цвет текста строки ( ФИО пользователя )
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:H{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Объединяем ячейки по горизонтали
	$activeSheet->mergeCells("A{$line}:G{$line}");
// Вывод данных
	$activeSheet->setCellValue("A{$line}", 'ИТОГО ПО ЗАКАЗЧИКУ');
	$activeSheet->setCellValue("H{$line}", $_SUM_summazadol_zakaz);
	$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_2);
// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Оформляем границы
		$activeSheet->getStyle("A{$line}:H{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
}
#
#
// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(32);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setName('Arial');
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setSize(14);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->setBold(true); // делаем шрифт жирным
// Задаем цвет заливки строки ( ФИО пользователя )
	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$activeSheet->getStyle("A{$line}:H{$line}")->getFill()->getStartColor()->setRGB("FFFFFF");
// Задаем цвет текста строки ( ФИО пользователя )
	$activeSheet->getStyle("A{$line}:H{$line}")->getFont()->getColor()->setRGB('111111');
// Выравниваем строку по вертикали ( середина )
	$activeSheet->getStyle("A{$line}:H{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Объединяем ячейки по горизонтали
	$activeSheet->mergeCells("A{$line}:G{$line}");
// Вывод данных
	$activeSheet->setCellValue("A{$line}", 'ОБЩАЯ ЗАДОЛЖЕННОСТЬ');
	$activeSheet->setCellValue("H{$line}", $_SUM_summazadol_total);
	$activeSheet->getStyle("H{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("H{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Оформляем границы
		$activeSheet->getStyle("A{$line}:H{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
	$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
	$line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:H{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:H{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);
