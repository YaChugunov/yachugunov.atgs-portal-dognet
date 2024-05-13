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
$objPHPExcel->setActiveSheetIndex($cntsheets - 1);
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
$activeSheet->setTitle('Перечень договоров');
#
// Колонтитулы
$activeSheet->getHeaderFooter()->setOddHeader('&L&G&B&12ПЕРЕЧЕНЬ ДОГОВОРОВ&R&G&B&12');
$activeSheet->getHeaderFooter()->setOddFooter('&11&L&B' . $_SESSION["current_user_firstname"] . ' ' . $_SESSION["current_user_lastname"] . ' / ' . date('d.m.Y H:i:s') . '&R&11Страница &P из &N');
#
// Настройки шрифта
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
// Задаем свой формат
define("PRICE_FORMAT_1", PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 . "[\$ р.-419]");
// Предопределим массивы оформления границы ячеек
$_BORDER_RIGHT = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_RIGHT_NONE = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));
$_BORDER_LEFT = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_LEFT_NONE = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));
// Внешняя рамка, тонкая
$_BORDER_OUTSIDE_THIN = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
// Внешняя рамка, толстая
$_BORDER_OUTSIDE_THICK = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => array('rgb' => '000000'))));
// Внутренние разделители
$_BORDER_INSIDE = array('borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_INSIDE_NONE = array('borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_NONE)));
$_BORDER_TOP = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_BOTTOM_THIN = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))));
$_BORDER_BOTTOM_THICK = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THICK, 'color' => array('rgb' => '000000'))));
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// $start_date = date("Y-m-d", strtotime($_GET['start_date']));
// $end_date = date("Y-m-d", strtotime($_GET['end_date']));
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
# ФОРМАТИРУЕМ ВЫХОДНУЮ ТАБЛИЦУ EXCEL
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
// Задаем ширины столбцов
$activeSheet->getColumnDimension('A')->setWidth(15); // Номер договора
$activeSheet->getColumnDimension('B')->setWidth(10); // Шаблон
$activeSheet->getColumnDimension('C')->setWidth(15); // Начало договора
$activeSheet->getColumnDimension('D')->setWidth(60); // Название договора
$activeSheet->getColumnDimension('E')->setWidth(30); // Заказчик
$activeSheet->getColumnDimension('F')->setWidth(30); // Объект
$activeSheet->getColumnDimension('G')->setWidth(20); // Сумма
$activeSheet->getColumnDimension('H')->setWidth(25); // Тип
$activeSheet->getColumnDimension('I')->setWidth(15); // Конец договора
$activeSheet->getColumnDimension('J')->setWidth(15); // Закрытие договора
$activeSheet->getColumnDimension('K')->setWidth(20); // Статус
$activeSheet->getColumnDimension('L')->setWidth(20); // Исполнитель
#
// Для удобства заводим переменную $line, в ней будем считать номер строки
$line = 1;
#
# ----- ----- ----- ----- -----
# СТРОКА 1
# ----- ----- ----- ----- -----
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'ПЕРЕЧЕНЬ ДОГОВОРОВ');
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(24);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:L{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(15);
#
# ----- ----- ----- ----- -----
# СТРОКА 2
# ----- ----- ----- ----- -----
$line++;
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", 'Дата отчета: ' . date("d.m.Y H:i:s"));
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:L{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(13);
#
# ----- ----- ----- ----- -----
# СТРОКА 3
# ----- ----- ----- ----- -----
$line++;
// Выводим название отчета
$activeSheet->setCellValue("A{$line}", "Отчет составлен: " . $_SESSION['lastname'] . " " . $_SESSION['firstname'] . " " . $_SESSION['middlename']);
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:L{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}")->getFont()->setSize(13);
#
# ----- ----- ----- ----- -----
# СТРОКА 4-5
# ----- ----- ----- ----- -----
$line++;
#
$_cntYearSelector = "";
if (!empty($_GET['YearSelector']) && isset($_GET['YearSelector'])) {
	$_arrYearSelector = $_GET['YearSelector'];
	$_cntYearSelector = count($_arrYearSelector);
}
$_cntStatusSelector = "";
if (!empty($_GET['StatusSelector']) && isset($_GET['StatusSelector'])) {
	$_arrStatusSelector = $_GET['StatusSelector'];
	$_cntStatusSelector = count($_arrStatusSelector);
}
#
// Выводим название отчета
$_yearTitleStr = "";
if ($_cntYearSelector == 0) {
	$_yearTitleStr .= "---";
} else {
	for ($i = 0; $i < $_cntYearSelector; $i++) {
		if ($i < ($_cntYearSelector - 1)) {
			$_yearTitleStr .= $_arrYearSelector[$i] . ", ";
		}
		if ($i == ($_cntYearSelector - 1)) {
			$_yearTitleStr .= $_arrYearSelector[$i];
		}
	}
}
$_yearTitleStr .= "";
//
$_statusTitleStr = "";
if ($_cntStatusSelector == 0) {
	$_statusTitleStr .= "---";
} else {
	for ($i = 0; $i < $_cntStatusSelector; $i++) {
		$_QRY_STS = mysqlQuery(" SELECT statusnameshot FROM dognet_spstatus WHERE kodstatus='" . $_arrStatusSelector[$i] . "'");
		$_ROW_STS = mysqli_fetch_assoc($_QRY_STS);

		if ($i < ($_cntStatusSelector - 1)) {
			$_statusTitleStr .= $_ROW_STS['statusnameshot'] . ", ";
		}
		if ($i == ($_cntStatusSelector - 1)) {
			$_statusTitleStr .= $_ROW_STS['statusnameshot'];
		}
	}
}
$_statusTitleStr .= "";
#
$activeSheet->setCellValue("A{$line}", "Фильтр экспорта по году закрытия:");
$activeSheet->setCellValue("D{$line}", $_yearTitleStr);
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:C{$line}");
$activeSheet->mergeCells("D{$line}:L{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:L{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("D{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:L{$line}")->getFont()->setSize(12);
#
#
$line++;
$activeSheet->setCellValue("A{$line}", "Фильтр экспорта по статусу договора:");
$activeSheet->setCellValue("D{$line}", $_statusTitleStr);
// Задаем высоту строки
$activeSheet->getRowDimension($line)->setRowHeight(20);
// Объединяем ячейки по горизонтали
$activeSheet->mergeCells("A{$line}:C{$line}");
$activeSheet->mergeCells("D{$line}:L{$line}");
// Делаем выравнивание по центру вертикали и горизонтали
$activeSheet->getStyle("A{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("A{$line}:L{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Делаем текст жирным и увеличиваем шрифт.
$activeSheet->getStyle("A{$line}")->getFont()->setBold(false);
$activeSheet->getStyle("D{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("A{$line}:L{$line}")->getFont()->setSize(12);
#
# ----- ----- ----- ----- -----
# СТРОКА 6
# ----- ----- ----- ----- -----
// Пропускаем строку
$line++;
$activeSheet->setCellValue("A{$line}", '');
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
$line++;
$start_table = $line;
// Шапка таблицы
$activeSheet->setCellValue("A{$line}", 'ДОГОВОР');
$activeSheet->setCellValue("B{$line}", 'ШАБЛ');
$activeSheet->setCellValue("C{$line}", 'НАЧАЛО');
$activeSheet->setCellValue("D{$line}", 'НАЗВАНИЕ ДОГОВОРА');
$activeSheet->setCellValue("E{$line}", 'ЗАКАЗЧИК');
$activeSheet->setCellValue("F{$line}", 'ОБЪЕКТ');
$activeSheet->setCellValue("G{$line}", 'СУММА');
$activeSheet->setCellValue("H{$line}", 'ТИП');
$activeSheet->setCellValue("I{$line}", 'КОНЕЦ ');
$activeSheet->setCellValue("J{$line}", 'ЗАКРЫТИЕ');
$activeSheet->setCellValue("K{$line}", 'СТАТУС');
$activeSheet->setCellValue("L{$line}", 'ИСПОЛНИТЕЛЬ');
// Стили для текста в шапки таблицы.
$activeSheet->getRowDimension($line)->setRowHeight(18); // высота строки
$activeSheet->getStyle("A{$line}:L{$line}")->getFont()->setSize(11); // размер шрифта
$activeSheet->getStyle("A{$line}:L{$line}")->getFont()->setBold(true); // делаем шрифт жирным
$activeSheet->getStyle("A{$line}:L{$line}")->getAlignment()->setWrapText(true); // разрешаем перенос строк в ячейке

// Выравнивание по вертикали - середина
$activeSheet->getStyle("A{$line}:L{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Выравнивание по горизонтали - центр
$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("E{$line}:L{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Делаем заливку области ячеек
$activeSheet->getStyle("A{$line}:L{$line}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle("A{$line}:L{$line}")->getFill()->getStartColor()->setRGB("31708F");
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:L{$line}")->getFont()->getColor()->setRGB('FFFFFF');
// Оформляем границы
$activeSheet->getStyle("A{$line}:L{$line}")->applyFromArray($_BORDER_INSIDE);
$activeSheet->getStyle("A{$line}:L{$line}")->applyFromArray($_BORDER_OUTSIDE_THICK);
#
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Следующая строка
$line++;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
$qryPart = "SELECT koddoc, kodshab, koddened, docnumber, docnameshot, docsumma, yearnachdoc, monthnachdoc, daynachdoc, yearenddoc, monthenddoc, dayenddoc, docnamefullm, kodzakaz, kodobject, kodispol, kodtip, kodstatus, datezakr FROM dognet_docbase WHERE ";

$_yearQueryStr = "";
for ($i = 0; $i < $_cntYearSelector; $i++) {
	if ($i == 0) {
		$_yearQueryStr .= "(";
	}
	$_yearQueryStr .= "YEAR(datezakr) = '";
	if ($i < ($_cntYearSelector - 1)) {
		$_yearQueryStr .= $_arrYearSelector[$i] . "' OR ";
	}
	if ($i == ($_cntYearSelector - 1)) {
		$_yearQueryStr .= $_arrYearSelector[$i] . "')";
	}
}
$qryPart .= $_yearQueryStr;
#
$_kodstatusQueryStr = "";
for ($i = 0; $i < $_cntStatusSelector; $i++) {
	if ($i == 0) {
		$_kodstatusQueryStr .= "(";
	}
	$_kodstatusQueryStr .= "kodstatus = '";
	if ($i < ($_cntStatusSelector - 1)) {
		$_kodstatusQueryStr .= $_arrStatusSelector[$i] . "' OR ";
	}
	if ($i == ($_cntStatusSelector - 1)) {
		$_kodstatusQueryStr .= $_arrStatusSelector[$i] . "')";
	}
}
$qryPart .= (($_yearQueryStr != "") && ($_kodstatusQueryStr != "")) ? " AND " . $_kodstatusQueryStr : $_kodstatusQueryStr;
#
$qryPart .= (($_yearQueryStr == "") && ($_kodstatusQueryStr == "")) ? " koddel<>'99'" : " AND koddel<>'99'";

// echo $qryPart;
// Делаем выборку этапов по идентификатору этапа (kodkalplan)
$_QRY = mysqlQuery($qryPart);
//
while ($_ROW = mysqli_fetch_assoc($_QRY)) {
	$DOCTIP = $db_handle->runQuery("SELECT nametip FROM dognet_sptipdog WHERE kodtip='" . $_ROW['kodtip'] . "'");
	$DOCSTATUS = $db_handle->runQuery("SELECT statusnameshot FROM dognet_spstatus WHERE kodstatus='" . $_ROW['kodstatus'] . "'");
	$DOCOBJ = $db_handle->runQuery("SELECT nameobjectshot FROM sp_objects WHERE kodobject='" . $_ROW['kodobject'] . "'");
	$DOCZAK = $db_handle->runQuery("SELECT nameshort FROM sp_contragents WHERE kodcontragent='" . $_ROW['kodzakaz'] . "'");
	$DOCISP = $db_handle->runQuery("SELECT ispolnameshot FROM dognet_spispol WHERE kodispol='" . $_ROW['kodispol'] . "'");
	//
	$_DOCNUM = $_ROW['docnumber'];
	//
	switch ($_ROW['kodshab']) {
		case 0:
			$_DOCSHAB = "ДСЧ";
			break;

		case 1:
			$_DOCSHAB = "СКП";
			break;

		case 2:
			$_DOCSHAB = "БКП";
			break;

		default:
			$_DOCSHAB = "---";
	}
	$_DOCNAME = $_ROW['docnameshot'];
	//
	$_DOCDATE_NACH_DAY = ($_ROW['daynachdoc'] != "" && $_ROW['daynachdoc'] != 0) ? str_pad($_ROW['daynachdoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_NACH_MON = ($_ROW['monthnachdoc'] != "" && $_ROW['monthnachdoc'] != 0) ? str_pad($_ROW['monthnachdoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_NACH_YER = ($_ROW['yearnachdoc'] != "" && $_ROW['yearnachdoc'] != 0) ? str_pad($_ROW['yearnachdoc'], 2, '0', STR_PAD_LEFT) : "----";
	$_DOCDATE_NACH = $_DOCDATE_NACH_DAY . "." . $_DOCDATE_NACH_MON . "." . $_DOCDATE_NACH_YER;
	//
	$_DOCDATE_END_DAY = ($_ROW['dayenddoc'] != "" && $_ROW['dayenddoc'] != 0) ? str_pad($_ROW['dayenddoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_END_MON = ($_ROW['monthenddoc'] != "" && $_ROW['monthenddoc'] != 0) ? str_pad($_ROW['monthenddoc'], 2, '0', STR_PAD_LEFT) : "--";
	$_DOCDATE_END_YER = ($_ROW['yearenddoc'] != "" && $_ROW['yearenddoc'] != 0) ? str_pad($_ROW['yearenddoc'], 2, '0', STR_PAD_LEFT) : "----";
	$_DOCDATE_END = $_DOCDATE_END_DAY . "." . $_DOCDATE_END_MON . "." . $_DOCDATE_END_YER;
	//
	$_DOCTIP = $DOCTIP[0]['nametip'];
	$_DOCSTATUS = $DOCSTATUS[0]['statusnameshot'];
	$_DOCOBJ = $DOCOBJ[0]['nameobjectshot'];
	$_DOCZAK = $DOCZAK[0]['nameshort'];
	$_DOCDATE_ZAK = (!empty($_ROW['datezakr'])) ? date("Y", strtotime($_ROW['datezakr'])) : "---";
	// 			$_DOCDATE_ZAK = "";
	$_DOCSUM = $_ROW['docsumma'];
	$_DOCISP = $DOCISP[0]['ispolnameshot'];
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Задаем высоту строки и шрифт
	$activeSheet->getRowDimension($line)->setRowHeight(18);
	$activeSheet->getStyle("A{$line}:L{$line}")->getFont()->setSize(10);
	$activeSheet->getStyle("A{$line}:L{$line}")->getFont()->setBold(false);
	// Задаем цвет текста строки
	$activeSheet->getStyle("A{$line}:L{$line}")->getFont()->getColor()->setRGB('111111');
	// Выравнивание по вертикали - середина
	$activeSheet->getStyle("A{$line}:L{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	// Выравнивание по горизонтали - слева
	$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$activeSheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	// Выравнивание по горизонтали - центр
	$activeSheet->getStyle("C{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->getStyle("E{$line}:L{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$activeSheet->setCellValue("A{$line}", '3-4/' . $_DOCNUM);
	$activeSheet->setCellValue("B{$line}", $_DOCSHAB);
	$activeSheet->setCellValue("C{$line}", $_DOCDATE_NACH);
	$activeSheet->setCellValue("D{$line}", $_DOCNAME);
	$activeSheet->setCellValue("E{$line}", $_DOCZAK);
	$activeSheet->setCellValue("F{$line}", $_DOCOBJ);
	$activeSheet->setCellValue("G{$line}", $_DOCSUM);
	$activeSheet->getStyle("G{$line}")->getNumberFormat()->setFormatCode(PRICE_FORMAT_1);
	$activeSheet->setCellValue("H{$line}", $_DOCTIP);
	$activeSheet->setCellValue("I{$line}", $_DOCDATE_END);
	$activeSheet->setCellValue("J{$line}", $_DOCDATE_ZAK);
	$activeSheet->setCellValue("K{$line}", $_DOCSTATUS);
	$activeSheet->setCellValue("L{$line}", $_DOCISP);
	// Оформляем границы
	$activeSheet->getStyle("A{$line}:L{$line}")->applyFromArray($_BORDER_INSIDE);
	$activeSheet->getStyle("A{$line}:L{$line}")->applyFromArray($_BORDER_BOTTOM_THIN);
	// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
	// Следующая строка
	$line++;
}
#
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
# Возвращаемся на 1 строку
$line = $line - 1;
# ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
#
#
// Добавляем рамку к шапке таблицы
$activeSheet->getStyle("A{$start_table}:L{$start_table}")->applyFromArray($_BORDER_OUTSIDE_THIN);
// Добавляем рамку ко всей таблице
$activeSheet->getStyle("A{$start_table}:L{$line}")->applyFromArray($_BORDER_OUTSIDE_THIN);

// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
$objPHPExcel->getActiveSheet()->setAutoFilter("A{$start_table}:L{$start_table}");

// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----

// Следующая строка
$line++;
$line++;
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(18);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setSize(10);
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("B{$line}")->getFont()->setBold(false);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->getColor()->setRGB('111111');
// Выравнивание по вертикали - середина
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->setCellValue("A{$line}", "ДСЧ");
$activeSheet->setCellValue("B{$line}", "Договор-счет");
//
// Следующая строка
$line++;
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(18);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setSize(10);
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("B{$line}")->getFont()->setBold(false);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->getColor()->setRGB('111111');
// Выравнивание по вертикали - середина
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->setCellValue("A{$line}", "БКП");
$activeSheet->setCellValue("B{$line}", "Договор без календарного плана");
//
// Следующая строка
$line++;
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(18);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setSize(10);
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("B{$line}")->getFont()->setBold(false);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->getColor()->setRGB('111111');
// Выравнивание по вертикали - середина
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->setCellValue("A{$line}", "СКП");
$activeSheet->setCellValue("B{$line}", "Договор с календарным планом");


//
// SQL ЗАПРОС
$line++;
// Задаем высоту строки и шрифт
$activeSheet->getRowDimension($line)->setRowHeight(18);
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->setSize(10);
$activeSheet->getStyle("A{$line}")->getFont()->setBold(true);
$activeSheet->getStyle("B{$line}")->getFont()->setBold(false);
// Задаем цвет текста строки
$activeSheet->getStyle("A{$line}:B{$line}")->getFont()->getColor()->setRGB('111111');
// Выравнивание по вертикали - середина
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// Выравнивание по горизонтали - слева
$activeSheet->getStyle("A{$line}:B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$activeSheet->setCellValue("A{$line}", "SQL ЗАПРОС (админу для контроля)");
$activeSheet->setCellValue("B{$line}", $qryPart);
